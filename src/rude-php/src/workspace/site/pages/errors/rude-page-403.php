<?

namespace rude;

class page_403
{
	public static function init()
	{
		headers::forbidden();

		page_error::init('403', 'Auth required');

		die;
	}
}