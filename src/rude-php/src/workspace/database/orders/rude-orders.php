<?

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_ORDERS'))             { define('RUDE_DATABASE_TABLE_ORDERS',             'orders'); }
if (!defined('RUDE_DATABASE_TABLE_ORDERS_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_ORDERS_PRIMARY_KEY', 'id'); }

class orders
{
	public static function get($id = null, $limit = null, $offset = null)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_ORDERS);
		$q->limit($limit, $offset);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_TABLE_ORDERS_PRIMARY_KEY, $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_last($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_ORDERS);
		$q->order_by(RUDE_DATABASE_TABLE_ORDERS_PRIMARY_KEY, 'DESC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function get_first($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_ORDERS);
		$q->order_by(RUDE_DATABASE_TABLE_ORDERS_PRIMARY_KEY, 'ASC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function add($service_id = null, $name = null, $time_from = null, $time_to = null, $date = null, $user_name = null, $user_phone = null, $user_email = null, $user_message = null)
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_ORDERS);

		if ($service_id   !== null) { $q->add('service_id',   $service_id  ); }
		if ($name         !== null) { $q->add('name',         $name        ); }
		if ($time_from    !== null) { $q->add('time_from',    $time_from   ); }
		if ($time_to      !== null) { $q->add('time_to',      $time_to     ); }
		if ($date         !== null) { $q->add('date',         $date        ); }
		if ($user_name    !== null) { $q->add('user_name',    $user_name   ); }
		if ($user_phone   !== null) { $q->add('user_phone',   $user_phone  ); }
		if ($user_email   !== null) { $q->add('user_email',   $user_email  ); }
		if ($user_message !== null) { $q->add('user_message', $user_message); }

		$q->query();

		return $q->get_id();
	}

	public static function update($id, $service_id = null, $name = null, $time_from = null, $time_to = null, $date = null, $user_name = null, $user_phone = null, $user_email = null, $user_message = null, $limit = null, $offset = null)
	{
		$q = new query_update(RUDE_DATABASE_TABLE_ORDERS);

		if ($service_id   !== null) { $q->update('service_id',   $service_id  ); }
		if ($name         !== null) { $q->update('name',         $name        ); }
		if ($time_from    !== null) { $q->update('time_from',    $time_from   ); }
		if ($time_to      !== null) { $q->update('time_to',      $time_to     ); }
		if ($date         !== null) { $q->update('date',         $date        ); }
		if ($user_name    !== null) { $q->update('user_name',    $user_name   ); }
		if ($user_phone   !== null) { $q->update('user_phone',   $user_phone  ); }
		if ($user_email   !== null) { $q->update('user_email',   $user_email  ); }
		if ($user_message !== null) { $q->update('user_message', $user_message); }

		$q->where(RUDE_DATABASE_TABLE_ORDERS_PRIMARY_KEY, $id);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_ORDERS);
		$q->where(RUDE_DATABASE_TABLE_ORDERS_PRIMARY_KEY, $id);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function count()
	{
		$database = database();
		$database->query('SELECT COUNT(*) as count FROM ' . RUDE_DATABASE_TABLE_ORDERS);

		return $database->get_object()->count;
	}

	public static function get_by_id($id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_ORDERS);
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
		$q = new query_select(RUDE_DATABASE_TABLE_ORDERS);
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
		$q = new query_select(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('name', $name);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_time_from($time_from, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('time_from', $time_from);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_time_to($time_to, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('time_to', $time_to);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_date($date, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('date', $date);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_user_name($user_name, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('user_name', $user_name);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_user_phone($user_phone, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('user_phone', $user_phone);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_user_email($user_email, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('user_email', $user_email);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_user_message($user_message, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('user_message', $user_message);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function remove_by_id($id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('id', $id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_service_id($service_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('service_id', $service_id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_name($name)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('name', $name);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_time_from($time_from)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('time_from', $time_from);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_time_to($time_to)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('time_to', $time_to);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_date($date)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('date', $date);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_user_name($user_name)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('user_name', $user_name);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_user_phone($user_phone)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('user_phone', $user_phone);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_user_email($user_email)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('user_email', $user_email);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_user_message($user_message)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_ORDERS);
		$q->where('user_message', $user_message);
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

	public static function is_exists_time_from($time_from)
	{
		return static::get_by_time_from($time_from) == true;
	}

	public static function is_exists_time_to($time_to)
	{
		return static::get_by_time_to($time_to) == true;
	}

	public static function is_exists_date($date)
	{
		return static::get_by_date($date) == true;
	}

	public static function is_exists_user_name($user_name)
	{
		return static::get_by_user_name($user_name) == true;
	}

	public static function is_exists_user_phone($user_phone)
	{
		return static::get_by_user_phone($user_phone) == true;
	}

	public static function is_exists_user_email($user_email)
	{
		return static::get_by_user_email($user_email) == true;
	}

	public static function is_exists_user_message($user_message)
	{
		return static::get_by_user_message($user_message) == true;
	}
}