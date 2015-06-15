<?

namespace rude;

class headers
{
	# See also http://wiki.nginx.org/XSendfile
	public static function file($file_path, $file_name = false)
	{
		if ($file_name === false)
		{
			$file_name = basename($file_path);
		}

		if (file_exists($file_path))
		{
			@set_time_limit(0);

			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="' . str_replace('"', "'", $file_name) . '"');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file_path));

			readfile($file_path);
		}

		exit;
	}


	/**
	 * @en HTTP 404 header answer (not found)
	 * @ru Заголовок HTTP с кодом ответа 404 (не найдено)
	 */
	public static function not_found()
	{
		header('HTTP/1.0 404 Not Found');
	}

	public static function forbidden()
	{
		header('HTTP/1.0 403 Forbidden');
	}

	public static function unavailable($retry_after = 120)
	{
		header('HTTP/1.1 503 Service Temporarily Unavailable');
		header('Status: 503 Service Temporarily Unavailable');
		header('Retry-After: ' . (int) $retry_after);

		exit;
	}

	public static function redirect($url, $replace = null, $code = null)
	{
		header('Location: ' . $url, $replace, $code);

		exit;
	}

	public static function refresh($url = null)
	{
		if ($url === null)
		{
			$url = url::current();
		}

		static::redirect($url, true, 303);
	}
}