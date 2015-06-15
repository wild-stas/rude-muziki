<?

namespace rude;

class query_insert extends query
{
	public function __construct($table)
	{
		$this->database = database();

		static::add_table($table);
	}

	public function add($field, $value)
	{
		static::add_insert($field, $value);
	}

	public function from($table)
	{
		static::add_from($table);
	}

	public function sql()
	{
		return static::sql_insert();
	}

	public function query() { return $this->database->query($this->sql()); }

	public function get_id() { return $this->database->insert_id(); }
}