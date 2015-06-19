<?

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_COMMENTS'))             { define('RUDE_DATABASE_TABLE_COMMENTS',             'comments'); }
if (!defined('RUDE_DATABASE_TABLE_COMMENTS_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_COMMENTS_PRIMARY_KEY', 'id'); }

class comments
{
	public static function get($id = null, $limit = null, $offset = null)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_COMMENTS);
		$q->limit($limit, $offset);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_TABLE_COMMENTS_PRIMARY_KEY, $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_last($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_COMMENTS);
		$q->order_by(RUDE_DATABASE_TABLE_COMMENTS_PRIMARY_KEY, 'DESC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function get_first($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_COMMENTS);
		$q->order_by(RUDE_DATABASE_TABLE_COMMENTS_PRIMARY_KEY, 'ASC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function add($song_id = null, $user_id = null, $text = null, $timestamp = null)
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_COMMENTS);

		if ($song_id   !== null) { $q->add('song_id',   $song_id  ); }
		if ($user_id   !== null) { $q->add('user_id',   $user_id  ); }
		if ($text      !== null) { $q->add('text',      $text     ); }
		if ($timestamp !== null) { $q->add('timestamp', $timestamp); }

		$q->query();

		return $q->get_id();
	}

	public static function update($id, $song_id = null, $user_id = null, $text = null, $timestamp = null, $limit = null, $offset = null)
	{
		$q = new query_update(RUDE_DATABASE_TABLE_COMMENTS);

		if ($song_id   !== null) { $q->update('song_id',   $song_id  ); }
		if ($user_id   !== null) { $q->update('user_id',   $user_id  ); }
		if ($text      !== null) { $q->update('text',      $text     ); }
		if ($timestamp !== null) { $q->update('timestamp', $timestamp); }

		$q->where(RUDE_DATABASE_TABLE_COMMENTS_PRIMARY_KEY, $id);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_COMMENTS);
		$q->where(RUDE_DATABASE_TABLE_COMMENTS_PRIMARY_KEY, $id);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function count()
	{
		$database = database();
		$database->query('SELECT COUNT(*) as count FROM ' . RUDE_DATABASE_TABLE_COMMENTS);

		return $database->get_object()->count;
	}

		public static function get_by_id($id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_COMMENTS);
		$q->where('id', $id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_song_id($song_id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_COMMENTS);
		$q->where('song_id', $song_id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_user_id($user_id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_COMMENTS);
		$q->where('user_id', $user_id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_text($text, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_COMMENTS);
		$q->where('text', $text);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_timestamp($timestamp, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_COMMENTS);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_COMMENTS);
		$q->where('id', $id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_song_id($song_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_COMMENTS);
		$q->where('song_id', $song_id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_user_id($user_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_COMMENTS);
		$q->where('user_id', $user_id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_text($text)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_COMMENTS);
		$q->where('text', $text);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_timestamp($timestamp)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_COMMENTS);
		$q->where('timestamp', $timestamp);
		$q->query();

		return $q->affected();
	}

	public static function is_exists_id($id)
	{
		return static::get_by_id($id) == true;
	}

	public static function is_exists_song_id($song_id)
	{
		return static::get_by_song_id($song_id) == true;
	}

	public static function is_exists_user_id($user_id)
	{
		return static::get_by_user_id($user_id) == true;
	}

	public static function is_exists_text($text)
	{
		return static::get_by_text($text) == true;
	}

	public static function is_exists_timestamp($timestamp)
	{
		return static::get_by_timestamp($timestamp) == true;
	}
}