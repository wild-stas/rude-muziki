<?

namespace rude;

class query_update extends query
{
	public function __construct($table)
	{
		$this->database = database();

		static::add_table($table);
	}

	public function update($field, $value) { static::add_update($field, $value); }

	public function sql()
	{
		$sql  = static::sql_update();
		$sql .= static::sql_set();
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