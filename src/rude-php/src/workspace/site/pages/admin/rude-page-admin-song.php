<?

namespace rude;

class page_admin_song
{
	private $songs = null;

	public function __construct()
	{
		$this->songs = static::get_songs();
	}

	public static function get_songs()
	{
		$search_name     = get('search-name');
		$search_genre    = get('search-genre');
		$search_author   = get('search-author');
		$num_page = get('num_page');


		$database = database();

		$q =
			'
				SELECT
					*
				FROM
					songs
				WHERE 1
			';

		if ($search_name)   { $q .= 'AND name      LIKE "%' . $database->escape($search_name)   . '%"' . PHP_EOL; }
		if ($search_genre)  { $q .= 'AND genre_id  LIKE "%' . $database->escape($search_genre)  . '%"' . PHP_EOL; }
		if ($search_author) { $q .= 'AND author_id LIKE "%' . $database->escape($search_author) . '%"' . PHP_EOL; }

		$q .=
			'
				ORDER BY
					timestamp DESC
			';

		if ($num_page){
			$q .= '
				LIMIT ' . ($num_page-1)*100 . ',100
				';
		}

			if (!$num_page and !$search_name and !$search_genre and !$search_author)
		{
			$q .=
				'
					LIMIT 0,100
				';
		}


		$database->query($q);

		return $database->get_object_list();
	}

	public function init()
	{
		if (!$this->songs)
		{
			return;
		}

		$search_name     = get('search-name');
		$search_genre    = get('search-genre');
		$search_author   = get('search-author');
		?>

		<div class="ui segment inverted teal">
			<form class="ui form inverted" action="?page=admin&task=song" method="post">

				<h2 class="ui header inverted white">Search Songs</h2>

				<input type="hidden" name="action" value="search">


				<div class="field">
					<label for="search-name">Search by Name</label>

					<input id="search-name" name="search-name" value="<?= $search_name ?>">
				</div>

				<div class="field">
					<label for="search-genre">Search by Genre</label>
					<div class="ui fluid selection dropdown">
						<div class="default text" >Select Genre</div>
						<input type="hidden" id="search-genre" name="search-genre" value="<?= $search_genre ?>">
						<div style="max-height: 150px;" class="menu">
							<?
							$song_genres = song_genres::get();
							foreach ($song_genres as $genre)
							{
								?>
								<div class="item" data-value="<?= $genre->id  ?>"><?= $genre->name  ?></div>
							<?
							}?>
						</div>
					</div>
				</div>

				<div class="field">
					<label for="search-author">Search by Author</label>
					<div class="ui fluid selection dropdown">
						<div class="default text" >Select Author</div>
						<input type="hidden" id="search-author" name="search-author" value="<?= $search_author ?>">
						<div style="max-height: 150px;" class="menu">
							<?
							$song_authors = song_authors::get();
							foreach ($song_authors as $author)
							{
								?>
								<div class="item" data-value="<?= $author->id  ?>"><?= $author->name  ?></div>
							<?
							}?>
						</div>
					</div>
				</div>

				<button type="submit" class="ui orange button icon labeled">
					<i class="icon search"></i>

					Search
				</button>
			</form>
		</div>

		<script>
			rude.semantic.init.dropdown();
		</script>

		<div id="main">
			<table class="ui table segment square-corners celled">
				<thead>
				<tr class="header">
					<th>Name</th>
					<th>Description</th>
					<th>Genre</th>
					<th>Author</th>
					<th colspan="2" class="right icon-add"><a href="?page=admin&task=add_song"><i class="icon add sign pointer" title="Add"></i></a></th>
				</tr>
				</thead>
				<tbody>
				<?
				foreach ($this->songs as $song)
				{
					?>
					<tr>
						<td><?= $song->name ?></td>
						<td><?= $song->description ?></td>
						<td><?= song_genres::get_by_id($song->genre_id,true)->name; ?></td>
						<td><?= song_authors::get_by_id($song->author_id,true)->name; ?></td>
						<td class="icon first no-border">
							<a href="?page=admin&task=edit_song&id=<?=$song->id?>">
								<i class="icon edit" title="Edit"></i>
							</a>
						</td>
						<td class="icon last no-border">
							<a href="#" >
								<i class="icon remove circle" title="Delete"></i>
							</a>
						</td>
					</tr>
				<?
				}
				?>
				</tbody>
			</table>
			<?
			if (!$search_name and !$search_genre and !$search_author)
				pagination::html(songs::count(),get('num_page'),100,6,'p');
			?>

		</div>
		<?
	}	
}