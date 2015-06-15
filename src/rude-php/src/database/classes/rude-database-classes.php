<?

namespace rude;

class database_classes
{
	public static function create_all()
	{
		foreach (database()->tables() as $table)
		{
			static::create($table);
		}
	}

	public static function create($table, $class_name_parent = null, $class_name_child = null)
	{
		if ($class_name_parent === null)
		{
			$class_name_parent = english::pluralize($table);
		}

		if ($class_name_child === null)
		{
			$class_name_child = english::singularize($class_name_parent);
		}


		static::create_parent($table, $class_name_parent);
		static::create_child($table, $class_name_child);
	}

	private static function save($template, $table, $class_name)
	{
		$directory = RUDE_DIR_WORKSPACE_DATABASE . DIRECTORY_SEPARATOR . $table;

		if (!filesystem::is_exists($directory))
		{
			filesystem::create_directory($directory);
		}

		filesystem::rewrite($directory . DIRECTORY_SEPARATOR . 'rude-' . static::escape($class_name, '-') . '.php', $template);
	}

	private static function create_parent($table, $class_name)
	{
		$template = static::read_parent();
		$template = static::replace($template, '%CLASS_NAME%',           $class_name);
		$template = static::replace($template, '%ADVANCED%',             static::advanced($table),            false);
		$template = static::replace($template, '%TABLE_NAME%',           $table,                              false);
		$template = static::replace($template, '%TABLE_NAME_UPPERCASE%', string::to_uppercase($table),        false);
		$template = static::replace($template, '%INLINE_FIELDS%',        static::parent_fields($table),       false);
		$template = static::replace($template, '%QUERY_ADD%',            static::parent_query_add($table),    false);
		$template = static::replace($template, '%QUERY_UPDATE%',         static::parent_query_update($table), false);
		$template = static::replace($template, '%PRIMARY_ESCAPED%',      static::primary($table),             false);
		$template = static::replace($template, '%PRIMARY%',              static::primary($table));

		static::save($template, $table, $class_name);
	}

	private static function create_child($table, $class_name)
	{
		$template = static::read_child();
		$template = static::replace($template, '%CLASS_NAME%',           $class_name);
		$template = static::replace($template, '%TABLE_NAME%',           $table,                       false);
		$template = static::replace($template, '%TABLE_NAME_UPPERCASE%', string::to_uppercase($table), false);
		$template = static::replace($template, '%CLASS_FIELDS%',         static::child_fields($table), false);
		$template = static::replace($template, '%PRIMARY_ESCAPED%',      static::primary($table),      false);
		$template = static::replace($template, '%PRIMARY%',              static::primary($table));

		static::save($template, $table, $class_name);
	}

	private static function parent_fields($table)
	{
		$result = null;

		foreach (database()->fields($table) as $field)
		{
			if ($field == 'id')
			{
				continue;
			}

			$result .= '$' . static::escape($field) . ' = null, ';
		}

		$result = char::remove_last($result, 2);


		return $result;
	}

	private static function parent_query_add($table)
	{
		$fields = database()->fields($table);


		$result = null;

		$max_length = items::max_length($fields);

		foreach ($fields as $field)
		{
			if ($field == 'id')
			{
				continue;
			}


			$field_escaped = static::escape($field);
			$field_escaped = static::align($field_escaped, $max_length);
			$field_name    = static::align("'" . $field . "',", $max_length + 3);

			$result .=  'if ($' . $field_escaped . ' !== null) { $q->add(' . $field_name . ' $' . $field_escaped . '); }' . PHP_EOL . "\t\t";
		}

		$result = char::remove_last($result, 3);


		return $result;
	}

	private static function parent_query_update($table)
	{
		$fields = database()->fields($table);


		$result = null;


		$primary = static::primary($table);

		$max_length = items::max_length($fields);

		foreach ($fields as $field)
		{
			if ($field == $primary)
			{
				continue;
			}


			$field_escaped = static::escape($field);
			$field_escaped = static::align($field_escaped, $max_length);
			$field_name    = static::align("'" . $field . "',", $max_length + 3);

			$result .=  'if ($' . $field_escaped . ' !== null) { $q->update(' . $field_name . ' $' . $field_escaped . '); }' . PHP_EOL . "\t\t";
		}

		$result = char::remove_last($result, 3);


		return $result;
	}

