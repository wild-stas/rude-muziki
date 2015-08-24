<?

namespace rude;

class page_admin_song
{
	private $songs = null;

	public function __construct()
    {
        $this->songs = static::get_songs();

        $action = get('action');
        switch ($action) {
            case 'remove':

                $id = get('song-id');

                if ($id) {

                    songs::remove_by_id($id);
                    ?>
                    <div class="ui divider"></div>

                    <div class="ui icon message orange">
                        <i class="icon remove"></i>

                        <div class="content">
                            <div class="header">
                                Success
                            </div>
                            <p>Selected song have been successfully removed</p>
                        </div>
                    </div>


                    <div class="ui divider"></div>
                <?
                }


                break;
        }
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
					songs.*,
					song_authors.name AS author_name
				FROM
					songs
					JOIN song_authors on songs.author_id = song_authors.id
				WHERE 1
			';

		if ($search_name)   { $q .= 'AND songs.name      LIKE "%' . $database->escape($search_name)   . '%"' . PHP_EOL; }
		if ($search_genre)  { $q .= 'AND songs.genre_id  LIKE "%' . $database->escape($search_genre)  . '%"' . PHP_EOL; }
		if ($search_author) { $q .= 'AND author_name LIKE "%' . $database->escape($search_author) . '%"' . PHP_EOL; }

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

                    <input id="search-author" name="search-author" value="<?= $search_author ?>">
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
                            <i class="icon remove red popup init" onclick="$('#song-id').val(<?= $song->id ?>); $('#modal-remove').modal('show');" data-content="Remove song"></i>
                        </td>
					</tr>
				<?
				}
				?>
				</tbody>
			</table>
            <form id="modal-remove" class="ui small modal transition" method="post" xmlns="http://www.w3.org/1999/html">
                <i class="close icon"></i>
                <div class="header">
                    Interrupted
                </div>
                <div class="content">
                    <div class="ui form">
                        <input type="hidden" name="action" value="remove">

                        <input type="hidden" id="song-id" name="song-id" value="">

                        <p>Are you REALLY sure that you want to delete this song?</p>
                    </div>
                </div>
                <div class="actions-fixed">
                    <div class="ui negative right labeled icon button" onclick="$('#modal-remove').modal('hide')">
                        <i class="remove icon"></i>

                        Calcel
                    </div>

                    <button class="ui positive right labeled icon button" type="submit">
                        <i class="checkmark icon"></i>

                        Do it
                    </button>
                </div>
            </form>
			<?
			if (!$search_name and !$search_genre and !$search_author)
				pagination::html(songs::count(),get('num_page'),100,6,'p');
			?>

		</div>
		<?
	}	
}