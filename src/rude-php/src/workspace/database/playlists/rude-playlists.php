<?

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_PLAYLISTS'))             { define('RUDE_DATABASE_TABLE_PLAYLISTS',             'playlists'); }
if (!defined('RUDE_DATABASE_TABLE_PLAYLISTS_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_PLAYLISTS_PRIMARY_KEY', 'id'); }

class playlists
{
	public static function get($id = null, $limit = null, $offset = null)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_PLAYLISTS);
		$q->limit($limit, $offset);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_TABLE_PLAYLISTS_PRIMARY_KEY, $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_last($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_PLAYLISTS);
		$q->order_by(RUDE_DATABASE_TABLE_PLAYLISTS_PRIMARY_KEY, 'DESC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function get_first($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_PLAYLISTS);
		$q->order_by(RUDE_DATABASE_TABLE_PLAYLISTS_PRIMARY_KEY, 'ASC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function add($name = null, $title = null, $description = null, $file_image = null, $file_image_size = null, $timestamp = null)
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_PLAYLISTS);

		if ($name            !== null) { $q->add('name',            $name           ); }
		if ($title           !== null) { $q->add('title',           $title          ); }
		if ($description     !== null) { $q->add('description',     $description    ); }
		if ($file_image      !== null) { $q->add('file_image',      $file_image     ); }
		if ($file_image_size !== null) { $q->add('file_image_size', $file_image_size); }
		if ($timestamp       !== null) { $q->add('timestamp',       $timestamp      ); }

		$q->query();

		return $q->get_id();
	}

	public static function update($id, $name = null, $title = null, $description = null, $file_image = null, $file_image_size = null, $timestamp = null, $limit = null, $offset = null)
	{
		$q = new query_update(RUDE_DATABASE_TABLE_PLAYLISTS);

		if ($name            !== null) { $q->update('name',            $name           ); }
		if ($title           !== null) { $q->update('title',           $title          ); }
		if ($description     !== null) { $q->update('description',     $description    ); }
		if ($file_image      !== null) { $q->update('file_image',      $file_image     ); }
		if ($file_image_size !== null) { $q->update('file_image_size', $file_image_size); }
		if ($timestamp       !== null) { $q->update('timestamp',       $timestamp      ); }

		$q->where(RUDE_DATABASE_TABLE_PLAYLISTS_PRIMARY_KEY, $id);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_PLAYLISTS);
		$q->where(RUDE_DATABASE_TABLE_PLAYLISTS_PRIMARY_KEY, $id);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function count()
	{
		$database = database();
		$database->query('SELECT COUNT(*) as count FROM ' . RUDE_DATABASE_TABLE_PLAYLISTS);

		return $database->get_object()->count;
	}

	public static function get_by_id($id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_PLAYLISTS);
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
		$q = new query_select(RUDE_DATABASE_TABLE_PLAYLISTS);
		$q->where('name', $name);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_title($title, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_PLAYLISTS);
		$q->where('title', $title);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_description($description, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_PLAYLISTS);
		$q->where('description', $description);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_file_image($file_image, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_PLAYLISTS);
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
		$q = new query_select(RUDE_DATABASE_TABLE_PLAYLISTS);
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
		$q = new query_select(RUDE_DATABASE_TABLE_PLAYLISTS);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_PLAYLISTS);
		$q->where('id', $id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_name($name)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_PLAYLISTS);
		$q->where('name', $name);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_title($title)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_PLAYLISTS);
		$q->where('title', $title);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_description($description)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_PLAYLISTS);
		$q->where('description', $description);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_file_image($file_image)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_PLAYLISTS);
		$q->where('file_image', $file_image);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_file_image_size($file_image_size)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_PLAYLISTS);
		$q->where('file_image_size', $file_image_size);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_timestamp($timestamp)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_PLAYLISTS);
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

	public static function is_exists_title($title)
	{
		return static::get_by_title($title) == true;
	}

	public static function is_exists_description($description)
	{
		return static::get_by_description($description) == true;
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