	private static function child_fields($table)
	{
		$fields = database()->fields($table);


		$result = null;

		$max_length = items::max_length($fields);

		foreach ($fields as $field)
		{
			$field = static::escape($field);
			$field = static::align($field, $max_length);

			$result .=  'public $' . $field . ' = null;' . PHP_EOL . "\t";
		}

		$result = char::remove_last($result);


		return $result;
	}

	private static function replace($template, $key, $val, $escape = true)
	{
		if ($escape === true)
		{
			$val = static::escape($val);
		}

		return string::replace($template, $key, $val);
	}

	private static function primary($table)
	{
		$columns = database()->columns($table);

		foreach ($columns as $column)
		{
			if ($column[3] == 'PRI' and $column[5] == 'auto_increment')
			{
				return $column[0];
			}
		}

		return 'id';
	}

	private static function advanced_get()
	{
		$result  = PHP_EOL . '	public static function get_by_%FIELD%($%FIELD%, $only_first = false)';
		$result .= PHP_EOL . '	{';
		$result .= PHP_EOL . '		$q = new query_select(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%);';
		$result .= PHP_EOL . '		$q->where(\'%FIELD%\', $%FIELD%);';
		$result .= PHP_EOL . '		$q->query();';
		$result .= PHP_EOL;
		$result .= PHP_EOL . '		if ($only_first)';
		$result .= PHP_EOL . '		{';
		$result .= PHP_EOL . '			return $q->get_object();';
		$result .= PHP_EOL . '		}';
		$result .= PHP_EOL;
		$result .= PHP_EOL . '		return $q->get_object_list();';
		$result .= PHP_EOL . '	}';
		$result .= PHP_EOL;

		return $result;
	}

	private static function advanced_remove()
	{
		$result  = PHP_EOL . '	public static function remove_by_%FIELD%($%FIELD%)';
		$result .= PHP_EOL . '	{';
		$result .= PHP_EOL . '		$q = new query_delete(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%);';
		$result .= PHP_EOL . '		$q->where(\'%FIELD%\', $%FIELD%);';
		$result .= PHP_EOL . '		$q->query();';
		$result .= PHP_EOL;
		$result .= PHP_EOL . '		return $q->affected();';
		$result .= PHP_EOL . '	}';
		$result .= PHP_EOL;

		return $result;
	}

	private static function advanced_is_exists()
	{
		$result  = PHP_EOL . '	public static function is_exists_%FIELD%($%FIELD%)';
		$result .= PHP_EOL . '	{';
		$result .= PHP_EOL . '		return static::get_by_%FIELD%($%FIELD%) == true;';
		$result .= PHP_EOL . '	}';
		$result .= PHP_EOL;

		return $result;
	}

	private static function advanced($table)
	{
		$templates[] = static::advanced_get();
		$templates[] = static::advanced_remove();
		$templates[] = static::advanced_is_exists();


		$result = '';

		$fields = database()->fields($table);

		foreach ($templates as $template)
		{
			foreach ($fields as $field)
			{
				$field = static::escape($field);

				$result .= static::replace($template, '%FIELD%', $field, false);
			}
		}

		$result = char::remove_first($result, 2);
		$result = char::remove_last($result);

		return $result;
	}

	private static function escape($var, $replacer = '_')
	{
		$var = string::to_lowercase($var);

		$var = string::replace($var, ' ', $replacer);
		$var = string::replace($var, '-', $replacer);
		$var = string::replace($var, '_', $replacer);

		return $var;
	}

	private static function align($var, $length)
	{
		return str_pad($var, $length, ' ');
	}

	private static function read($template_name)
	{
		return '<?' . filesystem::read(__DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'template-' . $template_name . '.php');
	}

	private static function read_parent() { return static::read('parent'); }
	private static function read_child()  { return static::read('child');  }
}