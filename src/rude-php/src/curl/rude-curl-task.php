<?

namespace rude;

class curl_task
{
	private $id = null;

	private $handle = null;

	private $url = null;


	public function __construct($url, $id = null)
	{
		$this->url = $url;

		if ($id === null)
		{
			$this->id = $this->url;
		}
		else
		{
			$this->id = $id;
		}


		$this->handle = curl_init($this->url);


		####################
		# default settings #
		####################

		return static::set_timeout_execution()  and
		       static::set_timeout_connection() and
		       static::set_encoding()           and
		       static::enable_redirects()       and
		       static::enable_return_transfer() and
		       static::disable_post()           and
		       static::disable_ssl_verification();
	}


	public function & get_handle() { return $this->handle; }
	public function   get_url()    { return $this->url;    }
	public function   get_id()     { return $this->id;     }


	public function set_timeout_execution ($timeout = 30)  { return curl_setopt($this->handle, CURLOPT_TIMEOUT,        $timeout);    }
	public function set_timeout_connection($timeout = 30)  { return curl_setopt($this->handle, CURLOPT_CONNECTTIMEOUT, $timeout);    }
	public function set_encoding          ($encoding = '') { return curl_setopt($this->handle, CURLOPT_ENCODING,       $encoding);   }
	public function set_user_agent        ($user_agent)    { return curl_setopt($this->handle, CURLOPT_USERAGENT,      $user_agent); }
	public function set_cookie_file_save  ($file_path)     { return curl_setopt($this->handle, CURLOPT_COOKIEJAR,      $file_path);  }
	public function set_cookie_file_load  ($file_path)     { return curl_setopt($this->handle, CURLOPT_COOKIEFILE,     $file_path);  }
	public function set_referer           ($referer)       { return curl_setopt($this->handle, CURLOPT_REFERER,        $referer);    }
	public function set_post              ($post_fields)
	{
		return static::enable_post() and curl_setopt($this->handle, CURLOPT_POSTFIELDS, $post_fields);
	}

	public function set_proxy_http($proxy)
	{
		return curl_setopt($this->handle, CURLOPT_PROXYTYPE, CURLPROXY_HTTP) and
		       curl_setopt($this->handle, CURLOPT_PROXY, $proxy);
	}

	public function set_proxy_socks4($proxy)
	{
		return curl_setopt($this->handle, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4) and
		       curl_setopt($this->handle, CURLOPT_PROXY, $proxy);
	}

	public function set_proxy_socks5($proxy)
	{
		return curl_setopt($this->handle, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5) and
		       curl_setopt($this->handle, CURLOPT_PROXY, $proxy);
	}


	public function enable_post()             { return curl_setopt($this->handle, CURLOPT_POST,           true); }
	public function enable_redirects()        { return curl_setopt($this->handle, CURLOPT_FOLLOWLOCATION, true); }
	public function enable_return_headers()   { return curl_setopt($this->handle, CURLOPT_HEADER,         true); }
	public function enable_return_transfer()  { return curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true); }
	public function enable_binary_transfer()  { return curl_setopt($this->handle, CURLOPT_BINARYTRANSFER, true); }
	public function enable_ssl_verification() { return curl_setopt($this->handle, CURLOPT_SSL_VERIFYPEER, true); }


	public function disable_post()             { return curl_setopt($this->handle, CURLOPT_POST,           false); }
	public function disable_redirects()        { return curl_setopt($this->handle, CURLOPT_FOLLOWLOCATION, false); }
	public function disable_return_headers()   { return curl_setopt($this->handle, CURLOPT_HEADER,         false); }
	public function disable_return_transfer()  { return curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, false); }
	public function disable_binary_transfer()  { return curl_setopt($this->handle, CURLOPT_BINARYTRANSFER, false); }
	public function disable_ssl_verification() { return curl_setopt($this->handle, CURLOPT_SSL_VERIFYPEER, false); }
}