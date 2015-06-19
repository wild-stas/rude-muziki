<?

namespace rude;

class page_admin_song
{
	private $songs = null;

	public function __construct()
	{
		$this->songs = songs::get(null,30);
	}

	public function init()
	{
		if (!$this->songs)
		{
			return;
		}
		?>
		<div id="main">
			<table class="ui table segment square-corners celled">
				<thead>
				<tr class="header">
					<th>Название</th>
					<th>Описание</th>
					<th>Жанр</th>
					<th>Исполнитель</th>
					<th colspan="2" class="right icon-add"><a href="?page=admin&task=add_song"><i class="icon add sign pointer" title="Добавить"></i></a></th>
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
								<i class="icon edit" title="Редактировать"></i>
							</a>
						</td>
						<td class="icon last no-border">
							<a href="#">
								<i class="icon remove circle" title="Удалить"></i>
							</a>
						</td>
					</tr>
				<?
				}
				?>
				</tbody>
			</table>
		</div>
		<?
	}	
}