<?

namespace rude;

/**
 * @category database
 */
class database
{
	/** @var \mysqli  */
	private $mysqli = null;

	/** @var \mysqli_result  */
	private $result = null;


	private $columns = null; # columns cache


	public function __construct($host, $user, $pass, $name, $port = 3306, $charset = 'utf8')
	{
		$this->mysqli = new \mysqli($host, $user, $pass, $name, (int) $port);

		if ($this->mysqli->connect_error)
		{
			exception::error('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		}

		if (!$this->mysqli->set_charset($charset))
		{
			exception::error('Error loading character set (' . $charset . '): ' . $this->mysqli->error);
		}
	}

	/**
	 * @en Execute SQL query. WARNING: do not forget to escape SQL queries via escape() method if you don't use query() classes
	 * @ru Выполнение построенного SQL запроса. ВАЖНО: не забывайте экранировать SQL запросы с помощью метода escape() если вы генерируете SQL запрос без помощи семейства классов query()
	 *
	 * $database = new database($host, $user, $pass, $name);
	 * $database->query('SELECT * FROM users WHERE 1 = 1');
	 *
	 * @param $string
	 *
	 * @return mixed
	 */
	public function query($string)
	{
		$this->result = $this->mysqli->query($string);


		if ($this->result === false)
		{
			exception::error(string::replace($this->mysqli->error, PHP_EOL, ' ') . ':' . PHP_EOL . PHP_EOL . $string);
		}


		return $this->result;
	}

	public function escape($var)
	{
		return $this->mysqli->real_escape_string($var);
	}

	public function affected()
	{
		return $this->mysqli->affected_rows;
	}

	public function insert_id()
	{
		return $this->mysqli->insert_id;
	}

	public function tables()
	{
		$this->query('SHOW TABLES');

		$result = null;

		foreach ($this->get_object_list() as $object)
		{
			foreach ($object as $table)
			{
				$result[] = $table;

				break;
			}
		}

		return $result;
	}


	public function columns($table)
	{
		if (isset($this->columns[$table])) # search results in cache
		{
			return $this->columns[$table];
		}


		$result = $this->query('SHOW COLUMNS FROM ' . $this->escape($table));


		$table_fields = null;

		while ($column = $result->fetch_row())
		{
			$this->columns[$table][] = $column; # [0] - field
			                                    # [1] - type
			                                    # [2] - null
			                                    # [3] - key
			                                    # [4] - default
			                                    # [5] - extra
		}

		return $this->columns[$table];
	}

	public function fields($table)
	{
		$columns = $this->columns($table);


		$fields = null;

		foreach ($columns as $column)
		{
			$fields[] = $column[0]; # [0] - field
			                        # [1] - type
			                        # [2] - null
			                        # [3] - key
			                        # [4] - default
			                        # [5] - extra
		}

		return $fields;
	}

	/**
	 * @en Get query result as an object list
	 * @ru Получить ответ из базы данных в виде массива объектов
	 *
	 * $database = new database(); # do not forget to declare defines before calling this class:
	 *                             # > RUDE_DATABASE_USER
	 *                             # > RUDE_DATABASE_PASS
	 *                             # > RUDE_DATABASE_HOST
	 *                             # > RUDE_DATABASE_NAME
	 *
	 * $database->query('SELECT * FROM users WHERE 1 = 1');
	 *
	 * $result = $database->get_object_list(); # Array
	 *                                         # (
	 *                                         #     [0] => stdClass Object
	 *                                         #     (
	 *                                         #         [id] => 1
	 *                                         #         [username] => root
	 *                                         #         [hash] => e7ee2c83e86af973196fde64e1ab7178
	 *                                         #         [salt] => Jb9JbfrQoBRs7p0mNu3i7NSsC9AhuaCz
	 *                                         #         [role_id] => 1
	 *                                         #     )
	 *                                         #
	 *                                         #     [1] => stdClass Object
	 *                                         #     (
	 *                                         #         [id] => 2
	 *                                         #         [username] => manager
	 *                                         #         [hash] => 0991b08461e5ce0ee0a038c104b5a6d3
	 *                                         #         [salt] => nLpUwvzSpD5yoqXtqjvhtqwhJUsMFh8P
	 *                                         #         [role_id] => 2
	 *                                         #     )
	 *                                         # )
	 *
	 * @return mixed
	 */
	public function get_object_list()
	{
		$object_list = [];

		while ($object = $this->result->fetch_object())
		{
			$object_list[] = $object;
		}

		return $object_list;
	}

	/**
	 * @en Get element from query result as an object
	 * @ru Получить первую запись из ответа базы данных в виде объекта
	 *
	 * $database = new database(); # do not forget to declare defines before calling this class:
	 *                             # > RUDE_DATABASE_USER
	 *                             # > RUDE_DATABASE_PASS
	 *                             # > RUDE_DATABASE_HOST
	 *                             # > RUDE_DATABASE_NAME
	 *
	 * $database->query('SELECT * FROM users WHERE 1 = 1');
	 *
	 * $result = $database->get_object(); # stdClass Object
	 *                                    # (
	 *                                    #     [id] => 2
	 *                                    #     [username] => manager
	 *                                    #     [hash] => 0991b08461e5ce0ee0a038c104b5a6d3
	 *                                    #     [salt] => nLpUwvzSpD5yoqXtqjvhtqwhJUsMFh8P
	 *                                    #     [role_id] => 2
	 *                                    # )
	 *
	 * @return mixed
	 */
	public function get_object()
	{
		if ($object = $this->result->fetch_object())
		{
			return $object;
		}

		return null;
	}
}