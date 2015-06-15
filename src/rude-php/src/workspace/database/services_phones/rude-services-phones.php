<?

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_SERVICES_PHONES'))             { define('RUDE_DATABASE_TABLE_SERVICES_PHONES',             'services_phones'); }
if (!defined('RUDE_DATABASE_TABLE_SERVICES_PHONES_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_SERVICES_PHONES_PRIMARY_KEY', 'id'); }

class services_phones
{
	public static function get($id = null, $limit = null, $offset = null)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES_PHONES);
		$q->limit($limit, $offset);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_TABLE_SERVICES_PHONES_PRIMARY_KEY, $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_last($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES_PHONES);
		$q->order_by(RUDE_DATABASE_TABLE_SERVICES_PHONES_PRIMARY_KEY, 'DESC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function get_first($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES_PHONES);
		$q->order_by(RUDE_DATABASE_TABLE_SERVICES_PHONES_PRIMARY_KEY, 'ASC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function add($service_id = null, $phone = null)
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_SERVICES_PHONES);

		if ($service_id !== null) { $q->add('service_id', $service_id); }
		if ($phone      !== null) { $q->add('phone',      $phone     ); }

		$q->query();

		return $q->get_id();
	}

	public static function update($id, $service_id = null, $phone = null, $limit = null, $offset = null)
	{
		$q = new query_update(RUDE_DATABASE_TABLE_SERVICES_PHONES);

		if ($service_id !== null) { $q->update('service_id', $service_id); }
		if ($phone      !== null) { $q->update('phone',      $phone     ); }

		$q->where(RUDE_DATABASE_TABLE_SERVICES_PHONES_PRIMARY_KEY, $id);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES_PHONES);
		$q->where(RUDE_DATABASE_TABLE_SERVICES_PHONES_PRIMARY_KEY, $id);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function count()
	{
		$database = database();
		$database->query('SELECT COUNT(*) as count FROM ' . RUDE_DATABASE_TABLE_SERVICES_PHONES);

		return $database->get_object()->count;
	}

	public static function get_by_id($id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES_PHONES);
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
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES_PHONES);
		$q->where('service_id', $service_id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_phone($phone, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES_PHONES);
		$q->where('phone', $phone);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function remove_by_id($id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES_PHONES);
		$q->where('id', $id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_service_id($service_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES_PHONES);
		$q->where('service_id', $service_id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_phone($phone)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES_PHONES);
		$q->where('phone', $phone);
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

	public static function is_exists_phone($phone)
	{
		return static::get_by_phone($phone) == true;
	}
}