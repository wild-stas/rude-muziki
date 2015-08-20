<?

namespace rude;

class page_user_dashboard
{	

	public function __construct()
	{
		
	}

	public function init()
	{
		$user = users::get_by_id(current::user_id(),true);
		?>
		<script>
			rude.crawler.init();
		</script>
		<div id="dashboard" class="ui grid">
			<div class=" column">
				<h4 class="ui header dividing">User profile</h4>

					<img src="src/img/avatar.png">

				<div class="ui divider">

				</div>
				<div>
					<p>Username: <?=$user->name;?></p>
					<p>E-mail: <?=$user->email;?></p>
					<a href="?page=user&task=settings">
						Change profile information and password
						</a>


			</div>



		</div>
		<?
	}
}