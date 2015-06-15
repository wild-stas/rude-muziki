<?

namespace rude;

class visitor
{
	/**
	 * @en Shows current visitor's ip
	 * @ru Получение текущего ip пользователя
	 *
	 * $ip = visitor::ip(); # string(9) "86.92.16.32"
	 *
	 * @return string
	 */
	public static function ip()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))
		{
			return $_SERVER['HTTP_CLIENT_IP'];
		}

		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		return $_SERVER['REMOTE_ADDR'];
	}

	public static function lang()
	{
		return strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
	}

	public static function is_lang($lang)
	{
		if (static::lang() == $lang)
		{
			return true;
		}

		return false;
	}


	#####################################################################################
	# http://www.iana.org/assignments/language-subtag-registry/language-subtag-registry #
	#####################################################################################

	public static function is_englishman() { return static::is_lang('en'); }
	public static function is_spanish()    { return static::is_lang('es'); }
	public static function is_chinese()    { return static::is_lang('zh'); }
	public static function is_russian()    { return static::is_lang('ru'); }


	public static function referer()
	{
		return get('HTTP_REFERER', $_SERVER);
	}

	public static function is_referer($url, $case_sensitive = false)
	{
		return string::contains(static::referer(), $url, $case_sensitive);
	}
}