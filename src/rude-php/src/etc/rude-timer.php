<?

namespace rude;

class timer
{
	public $start = 0;
	public $end   = 0;

	public function __construct($auto_start = true)
	{
		if ($auto_start === true)
		{
			$this->start();
		}
	}

	public function current()
	{
		return microtime(true);
	}

	public function total($precision = 4)
	{
		return round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']), $precision);
	}

	public function start()
	{
		$this->start = $this->current();
	}

	public function end()
	{
		$this->end = $this->current();
	}

	public function result($precision = 4)
	{
		if (!$this->end)
		{
			$this->end();
		}

		return round($this->end - $this->start, $precision);
	}

	public function reset()
	{
		$this->start = 0;
		$this->end   = 0;
	}
}

