<?

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_SONG_AUTHORS'))             { define('RUDE_DATABASE_TABLE_SONG_AUTHORS',             'song_authors'); }
if (!defined('RUDE_DATABASE_TABLE_SONG_AUTHORS_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_SONG_AUTHORS_PRIMARY_KEY', 'id'); }

class song_authors
{
	public static function get($id = null, $limit = null, $offset = null)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SONG_AUTHORS);
		$q->limit($limit, $offset);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_TABLE_SONG_AUTHORS_PRIMARY_KEY, $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_last($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SONG_AUTHORS);
		$q->order_by(RUDE_DATABASE_TABLE_SONG_AUTHORS_PRIMARY_KEY, 'DESC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function get_first($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SONG_AUTHORS);
		$q->order_by(RUDE_DATABASE_TABLE_SONG_AUTHORS_PRIMARY_KEY, 'ASC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function add($name = null)
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_SONG_AUTHORS);

		if ($name !== null) { $q->add('name', $name); }

		$q->query();

		return $q->get_id();
	}

	public static function update($id, $name = null, $limit = null, $offset = null)
	{
		$q = new query_update(RUDE_DATABASE_TABLE_SONG_AUTHORS);

		if ($name !== null) { $q->update('name', $name); }

		$q->where(RUDE_DATABASE_TABLE_SONG_AUTHORS_PRIMARY_KEY, $id);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_SONG_AUTHORS);
		$q->where(RUDE_DATABASE_TABLE_SONG_AUTHORS_PRIMARY_KEY, $id);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function count()
	{
		$database = database();
		$database->query('SELECT COUNT(*) as count FROM ' . RUDE_DATABASE_TABLE_SONG_AUTHORS);

		return $database->get_object()->count;
	}

		public static function get_by_id($id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SONG_AUTHORS);
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
		$q = new query_select(RUDE_DATABASE_TABLE_SONG_AUTHORS);
		$q->where('name', $name);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function remove_by_id($id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SONG_AUTHORS);
		$q->where('id', $id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_name($name)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SONG_AUTHORS);
		$q->where('name', $name);
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
}