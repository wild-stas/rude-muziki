<?

namespace rude;

class page_genres
{

	public function __construct()
	{

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

			<div id="page">

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
			<div id="recent">
				<?  static::html_genres(); ?>
			</div>
		</div>

		<script>
			rude.semantic.init.dropdown();

			rude.crawler.init();
		</script>
		<?
	}

	public static function html_genres()
	{
		$genres = song_genres::get();
		?>
		<div id="main">
			<h2> Selected Genres </h2>
			<div id="" class="ui double six doubling" style="font-size: 0;">
				<?
				if ($genres)
				{
					foreach ($genres as $genre)
					{?>
						<div class="playlist_card ">
			<div class="image">
				<?
				if ($genre->file_image)
				{
					?><img src="src/img/genres/<?= $genre->file_image ?>"><?
				}
				else
				{
					?><img src="src/img/covers/image.png"><?
				}
				?>
			</div>
			<div class="content">
				<a href="?page=genre&genre_id=<?= $genre->id ?>">
					<p class="header"><?= $genre->name ?></p>
				</a>
			</div>
		</div>
					<?}
				}
				?>
			</div>
		</div>
		<?
	}
}