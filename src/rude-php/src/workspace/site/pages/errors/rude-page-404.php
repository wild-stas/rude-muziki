<?

namespace rude;

class page_404
{
	public static function init()
	{
//		headers::not_found();

		page_error::init('404', 'Запрашиваемая вами информация не была найдена');

		die;
	}
}