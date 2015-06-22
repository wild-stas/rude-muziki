<?

namespace rude;

class page_admin_author
{
	private $song_authors = null;

	public function __construct()
	{
		$this->song_authors = song_authors::get(null,30);
	}

	public function init()
	{
		if (!$this->song_authors)
		{
			return;
		}
		?>
		<div id="main">
			<table class="ui table segment square-corners celled">
				<thead>
				<tr class="header">
					<th>Name</th>
					<th>Count of songs</th>
					<th colspan="2" class="right icon-add"><a href="?page=admin&task=add_author"><i class="icon add sign pointer" title="Add"></i></a></th>
				</tr>
				</thead>
				<tbody>
				<?
				foreach ($this->song_authors as $song_author)
				{
					?>
					<tr>
						<td><?= $song_author->name ?></td>
						<td><?= count(songs::get_by_author_id($song_author->id)); ?></td>						
						<td class="icon first no-border">
							<a href="?page=admin&task=edit_author&id=<?=$song_author->id?>">
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
		</div>
		<?
	}	
}