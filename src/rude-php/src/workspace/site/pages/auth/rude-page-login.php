<?

namespace rude;

class page_login
{
	public function __construct()
	{
		static::validate();

	}

	public function init()
	{
		site::doctype();

		?>
		<html>

		<? site::head() ?>

		<body>
			<div id="container">

				<? site::header() ?>

				<div id="page-login">
					<? site::menu() ?>

					<div id="content" class="ui segment">
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

			<form id="login" method="post" class="ui form error">

				<h4 class="ui header dividing">Authorization</h4>

				<input type="hidden" name="action" value="authorization">

				<? site::error('Auth aborted') ?>

				<div class="field">
					<input name="username" type="text" placeholder="Username" value="<?= get('username') ?>">
				</div>

				<div class="field">
					<input name="password" type="password" placeholder="Password" value="<?= get('password') ?>">
				</div>

				<input class="ui button green fluid" type="submit" value="Sign In">
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
								$('#content').html(data);
								console.log('success login vk!');
							}
						});
					}
				}
            </script>




			<div id="login_button" onclick="VK.Auth.login(authInfo);"><i class="icon vk"></i></div>

			<script>
                fbAsyncInit();
            </script>

            <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
				<i class="icon facebook"></i>
            </fb:login-button>

            <div id="status">
            </div>
		</div>

		<script>
			rude.semantic.init.dropdown();
		</script>
		<?
	}

	public function validate()
	{
		if (get('action') != 'authorization')
		{
			return;
		}


		$username = get('username');
		$password = get('password');

		if (!$username)
		{
			errors::add('Fill the username field.');
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

		if (!site::is_username_valid($username))
		{
			errors::add('Username should only contain letters, numbers, space, dash and underscore characters.');
		}

		if (!users::get_by_name($username))
		{
			errors::add('We don\'t have such user.');
		}

		if (!errors::get())
		{
			if (site::auth($username, $password))
			{
				headers::redirect(RUDE_SITE_URL);
			}
			else
			{
				errors::add('Wrong password.');
			}
		}
	}
}