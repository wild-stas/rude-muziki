

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%'))             { define('RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%',             '%TABLE_NAME%'); }
if (!defined('RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%_PRIMARY_KEY', '%PRIMARY%'); }

class %CLASS_NAME%
{
	public static function get($%PRIMARY_ESCAPED% = null, $limit = null, $offset = null)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%);
		$q->limit($limit, $offset);

		if ($%PRIMARY_ESCAPED% !== null)
		{
			$q->where(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%_PRIMARY_KEY, $%PRIMARY_ESCAPED%);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_last($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%);
		$q->order_by(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%_PRIMARY_KEY, 'DESC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function get_first($n = 1)
	{
		$q = new query_select(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%);
		$q->order_by(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%_PRIMARY_KEY, 'ASC');
		$q->limit($n);
		$q->query();

		return $q->get_object_list();
	}

	public static function add(%INLINE_FIELDS%)
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%);

		%QUERY_ADD%

		$q->query();

		return $q->get_id();
	}

	public static function update($%PRIMARY_ESCAPED%, %INLINE_FIELDS%, $limit = null, $offset = null)
	{
		$q = new query_update(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%);

		%QUERY_UPDATE%

		$q->where(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%_PRIMARY_KEY, $%PRIMARY_ESCAPED%);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function is_exists($%PRIMARY_ESCAPED%)
	{
		if (static::get($%PRIMARY_ESCAPED%))
		{
			return true;
		}

		return false;
	}

	public static function remove($%PRIMARY_ESCAPED%, $limit = null, $offset = null)
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%);
		$q->where(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%_PRIMARY_KEY, $%PRIMARY_ESCAPED%);
		$q->limit($limit, $offset);
		$q->query();

		return $q->affected();
	}

	public static function count()
	{
		$database = database();
		$database->query('SELECT COUNT(*) as count FROM ' . RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%);

		return $database->get_object()->count;
	}

	%ADVANCED%
}