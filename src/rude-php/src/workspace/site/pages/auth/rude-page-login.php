<?

namespace rude;

class page_login
{
	public function __construct()
	{
		//static::validate();
	}

	public function init()
	{
		if (get('ajax')){
			?>
			<div id="page-login">
			<?
			static::main();
			?>
			</div>
			<?
			return;
		}


		site::doctype();

		?>
		<html>

		<? site::head() ?>

		<body>
			<div id="container">

				<? site::header() ?>


					<? site::menu() ?>

					<div id="content">
						<div id="page-login">
						<? static::main() ?>
					</div>
				</div>

				<? site::footer() ?>

				<? site::player() ?>
			</div>

			</body>
		</html>
		<?
	}

	public static function main()
	{
		?>
		<div id="main">

			<form id="login" method="POST" action="javascript:void(null)" class="ui form error">

				<h4 class="ui header dividing">Authorization</h4>

				<input type="hidden" name="action" id="action" value="authorization">

				<?
				$errors = [];
				if (get('action') == 'authorization')
				{
				$username = get('username');
				$password = get('password');

				if ($password and string::length($password) < 4)
				{
					array_push($errors,'Fill the username field.');
				}

				if ($username and string::length($username) < 4)
				{
					array_push($errors,'Username should be longer than 3 characters.');
				}

				if ($username and string::length($username) > 32)
				{
					array_push($errors,'Username should be shorter than 32 characters.');
				}

				if (!site::is_username_valid($username))
				{
					array_push($errors,'Username should only contain letters, numbers, space, dash and underscore characters.');
				}

				if (!users::get_by_name($username))
				{
					array_push($errors,'We don\'t have such user.');
				}

				if (!$errors)
				{
					if (site::auth($username, $password))
					{
						?>
							<script>
								rude.crawler.repaint_site_menu();
								rude.crawler.open('?page=homepage');
								rude.crawler.init();
							</script>
						<?

					}
					else
					{
						array_push($errors,'Wrong password.');
					}
				}
				}

				if ($errors){?>
			<div class="ui error message">
			<div class="ui header dividing">Auth aborted</div>

		<div class="ui list">
			<?
			foreach ($errors as $error)
			{
				?><span class="item black"><i class="icon bug"></i><?= $error ?></span><?
			}
			?>
		</div>
		</div>

<? } ?>

				<div class="field">
					<input name="username" id="username" type="text" placeholder="Username" value="<?= get('username') ?>">
				</div>

				<div class="field">
					<input name="password" id="password" type="password" placeholder="Password" value="<?= get('password') ?>">
				</div>

				<input class="ui button green fluid" type="submit" value="Sign In">
			</form>

            <script type="text/javascript">
				$('.ui.form')
					.form({
						username: {
							identifier : 'username',
							rules: [
								{
									type   : 'empty'
								}
							]
						},
						password: {
							identifier : 'password',
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
							login_ajax();
						}
					})
				;
				function login_ajax(){

					var username = $('#username').val();
					var password = $('#password').val();
					var action =   $('#action').val();
					$.ajax({

						type:'POST',
						url:'index.php?page=login',
						data: {

							username : username,
							password : password,
							action : action,
							ajax : 1
						},
						success: function(data){
							$('#content').html(data);
						},
						error: function ()
						{

							console.log('fail!');
						}
					});
				}
                VK.init({apiId: 4972706});
				function authInfo(response) {
					if (response.session) {
						$.ajax
						({
							url: 'index.php?page=ajax&task=vk_login',

							type: 'GET',

							data: {
								expire: response.session.expire,
								mid: response.session.mid,
								secret: response.session.secret,
								sid: response.session.sid,
								sig: response.session.sig
							},

							success: function (data)
							{
								rude.crawler.open('?page=homepage');
								rude.crawler.repaint_site_menu();
								console.log('success login vk!');
							}
						});
					}
				}
            </script>
			<?= html::js('src/js/fb.js') ?>
			<script>

               // fbAsyncInit();

            </script>

			<h4 class="ui header dividing">You can also login via social networks</h4>

			<div class="ui form socials">
				<div class="two fields">
					<div class="field">
						<div class="ui facebook button fluid mini" onclick="fb_login();">
							<i class="facebook icon"></i>
							Facebook
						</div>
					</div>

					<div class="field">
						<div class="ui vk button fluid mini" onclick="VK.Auth.login(authInfo);">
							<i class="vk icon"></i>
							VK
						</div>
					</div>
				</div>
			</div>
		</div>

		<script>
			rude.semantic.init.dropdown();
		</script>
		<?
	}

}

