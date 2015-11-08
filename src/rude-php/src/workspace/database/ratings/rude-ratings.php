<?

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_RATINGS'))             { define('RUDE_DATABASE_TABLE_RATINGS',             'ratings'); }
if (!defined('RUDE_DATABASE_TABLE_RATINGS_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_RATINGS_PRIMARY_KEY', 'id'); }

class ratings
{
	public static function get($id = null, $limit = null, $offset = null)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_RATINGS);
		$q->limit($limit, $offset);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_TABLE_RATINGS_PRIMARY_KEY, $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_last($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_RATINGS);
		$q->order_by(RUDE_DATABASE_TABLE_RATINGS_PRIMARY_KEY, 'DESC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function get_first($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_RATINGS);
		$q->order_by(RUDE_DATABASE_TABLE_RATINGS_PRIMARY_KEY, 'ASC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function add($user_id = null, $song_id = null, $value = null, $timestamp = null)
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_RATINGS);

		if ($user_id   !== null) { $q->add('user_id',   $user_id  ); }
		if ($song_id   !== null) { $q->add('song_id',   $song_id  ); }
		if ($value     !== null) { $q->add('value',     $value    ); }
		if ($timestamp !== null) { $q->add('timestamp', $timestamp); }

		$q->query();

		return $q->get_id();
	}

	public static function update($id, $user_id = null, $song_id = null, $value = null, $timestamp = null, $limit = null, $offset = null)
	{
		$q = new query_update(RUDE_DATABASE_TABLE_RATINGS);

		if ($user_id   !== null) { $q->update('user_id',   $user_id  ); }
		if ($song_id   !== null) { $q->update('song_id',   $song_id  ); }
		if ($value     !== null) { $q->update('value',     $value    ); }
		if ($timestamp !== null) { $q->update('timestamp', $timestamp); }

		$q->where(RUDE_DATABASE_TABLE_RATINGS_PRIMARY_KEY, $id);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_RATINGS);
		$q->where(RUDE_DATABASE_TABLE_RATINGS_PRIMARY_KEY, $id);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function count()
	{
		$database = database();
		$database->query('SELECT COUNT(*) as count FROM ' . RUDE_DATABASE_TABLE_RATINGS);

		return $database->get_object()->count;
	}

	public static function get_by_id($id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_RATINGS);
		$q->where('id', $id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_user_id($user_id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_RATINGS);
		$q->where('user_id', $user_id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_song_id($song_id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_RATINGS);
		$q->where('song_id', $song_id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_value($value, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_RATINGS);
		$q->where('value', $value);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_timestamp($timestamp, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_RATINGS);
		$q->where('timestamp', $timestamp);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function remove_by_id($id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_RATINGS);
		$q->where('id', $id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_user_id($user_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_RATINGS);
		$q->where('user_id', $user_id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_song_id($song_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_RATINGS);
		$q->where('song_id', $song_id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_value($value)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_RATINGS);
		$q->where('value', $value);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_timestamp($timestamp)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_RATINGS);
		$q->where('timestamp', $timestamp);
		$q->query();

		return $q->affected();
	}

	public static function is_exists_id($id)
	{
		return static::get_by_id($id) == true;
	}

	public static function is_exists_user_id($user_id)
	{
		return static::get_by_user_id($user_id) == true;
	}

	public static function is_exists_song_id($song_id)
	{
		return static::get_by_song_id($song_id) == true;
	}

	public static function is_exists_value($value)
	{
		return static::get_by_value($value) == true;
	}

	public static function is_exists_timestamp($timestamp)
	{
		return static::get_by_timestamp($timestamp) == true;
	}
}