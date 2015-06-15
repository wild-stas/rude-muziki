<?

namespace rude;

class system
{
	/**
	 * @en Byte order system checker, returns `true` on little endian systems and `false` on big endian systems
	 * @ru Проверка порядка байтов, возвращает `true` на системах с порядком `от младшего к старшему (little endian)` и `false` на системах `от старшего к младшему (big endian)`
	 *
	 * $result = sysinfo::is_little_endian();
	 *
	 * @return bool
	 */
	public static function is_little_endian()
	{
		$int = 0x00FF;

		return $int === current(unpack('v', pack('S', $int)));
	}

	public static function is_big_endian()
	{
		return !system::is_little_endian();
	}

	public static function uname()
	{
		return php_uname();
	}

	public static function os()
	{
		return php_uname('s');
	}

	public static function hostname()
	{
		return php_uname('n');
	}

	public static function processor()
	{
		return php_uname('m');
	}

	public static function is_windows()
	{
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
		{
			return true;
		}

		return false;
	}
}