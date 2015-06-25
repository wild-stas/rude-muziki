<?

namespace rude;

class errors
{
	public static function add($message)
	{
		$errors = static::get();
		$errors[] = $message;
		$errors = array_unique($errors);

		session::set('errors', $errors);
	}

	public static function get()
	{
		if (!session::is_exists('errors'))
		{
			return [];
		}

		$errors = session::get('errors');

		session::remove('errors');

		return $errors;
	}

	public static function is_exists()
	{
		return session::is_exists('errors');
	}
}