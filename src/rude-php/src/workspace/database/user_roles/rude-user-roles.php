<?

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_USER_ROLES'))             { define('RUDE_DATABASE_TABLE_USER_ROLES',             'user_roles'); }
if (!defined('RUDE_DATABASE_TABLE_USER_ROLES_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_USER_ROLES_PRIMARY_KEY', 'id'); }

class user_roles
{
	public static function get($id = null, $limit = null, $offset = null)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USER_ROLES);
		$q->limit($limit, $offset);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_TABLE_USER_ROLES_PRIMARY_KEY, $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_last($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USER_ROLES);
		$q->order_by(RUDE_DATABASE_TABLE_USER_ROLES_PRIMARY_KEY, 'DESC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function get_first($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USER_ROLES);
		$q->order_by(RUDE_DATABASE_TABLE_USER_ROLES_PRIMARY_KEY, 'ASC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function add($name = null, $is_admin = null, $is_company = null, $is_user = null)
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_USER_ROLES);

		if ($name       !== null) { $q->add('name',       $name      ); }
		if ($is_admin   !== null) { $q->add('is_admin',   $is_admin  ); }
		if ($is_company !== null) { $q->add('is_company', $is_company); }
		if ($is_user    !== null) { $q->add('is_user',    $is_user   ); }

		$q->query();

		return $q->get_id();
	}

	public static function update($id, $name = null, $is_admin = null, $is_company = null, $is_user = null, $limit = null, $offset = null)
	{
		$q = new query_update(RUDE_DATABASE_TABLE_USER_ROLES);

		if ($name       !== null) { $q->update('name',       $name      ); }
		if ($is_admin   !== null) { $q->update('is_admin',   $is_admin  ); }
		if ($is_company !== null) { $q->update('is_company', $is_company); }
		if ($is_user    !== null) { $q->update('is_user',    $is_user   ); }

		$q->where(RUDE_DATABASE_TABLE_USER_ROLES_PRIMARY_KEY, $id);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_USER_ROLES);
		$q->where(RUDE_DATABASE_TABLE_USER_ROLES_PRIMARY_KEY, $id);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function count()
	{
		$database = database();
		$database->query('SELECT COUNT(*) as count FROM ' . RUDE_DATABASE_TABLE_USER_ROLES);

		return $database->get_object()->count;
	}

	public static function get_by_id($id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USER_ROLES);
		$q->where('id', $id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_name($name, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USER_ROLES);
		$q->where('name', $name);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_is_admin($is_admin, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USER_ROLES);
		$q->where('is_admin', $is_admin);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_is_company($is_company, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USER_ROLES);
		$q->where('is_company', $is_company);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_is_user($is_user, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_USER_ROLES);
		$q->where('is_user', $is_user);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function remove_by_id($id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_USER_ROLES);
		$q->where('id', $id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_name($name)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_USER_ROLES);
		$q->where('name', $name);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_is_admin($is_admin)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_USER_ROLES);
		$q->where('is_admin', $is_admin);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_is_company($is_company)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_USER_ROLES);
		$q->where('is_company', $is_company);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_is_user($is_user)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_USER_ROLES);
		$q->where('is_user', $is_user);
		$q->query();

		return $q->affected();
	}

	public static function is_exists_id($id)
	{
		return static::get_by_id($id) == true;
	}

	public static function is_exists_name($name)
	{
		return static::get_by_name($name) == true;
	}

	public static function is_exists_is_admin($is_admin)
	{
		return static::get_by_is_admin($is_admin) == true;
	}

	public static function is_exists_is_company($is_company)
	{
		return static::get_by_is_company($is_company) == true;
	}

	public static function is_exists_is_user($is_user)
	{
		return static::get_by_is_user($is_user) == true;
	}
}