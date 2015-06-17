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

	public static function header()
	{
		?>
		<div id="header">

		</div>
		<?
	}

	public static function menu()
	{
		?>
		<div id="menu" class="ui top inverted sidebar menu visible">
			<div class="item">
				<a href="<?= site::url('homepage') ?>">
					<i class="icon home"></i> Homepage
				</a>
			</div>

			<div class="ui dropdown item">
				<i class="icon list"></i>

				Genres

				<div class="menu">

					<?
						$database = database();
						$database->query('
							SELECT
								song_genres.*,

								(SELECT COUNT(*) FROM songs WHERE songs.genre_id = song_genres.id) AS count
							FROM
								song_genres
							ORDER BY
								name ASC
						');

						foreach ($database->get_object_list() as $genre)
						{
							?><a class="item"><?= $genre->name ?> [<?= $genre->count ?>]</a><?
						}
					?>
				</div>
			</div>

			<script>
				rude.semantic.init.dropdown();
			</script>


			<div class="item">
				<a href="#">
					<i class="icon diamond"></i> Popular
				</a>
			</div>

			<div class="item">
				<a href="#">
					<i class="icon announcement"></i> New
				</a>
			</div>


			<?
				if (current::user_is_logged())
				{
					?>
					<a class="ui item right bold" href="<?= site::url('logout') ?>">
						<i class="icon sign out"></i>
						Logout
					</a>
					<?

					if (current::visitor_is_admin())
					{
						?>
						<a class="ui item right bold" href="<?= site::url('admin') ?>">
							<i class="icon configure"></i>
							Admin Panel
						</a>
						<?
					}
					else if (current::visitor_is_user())
					{
						?>
						<a class="ui item right bold" href="<?= site::url('company') ?>">
							<i class="icon configure"></i>
							User Panel
						</a>
						<?
					}
				}
				else
				{
					?>
					<a class="ui item right" href="<?= site::url('registration') ?>">
						<i class="icon add user"></i>
						Sign Up
					</a>

					<a class="ui item right" href="<?= site::url('login') ?>">
						<i class="icon sign in"></i>
						Sign In
					</a>
					<?
				}
			?>
		</div>
		<?
	}

	public static function footer()
	{
		?>

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