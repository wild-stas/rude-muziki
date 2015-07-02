<?

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_SONGS'))             { define('RUDE_DATABASE_TABLE_SONGS',             'songs'); }
if (!defined('RUDE_DATABASE_TABLE_SONGS_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_SONGS_PRIMARY_KEY', 'id'); }

class songs
{
	public static function get($id = null, $limit = null, $offset = null)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SONGS);
		$q->limit($limit, $offset);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_TABLE_SONGS_PRIMARY_KEY, $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_last($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SONGS);
		$q->order_by(RUDE_DATABASE_TABLE_SONGS_PRIMARY_KEY, 'DESC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function get_first($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SONGS);
		$q->order_by(RUDE_DATABASE_TABLE_SONGS_PRIMARY_KEY, 'ASC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function add($name = null, $description = null, $author_id = null, $genre_id = null, $length = null, $file_audio = null, $file_audio_size = null, $file_image = null, $file_image_size = null, $timestamp = null)
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_SONGS);

		if ($name            !== null) { $q->add('name',            $name           ); }
		if ($description     !== null) { $q->add('description',     $description    ); }
		if ($author_id       !== null) { $q->add('author_id',       $author_id      ); }
		if ($genre_id        !== null) { $q->add('genre_id',        $genre_id       ); }
		if ($length          !== null) { $q->add('length',          $length         ); }
		if ($file_audio      !== null) { $q->add('file_audio',      $file_audio     ); }
		if ($file_audio_size !== null) { $q->add('file_audio_size', $file_audio_size); }
		if ($file_image      !== null) { $q->add('file_image',      $file_image     ); }
		if ($file_image_size !== null) { $q->add('file_image_size', $file_image_size); }
		if ($timestamp       !== null) { $q->add('timestamp',       $timestamp      ); }

		$q->query();

		return $q->get_id();
	}

	public static function update($id, $name = null, $description = null, $author_id = null, $genre_id = null, $length = null, $file_audio = null, $file_audio_size = null, $file_image = null, $file_image_size = null, $timestamp = null, $limit = null, $offset = null)
	{
		$q = new query_update(RUDE_DATABASE_TABLE_SONGS);

		if ($name            !== null) { $q->update('name',            $name           ); }
		if ($description     !== null) { $q->update('description',     $description    ); }
		if ($author_id       !== null) { $q->update('author_id',       $author_id      ); }
		if ($genre_id        !== null) { $q->update('genre_id',        $genre_id       ); }
		if ($length          !== null) { $q->update('length',          $length         ); }
		if ($file_audio      !== null) { $q->update('file_audio',      $file_audio     ); }
		if ($file_audio_size !== null) { $q->update('file_audio_size', $file_audio_size); }
		if ($file_image      !== null) { $q->update('file_image',      $file_image     ); }
		if ($file_image_size !== null) { $q->update('file_image_size', $file_image_size); }
		if ($timestamp       !== null) { $q->update('timestamp',       $timestamp      ); }

		$q->where(RUDE_DATABASE_TABLE_SONGS_PRIMARY_KEY, $id);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_SONGS);
		$q->where(RUDE_DATABASE_TABLE_SONGS_PRIMARY_KEY, $id);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function count()
	{
		$database = database();
		$database->query('SELECT COUNT(*) as count FROM ' . RUDE_DATABASE_TABLE_SONGS);

		return $database->get_object()->count;
	}

	public static function get_by_id($id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SONGS);
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
		$q = new query_select(RUDE_DATABASE_TABLE_SONGS);
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
		$q = new query_select(RUDE_DATABASE_TABLE_SONGS);
		$q->where('description', $description);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_author_id($author_id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SONGS);
		$q->where('author_id', $author_id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_genre_id($genre_id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SONGS);
		$q->where('genre_id', $genre_id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_length($length, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SONGS);
		$q->where('length', $length);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_file_audio($file_audio, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SONGS);
		$q->where('file_audio', $file_audio);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_file_audio_size($file_audio_size, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SONGS);
		$q->where('file_audio_size', $file_audio_size);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_file_image($file_image, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SONGS);
		$q->where('file_image', $file_image);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_file_image_size($file_image_size, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SONGS);
		$q->where('file_image_size', $file_image_size);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_timestamp($timestamp, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_SONGS);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_SONGS);
		$q->where('id', $id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_name($name)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SONGS);
		$q->where('name', $name);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_description($description)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SONGS);
		$q->where('description', $description);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_author_id($author_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SONGS);
		$q->where('author_id', $author_id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_genre_id($genre_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SONGS);
		$q->where('genre_id', $genre_id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_length($length)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SONGS);
		$q->where('length', $length);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_file_audio($file_audio)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SONGS);
		$q->where('file_audio', $file_audio);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_file_audio_size($file_audio_size)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SONGS);
		$q->where('file_audio_size', $file_audio_size);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_file_image($file_image)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SONGS);
		$q->where('file_image', $file_image);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_file_image_size($file_image_size)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SONGS);
		$q->where('file_image_size', $file_image_size);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_timestamp($timestamp)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_SONGS);
		$q->where('timestamp', $timestamp);
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

	public static function is_exists_description($description)
	{
		return static::get_by_description($description) == true;
	}

	public static function is_exists_author_id($author_id)
	{
		return static::get_by_author_id($author_id) == true;
	}

	public static function is_exists_genre_id($genre_id)
	{
		return static::get_by_genre_id($genre_id) == true;
	}

	public static function is_exists_length($length)
	{
		return static::get_by_length($length) == true;
	}

	public static function is_exists_file_audio($file_audio)
	{
		return static::get_by_file_audio($file_audio) == true;
	}

	public static function is_exists_file_audio_size($file_audio_size)
	{
		return static::get_by_file_audio_size($file_audio_size) == true;
	}

	public static function is_exists_file_image($file_image)
	{
		return static::get_by_file_image($file_image) == true;
	}

	public static function is_exists_file_image_size($file_image_size)
	{
		return static::get_by_file_image_size($file_image_size) == true;
	}

	public static function is_exists_timestamp($timestamp)
	{
		return static::get_by_timestamp($timestamp) == true;
	}
}