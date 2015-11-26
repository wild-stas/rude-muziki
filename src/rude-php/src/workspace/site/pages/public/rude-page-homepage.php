<?

namespace rude;

class page_homepage
{
	private $songs = null;

	public function __construct()
	{
        $email = get('email');
		$social = get('social');
		$uid = get('uid');
		$keyword = get('s');



        if ($social=='fb'){
            if( users::is_exists_uid($uid)){
                site::auth_social('fb',$uid);
            }else
            {
                users::add('2',null,$email,null,null,null,'fb',$uid);
                site::auth_social('fb',$uid);
            }
        }


		$genre_id = get('genre_id');
		$author_id = get('author_id');

		$this->songs = static::get_songs($genre_id, 0, 100, $keyword);
	}

	public static function get_songs($genre_id = null, $offset = 0, $limit = 100, $keyword = null, $author_id= null)
	{
		$database = database();

		$q =
		'
			SELECT
				songs.*,

				song_authors.name AS author_name,
				song_genres.name  AS genre_name,

				(SELECT   SUM(value) FROM ratings WHERE song_id = songs.id) AS rating_value,
				(SELECT COUNT(id)    FROM ratings WHERE song_id = songs.id) AS rating_votes

			FROM
				songs
			LEFT JOIN
				song_authors ON song_authors.id = songs.author_id
			LEFT JOIN
				song_genres ON song_genres.id = songs.genre_id
			LEFT JOIN
				ratings ON ratings.song_id = songs.id
			WHERE
				1 = 1
		';



		if ($genre_id)
		{
			$q .= 'AND songs.genre_id = ' . (int) $genre_id . PHP_EOL;
		}

if ($author_id)
{
	$q .= 'AND songs.author_id = ' . (int) $author_id . PHP_EOL;
}

		if ($keyword)
		{
			$keyword = $database->escape($keyword);

			$q .=
			'
				AND
				(
						songs.name LIKE "%' . $keyword . '%"
					OR
						song_authors.name LIKE "%' . $keyword . '%"
					OR
						song_genres.name LIKE "%' . $keyword . '%"
				)
			';
		}

		$q .= 'GROUP BY	songs.id' . PHP_EOL;

		$q .= 'ORDER BY songs.id DESC LIMIT ' . (int) $offset . ',' . (int) $limit . PHP_EOL;


		$database->query($q);

		return $database->get_object_list();
	}

	public function init()
	{
		if (get('ajax'))
		{
			static::main();
			return;
		}

		site::doctype();

		?>
		<html>

		<? site::head() ?>

		<body>
		<div id="container">

			<? site::menu() ?>

			<? site::header() ?>

			<div id="page-homepage">

				<div id="content">
					<? static::main() ?>
				</div>
			</div>

			<? site::footer() ?>

			<? site::player() ?>
		</div>

		</body>
		</html>
		<?
	}

