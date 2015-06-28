<?

namespace rude;

class page_admin_genre
{
	private $song_genres = null;

	public function __construct()
	{
		$this->song_genres = song_genres::get(null);
		$action = get('action');
		switch ($action)
		{
			case 'remove':

				$id = get('genre-id');

				if ($id) {
                    if (songs::is_exists_genre_id($id)) { ?>
                        <div class="ui divider"></div>

                        <div class="ui icon message orange">
                            <i class="icon remove"></i>

                            <div class="content">
                                <div class="header">
                                    ERROR
                                </div>

                                <p>Selected genre consist a lot of songs</p>
                            </div>
                        </div>

                        <div class="ui divider"></div>
                    <? } else {
                        song_genres::remove_by_id($id);

                        ?>
                        <div class="ui divider"></div>

                        <div class="ui icon message orange">
                            <i class="icon remove"></i>

                            <div class="content">
                                <div class="header">
                                    Success
                                </div>

                                <p>Selected genre have been successfully removed</p>
                            </div>
                        </div>
                        <script>
                            setTimeout(function(){
                                rude.url.redirect('?page=admin&task=genre')
                            }, 1000);
                        </script>

                        <div class="ui divider"></div>
                    <?
                    }
                }

				break;
		}

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
					<th>Name</th>
					<th>Count of songs </th>
					<th colspan="2" class="right icon-add"><a href="?page=admin&task=add_genre"><i class="icon add sign pointer" title="Add"></i></a></th>
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
								<i class="icon edit" title="Edit"></i>
							</a>
						</td>
						<td class="icon last no-border">
							<i class="icon remove red popup init" onclick="$('#genre-id').val(<?= $song_genre->id ?>); $('#modal-remove').modal('show');" data-content="Remove genre"></i>
						</td>
					</tr>
				<?
				}
				?>
				</tbody>
			</table>
		</div>
		<form id="modal-remove" class="ui small modal transition" method="post" xmlns="http://www.w3.org/1999/html">
			<i class="close icon"></i>
			<div class="header">
				Interrupted
			</div>
			<div class="content">
				<div class="ui form">
					<input type="hidden" name="action" value="remove">

					<input type="hidden" id="genre-id" name="genre-id" value="">

					<p>Are you REALLY sure that you want to delete this genre?</p>
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
	}	
}