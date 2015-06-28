<?

namespace rude;

class page_registration
{
	public function __construct()
	{
		static::validate();
	}
	
	public static function init()
	{
		site::doctype();

		?>
		<html>

		<? site::head() ?>

		<body>
			<div id="container">

				<? site::header() ?>

				<div id="page-registration">
					<? site::menu() ?>

					<div id="content"">
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
			<form id="registration" method="post" class="ui form error">

				<h4 class="ui header dividing">Registration</h4>

				<input type="hidden" name="action" value="registration">

				<? site::error('Registration Aborted') ?>

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
					<input name="password-repeat" type="password" placeholder="Password (confirm)" value="<?= get('password-repeat') ?>">
				</div>

				<input class="ui button green fluid" type="submit" value="Sign Up">
			</form>
			<script type="text/javascript">
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
								rude.url.redirect('?page=homepage');
								console.log('success login vk!');
							}
						});
					}
				}
			</script>

			<script>
				fbAsyncInit();
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

	public static function validate()
	{
		if (get('action') != 'registration')
		{
			return;
		}

		$username        = get('username');
		$email           = get('email');
		$password        = get('password');
		$password_repeat = get('password-repeat');

		if (!$username)
		{
			errors::add('Fill the username field.');
		}

		if (!$email)
		{
			errors::add('Fill the mail field.');
		}

		if (!string::is_email($email))
		{
			errors::add('It\'s not an email address.');
		}

		if (!$password)
		{
			errors::add('Fill the password field.');
		}

		if ($password and string::length($password) < 4)
		{
			errors::add('Password should be longer than 3 characters.');
		}

		if ($username and string::length($username) < 4)
		{
			errors::add('Username should be longer than 3 characters.');
		}

		if ($username and string::length($username) > 32)
		{
			errors::add('Username should be shorter than 32 characters.');
		}

		if (!$password_repeat)
		{
			errors::add('Fill the password confirmation field');
		}

		if ($password != $password_repeat)
		{
			errors::add('Passwords does not match.');
		}

		if (!site::is_username_valid($username))
		{
			errors::add('Username should only contain letters, numbers, space, dash and underscore characters.');
		}

		if (users::is_exists_name($username))
		{
			errors::add('User with such username already registered.');
		}

		if (!errors::get())
		{
			if (site::register($username, $email, $password, RUDE_ROLE_USER))
			{
				site::auth($username, $password);

				headers::redirect(RUDE_SITE_URL);
			}
			else
			{
				errors::add('При попытке регистрации произошла непредвиденная ошибка. Если вы видите данное сообщение - пожалуйста, свяжитесь с владельцем данного ресурса и сообщите о данном сообщении.');
			}
		}
	}
}