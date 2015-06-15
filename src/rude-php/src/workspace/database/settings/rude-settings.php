<?

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_SETTINGS'))             { define('RUDE_DATABASE_TABLE_SETTINGS',             'settings'); }
if (!defined('RUDE_DATABASE_TABLE_SETTINGS_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_SETTINGS_PRIMARY_KEY', 'id'); }

class settings
{
	public static function get($id = null, $limit = null, $offset = null)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SETTINGS);
		$q->limit($limit, $offset);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_TABLE_SETTINGS_PRIMARY_KEY, $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_last($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SETTINGS);
		$q->order_by(RUDE_DATABASE_TABLE_SETTINGS_PRIMARY_KEY, 'DESC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function get_first($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SETTINGS);
		$q->order_by(RUDE_DATABASE_TABLE_SETTINGS_PRIMARY_KEY, 'ASC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function add($key = null, $val = null, $description = null)
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_SETTINGS);

		if ($key         !== null) { $q->add('key',         $key        ); }
		if ($val         !== null) { $q->add('val',         $val        ); }
		if ($description !== null) { $q->add('description', $description); }

		$q->query();

		return $q->get_id();
	}

	public static function update($id, $key = null, $val = null, $description = null, $limit = null, $offset = null)
	{
		$q = new query_update(RUDE_DATABASE_TABLE_SETTINGS);

		if ($key         !== null) { $q->update('key',         $key        ); }
		if ($val         !== null) { $q->update('val',         $val        ); }
		if ($description !== null) { $q->update('description', $description); }

		$q->where(RUDE_DATABASE_TABLE_SETTINGS_PRIMARY_KEY, $id);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function is_exists($id)
	{
		if (static::get($id))
		{
			return true;
		}

		return false;
	}

	public static function remove($id, $limit = null, $offset = null)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SETTINGS);
		$q->where(RUDE_DATABASE_TABLE_SETTINGS_PRIMARY_KEY, $id);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function count()
	{
		$database = database();
		$database->query('SELECT COUNT(*) as count FROM ' . RUDE_DATABASE_TABLE_SETTINGS);

		return $database->get_object()->count;
	}

	public static function get_by_id($id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SETTINGS);
		$q->where('id', $id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_key($key, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SETTINGS);
		$q->where('key', $key);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_val($val, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SETTINGS);
		$q->where('val', $val);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_description($description, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SETTINGS);
		$q->where('description', $description);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function remove_by_id($id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SETTINGS);
		$q->where('id', $id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_key($key)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SETTINGS);
		$q->where('key', $key);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_val($val)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SETTINGS);
		$q->where('val', $val);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_description($description)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SETTINGS);
		$q->where('description', $description);
		$q->query();

		return $q->affected();
	}

	public static function is_exists_id($id)
	{
		return static::get_by_id($id) == true;
	}

	public static function is_exists_key($key)
	{
		return static::get_by_key($key) == true;
	}

	public static function is_exists_val($val)
	{
		return static::get_by_val($val) == true;
	}

	public static function is_exists_description($description)
	{
		return static::get_by_description($description) == true;
	}
}