<?

namespace rude;

class page_registration
{
	public function __construct()
	{

	}
	
	public static function init()
	{
		if (get('ajax'))
		{
			?>
			<div id="page-registration">
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
						<div id="page-registration">
						<? static::main() ?>
					</div>
				</div>

				<? site::footer() ?>
			</div>
		</body>
		</html>
		<?
	}
	
	public static function main()
	{
		?>
		<div id="main">
			<form id="registration" method="post" action="javascript:void(null)" class="ui form error">

				<h4 class="ui header dividing">Registration</h4>

				<input type="hidden" name="action" value="registration">

				<?
				$errors = [];
				if (get('action') == 'registration')
				{

				$username        = get('username');
				$email           = get('email');
				$password        = get('password');
				$password_repeat = get('password_repeat');

				if (!$username)
				{
					array_push($errors,'Fill the username field.');
				}

				if (!$email)
				{
					array_push($errors,'Fill the mail field.');
				}

				if (!string::is_email($email))
				{
					array_push($errors,'It\'s not an email address.');
				}

				if (!$password)
				{
					array_push($errors,'Fill the password field.');
				}

				if ($password and string::length($password) < 4)
				{
					array_push($errors,'Password should be longer than 3 characters.');
				}

				if ($username and string::length($username) < 4)
				{
					array_push($errors,'Username should be longer than 3 characters.');
				}

				if ($username and string::length($username) > 32)
				{
					array_push($errors,'Username should be shorter than 32 characters.');
				}

				if (!$password_repeat)
				{
					array_push($errors,'Fill the password confirmation field');
				}

				if ($password != $password_repeat)
				{
					array_push($errors,'Passwords does not match.');
				}

				if (!site::is_username_valid($username))
				{
					array_push($errors,'Username should only contain letters, numbers, space, dash and underscore characters.');
				}

				if (users::is_exists_name($username))
				{
					array_push($errors,'User with such username already registered.');
				}

				if (!$errors)
				{
					if (site::register($username, $email, $password, RUDE_ROLE_USER))
					{
						site::auth($username, $password);
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
						array_push($errors,'Some error. Please report us about this.');
						return false;
					}
				}
				}
				if ($errors){?>
					<div class="ui error message">
						<div class="ui header dividing">Registration aborted</div>

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
					<input name="username" type="text" placeholder="Username" value="<?= get('username') ?>">
				</div>

				<div class="field">
					<input name="email" type="email" placeholder="E-mail" value="<?= get('email') ?>">
				</div>

				<div class="field">
					<input name="password" type="password" placeholder="Password" value="<?= get('password') ?>">
				</div>

				<div class="field">
					<input name="password_repeat" type="password" placeholder="Password (confirm)" value="<?= get('password_repeat') ?>">
				</div>

				<input class="ui button green fluid" type="submit" value="Sign Up">
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
						email: {
							identifier : 'email',
							rules: [
								{
									type   : 'empty'
								}
							]
						},
						password_repeat: {
							identifier : 'password_repeat',
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
							register_ajax();
						}
					})
				;
				function register_ajax(){
					$.ajax({
						type:'POST',
						url:'index.php?page=registration',
						data: {
							ajax: 1,
							username : $('input[name=username]').val(),
							email : $('input[name=email]').val(),
							password : $('input[name=password]').val(),
							password_repeat : $('input[name=password_repeat]').val(),
							action : $('input[name=action]').val()
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

			<script>
				//fbAsyncInit();
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