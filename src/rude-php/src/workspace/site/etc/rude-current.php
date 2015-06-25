<?

namespace rude;

$_current = null;

class current
{
	private $page = null;
	private $task = null;
	private $user = null;

	public static function get()
	{
		global $_current; /** @var $_current \stdClass */

		if ($_current === null)
		{
			static::reload();
		}

		return $_current;
	}

	public static function reload()
	{
		global $_current;

		$_current = new \stdClass();
		$_current->task = get('task');
		$_current->user = session::get('user');

		$page = get('page');

		     if (url::current() == RUDE_SITE_URL or $page == 'homepage') { $_current->page = 'homepage';  }
		else                                                             { $_current->page = $page;       }

		$_current->settings = null;

		$settings = settings::get();

		if ($settings)
		{
			$_current->settings = new \stdClass();

			foreach ($settings as $setting)
			{
				$key = $setting->key;
				$val = $setting->val;

				$_current->settings->$key = $val;
			}
		}
	}

	public static function page()     { return static::get()->page;     }
	public static function task()     { return static::get()->task;     }
	public static function user()     { return static::get()->user;     }
	public static function settings() { return static::get()->settings; }

	public static function visitor_is_admin() { return static::user_is(RUDE_ROLE_ADMIN); }
	public static function visitor_is_user()  { return static::user_is(RUDE_ROLE_USER);  }

	private static function user_is($role_id)
	{
		$user = static::user();

		if ($user !== null and $user->role_id == $role_id)
		{
			return true;
		}

		return false;
	}

	public static function user_is_logged()
	{
		if (static::user() !== null)
		{
			return true;
		}

		return false;
	}

	public static function user_id()
	{
		$user = static::user();

		if ($user !== null)
		{
			return $user->id;
		}

		return null;
	}

	public static function user_name()
	{
		$user = static::user();

		if ($user !== null)
		{
			return $user->name;
		}

		return null;
	}

	public static function title()       { return object::get(static::settings(), 'title_'       . static::page()); }
	public static function keywords()    { return object::get(static::settings(), 'keywords_'    . static::page()); }
	public static function description() { return object::get(static::settings(), 'description_' . static::page()); }
}