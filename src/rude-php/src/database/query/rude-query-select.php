<?

namespace rude;

class query_select extends query
{
	public function __construct($table)
	{
		$this->database = database();

		static::add_table($table);
		static::add_from($table);
	}

	public function field($field, $table = null)
	{
		static::add_field($field, $table);
	}

	public function from($table)
	{
		static::add_from($table);
	}

	public function sql()
	{
		$sql  = static::sql_fields();
		$sql .= static::sql_from();
		$sql .= static::sql_where();
		$sql .= static::sql_order();
		$sql .= static::sql_limit();

		return $sql;
	}

	public function where    ($field, $value, $table = null) { static::add_where    ($table, $field, $value); }
	public function where_not($field, $value, $table = null) { static::add_where_not($table, $field, $value); }

	public function order_by($field, $direction = null) { static::add_order($field, $direction); }

	public function limit($limit, $offset = null) { static::add_limit($limit, $offset); }

	public function query() { return $this->database->query($this->sql()); }

	public function get_object()      { return $this->database->get_object();      }
	public function get_object_list() { return $this->database->get_object_list(); }
}