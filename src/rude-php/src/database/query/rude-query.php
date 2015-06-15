<?

namespace rude;

define('RUDE_DATABASE_TYPE_NUMBER',  1);
define('RUDE_DATABASE_TYPE_BOOLEAN', 2);
define('RUDE_DATABASE_TYPE_STRING',  3);

define('RUDE_DATABASE_TYPE_ENUM_NUMBERS', 4);
define('RUDE_DATABASE_TYPE_ENUM_STRINGS', 5);


define('RUDE_DATABASE_WHERE_TYPE_EQUALS',     1);
define('RUDE_DATABASE_WHERE_TYPE_NOT_EQUALS', 2);
define('RUDE_DATABASE_WHERE_TYPE_IN',         3);
define('RUDE_DATABASE_WHERE_TYPE_NOT_IN',     4);


define('RUDE_SQL_NEWLINE',     PHP_EOL       );
define('RUDE_SQL_NEWLINE_TAB', PHP_EOL . "\t");
define('RUDE_SQL_TAB_NEWLINE', "\t" . PHP_EOL);
define('RUDE_SQL_TAB',                   "\t");

class query
{
	/** @var database */
	protected $database = null;

	protected $table = null;


	protected $list_fields = null; # item: array($table, $field)
	protected $list_from   = null; # item: $table
	protected $list_where  = null; # item: array($table, $field, $value, RUDE_DATABASE_WHERE_TYPE)

	protected $list_update = null; # item: array($field, $value)
	protected $list_insert = null; # item: array($field, $value)

	protected $limit = null; # item: array($limit, $offset)
	
	protected $order = null; # item: array($field, $direction)

	##########################
	# shared mothods section #
	##########################

	public function affected() { return $this->database->affected(); }

	public function escape($var)
	{
		return $this->database->escape($var);
	}

	protected function add_table($table)
	{
		$this->table = static::escape($table);
	}

	protected function add_from($table)
	{
		$this->list_from[] = static::escape($table);
	}

	protected function add_insert($field, $value)
	{
		if (!in_array($field, $this->database->fields($this->table)))
		{
			exception::error('Field ' . $field . ' is not found in the table `' . $this->table . '`');
		}

		$this->list_insert[] = array(static::escape($field), $value);
	}

	protected function add_field($field, $table = null)
	{
		if ($table === null)
		{
			$table = $this->table;
		}
		else
		{
			$table = static::escape($table);
		}

		if (!in_array($field, $this->database->fields($table)))
		{
			exception::error('Field ' . $field . ' is not found in the table `' . $table . '`');
		}

		$field = static::escape($field);

		$this->list_fields[] = array($table, $field);

		if (!$this->list_from or !in_array($table, $this->list_from))
		{
			$this->list_from[] = $table;
		}
	}

	protected function add_update($field, $value)
	{
		$field = static::escape($field);

		if (!in_array($field, $this->database->fields($this->table)))
		{
			exception::error('Field ' . $field . ' is not found in the table `' . $this->table . '`');
		}


		if (!$this->list_update or !in_array(array($field, $value), $this->list_update))
		{
			$this->list_update[] = array($field, $value);
		}
	}

	protected function add_where($table, $field, $value)
	{
		if (is_array($value))
		{
			static::add_where_in($table, $field, $value);

			return;
		}

		if ($table === null)
		{
			$table = $this->table;
		}

		if (!in_array($field, $this->database->fields($table)))
		{
			exception::error('Field `' . $field . '` is not found in the table `' . $table . '`');
		}

		$this->list_where[] = array($table, $field, $value, RUDE_DATABASE_WHERE_TYPE_EQUALS);
	}

	protected function add_where_not($table, $field, $value)
	{
		if (is_array($value))
		{
			static::add_where_not_in($table, $field, $value);

			return;
		}

		if ($table === null)
		{
			$table = $this->table;
		}

		if (!in_array($field, $this->database->fields($table)))
		{
			exception::error('Field ' . $field . ' is not found in the table `' . $table . '`');
		}

		$this->list_where[] = array($table, $field, $value, RUDE_DATABASE_WHERE_TYPE_NOT_EQUALS);
	}

