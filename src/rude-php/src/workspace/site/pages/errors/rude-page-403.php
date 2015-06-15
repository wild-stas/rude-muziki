<?

namespace rude;

class page_403
{
	public static function init()
	{
		headers::forbidden();

		page_error::init('403', 'Для доступа к данной странице необходимо авторизоваться');

		die;
	}
}