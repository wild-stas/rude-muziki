<?

namespace rude;

class tests
{
	private $namespace = null;
	private $class     = null;
	private $method    = null;
	private $arguments = null;
	
	private $log = null;

	public function set_namespace($namespace) { $this->namespace = $namespace;  }
	public function set_class($class)         { $this->class     = $class;      }
	public function set_method($method)       { $this->method    = $method;     }
	public function set_arguments($arguments) { $this->arguments = $arguments;  }
	
	public function get_namespace() { return $this->namespace;  }
	public function get_class()     { return $this->class;      }
	public function get_method()    { return $this->method;     }
	public function get_arguments() { return $this->arguments;  }

	public function __construct($namespace = 'rude')
	{
		static::set_namespace($namespace);
	}
	
	public function init()
	{
		static::string();
		static::char();
	}

	public function string()
	{
		static::set_class(__FUNCTION__);


		static::header();


		static::set_method('find');

		static::verify(['string πράδειγμα string πράδειγμα', 'string'],           0);
		static::verify(['string πράδειγμα string πράδειγμα', 'string', 0],        0);
		static::verify(['string πράδειγμα string πράδειγμα', 'string', 5],        17);
		static::verify(['string πράδειγμα STRING πράδειγμα', 'STRING', 0, false], 0);
		static::verify(['string πράδειγμα STRING πράδειγμα', 'STRING', 0, true],  17);


		static::set_method('size');

		static::verify([''],          0);
		static::verify(['ABCDEFEGH'], 9);
		static::verify(['πράδειγμα'], 18);


		static::set_method('length');

		static::verify(['string'],    6);
		static::verify(['πράδειγμα'], 9);
		static::verify([''],          0);


		static::set_method('count');

		static::verify(['string', '1234'],                          0);
		static::verify(['string', 'str'],                           1);
		static::verify(['string πράδειγμα πράδειγμα', 'πράδειγμα'], 2);


		static::set_method('count_lines');

		static::verify([''],                        1);
		static::verify(['one' . PHP_EOL . 'two'],   2);
		static::verify(['one' . PHP_EOL . PHP_EOL], 3);


		static::set_method('replace');

		static::verify(['string string πράδειγμα πράδειγμα', '', ''],        'string string πράδειγμα πράδειγμα');
		static::verify(['string string πράδειγμα πράδειγμα', 'string ', ''], 'πράδειγμα πράδειγμα');
		static::verify(['string string πράδειγμα πράδειγμα', 'i', 'o'],      'strong strong πράδειγμα πράδειγμα');


		static::set_method('replace_first');

		static::verify(['string string πράδειγμα πράδειγμα', '', ''],        'string string πράδειγμα πράδειγμα');
		static::verify(['string πράδειγμα string πράδειγμα', 'string ', ''], 'πράδειγμα string πράδειγμα');
		static::verify(['string πράδειγμα string πράδειγμα', 'i', 'o'],      'strong πράδειγμα string πράδειγμα');


		static::set_method('replace_last');

		static::verify(['string πράδειγμα string πράδειγμα', '', ''],        'string πράδειγμα string πράδειγμα');
		static::verify(['string πράδειγμα string πράδειγμα', 'string ', ''], 'string πράδειγμα πράδειγμα');
		static::verify(['string πράδειγμα string πράδειγμα', 'i', 'o'],      'string πράδειγμα strong πράδειγμα');


		static::set_method('read');

		static::verify(['string πράδειγμα string πράδειγμα'],           'string πράδειγμα string πράδειγμα');
		static::verify(['string πράδειγμα string πράδειγμα', null, 0],  'string πράδειγμα string πράδειγμα');
		static::verify(['string πράδειγμα string πράδειγμα', null, 0],  'string πράδειγμα string πράδειγμα');
		static::verify(['string πράδειγμα string πράδειγμα', null, 0],  'string πράδειγμα string πράδειγμα');
		static::verify(['string πράδειγμα string πράδειγμα', null, 12], 'ιγμα string πράδειγμα');
		static::verify(['string πράδειγμα string πράδειγμα', 12, 0],    'string πράδε');
		static::verify(['string πράδειγμα string πράδειγμα', 12, 2],    'ring πράδειγ');
		static::verify(['string πράδειγμα string πράδειγμα', 12, 99],   '');
		static::verify(['string πράδειγμα string πράδειγμα', 0],        '');


		static::set_method('read_after');

		static::verify(['string πράδειγμα string πράδειγμα', ''],                                  '');
		static::verify(['string πράδειγμα string πράδειγμα', 'string πράδειγμα'],                  ' string πράδειγμα');
		static::verify(['string πράδειγμα string πράδειγμα', 'string πράδειγμα string πράδειγμα'], '');
	}

	public function char()
	{
		static::set_class(__FUNCTION__);


		static::header();


		static::set_method('count_unique');

		static::verify([''],          0);
		static::verify(['AABCDEFFG'], 7);
		static::verify(['πράδειγμα'], 9);
	}

	private function header()
	{
		debug('==========================' . PHP_EOL . 'rude\\' . static::get_class() . PHP_EOL . '==========================');
	}

	private function verify(array $arguments, $result)
	{
		$call = static::caller();

		if (is_callable($call))
		{
			$answer = call_user_func_array($call, $arguments);

			if ($answer === $result)
			{
				$title = static::title(true);

				$message = static::caller($arguments) . ' [' . $answer . '] === ' . static::to_string($result);
			}
			else
			{
				$title = static::title(false);

				$message = static::caller($arguments) . ' [' . $answer . '] !== ' . static::to_string($result);
			}
		}
		else
		{
			$title = static::title(false);

			$message = static::caller($arguments) . ' is not callable';
		}

		debug($message, false, $title);
	}

	private function title($is_success)
	{
		     if ($is_success) { $title = 'passed'; }
		else                  { $title = 'failed'; }


		if (!defined('RUDE_CLI' or !RUDE_CLI))
		{
			     if ($is_success) { $title = '<span style="color: green;">' . $title . '</span>'; }
			else                  { $title = '<span style="color: red;">' . $title . '</span>';   }
		}

		return $title;
	}

	private function caller($arguments = null)
	{
		$call = static::get_namespace() . '\\' . static::get_class() . '::' . static::get_method();

		if (is_array($arguments))
		{
			foreach ($arguments as $key => $argument)
			{
				$arguments[$key] = static::to_string($argument);
			}

			$call .= '(' . implode(', ', $arguments) . ')';
		}

		return $call;
	}

	private function to_string($var)
	{
		if (is_string($var))
		{
			$var = str_replace(PHP_EOL, '\r', $var);

			return "'" . $var . "'";
		}
		else if (is_bool($var))
		{
			     if ($var) { return 'TRUE';  }
			else           { return 'FALSE'; }
		}
		else if (is_null($var))
		{
			return 'NULL';
		}
		else
		{
			return $var;
		}
	}
}