	protected function add_where_in($table, $field, $value)
	{
		if ($table === null)
		{
			$table = $this->table;
		}

		if (!in_array($field, $this->database->fields($table)))
		{
			exception::error('Field ' . $field . ' is not found in the table `' . $table . '`');
		}

		$this->list_where[] = array($table, $field, $value, RUDE_DATABASE_WHERE_TYPE_IN);
	}

	protected function add_where_not_in($table, $field, $value)
	{
		if ($table === null)
		{
			$table = $this->table;
		}

		if (!in_array($field, $this->database->fields($table)))
		{
			exception::error('Field ' . $field . ' is not found in the table `' . $table . '`');
		}

		$this->list_where[] = array($table, $field, $value, RUDE_DATABASE_WHERE_TYPE_NOT_IN);
	}

	protected function add_limit($limit, $offset = null)
	{
		if ($limit !== null)
		{
			if ($offset !== null)
			{
				$this->limit = [(int) $limit, (int) $offset];
			}
			else
			{
				$this->limit = [(int) $limit];
			}
		}
	}
	
	protected function add_order($field, $direction = null)
	{
		if ($direction === null)
		{
			$direction = 'DESC';
		}


		$direction = string::to_uppercase($direction);

		if ($direction == 'ASC' || $direction == 'DESC')
		{
			$this->order = [static::escape($field), $direction];
		}
		else
		{
			exception::warning('Wrong SQL `ORDER BY` direction: ' . $direction);
		}
	}

	protected function sql_fields()
	{
		if (!$this->list_fields)
		{
			return 'SELECT' . RUDE_SQL_NEWLINE_TAB . '*' . RUDE_SQL_NEWLINE;
		}


		$sql = 'SELECT' . RUDE_SQL_NEWLINE;

		if ($this->list_fields)
		{
			foreach ($this->list_fields as $fields)
			{
				$table = items::get($fields, 1);
				$field = items::get($fields, 2);

					 if ($table == $this->table) { $field_name = $table . '.' . $field ;                                 }
				else                             { $field_name = $table . '.' . $field . ' AS ' . $table . '_' . $field; }

				$sql .= RUDE_SQL_TAB . $field_name . ',' . RUDE_SQL_NEWLINE;
			}

			$sql = char::remove_last($sql, string::length(',' . RUDE_SQL_NEWLINE));
		}

		return $sql . RUDE_SQL_NEWLINE;
	}

	protected function sql_delete()
	{
		return 'DELETE ';
	}

	protected function sql_from()
	{
		$sql = 'FROM' . RUDE_SQL_NEWLINE;

		if ($this->list_from)
		{
			foreach ($this->list_from as $from)
			{
				$sql .= RUDE_SQL_TAB . $from . ',' . RUDE_SQL_NEWLINE;
			}

			$sql = char::remove_last($sql, string::length(',' . RUDE_SQL_NEWLINE));
		}

		return $sql . RUDE_SQL_NEWLINE;
	}

	public function sql_update()
	{
		return 'UPDATE' . RUDE_SQL_NEWLINE_TAB . $this->table . RUDE_SQL_NEWLINE;
	}

	public function sql_insert()
	{
		$sql = 'INSERT INTO ' . $this->table . RUDE_SQL_NEWLINE . '(' . RUDE_SQL_NEWLINE;


		$columns = $this->database->columns($this->table);

		foreach ($columns as $column)
		{
			$sql .= RUDE_SQL_TAB . '`' . $column[0] . '`,' . RUDE_SQL_NEWLINE;
		}

		$sql = char::remove_last($sql, string::length(',' . RUDE_SQL_NEWLINE));

		$sql .= RUDE_SQL_NEWLINE . ')' . RUDE_SQL_NEWLINE . 'VALUES' . RUDE_SQL_NEWLINE . '(' . RUDE_SQL_NEWLINE;


		if ($this->list_insert)
		{
			foreach ($columns as $column)
			{
				$is_found = false;

				foreach ($this->list_insert as $insert)
				{
					$field = items::get($insert, 1);
					$value = items::get($insert, 2);

					if ($column[0] == $field)
					{
						$sql .= RUDE_SQL_TAB . static::to($value, $column[1]);

						$is_found = true;
						break;
					}
				}

				if (!$is_found)
				{
					if ($column[4] and $column[4] != 'CURRENT_TIMESTAMP')
					{
						$sql .= RUDE_SQL_TAB . static::to($column[4], $column[1]);
					}
					else
					{
						$sql .= RUDE_SQL_TAB . 'NULL';
					}
				}

				$sql .= ',' . RUDE_SQL_NEWLINE;
			}

			$sql = char::remove_last($sql, string::length(',' . RUDE_SQL_NEWLINE));
		}

		$sql .= RUDE_SQL_NEWLINE . ')';


		return $sql;
	}

