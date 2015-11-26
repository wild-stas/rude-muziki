<?

namespace rude;

class site
{
	public static function init()
	{
		session::start();

		rewrite::update();

		switch (current::page())
		{
			case 'homepage':        $page = new page_homepage();        break;
			case 'searchpage':        $page = new page_searchpage();        break;
			case 'song':            $page = new page_song();            break;
			case 'genres':            $page = new page_genres();            break;
			case 'genre':            $page = new page_genre();            break;
			case 'author':            $page = new page_author();            break;
			case 'about':            $page = new page_about();            break;
			case 'help':            $page = new page_help();            break;
			case 'terms':            $page = new page_terms();            break;
			case 'playlists':       $page = new page_playlists();       break;
			case 'news':       $page = new page_news();       break;
			case 'your_playlists':  $page = new page_user_playlists();  break;
			case 'playlist':        $page = new page_playlist();        break;
			case 'news_item':        $page = new page_playlist();        break;
			case 'admin':           $page = new page_admin();           break;
			case 'user':            $page = new page_user();            break;
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
<!--			<title>--><?//= current::title() ?><!--</title>-->
	<title>Kitangoma</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="keywords" content="Bongoflava, bolingo, dini, taarabu, genge, singeli, mchiriku,joh makini, christian bella zilipendwa, vigodoro, wasafi, diamond platnumz, weusi, alikiba">
	<meta name="description" content="Furahia Muziki Kutoka Tanzania, Kenya, Uganda na Afrika BURE">

			<?= html::js(RUDE_SITE_URL . 'src/js/jquery/1.11.3/jquery-1.11.3.min.js') ?>

			<?= html::js(RUDE_SITE_URL . 'src/js/jquery-ui/1.11.4/jquery-ui.js') ?>
			<?= html::css(RUDE_SITE_URL . 'src/js/jquery-ui/1.11.4/jquery-ui.css') ?>

			<?= html::js(RUDE_SITE_URL . 'src/js/semantic-ui/1.11.4/semantic.min.js') ?>
			<?= html::css(RUDE_SITE_URL . 'src/js/semantic-ui/1.11.4/semantic.min.css') ?>

<!--			--><?//= html::js('src/js/sound-manager/2.97a/soundmanager2.min.js') ?>
			<?= html::js(RUDE_SITE_URL . 'src/js/sound-manager/2.97a/soundmanager2.js') ?>
			<?= html::js(RUDE_SITE_URL . 'src/js/flexslider/jquery.flexslider.js') ?>
			<?= html::css(RUDE_SITE_URL . 'src/js/flexslider/flexslider.css') ?>
            <?= html::js('//vk.com/js/api/openapi.js?116') ?>
			<?= html::js(RUDE_SITE_URL . 'src/js/rude.js') ?>
			<?= html::js(RUDE_SITE_URL . 'src/js/rude-fixes.js') ?>

			<?= html::css(RUDE_SITE_URL . 'src/css/style.css') ?>
		</head>
		<?
	}

	public static function header()
	{
		?>
		<div id="header">

		</div>

		<script>
			rude.crawler.init();
			//rude.lazy.init();
		</script>
		<?
	}

	public static function menu()
	{
		$database = database();
		$database->query
		('
			SELECT
				song_genres.*,

				(SELECT COUNT(*) FROM songs WHERE songs.genre_id = song_genres.id) AS count
			FROM
				song_genres
			ORDER BY
				name ASC
		');

		$genres = $database->get_object_list();

		?>
		<div id="menu" class="ui top inverted sidebar menu visible">
			<div class="item" onclick="rude.menu.navigation.title('');">
				<a href="<?= site::url('homepage') ?>">
					<i class="icon home"></i> Homepage
				</a>
			</div>
			<div class="item" onclick="rude.menu.navigation.title('');">
				<a href="<?= site::url('playlists') ?>">
					<i class="icon diamond"></i> Top playlists
				</a>
			</div>
			<div class="item" onclick="rude.menu.navigation.title('');">
				<a href="<?= site::url('genres') ?>">
					<i class="icon list"></i> Genres
				</a>
			</div>
			<div class="item" onclick="rude.menu.navigation.title('');">
				<a href="<?= site::url('news') ?>">
					<i class="icon announcement"></i> News
				</a>
			</div>

<!--			<div class="ui dropdown item navigation" tabindex="0">-->
<!--				<i class="icon sidebar"></i>-->
<!---->
<!--				<span class="title">Navigation</span>-->
<!---->
<!--				<i class="dropdown icon"></i>-->
<!--				<div class="menu transition hidden" tabindex="-1">-->
<!--					<div class="item" onclick="rude.menu.navigation.title('Popular'); rude.menu.navigation.hide();">-->
<!--						<a href="#">-->
<!--							<i class="icon diamond"></i> Popular-->
<!--						</a>-->
<!--					</div>-->
<!---->
<!--					<div class="item" onclick="rude.menu.navigation.title('New'); rude.menu.navigation.hide();">-->
<!--						<a href="#">-->
<!--							<i class="icon announcement"></i> New-->
<!--						</a>-->
<!--					</div>-->
<!---->
<!--					<div class="item" onclick="rude.menu.navigation.title('Top playlists'); rude.menu.navigation.hide();">-->
<!--						<a href="--><?//= site::url('playlists') ?><!--">-->
<!--							<i class="icon list"></i> Top playlists-->
<!--						</a>-->
<!--					</div>-->
<!---->
<!--					--><?// if(current::user_is_logged()): ?>
<!--					<div class="item" onclick="rude.menu.navigation.title('Playlists'); rude.menu.navigation.hide();">-->
<!--						<a href="--><?//= site::url('your_playlists') ?><!--">-->
<!--							<i class="icon list"></i> Playlists-->
<!--						</a>-->
<!--					</div>-->
<!--					--><?// endif; ?>
<!---->
<!--					<div class="ui dropdown item">-->
<!--						<a href="--><?//= site::url('genres') ?><!--">-->
<!--						Genres-->
<!--						</a>-->
<!--						<i class="dropdown icon"></i>-->
<!---->
<!--						<div class="menu">-->
<!--							--><?//
//								if ($genres)
//								{
//									foreach ($genres as $genre)
//									{
//										?><!--<a class="item" href="--><?//= site::url('genre') ?><!--&genre_id=--><?//= url::encode($genre->id) ?><!--" onclick="$(this).parent().find('.item').removeClass('active'); $(this).addClass('active'); rude.menu.navigation.title('Genre: --><?//= $genre->name ?>//')"><?//= $genre->name ?><!-- [--><?//= $genre->count ?><!--]</a>--><?//
//									}
//								}
//							?>
<!--						</div>-->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->

			<script>
				rude.semantic.init.dropdown();
			</script>
			<div class="ui item  search">
				<div class="ui icon input">
					<form id="search-form" onsubmit="rude.crawler.open('?page=searchpage&s=' + encodeURIComponent($('#search-field').val())); return false;">
						<input id="search-field" type="text" placeholder="Search...">

					</form>

					<i class="search icon" onclick="$('#search-form').submit()"></i>
				</div>
			</div>

				<?
					if (current::user_is_logged())
					{
						if (current::visitor_is_admin())
						{
							?>
							<a class="ui item " href="<?= site::url('admin') ?>">
								<i class="icon configure"></i>
								Panel
							</a>
							<?
						}
						else if (current::visitor_is_user())
						{
							?>
							<a class="ui item " href="<?= site::url('user') ?>">
								<i class="icon user"></i>
								Account
							</a>

							<a class="ui item " href="<?= site::url('user', 'playlists') ?>">
								<i class="icon list"></i>
								Playlists
							</a>

							<a class="ui item " href="<?= site::url('user', 'settings') ?>">
								<i class="icon configure"></i>
								Configure
							</a>
							<?
						}

						?>
						<a class="ui item " href="<?= site::url('logout') ?>">
							<i class="icon sign out"></i>
							Logout
						</a>
						<?
					}
					else
					{
						?>
						<!--<a class="ui item right" href="<?= site::url('registration') ?>">
							<i class="icon add user"></i>
							Sign Up
						</a>

						<a class="ui item right" href="<?= site::url('login') ?>">
							<i class="icon sign in"></i>
							Sign In
						</a>-->
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
		<div id="playlist" class="ui modal small transition">
			<input id="current_playlist" type="hidden">
			<i class="close icon"></i>
			<div class="header">
				Playlist
			</div>

			<div class="content"></table></div>

			<div class="actions">
				<div class="ui positive button">
					Hide
				</div>
			</div>
		</div>

		<div id="player" class="ui bottom inverted labeled icon sidebar menu visible">
			<div class="item">
				<div class="button group">
					<i class="icon backward" onclick="rude.player.song.previous();"></i>

					<i id="player-button-play" class="icon play" onclick="rude.player.song.resume();"></i>
					<i id="player-button-stop" class="icon stop" onclick="rude.player.song.pause();" style="display: none;"></i>

					<i class="icon forward" onclick="rude.player.song.next();"></i>
				</div>
			</div>

			<div class="item">
				<div class="button group">
					<i id="player-button-repeat" class="icon repeat" onclick="$(this).toggleClass('active')"></i>
					<i id="player-button-shuffle" class="icon random"></i>
				</div>
			</div>

			<div class="item">
				<marquee id="player-song-title" class="song title" scrollamount="4" behavior="scroll"></marquee>

				<div class="song slider">
					<input id="player-song-current" type="hidden">

					<div class="container"></div>

					<span id="player-song-length" class="value">00:00/00:00</span>
				</div>
			</div>

			<div class="item">
				<div class="volume slider">
					<i id="player-volume-icon" class="icon volume up" onclick="rude.player.slider.volume.toggle()"></i>

					<div style="display: none" class="container"></div>

					<span style="display: none" id="player-volume-level" class="value">0%</span>
				</div>
			</div>

			<div class="item">
				<div class="button group pointer" onclick="$('#playlist').modal({ closable: false }).modal('show')">
					<i class="icon list"></i>

					<span id="playlist-size">0</span>
				</div>
			</div>
		</div>

		<script>
			rude.player.init();
		</script>
		<?
	}

	public static function error($title)
	{
		$errors = errors::get();

		if (!$errors)
		{
			return;
		}

		?>
		<div class="ui error message">
			<div class="ui header dividing"><?= $title ?></div>

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

	public static function url_seo($page, $query)
	{
		return '/' . $page . '/' . $query;
	}

	public static function url($page, $task = null, $id = null)
	{
		$url = RUDE_SITE_URL . '?page=' . url::encode($page);

		if ($task !== null)
		{
			$url .= '&task=' . url::encode($task);
		}

		if ($id !== null)
		{
			$url .= '&id=' . url::encode($id);
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

			//current::reload();

			return true;
		}

		return false;
	}

    public static function auth_social($social, $uid)
    {
        $user = users::get_by_uid($uid, true);

        if ($user and $user->social==$social)
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