	public function slider(){
		?>


		<div class="ui grid">
			<div> <!--class="eleven wide column " -->
				<?
				$playlists = playlists::get_last(10);

				if ($playlists)
				{

					?>

						<div class="flexslider">
							<ul class="slides">
								<?
							foreach ($playlists as $playlist)
							{
								if (!$playlist->file_image)
								{
									continue;
								}

								if ($playlist->is_news)
								{
									continue;
								}


								$playlist_items = playlist_items::get_by_playlist_id($playlist->id);

								if (!$playlist_items)
								{
									continue;
								}


								$song_ids = [];

								foreach ($playlist_items as $playlist_item)
								{
									$song_ids[] = $playlist_item->song_id;
								}

								$songs = songs::get_by_id($song_ids);

								if (!$songs)
								{
									continue;
								}


								?>
<!--								<li style="background: --><?//= $playlist->background_color ?>/*; color: */<?//= $playlist->font_color ?><!--">-->
								<li style="position: relative">
									<div class="slider_item">
										<img src="src/img/<?= $playlist->id ?>/<?= $playlist->file_image ?>" alt="">

										<div class="flex-caption"><span>
											<h4 class="ui white" onclick="rude.crawler.open('?page=playlist&type=public&id=<?= $playlist->id ?>');"><?= $playlist->title ?></h4>

											<p ><?= substr($playlist->description, 0, 35);  ?></p>

											<div class="ui icon button" style="    position: absolute;    top: 12px;    left: 12px;" onclick="<? static::songs_to_js($playlist_items,$playlist->id) ?>">
												<i class="icon video play" ></i>
											</div>
										</span>
										</div>
									</div>

								</li>
							<?
							}
							?>
							</ul>
						</div>

					<script type="text/javascript">

						$(document).ready(function()
						{

//							function color_navs(){
//								$('.flex-control-paging li a').css('background',$('.flexslider').find('.flex-active-slide').css('color'));
//
//							}
//							setInterval(color_navs, 500);


							$('.flexslider').flexslider({
									minItems: 2,
									maxItems: 4,
									itemWidth: 170,
									itemMargin: 0,
									animation: "slide",
									directionNav: false,
									start: function(slider){
										$('body').removeClass('loading');
										$(window).resize();
									}
								});


						});

					</script>

				<?
				}
				?>
			</div>
			<h2 style="font-size: 17px">HEAR THIS</h2>

			<div class="five wide column">
				<div class="songs-top">

					<h4 class="ui header">
						Top 20 songs
					</h4>

					<?
					$songs_ids = songs::get_by_is_top(1);
					?>

					<div class="ui icon button" style="top: 13px;" onclick="<? static::songs_to_js($songs_ids,null,1) ?>">
						<i class="icon video play"></i>
					</div>
				</div>
			</div>

			<div class="six wide column">
				<div class="songs-new">
					<h4 class="ui header">
						New releases
					</h4>
					<? $songs = songs::get_last(40);?>

					<div class="ui icon button" style="top: 13px;" onclick="<? static::songs_to_js($songs,null,1) ?>">
						<i class="icon video play"></i>
					</div>
				</div>
			</div>

			<div class="five wide column">
				<div class="songs-new">
					<h4 class="ui header">
						Selected Genres
					</h4>
					<div class="ui icon button" style="top: 13px;" onclick="rude.crawler.open('?page=genres')">
						<i class="long arrow right icon"></i>
					</div>
				</div>
			</div>


			<h2 style="font-size: 17px">
				MUZIKI NEWS
			</h2>

			<? $news=playlists::get_last(playlists::count());
			?>
			<div id="" class="ui double six doubling" style="font-size: 0;    margin-bottom: 30px;">
				<?
				if ($news)
				{

					$count=1;
					foreach ($news as $news_item)
					{

						if (!$news_item->is_news)
						{
							continue;
						}
						if ($count>12){
							continue;
						}
						static::news_as_playlist($news_item);
						$count++;
					}
				}
				?>
			</div>
			<h2 style="font-size: 17px">
				TRENDING ARTISTS
			</h2>
			<div id="" class="ui double six doubling" style="font-size: 0;    margin-bottom: 30px;">
				<?
				$authors=song_authors::get_by_in_homepage(1);

				if ($authors)
				{
					$count=1;
					foreach ($authors as $author)
					{
						if ($count>12){
							continue;
						}
						?>
						<div class="homeplaylist playlist_card ">
							<div class="image">
								<?
								if ($author->file_image)
								{
									?><img src="src/img/author/<?= $author->file_image ?>"><?
								}
								else
								{
									?><img src="src/img/covers/image.png"><?
								}
								?>
							</div>
							<div class="content">
								<a href="?page=author&author_id=<?= $author->id ?>"><p class="header"><?= $author->name ?></p></a>
							</div>
						</div>
				<?
						$count++;
					}
				}
				?>
			</div>
			<div id="homefooter" class="ui menu visible">

						<div class="item" onclick=" rude.menu.navigation.hide();">
							<a href="<?= site::url('about') ?>">
								About
							</a>
						</div>

						<div class="item" onclick="rude.menu.navigation.hide();">
							<a href="<?= site::url('help') ?>">
								Help and Contacts
							</a>
						</div>

						<div class="item" onclick=" rude.menu.navigation.hide();">
							<a href="<?= site::url('terms') ?>">
								Terms & Conditions
							</a>
						</div>



						<div class="item" onclick="rude.menu.navigation.hide();">
							<a class="footersocial" href="http://www.facebook.com/Muziki.net" title="We're on Facebook" target="_blank">Facebook</a>
						</div>

						<div class="item" onclick="rude.menu.navigation.hide();">
							<a class="footersocial" href="http://www.twitter.com/MuzikiNet" title="We're on Twitter" target="_blank">Twitter</a>
						</div>

						<div class="item" onclick=" rude.menu.navigation.hide();">
							<a class="footersocial" href="http://www.google.com/+MuzikiNet" title="We're on Google+" target="_blank">Google+</a>
						</div>

				</div>
			</div>
			<script>
				$( document ).ready(function() {
					$('.playlist_card.add_new_one').height($('.playlist_card').height());

					$(".playlist_card").each(function() {
						if ($( this ).data( "id" )==$('#current_playlist').val()){
							$( this).addClass('active');
						}
					});
				});
				function listen_all(selector){
					$('#current_playlist').val($(selector).parent().data('id'));
					$('.playlist_card').removeClass('active');
					$(selector).parent().addClass('active');
					rude.player.playlist.remove();
					rude.player.init();
					var songs_cont = $(selector).parent().find('.song_container');
					var all_songs = $(songs_cont).find('span');
					$( all_songs ).each(function(  ) {
						rude.player.song.add($(this).data('file_audio'), $(this).data('name'), $(this).data('author_name'),'false');
					});
				}

			</script>
			<div>

			</div>
		</div>

		</div>
		<?
	}

