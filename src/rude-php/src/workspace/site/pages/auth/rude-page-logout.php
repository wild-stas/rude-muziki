<?

namespace rude;

class page_logout
{
	public static function init()
	{
		site::logout();

		headers::redirect(RUDE_SITE_URL);
	}
}