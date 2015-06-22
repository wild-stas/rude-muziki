<?

namespace rude;

class page_admin_author_add
{

	public function __construct()
	{
				
	}

	public function init()
	{
		if (get('step')!='2')
		{
			?>
			<form class="ui form error" method="post" enctype="multipart/form-data" action="http://localhost/rude-muziki/?page=admin&task=add_author&step=2">				
				<div class="field">
					<label for="name">Name:</label>
					<input id="name" name="name" value="">
				</div>				
				<button type="submit" class="ui button green">Add</button>
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
			if (song_authors::add(get('name'))){
					?>
						Artist successfully added.
					<?								
			}
			else
			{
				echo "An error has occurred, please try again.";
			}
		}
	}
}