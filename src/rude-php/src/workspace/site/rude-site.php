<?

namespace rude;

$cms = null;

class site
{
	public static function init()
	{
		session::start();

		switch (current::page())
		{
			case 'homepage':        $page = new page_homepage();        break;
			case 'song':            $page = new page_song();            break;

			case 'admin':           $page = new page_admin();           break;
			case 'user':            $page = new page_user();            break;
			case 'about':           $page = new page_about();           break;
			case 'login':           $page = new page_login();           break;
			case 'logout':          $page = new page_logout();          break;
			case 'registration':    $page = new page_registration();    break;

			case 'ajax':            $page = new page_ajax();            break;

			default:
				$page = new page_404();
		}
		
		$page->init();
	}

	public static function doctype()
	{
		?><!DOCTYPE html><?
	}

	public static function head()
	{
		?>
		<head>
			<title><?= current::title() ?></title>

			<meta name="viewport" content="initial-scale=1.0, user-scalable=no, maximum-scale=1" />

			<?= html::js('src/js/jquery/1.11.2/jquery-1.11.2.min.js') ?>

			<?= html::js('src/js/jquery-ui/1.11.4/jquery-ui.js') ?>
			<?= html::css('src/js/jquery-ui/1.11.4/jquery-ui.css') ?>

			<?= html::js('src/js/semantic-ui/1.11.4/semantic.min.js') ?>
			<?= html::css('src/js/semantic-ui/1.11.4/semantic.min.css') ?>

<!--			--><?//= html::js('src/js/sound-manager/2.97a/soundmanager2.min.js') ?>
			<?= html::js('src/js/sound-manager/2.97a/soundmanager2.js') ?>

			<?= html::js('src/js/rude.js') ?>
			<?= html::js('src/js/rude-fixes.js') ?>

			<?= html::css('src/css/style.css') ?>
		</head>
		<?
	}

	public static function logo()
	{
		?>
		<div id="header">
			<h1 class="ui header"><a href="<?= RUDE_SITE_URL ?>"><?= current::title() ?></a></h1>
		</div>
		<?
	}

	public static function menu()
	{
		?>
		<div id="player" class="ui top inverted labeled icon sidebar menu visible">
			<div class="item">

			</div>
		</div>

		<div id="menu" class="ui secondary pointing menu">
			<a class="item <?= static::highlight_item('homepage') ?>" href="<?= RUDE_SITE_URL ?>">
				<i class="icon home"></i> Главная
			</a>

			<a class="item <?= static::highlight_item('about') ?>" href="<?= site::url('about') ?>">
				<i class="icon info"></i> О нас
			</a>

			<?
				if (current::user_is_logged())
				{
					?>
					<div class="right menu">

						<?
							if (current::visitor_is_admin())
							{
								?>
								<a class="ui item highlight <?= static::highlight_item('admin') ?>" href="<?= site::url('admin') ?>">
									<i class="icon configure"></i>
									Панель администратора
								</a>
								<?
							}
							else if (current::visitor_is_user())
							{
								?>
								<a class="ui item highlight <?= static::highlight_item('company') ?>" href="<?= site::url('company') ?>">
									<i class="icon configure"></i>
									Панель пользователя
								</a>
								<?
							}
						?>

						<a class="ui item <?= static::highlight_item('logout') ?>" href="<?= site::url('logout') ?>">
							<i class="icon sign out"></i>
							Выход
						</a>
					</div>
					<?
				}
				else
				{
					?>
					<div class="right menu">
						<a class="ui item <?= static::highlight_item('registration') ?>" href="<?= site::url('registration') ?>">
							<i class="icon add user"></i>
							Регистрация
						</a>
					</div>

					<div class="right menu">
						<a class="ui item <?= static::highlight_item('login') ?>" href="<?= site::url('login') ?>">
							<i class="icon sign in"></i>
							Авторизация
						</a>
					</div>
					<?
				}
			?>

		</div>
		<?
	}

