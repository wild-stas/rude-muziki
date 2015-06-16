<?

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_USERS'))             { define('RUDE_DATABASE_TABLE_USERS',             'users'); }
if (!defined('RUDE_DATABASE_TABLE_USERS_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_USERS_PRIMARY_KEY', 'id'); }

class users
{
	public static function get($id = null, $limit = null, $offset = null)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USERS);
		$q->limit($limit, $offset);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_TABLE_USERS_PRIMARY_KEY, $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_last($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USERS);
		$q->order_by(RUDE_DATABASE_TABLE_USERS_PRIMARY_KEY, 'DESC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function get_first($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USERS);
		$q->order_by(RUDE_DATABASE_TABLE_USERS_PRIMARY_KEY, 'ASC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function add($role_id = null, $name = null, $email = null, $hash = null, $salt = null, $registered = null)
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_USERS);

		if ($role_id    !== null) { $q->add('role_id',    $role_id   ); }
		if ($name       !== null) { $q->add('name',       $name      ); }
		if ($email      !== null) { $q->add('email',      $email     ); }
		if ($hash       !== null) { $q->add('hash',       $hash      ); }
		if ($salt       !== null) { $q->add('salt',       $salt      ); }
		if ($registered !== null) { $q->add('registered', $registered); }

		$q->query();

		return $q->get_id();
	}

	public static function update($id, $role_id = null, $name = null, $email = null, $hash = null, $salt = null, $registered = null, $limit = null, $offset = null)
	{
		$q = new query_update(RUDE_DATABASE_TABLE_USERS);

		if ($role_id    !== null) { $q->update('role_id',    $role_id   ); }
		if ($name       !== null) { $q->update('name',       $name      ); }
		if ($email      !== null) { $q->update('email',      $email     ); }
		if ($hash       !== null) { $q->update('hash',       $hash      ); }
		if ($salt       !== null) { $q->update('salt',       $salt      ); }
		if ($registered !== null) { $q->update('registered', $registered); }

		$q->where(RUDE_DATABASE_TABLE_USERS_PRIMARY_KEY, $id);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_USERS);
		$q->where(RUDE_DATABASE_TABLE_USERS_PRIMARY_KEY, $id);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function count()
	{
		$database = database();
		$database->query('SELECT COUNT(*) as count FROM ' . RUDE_DATABASE_TABLE_USERS);

		return $database->get_object()->count;
	}

		public static function get_by_id($id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USERS);
		$q->where('id', $id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_role_id($role_id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USERS);
		$q->where('role_id', $role_id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_name($name, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USERS);
		$q->where('name', $name);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_email($email, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USERS);
		$q->where('email', $email);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_hash($hash, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USERS);
		$q->where('hash', $hash);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_salt($salt, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USERS);
		$q->where('salt', $salt);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_registered($registered, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USERS);
		$q->where('registered', $registered);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function remove_by_id($id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_USERS);
		$q->where('id', $id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_role_id($role_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_USERS);
		$q->where('role_id', $role_id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_name($name)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_USERS);
		$q->where('name', $name);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_email($email)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_USERS);
		$q->where('email', $email);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_hash($hash)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_USERS);
		$q->where('hash', $hash);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_salt($salt)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_USERS);
		$q->where('salt', $salt);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_registered($registered)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_USERS);
		$q->where('registered', $registered);
		$q->query();

		return $q->affected();
	}

	public static function is_exists_id($id)
	{
		return static::get_by_id($id) == true;
	}

	public static function is_exists_role_id($role_id)
	{
		return static::get_by_role_id($role_id) == true;
	}

	public static function is_exists_name($name)
	{
		return static::get_by_name($name) == true;
	}

	public static function is_exists_email($email)
	{
		return static::get_by_email($email) == true;
	}

	public static function is_exists_hash($hash)
	{
		return static::get_by_hash($hash) == true;
	}

	public static function is_exists_salt($salt)
	{
		return static::get_by_salt($salt) == true;
	}

	public static function is_exists_registered($registered)
	{
		return static::get_by_registered($registered) == true;
	}
}