	public static function news_as_playlist($news_item)
	{
		?>


		<div class="homeplaylist playlist_card ">
			<div class="image">
				<?
				if ($news_item->file_image)
				{
					?><img src="src/img/<?= $news_item->id ?>/<?= $news_item->file_image ?>"><?
				}
				else
				{
					?><img src="src/img/covers/image.png"><?
				}
				?>
			</div>
			<div class="ui icon button" onclick="listen_all(this)">
				<i class="icon video play"></i>
			</div>
			<div class="content">
				<a href="?page=news_item&type=public&id=<?= $news_item->id ?>"><p class="header"><?= $news_item->name ?></p></a>
				<div class="description">
					<? $song_ids = playlist_items::get_by_playlist_id($news_item->id); ?>
					<?= $news_item->title ?>
				</div>
			</div>

			<div class="song_container" style="display: none">
				<?
				if ($song_ids)
				{
					foreach ($song_ids as $song_id)
					{
						$song = songs::get_by_id($song_id->song_id,true);

						?>
						<span data-file_audio="<?= $song->file_audio ?>" data-name="<?= $song->name ?>" data-author_name="<?= song_authors::get_by_id($song->author_id,true)->name; ?>"></span>
					<?}
				}
				?>
			</div>

			<script>
				rude.crawler.init();
			</script>

		</div>
	<?
	}

	public function songs_to_js($songs,$playlist_id=null,$is_song=0)
	{
		if ($songs)
		{?>
			rude.player.playlist.remove();
			rude.player.init();
			<?
			if (!$is_song){
				foreach ($songs as $song_id)
				{
					$song = songs::get_by_id($song_id->song_id, true);

					?>
					rude.player.song.add('<?= static::escape_js($song->file_audio) ?>', '<?= static::escape_js($song->name); ?>', '<?= static::escape_js(song_authors::get_by_id($song->author_id, true)->name); ?>','false');
				<?
				}
			}
			if ($is_song){
				foreach ($songs as $song)
				{

					?>
					rude.player.song.add('<?= static::escape_js($song->file_audio) ?>', '<?= static::escape_js($song->name); ?>', '<?= static::escape_js(song_authors::get_by_id($song->author_id, true)->name); ?>','false');
				<?
				}
			}
			if ($playlist_id!=null){?>
			$('#current_playlist').val('public_<?=$playlist_id?>');
			<?}
		}
		?>


	<?
	}


