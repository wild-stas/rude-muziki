<?

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_SERVICES_JOBS'))             { define('RUDE_DATABASE_TABLE_SERVICES_JOBS',             'services_jobs'); }
if (!defined('RUDE_DATABASE_TABLE_SERVICES_JOBS_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_SERVICES_JOBS_PRIMARY_KEY', 'id'); }

class services_jobs
{
	public static function get($id = null, $limit = null, $offset = null)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES_JOBS);
		$q->limit($limit, $offset);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_TABLE_SERVICES_JOBS_PRIMARY_KEY, $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_last($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES_JOBS);
		$q->order_by(RUDE_DATABASE_TABLE_SERVICES_JOBS_PRIMARY_KEY, 'DESC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function get_first($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES_JOBS);
		$q->order_by(RUDE_DATABASE_TABLE_SERVICES_JOBS_PRIMARY_KEY, 'ASC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function add($service_id = null, $name = null, $multiplier = null)
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_SERVICES_JOBS);

		if ($service_id !== null) { $q->add('service_id', $service_id); }
		if ($name       !== null) { $q->add('name',       $name      ); }
		if ($multiplier !== null) { $q->add('multiplier', $multiplier); }

		$q->query();

		return $q->get_id();
	}

	public static function update($id, $service_id = null, $name = null, $multiplier = null, $limit = null, $offset = null)
	{
		$q = new query_update(RUDE_DATABASE_TABLE_SERVICES_JOBS);

		if ($service_id !== null) { $q->update('service_id', $service_id); }
		if ($name       !== null) { $q->update('name',       $name      ); }
		if ($multiplier !== null) { $q->update('multiplier', $multiplier); }

		$q->where(RUDE_DATABASE_TABLE_SERVICES_JOBS_PRIMARY_KEY, $id);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES_JOBS);
		$q->where(RUDE_DATABASE_TABLE_SERVICES_JOBS_PRIMARY_KEY, $id);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function count()
	{
		$database = database();
		$database->query('SELECT COUNT(*) as count FROM ' . RUDE_DATABASE_TABLE_SERVICES_JOBS);

		return $database->get_object()->count;
	}

	public static function get_by_id($id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES_JOBS);
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
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES_JOBS);
		$q->where('service_id', $service_id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_name($name, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES_JOBS);
		$q->where('name', $name);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_multiplier($multiplier, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES_JOBS);
		$q->where('multiplier', $multiplier);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function remove_by_id($id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES_JOBS);
		$q->where('id', $id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_service_id($service_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES_JOBS);
		$q->where('service_id', $service_id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_name($name)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES_JOBS);
		$q->where('name', $name);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_multiplier($multiplier)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES_JOBS);
		$q->where('multiplier', $multiplier);
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

	public static function is_exists_name($name)
	{
		return static::get_by_name($name) == true;
	}

	public static function is_exists_multiplier($multiplier)
	{
		return static::get_by_multiplier($multiplier) == true;
	}
}