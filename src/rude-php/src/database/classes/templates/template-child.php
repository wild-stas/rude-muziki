

namespace rude;

if (!defined('RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%'))             { define('RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%',             '%TABLE_NAME%'); }
if (!defined('RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%_PRIMARY_KEY')) { define('RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%_PRIMARY_KEY', '%PRIMARY%'); }

class %CLASS_NAME%
{
	%CLASS_FIELDS%

	public function __construct($%PRIMARY_ESCAPED% = null)
	{
		if ($%PRIMARY_ESCAPED%)
		{
			$this->%PRIMARY_ESCAPED% = (int) $%PRIMARY_ESCAPED%;

			static::load($this->%PRIMARY_ESCAPED%);
		}
	}

	public function load($%PRIMARY_ESCAPED% = null)
	{
		if ($%PRIMARY_ESCAPED% === null)
		{
			$%PRIMARY_ESCAPED% = $this->%PRIMARY_ESCAPED%;
		}


		$q = new query_select(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%);
		$q->where(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%_PRIMARY_KEY, $%PRIMARY_ESCAPED%);
		$q->query();


		$item = $q->get_object();

		if (!$item)
		{
			return false;
		}


		foreach (get_object_vars($item) as $key => $val)
		{
			if (property_exists($this, $key))
			{
				$this->{$key} = $val;
			}
		}

		return true;
	}

	public function save()
	{
		$q = new query_insert(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%);

		foreach (get_object_vars($this) as $field => $value)
		{
			if (isset($this->{$field}) and $this->{$field} !== null)
			{
				$q->add($field, $this->{$field});
			}
		}

		$q->query();

		return $q->get_id();
	}

	public function update()
	{
		$q = new query_update(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%);

		foreach (get_object_vars($this) as $field => $value)
		{
			if ($field == RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%_PRIMARY_KEY)
			{
				continue;
			}

			if (isset($this->{$field}) and $this->{$field} !== null)
			{
				$q->update($field, $this->{$field});
			}
		}

		$q->where(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%_PRIMARY_KEY, $this->%PRIMARY_ESCAPED%);
		$q->query();

		return $q->affected();
	}

	public function delete()
	{
		$q = new query_delete(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%);
		$q->where(RUDE_DATABASE_TABLE_%TABLE_NAME_UPPERCASE%_PRIMARY_KEY, $this->%PRIMARY_ESCAPED%);
		$q->query();

		return $q->affected();
	}
}