	public function main()
	{
		?>
		<script>
			$(window).unbind('scroll');
			</script>
		<div id="modal-vote-denied" class="ui small modal transition">
			<i class="close icon"></i>
			<div class="header">
				Vote Denied
			</div>
			<div class="content">
				<p>You must be <a href="<?= site::url('login') ?>" onclick="$('#modal-vote-denied').modal('hide')">logged in</a> to vote for songs.</p>
			</div>
			<div class="actions">
				<div class="ui positive right labeled icon button">
					OK
					<i class="checkmark icon"></i>
				</div>
			</div>
		</div>

		<div id="main">
			<? static::slider() ?>
<!--			<div id="recent">-->
<!--				--><?// // static::html_songs($this->songs, true); ?>
<!--			</div>-->
		</div>

		<script>
			rude.semantic.init.dropdown();

			rude.crawler.init();

			function vote(selector)
			{
				var is_logged = <?= (int) current::user_is_logged() ?>;

				if (!is_logged)
				{
					$('#modal-vote-denied').modal('show');

					return;
				}


				var song_id = $(selector).attr('data-song-id');

				var value = $(selector).find('.icon.active').length;

				debug(value);

				$.ajax
				({
					url: 'index.php',

					type: 'GET',

					data:
					{
						page: 'ajax',
						task: 'rating',
						song_id: song_id,
						value: value
					},

					success: function (data)
					{
						debug(data);
					}
				});
			}
		</script>
		<?
	}

	public static function html_songs($songs, $include_head = false)
	{
		if (!$songs)
		{
			return;
		}

		?>
		<table class="ui celled unstackable  table striped ">

			<?
				if ($include_head)
				{
					?>
					<thead>
						<tr>
							<th>Listen</th>
<!--							<th>Image</th>-->
							<th>Song Name</th>
							<th>Author</th>
<!--							<th>Rating</th>-->

						</tr>
					</thead>
					<?
				}
			?>

			<tbody>
			<?
				$keyword = get('s');

				foreach ($songs as $song)
				{
					?>
					<tr class="song <?= $song->file_audio ?>">
						<td>
							<div class="ui icon button" onclick="rude.player.song.add('<?= $song->file_audio ?>', '<?= $song->name ?>', '<?= $song->author_name ?>'); rude.player.song.play('<?= $song->file_audio ?>')">
								<i class="icon video play"></i>
							</div>
						</td>
<!--						<td>-->
<!--							--><?//
//								$image = 'image_white.png';
//
//								if ($song->file_image)
//								{
//									$image = $song->file_image;
//								}
//							?>
<!---->
<!--							<a class="header" href="--><?//= site::url_seo('song', $song->alias) ?><!--">-->
<!--								<img src="--><?//= RUDE_SITE_URL ?><!--src/img/covers/--><?//= $image ?><!--">-->
<!--							</a>-->
<!--						</td>-->

						<td>
							<a class="header" href="<?= site::url_seo('song', $song->alias) ?>"><?= static::highlight($song->name, $keyword) ?></a>
						</td>

						<td>
							<?= static::highlight($song->author_name, $keyword) ?>
						</td>


<!--						<td>-->
<!--							<div class="rating box">-->
<!--								--><?//
//									$rating = 0;
//
//									if ($song->rating_votes)
//									{
//										$rating = float::to_upper($song->rating_value / $song->rating_votes);
//									}
//								?>
<!---->
<!--								<div class="ui star tiny rating" data-song-id="--><?//= $song->id ?><!--" data-rating="--><?//= $rating ?><!--" data-max-rating="5" onclick="vote(this)"></div>-->
<!--							</div>-->
<!--						</td>-->



					</tr>
					<?
				}
			?>
			</tbody>
		</table>

		<script>
			rude.semantic.init.rating();
		</script>
		<?
	}

	public static function highlight($string, $keyword = null)
	{
		if (!$keyword or !string::contains($string, $keyword, false))
		{
			return $string;
		}

		return string::replace($string, $keyword, '<span class="highlight">' . $keyword . '</span>', false);
	}

	public static function escape_js($string)
	{
		$string = string::replace($string, '\\', '\\\\');
		$string = string::replace($string, '"', "'");
		$string = string::replace($string, "'", "\'");
		$string = string::replace($string, PHP_EOL, '<br>');
		$string = string::replace($string, "\r", '');

		return $string;
	}
}