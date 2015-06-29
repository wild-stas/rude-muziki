<?

namespace rude;

class page_user_settings
{

	public function __construct()
	{
		static::validate();
	}

	public static function init()
	{
		if (get('ajax'))
		{
			static::main();
			return;
		}
		site::doctype();

		?>
		<html>

		<? site::head() ?>

		<body>
		<div id="container">


			<div id="page-user-settings">

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
		$user = users::get_by_id(current::user_id(),true);
		?>
		<script>
			rude.crawler.init();
		</script>
		<div id="main">
			<form id="registration" method="post" class="ui form error">

				<h4 class="ui header dividing">Change user settings</h4>

				<input type="hidden" name="action" value="edit">

				<? site::error('Setup Aborted') ?>

				<div class="field">
					<input name="username" type="text" placeholder="Username" value="<?= $user->name; ?>">
				</div>

				<div class="field">
					<input name="email" type="email" placeholder="E-mail" value="<?= $user->email; ?>">
				</div>

				<div class="field">
					<input name="password" type="password" placeholder="Password" value="">
				</div>

				<div class="field">
					<input name="password-repeat" type="password" placeholder="Password (confirm)" value="">
				</div>

				<input class="ui button green fluid" type="submit" value="Save">
			</form>
		</div>

		<script>
			rude.semantic.init.dropdown();
		</script>
	<?
	}

	public static function validate()
	{
		if (get('action') != 'edit')
		{
			return;
		}

		$username        = get('username');
		$email           = get('email');
		$password        = get('password');
		$password_repeat = get('password-repeat');



		if ($email && !string::is_email($email))
		{
			errors::add('It\'s not an email address.');
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

		if ($password && !$password_repeat)
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



		if (!errors::get())
		{
			if ($password){
				list($hash, $salt) = crypt::password($password);
			}
			if (users::update(current::user_id(),2, $username, $email, $hash, $salt)){
				headers::redirect('?page=user');
			}
			else
			{
				errors::add('При попытке регистрации произошла непредвиденная ошибка. Если вы видите данное сообщение - пожалуйста, свяжитесь с владельцем данного ресурса и сообщите о данном сообщении.');
			}
		}
	}
}