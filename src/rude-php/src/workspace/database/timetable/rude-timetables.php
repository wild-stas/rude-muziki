<?

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_TIMETABLE'))             { define('RUDE_DATABASE_TABLE_TIMETABLE',             'timetable'); }
if (!defined('RUDE_DATABASE_TABLE_TIMETABLE_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_TIMETABLE_PRIMARY_KEY', 'id'); }

class timetables
{
	public static function get($id = null, $limit = null, $offset = null)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE);
		$q->limit($limit, $offset);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_TABLE_TIMETABLE_PRIMARY_KEY, $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_last($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE);
		$q->order_by(RUDE_DATABASE_TABLE_TIMETABLE_PRIMARY_KEY, 'DESC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function get_first($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE);
		$q->order_by(RUDE_DATABASE_TABLE_TIMETABLE_PRIMARY_KEY, 'ASC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function add($service_id = null, $interval = null)
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_TIMETABLE);

		if ($service_id !== null) { $q->add('service_id', $service_id); }
		if ($interval   !== null) { $q->add('interval',   $interval  ); }

		$q->query();

		return $q->get_id();
	}

	public static function update($id, $service_id = null, $interval = null, $limit = null, $offset = null)
	{
		$q = new query_update(RUDE_DATABASE_TABLE_TIMETABLE);

		if ($service_id !== null) { $q->update('service_id', $service_id); }
		if ($interval   !== null) { $q->update('interval',   $interval  ); }

		$q->where(RUDE_DATABASE_TABLE_TIMETABLE_PRIMARY_KEY, $id);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_TIMETABLE);
		$q->where(RUDE_DATABASE_TABLE_TIMETABLE_PRIMARY_KEY, $id);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function count()
	{
		$database = database();
		$database->query('SELECT COUNT(*) as count FROM ' . RUDE_DATABASE_TABLE_TIMETABLE);

		return $database->get_object()->count;
	}

	public static function get_by_id($id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE);
		$q->where('id', $id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_service_id($service_id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE);
		$q->where('service_id', $service_id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_interval($interval, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE);
		$q->where('interval', $interval);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function remove_by_id($id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_TIMETABLE);
		$q->where('id', $id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_service_id($service_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_TIMETABLE);
		$q->where('service_id', $service_id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_interval($interval)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_TIMETABLE);
		$q->where('interval', $interval);
		$q->query();

		return $q->affected();
	}

	public static function is_exists_id($id)
	{
		return static::get_by_id($id) == true;
	}

	public static function is_exists_service_id($service_id)
	{
		return static::get_by_service_id($service_id) == true;
	}

	public static function is_exists_interval($interval)
	{
		return static::get_by_interval($interval) == true;
	}
}