<?

namespace rude;

class session
{
	/**
	 * @en Session initialization
	 * @ru Инициализация сессии
	 *
	 * @return bool
	 */
	public static function start()
	{
		return session_start();
	}

	public static function get($key)
	{
		return get($key, $_SESSION);
	}

	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public static function remove($key)
	{
		if (static::is_set($key))
		{
			unset ($_SESSION[$key]);
		}
	}

	public static function is_set($key)
	{
		if (empty($_SESSION[$key]))
		{
			return false;
		}

		return true;
	}

	public static function is_equals($key, $value)
	{
		if (session::is_set($key) and $_SESSION[$key] == $value)
		{
			return true;
		}

		return false;
	}

	/**
	 * @en Session destruction
	 * @ru Завершение сессии
	 *
	 * @return bool
	 */
	public static function destroy()
	{
		$_SESSION = [];

		if (ini_get("session.use_cookies"))
		{
			$params = session_get_cookie_params();

			setcookie(
				session_name(),
				'',
				time() - 42000,
				$params["path"],
				$params["domain"],
				$params["secure"],
				$params["httponly"]
			);
		}

		return session_destroy();
	}
}
