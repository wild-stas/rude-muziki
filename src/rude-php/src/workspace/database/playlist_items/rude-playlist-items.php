<?

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_PLAYLIST_ITEMS'))             { define('RUDE_DATABASE_TABLE_PLAYLIST_ITEMS',             'playlist_items'); }
if (!defined('RUDE_DATABASE_TABLE_PLAYLIST_ITEMS_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_PLAYLIST_ITEMS_PRIMARY_KEY', 'id'); }

class playlist_items
{
	public static function get($id = null, $limit = null, $offset = null)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS);
		$q->limit($limit, $offset);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS_PRIMARY_KEY, $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_last($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS);
		$q->order_by(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS_PRIMARY_KEY, 'DESC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function get_first($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS);
		$q->order_by(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS_PRIMARY_KEY, 'ASC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function add($playlist_id = null, $song_id = null)
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS);

		if ($playlist_id !== null) { $q->add('playlist_id', $playlist_id); }
		if ($song_id     !== null) { $q->add('song_id',     $song_id    ); }

		$q->query();

		return $q->get_id();
	}

	public static function update($id, $playlist_id = null, $song_id = null, $limit = null, $offset = null)
	{
		$q = new query_update(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS);

		if ($playlist_id !== null) { $q->update('playlist_id', $playlist_id); }
		if ($song_id     !== null) { $q->update('song_id',     $song_id    ); }

		$q->where(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS_PRIMARY_KEY, $id);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS);
		$q->where(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS_PRIMARY_KEY, $id);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function count()
	{
		$database = database();
		$database->query('SELECT COUNT(*) as count FROM ' . RUDE_DATABASE_TABLE_PLAYLIST_ITEMS);

		return $database->get_object()->count;
	}

		public static function get_by_id($id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS);
		$q->where('id', $id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_playlist_id($playlist_id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS);
		$q->where('playlist_id', $playlist_id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_song_id($song_id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS);
		$q->where('song_id', $song_id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function remove_by_id($id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS);
		$q->where('id', $id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_playlist_id($playlist_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS);
		$q->where('playlist_id', $playlist_id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_song_id($song_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_PLAYLIST_ITEMS);
		$q->where('song_id', $song_id);
		$q->query();

		return $q->affected();
	}

	public static function is_exists_id($id)
	{
		return static::get_by_id($id) == true;
	}

	public static function is_exists_playlist_id($playlist_id)
	{
		return static::get_by_playlist_id($playlist_id) == true;
	}

	public static function is_exists_song_id($song_id)
	{
		return static::get_by_song_id($song_id) == true;
	}
}