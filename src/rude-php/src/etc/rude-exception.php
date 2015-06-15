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
		return trigger_error($error_message, $error_type);
	}
}