<?

namespace rude;

class page_admin_author_edit
{

	public function __construct()
	{
				
	}

	public function init()
	{
		if (get('step')!='2')
		{
			$song_author = song_authors::get_by_id(get('id'),true);
			?>
			<form class="ui form error" method="post" enctype="multipart/form-data" action="http://localhost/rude-muziki/?page=admin&task=edit_author&step=2">	
				<input type="hidden" id="id" name="id" value="<?=$song_author->id;?>">
				<div class="field">
					<label for="name">Название:</label>
					<input id="name" name="name" value="<?=$song_author->name;?>">
				</div>				
				<button type="submit" class="ui button green">Сохранить</button>
			</form>
			<script>
				$('.ui.form')
					.form({
						name: {
							identifier : 'name',
							rules: [
								{
									type   : 'empty'
								}
							]
						}
					},
					{
						onSuccess: function()
						{
							this.submit();
						}
					})
				;
			</script>
			<?
		}
		if (get('step')=='2'){
			if (song_authors::update( get('id'),get('name'),1 )){
				?>
						Исполнитель успешно изменен.
				<?								
			}
			else
			{
				echo "Произошла ошибка, попробуйте еще раз.";
			}
		}
	}
}