<?

namespace rude;

class exception
{
	public static function notice($message)     { return static::trigger($message, E_USER_NOTICE);     }
	public static function warning($message)    { return static::trigger($message, E_USER_WARNING);    }
	public static function deprecated($message) { return static::trigger($message, E_USER_DEPRECATED); }
	public static function error($message)      { return static::trigger($message, E_USER_ERROR);      }

	private static function trigger($error_message, $error_type)
	{
		$caller = items::get(debug_backtrace(), 3);

		return trigger_error($error_message . ' in <b>' . $caller['class'] . $caller['type'] . $caller['function'] . '()</b> called from <b>' . $caller['file'] . '</b> on line <b>' . $caller['line'] . '</b>.' . PHP_EOL . '<br />Error handler called ', $error_type);
	}
}