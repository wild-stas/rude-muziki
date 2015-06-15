<?

namespace rude;

class query_delete extends query
{
	public function __construct($table)
	{
		$this->database = database();

		static::add_table($table);
		static::add_from($table);
	}

	public function sql()
	{
		$sql  = static::sql_delete();
		$sql .= static::sql_from();
		$sql .= static::sql_where();
		$sql .= static::sql_limit();

		return $sql;
	}

	public function where    ($field, $value, $table = null) { static::add_where    ($table, $field, $value); }
	public function where_not($field, $value, $table = null) { static::add_where_not($table, $field, $value); }

	public function limit($limit, $offset = null) { static::add_limit($limit, $offset); }

	public function query() { return $this->database->query($this->sql()); }

	public function affected() { return $this->database->affected(); }
}