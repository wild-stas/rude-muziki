<?

namespace rude;

class page_admin_genre
{
	private $song_genres = null;

	public function __construct()
	{
		$this->song_genres = song_genres::get(null);
	}

	public function init()
	{
		if (!$this->song_genres)
		{
			return;
		}
		?>
		<div id="main">
			<table class="ui table segment square-corners celled">
				<thead>
				<tr class="header">
					<th>Название</th>					
					<th>Кол-во композиций</th>					
					<th colspan="2" class="right icon-add"><a href="?page=admin&task=add_genre"><i class="icon add sign pointer" title="Добавить"></i></a></th>
				</tr>
				</thead>
				<tbody>
				<?
				foreach ($this->song_genres as $song_genre)
				{
					?>
					<tr>
						<td><?= $song_genre->name ?></td>
						<td><?= count(songs::get_by_genre_id($song_genre->id)); ?></td>						
						<td class="icon first no-border">
							<a href="?page=admin&task=edit_genre&id=<?=$song_genre->id?>">
								<i class="icon edit" title="Редактировать"></i>
							</a>
						</td>
						<td class="icon last no-border">
							<a href="#" >
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