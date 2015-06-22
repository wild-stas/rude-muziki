<?

namespace rude;

class page_homepage
{
	private $songs = null;

	public function __construct()
	{
		$q =
		'
			SELECT
				songs.*,

				song_authors.name AS author_name,
				song_genres.name  AS genre_name
			FROM
				songs
			LEFT JOIN
				song_authors ON song_authors.id = songs.author_id
			LEFT JOIN
				song_genres ON song_genres.id = songs.genre_id
			WHERE
				1 = 1
		';


		$genre_id = (int) get('genre_id');

		if ($genre_id)
		{
			$q .= 'AND songs.genre_id = ' . (int) $genre_id . PHP_EOL;
		}


		$q .= 'ORDER BY songs.id DESC LIMIT 100';


		$database = database();
		$database->query($q);

		$this->songs = $database->get_object_list();
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
		<div id="main">
			<div id="recent" class="ui double six doubling cards">
				<?
					if ($this->songs)
					{
						foreach ($this->songs as $song)
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
				?>
			</div>
		</div>

		<script>
			rude.semantic.init.rating();

			rude.semantic.init.dropdown();
		</script>
		<?
	}

	public function card($service)
	{
		?>
		<div class="black card">
			<div class="content">
				<a href="<?= site::url('service') ?>&id=<?= $service->id ?>" class="header"><?= html::escape(string::excerpt($service->name, 100)) ?></a>

				<p class="address"><?= html::escape($service->address) ?></p>

				<div class="">
					<?= html::escape(string::excerpt($service->description, 160)) ?>
				</div>
			</div>

			<div class="extra content">
				Отзывов: <?= $service->comments_count ?>.
			</div>
		</div>
		<?
	}
}