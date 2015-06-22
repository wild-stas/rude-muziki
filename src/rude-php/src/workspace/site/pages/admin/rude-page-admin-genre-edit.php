<?

namespace rude;

class page_admin_genre_edit
{

	public function __construct()
	{
				
	}

	public function init()
	{
		if (get('step')!='2')
		{
			$song_genre = song_genres::get_by_id(get('id'),true);
			?>
			<form class="ui form error" method="post" enctype="multipart/form-data" action="http://localhost/rude-muziki/?page=admin&task=edit_genre&step=2">	
				<input type="hidden" id="id" name="id" value="<?=$song_genre->id;?>">
				<div class="field">
					<label for="name">Name:</label>
					<input id="name" name="name" value="<?=$song_genre->name;?>">
				</div>				
				<button type="submit" class="ui button green">Save</button>
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
			if (song_genres::update( get('id'),get('name'),1 )){
				?>
				Genre successfully changed.
				<?								
			}
			else
			{
				echo "An error has occurred, please try again.";
			}
		}
	}
}