<?

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_SERVICES'))             { define('RUDE_DATABASE_TABLE_SERVICES',             'services'); }
if (!defined('RUDE_DATABASE_TABLE_SERVICES_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_SERVICES_PRIMARY_KEY', 'id'); }

class services
{
	public static function get($id = null, $limit = null, $offset = null)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES);
		$q->limit($limit, $offset);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_TABLE_SERVICES_PRIMARY_KEY, $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_last($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES);
		$q->order_by(RUDE_DATABASE_TABLE_SERVICES_PRIMARY_KEY, 'DESC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function get_first($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES);
		$q->order_by(RUDE_DATABASE_TABLE_SERVICES_PRIMARY_KEY, 'ASC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function add($type_id = null, $user_id = null, $name = null, $description = null, $address = null, $latitude = null, $longitude = null, $logo = null)
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_SERVICES);

		if ($type_id     !== null) { $q->add('type_id',     $type_id    ); }
		if ($user_id     !== null) { $q->add('user_id',     $user_id    ); }
		if ($name        !== null) { $q->add('name',        $name       ); }
		if ($description !== null) { $q->add('description', $description); }
		if ($address     !== null) { $q->add('address',     $address    ); }
		if ($latitude    !== null) { $q->add('latitude',    $latitude   ); }
		if ($longitude   !== null) { $q->add('longitude',   $longitude  ); }
		if ($logo        !== null) { $q->add('logo',        $logo       ); }

		$q->query();

		return $q->get_id();
	}

	public static function update($id, $type_id = null, $user_id = null, $name = null, $description = null, $address = null, $latitude = null, $longitude = null, $logo = null, $limit = null, $offset = null)
	{
		$q = new query_update(RUDE_DATABASE_TABLE_SERVICES);

		if ($type_id     !== null) { $q->update('type_id',     $type_id    ); }
		if ($user_id     !== null) { $q->update('user_id',     $user_id    ); }
		if ($name        !== null) { $q->update('name',        $name       ); }
		if ($description !== null) { $q->update('description', $description); }
		if ($address     !== null) { $q->update('address',     $address    ); }
		if ($latitude    !== null) { $q->update('latitude',    $latitude   ); }
		if ($longitude   !== null) { $q->update('longitude',   $longitude  ); }
		if ($logo        !== null) { $q->update('logo',        $logo       ); }

		$q->where(RUDE_DATABASE_TABLE_SERVICES_PRIMARY_KEY, $id);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES);
		$q->where(RUDE_DATABASE_TABLE_SERVICES_PRIMARY_KEY, $id);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function count()
	{
		$database = database();
		$database->query('SELECT COUNT(*) as count FROM ' . RUDE_DATABASE_TABLE_SERVICES);

		return $database->get_object()->count;
	}

	public static function get_by_id($id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('id', $id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_type_id($type_id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('type_id', $type_id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_user_id($user_id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('user_id', $user_id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_name($name, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('name', $name);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_description($description, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('description', $description);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_address($address, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('address', $address);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_latitude($latitude, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('latitude', $latitude);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_longitude($longitude, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('longitude', $longitude);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_logo($logo, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('logo', $logo);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function remove_by_id($id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('id', $id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_type_id($type_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('type_id', $type_id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_user_id($user_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('user_id', $user_id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_name($name)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('name', $name);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_description($description)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('description', $description);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_address($address)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('address', $address);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_latitude($latitude)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('latitude', $latitude);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_longitude($longitude)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('longitude', $longitude);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_logo($logo)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SERVICES);
		$q->where('logo', $logo);
		$q->query();

		return $q->affected();
	}

	public static function is_exists_id($id)
	{
		return static::get_by_id($id) == true;
	}

	public static function is_exists_type_id($type_id)
	{
		return static::get_by_type_id($type_id) == true;
	}

	public static function is_exists_user_id($user_id)
	{
		return static::get_by_user_id($user_id) == true;
	}

	public static function is_exists_name($name)
	{
		return static::get_by_name($name) == true;
	}

	public static function is_exists_description($description)
	{
		return static::get_by_description($description) == true;
	}

	public static function is_exists_address($address)
	{
		return static::get_by_address($address) == true;
	}

	public static function is_exists_latitude($latitude)
	{
		return static::get_by_latitude($latitude) == true;
	}

	public static function is_exists_longitude($longitude)
	{
		return static::get_by_longitude($longitude) == true;
	}

	public static function is_exists_logo($logo)
	{
		return static::get_by_logo($logo) == true;
	}
}