	public function sql_set()
	{
		$sql = 'SET' . RUDE_SQL_NEWLINE;


		$columns = $this->database->columns($this->table);

		if ($this->list_update)
		{
			foreach ($this->list_update as $update)
			{
				$field = items::get($update, 1);
				$value = items::get($update, 2);

				foreach ($columns as $column)
				{
					if ($column[0] == $field)
					{
						$value = static::to($value, $column[1]);

						if ($value === null)
						{
							break;
						}

						$sql .= RUDE_SQL_TAB . '`' . $field . '` = ' . $value . ',' . RUDE_SQL_NEWLINE;

						break;
					}
				}
			}

			$sql = char::remove_last($sql, string::length(',' . RUDE_SQL_NEWLINE));
		}

		return $sql . RUDE_SQL_NEWLINE;
	}

	protected function sql_where()
	{
		if (!$this->list_where)
		{
			return 'WHERE' . RUDE_SQL_NEWLINE_TAB . '1 = 1' . RUDE_SQL_NEWLINE;
		}


		$sql = '';

		foreach ($this->list_where as $where)
		{
			$table = items::get($where, 1);
			$field = items::get($where, 2);
			$value = items::get($where, 3);
			$type  = items::get($where, 4);

			foreach ($this->database->columns($table) as $column)
			{
				if ($column[0] == $field)
				{
					$value = static::to($value, $column[1]);

					if ($value === null)
					{
						break;
					}

					     if ($table == $this->table) { $field_name = $table . '.' . $field; }
					else                             { $field_name = $table . '_' . $field; }

					switch ($type)
					{
						case RUDE_DATABASE_WHERE_TYPE_EQUALS:     $sql .= 'AND' . RUDE_SQL_NEWLINE_TAB . $field_name .  ' = ' . $value . RUDE_SQL_NEWLINE; break;
						case RUDE_DATABASE_WHERE_TYPE_NOT_EQUALS: $sql .= 'AND' . RUDE_SQL_NEWLINE_TAB . $field_name . ' != ' . $value . RUDE_SQL_NEWLINE; break;

						case RUDE_DATABASE_WHERE_TYPE_IN:     $sql .= 'AND' . RUDE_SQL_NEWLINE_TAB . $field_name .     ' IN(' . $value . ')' . RUDE_SQL_NEWLINE; break;
						case RUDE_DATABASE_WHERE_TYPE_NOT_IN: $sql .= 'AND' . RUDE_SQL_NEWLINE_TAB . $field_name . ' NOT IN(' . $value . ')' . RUDE_SQL_NEWLINE; break;

						default:
							exception::error('Unsupported `where` expression type: ' . $type);
					}

					break;
				}
			}
		}

		return string::replace_first($sql, 'AND', 'WHERE');
	}

	protected function sql_limit()
	{
		$sql = '';

		if ($this->limit !== null)
		{
			$limit  = items::get($this->limit, 1);
			$offset = items::get($this->limit, 2);
			
			if ($offset !== null)
			{
				return 'LIMIT' . RUDE_SQL_NEWLINE_TAB . $offset . ',' . $limit . RUDE_SQL_NEWLINE;
			}
			else
			{
				return 'LIMIT' . RUDE_SQL_NEWLINE_TAB . $limit . RUDE_SQL_NEWLINE;
			}
		}

		return $sql;
	}

	protected function sql_order()
	{
		$sql = '';

		if ($this->order !== null)
		{
			$field     = items::get($this->order, 1);
			$direction = items::get($this->order, 2);

			$sql .= 'ORDER BY' . RUDE_SQL_NEWLINE_TAB . $field . ' ' . $direction . RUDE_SQL_NEWLINE;
		}

		return $sql;
	}

	################
	# cast section #
	################

