<?

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_TIMETABLE_ITEMS'))             { define('RUDE_DATABASE_TABLE_TIMETABLE_ITEMS',             'timetable_items'); }
if (!defined('RUDE_DATABASE_TABLE_TIMETABLE_ITEMS_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_TIMETABLE_ITEMS_PRIMARY_KEY', 'id'); }

class timetable_items
{
	public static function get($id = null, $limit = null, $offset = null)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->limit($limit, $offset);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS_PRIMARY_KEY, $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_last($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->order_by(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS_PRIMARY_KEY, 'DESC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function get_first($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->order_by(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS_PRIMARY_KEY, 'ASC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function add($timetable_id = null, $timetable_day_id = null, $is_day_off = null, $working_begin = null, $working_end = null, $lanch_begin = null, $lanch_end = null)
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);

		if ($timetable_id     !== null) { $q->add('timetable_id',     $timetable_id    ); }
		if ($timetable_day_id !== null) { $q->add('timetable_day_id', $timetable_day_id); }
		if ($is_day_off       !== null) { $q->add('is_day_off',       $is_day_off      ); }
		if ($working_begin    !== null) { $q->add('working_begin',    $working_begin   ); }
		if ($working_end      !== null) { $q->add('working_end',      $working_end     ); }
		if ($lanch_begin      !== null) { $q->add('lanch_begin',      $lanch_begin     ); }
		if ($lanch_end        !== null) { $q->add('lanch_end',        $lanch_end       ); }

		$q->query();

		return $q->get_id();
	}

	public static function update($id, $timetable_id = null, $timetable_day_id = null, $is_day_off = null, $working_begin = null, $working_end = null, $lanch_begin = null, $lanch_end = null, $limit = null, $offset = null)
	{
		$q = new query_update(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);

		if ($timetable_id     !== null) { $q->update('timetable_id',     $timetable_id    ); }
		if ($timetable_day_id !== null) { $q->update('timetable_day_id', $timetable_day_id); }
		if ($is_day_off       !== null) { $q->update('is_day_off',       $is_day_off      ); }
		if ($working_begin    !== null) { $q->update('working_begin',    $working_begin   ); }
		if ($working_end      !== null) { $q->update('working_end',      $working_end     ); }
		if ($lanch_begin      !== null) { $q->update('lanch_begin',      $lanch_begin     ); }
		if ($lanch_end        !== null) { $q->update('lanch_end',        $lanch_end       ); }

		$q->where(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS_PRIMARY_KEY, $id);
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
		$q = new query_delete(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS_PRIMARY_KEY, $id);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function count()
	{
		$database = database();
		$database->query('SELECT COUNT(*) as count FROM ' . RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);

		return $database->get_object()->count;
	}

	public static function get_by_id($id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where('id', $id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_timetable_id($timetable_id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where('timetable_id', $timetable_id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_timetable_day_id($timetable_day_id, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where('timetable_day_id', $timetable_day_id);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_is_day_off($is_day_off, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where('is_day_off', $is_day_off);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_working_begin($working_begin, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where('working_begin', $working_begin);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_working_end($working_end, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where('working_end', $working_end);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_lanch_begin($lanch_begin, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where('lanch_begin', $lanch_begin);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function get_by_lanch_end($lanch_end, $only_first = false)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where('lanch_end', $lanch_end);
		$q->query();

		if ($only_first)
		{
			return $q->get_object();
		}

		return $q->get_object_list();
	}

	public static function remove_by_id($id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where('id', $id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_timetable_id($timetable_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where('timetable_id', $timetable_id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_timetable_day_id($timetable_day_id)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where('timetable_day_id', $timetable_day_id);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_is_day_off($is_day_off)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where('is_day_off', $is_day_off);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_working_begin($working_begin)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where('working_begin', $working_begin);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_working_end($working_end)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where('working_end', $working_end);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_lanch_begin($lanch_begin)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where('lanch_begin', $lanch_begin);
		$q->query();

		return $q->affected();
	}

	public static function remove_by_lanch_end($lanch_end)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_TIMETABLE_ITEMS);
		$q->where('lanch_end', $lanch_end);
		$q->query();

		return $q->affected();
	}

	public static function is_exists_id($id)
	{
		return static::get_by_id($id) == true;
	}

	public static function is_exists_timetable_id($timetable_id)
	{
		return static::get_by_timetable_id($timetable_id) == true;
	}

	public static function is_exists_timetable_day_id($timetable_day_id)
	{
		return static::get_by_timetable_day_id($timetable_day_id) == true;
	}

	public static function is_exists_is_day_off($is_day_off)
	{
		return static::get_by_is_day_off($is_day_off) == true;
	}

	public static function is_exists_working_begin($working_begin)
	{
		return static::get_by_working_begin($working_begin) == true;
	}

	public static function is_exists_working_end($working_end)
	{
		return static::get_by_working_end($working_end) == true;
	}

	public static function is_exists_lanch_begin($lanch_begin)
	{
		return static::get_by_lanch_begin($lanch_begin) == true;
	}

	public static function is_exists_lanch_end($lanch_end)
	{
		return static::get_by_lanch_end($lanch_end) == true;
	}
}