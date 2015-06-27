<?

namespace rude;

class page_admin_author
{
	private $song_authors = null;

    public static function get_song_authors()    {

        $num_page = get('num_page');

        $database = database();

        $q =
            '
				SELECT
					*
				FROM
					song_authors
				WHERE 1
			';

        if ($num_page){
            $q .= '
				LIMIT ' . ($num_page-1)*100 . ',100
				';
        }

        if (!$num_page)
        {
            $q .=
                '
					LIMIT 0,100
				';
        }


        $database->query($q);

        return $database->get_object_list();
    }

	public function __construct()
	{
		$this->song_authors = static::get_song_authors();

        $action = get('action');
        switch ($action)
        {
            case 'remove':

                $id = get('author-id');

                if ($id) {
                    if (songs::is_exists_author_id($id)) { ?>
                        <div class="ui divider"></div>

                        <div class="ui icon message orange">
                            <i class="icon remove"></i>

                            <div class="content">
                                <div class="header">
                                    ERROR
                                </div>

                                <p>Selected author take part in many songs</p>
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

                                <p>Selected author have been successfully removed</p>
                            </div>
                        </div>
                        <script>
                            setTimeout(function(){
                                rude.url.redirect('?page=admin&task=author')
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
                            <i class="icon remove red popup init" onclick="$('#author-id').val(<?= $song_author->id ?>); $('#modal-remove').modal('show');" data-content="Remove author"></i>
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

                    <input type="hidden" id="author-id" name="author-id" value="">

                    <p>Are you REALLY sure that you want to delete this author?</p>
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
        pagination::html(song_authors::count(),get('num_page'),100,6,'p','?page=admin&task=author');
	}	
}