<?

namespace rude;

class mime
{
	public static function is_image($string)
	{
		if (items::contains(
			[
				'image/gif',
				'image/jpeg',
				'image/pjpeg',
				'image/png',
				'image/svg+xml',
				'image/tiff',
				'image/vnd.microsoft.icon',
				'image/vnd.wap.wbmp'
			], $string))
		{
			return true;
		}

		return false;
	}

	public static function is_audio($string)
	{
		if (items::contains(
			[
				'audio/mp3',
				'audio/mp4',
				'audio/ogg',
				'audio/opus',
				'audio/wav'
			], $string))
		{
			return true;
		}

		return false;
	}
}