	private function to($var, $type)
	{
		if ($type == RUDE_DATABASE_WHERE_TYPE_IN     or
		    $type == RUDE_DATABASE_WHERE_TYPE_NOT_IN or
		    is_array($var))
		{
			     if (static::is_number($type) or static::is_enum_numbers($type)) { return static::to_enum_numbers($var); }
			else if (static::is_string($type) or static::is_enum_strings($type)) { return static::to_enum_strings($var); }
			else
			{
				exception::error('Unsupported enum field type: ' . $type);
			}
		}
		else if (static::is_string    ($type)) { return static::to_string   ($var); }
		else if (static::is_number    ($type)) { return static::to_number   ($var); }
		else if (static::is_float     ($type)) { return static::to_float    ($var); }
		else if (static::is_boolean   ($type)) { return static::to_boolean  ($var); }
		else if (static::is_time      ($type)) { return static::to_time     ($var); }
		else if (static::is_date      ($type)) { return static::to_date     ($var); }
		else if (static::is_timestamp ($type)) { return static::to_timestamp($var); }
		else if (static::is_datetime  ($type)) { return static::to_datetime ($var); }
		else if (static::is_enum      ($type))
		{
			     if (static::is_enum_strings($type)) { return static::to_string($var); }
			else if (static::is_enum_numbers($type)) { return static::to_number($var); }
		}
		else
		{
			exception::error('Unsupported field type: ' . $type);
		}

		return null;
	}

	private function to_number($var)
	{
		return (int) $var;
	}

	private function to_float($var)
	{
		return (float) $var;
	}

	private function to_string($var)
	{
		return "'" . $this->database->escape((string) $var) . "'";
	}

	private function to_boolean($var)
	{
		if ($var)
		{
			return 'TRUE';
		}

		return 'FALSE';
	}

	private function to_datetime($string)
	{
		return "'" . date('Y-m-d H:i:s', strtotime($string)) . "'";
	}

	private function to_time($string)
	{
		return "'" . date('H:i:s', strtotime($string)) . "'";
	}

	private function to_date($string)
	{
		return "'" . date('Y-m-d', strtotime($string)) . "'";
	}

	private function to_timestamp($var)
	{
		$date = date_create($var);

		if (!$date)
		{
			return "''";
		}

		return "'" . date_format($date, 'Y-m-d H:i:s') . "'";
	}

	private function to_enum_numbers(array $var_list)
	{
		$result = null;

		foreach ($var_list as $var)
		{
			$result .= static::to_number($var) . ", ";
		}

		return char::remove_last($result, 2);
	}

	private function to_enum_strings(array $var_list)
	{
		$result = null;

		foreach ($var_list as $var)
		{
			$result .= "'" . static::to_string($var) . "', ";
		}

		return char::remove_last($result, 2);
	}


	######################
	# validation section #
	######################

	protected function in_table($table, $field)
	{
		foreach ($this->database->columns($table) as $column)
		{
			if ($column[0] == $field)
			{
				return true;
			}
		}

		return false;
	}

	protected function is_string($field_type)    { return string::starts_with($field_type, ['varchar', 'text', 'char', 'tinytext', 'mediumtext', 'longtext']); }
	protected function is_number($field_type)    { return string::starts_with($field_type, ['int', 'tinyint', 'smallint', 'mediumint', 'bigint']); }

	protected function is_boolean($field_type)   { return string::starts_with($field_type, 'bit');       }
	protected function is_float($field_type)     { return string::starts_with($field_type, 'float');     }
	protected function is_datetime($field_type)  { return string::starts_with($field_type, 'datetime');  }
	protected function is_timestamp($field_type) { return string::starts_with($field_type, 'timestamp'); }
	protected function is_date($field_type)      { return string::starts_with($field_type, 'date') and
	                                                     !string::starts_with($field_type, 'datetime'); }
	protected function is_time($field_type)      { return string::starts_with($field_type, 'time') and
	                                                     !string::starts_with($field_type, 'timestamp'); }

	private function is_enum($field_type)         { return string::starts_with($field_type, 'enum');                               }
	private function is_enum_strings($field_type) { return string::starts_with($field_type, "enum('");                             }
	private function is_enum_numbers($field_type) { return static::is_enum($field_type) and !static::is_enum_strings($field_type); }
}
