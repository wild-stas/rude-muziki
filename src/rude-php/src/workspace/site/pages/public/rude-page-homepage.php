<?

namespace rude;

class page_homepage
{
	private $songs = null;

	public function __construct()
	{
        $email = get('email');
        $social = get('social');



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

		$this->songs = static::get_songs($genre_id);
	}

	public static function get_songs($genre_id = null, $offset = 0, $limit = 100)
	{
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


		$q .= 'ORDER BY songs.id DESC LIMIT ' . (int) $offset . ',' . (int) $limit;

		$database = database();
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

	public function main()
	{
		?>
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
			<div id="recent" class="ui double six doubling cards">
				<?
					if ($this->songs)
					{
						foreach ($this->songs as $song)
						{
							static::html_song($song);
						}
					}
				?>
			</div>
		</div>

		<script>
			rude.semantic.init.rating();
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

	public static function html_song($song)
	{
		?>
		<div class="card">
			<div class="image">
				<?
					if ($song->file_image)
					{
						?><img src="src/img/covers/<?= $song->file_image ?>"><?
					}
					else
					{
						?><i class="icon music"></i><?
					}
				?>

				<div class="rating box">
					<?
						$rating = 0;

						if ($song->rating_votes)
						{
							$rating = $song->rating_value / $song->rating_votes;
						}
					?>

					<div class="ui star tiny rating" data-song-id="<?= $song->id ?>" data-rating="<?= $rating ?>" data-max-rating="5" onclick="vote(this)"></div>
				</div>
			</div>

			<div class="content">
				<a class="header" href="<?= site::url('song', null, $song->id) ?>"><?= $song->name ?></a>

				<div class="ui divider">

				</div>

				<div class="description">
					<div class="ui icon labeled button bottom fluid" onclick="rude.player.song.add('<?= $song->file_audio ?>', '<?= $song->name ?>', '<?= $song->author_name ?>'); rude.player.manager.play('<?= $song->file_audio ?>'); rude.player.manager.setVolume('<?= $song->file_audio ?>', 20);">
						<i class="icon video play"></i> Listen
					</div>
				</div>
			</div>
		</div>
		<?
	}
}