<?

namespace rude;

$_errors = [];

class errors
{
	public static function add($message)
	{
		global $_errors;

		$_errors[] = $message;

		$_errors = array_unique($_errors);

		return false;
	}

	public static function get()
	{
		global $_errors;

		return $_errors;
	}
}