	public static function footer()
	{
		?>
		<div id="footer" class="ui black vertical segment">
			<div class="container">
				<div class="ui stackable divided relaxed grid">
					<div class="eight wide column">
						<h4 class="ui header">Нужна помощь?</h4>

						<div class="description">
							<p>В случае если у вас что-то не получается или же если вы хотите задать какие-либо вопросы другого характера, можете обращаться по следующим реквизитам:</p>
						</div>

						<div class="contacts">
							<p><i class="icon mail"></i> koskaglebov@gmail.com</p>
							<p><i class="icon call"></i> +7(920)3736292</p>
							<p><i class="icon skype"></i> koskaglebov</p>
						</div>
					</div>

					<div class="four wide column">
						<h4 class="ui header">Навигация</h4>
						<div class="ui link list">
							<a class="item" href="<?= RUDE_SITE_URL ?>"><i class="icon home"></i> Главная страница</a>
							<a class="item" href="<?= site::url('discounts') ?>"><i class="icon diamond"></i> Акции</a>
							<a class="item" href="<?= site::url('about') ?>"><i class="icon info"></i> О нас</a>
						</div>
					</div>

					<div class="four wide column">
						<h4 class="ui header">Аккаунт</h4>
						<div class="ui link list">

							<?
								if (current::user_is_logged())
								{
									?>
									<a class="item" href="<?= site::url('logout') ?>"><i class="icon sign out"></i> Выход</a>
									<?
								}
								else
								{
									?>
									<a class="item" href="<?= site::url('registration') ?>"><i class="icon user add"></i> Регистрация</a>
									<a class="item" href="<?= site::url('login') ?>"><i class="icon sign in"></i> Авторизация</a>
									<?
								}
							?>

						</div>
					</div>
				</div>
			</div>
		</div>
		<?
	}

	public static function player()
	{
		?>
		<div id="player" class="ui bottom inverted labeled icon sidebar menu visible">
			<div class="item">
				<div class="button group">
					<i class="icon backward"></i>

					<i class="icon play"></i>
					<i class="icon stop invisible"></i>

					<i class="icon forward"></i>
				</div>
			</div>

			<div class="item">
				<div class="button group">
					<i class="icon repeat"></i>
					<i class="icon random"></i>
				</div>
			</div>

			<div class="item">
				<div class="song slider">
					<div class="container"></div>

					<span class="value">00:00</span>
				</div>
			</div>

			<div class="item">
				<div class="volume slider">
					<i class="icon volume up" onclick="rude.player.slider.volume.toggle()"></i>

					<div class="container"></div>

					<span class="value">0%</span>
				</div>
			</div>
		</div>

		<script>
			rude.player.init();
		</script>
		<?
	}

	public static function error($message)
	{
		$errors = errors::get();

		if (!$errors)
		{
			return;
		}

		?>
		<div class="ui error message">
			<div class="ui header dividing">Операция прервана</div>
			<p class="black"><?= $message ?></p>

			<div class="ui list">
			<?
				foreach ($errors as $error)
				{
					?><span class="item black"><i class="icon bug"></i><?= $error ?></span><?
				}
			?>
			</div>
		</div>
		<?
	}

	public static function url($page, $task = null)
	{
		$url = '?page=' . url::encode($page);

		if ($task !== null)
		{
			$url .= '&task=' . url::encode($task);
		}

		return $url;
	}

	public static function highlight_time($timestamp)
	{
			 if (strtotime($timestamp) > strtotime('-1 day'))  { return 'day-now';  }
		else if (strtotime($timestamp) > strtotime('-2 days')) { return 'day-yesterday'; }

		return '';
	}

	public static function highlight_item($page)
	{
		if (current::page() == $page)
		{
			return 'active';
		}

		return '';
	}

	public static function is_username_valid($username)
	{
		$alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZабвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ-_ ';

		return items::contains(string::chars($alphabet), string::chars($username));
	}

	public static function register($username, $email, $password, $role_id)
	{
		list($hash, $salt) = crypt::password($password);

		return users::add($role_id, $username, $email, $hash, $salt);
	}

	public static function auth($username, $password)
	{
		$user = users::get_by_name($username, true);

		if ($user and crypt::is_valid($password, $user->hash, $user->salt))
		{
			session::set('user', $user);

			current::reload();

			return true;
		}

		return false;
	}

	public static function logout()
	{
		session::destroy();
		cookies::delete();
	}
}