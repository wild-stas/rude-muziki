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

				<? site::logo() ?>

				<div id="page-login">
					<? site::menu() ?>

					<div id="content" class="ui segment">
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
			<form id="login" method="post" class="ui form error">
				<input type="hidden" name="action" value="authorization">

				<? site::error('При попытке авторизации возникли некоторые трудности. Пожалуйста, проверьте корректность ввода данных со следующими рекомендациями:') ?>

				<div class="field">
					<input name="username" type="text" placeholder="Псевдоним" value="<?= get('username') ?>">
				</div>

				<div class="field">
					<input name="password" type="password" placeholder="Пароль" value="<?= get('password') ?>">
				</div>

				<input class="ui button green to-left" type="submit" value="Авторизироваться">
			</form>
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
			errors::add('Укажите имя пользователя.');
		}

		if (!$password)
		{
			errors::add('Введите пароль пользователя.');
		}

		if ($password and string::length($password) < 4)
		{
			errors::add('Пароль не может быть короче 4 символов.');
		}

		if ($username and string::length($username) < 4)
		{
			errors::add('Имя пользователя не может быть короче 4 символов.');
		}

		if ($username and string::length($username) > 32)
		{
			errors::add('Имя пользователя не может содержать более 32 символов.');
		}

		if (!site::is_username_valid($username))
		{
			errors::add('Имя пользователя может содержать только цифры, буквы русского и английского алфавита, а также пробел, чёрточку и символ нижнего подчёркивания.');
		}

		if (!users::get_by_name($username))
		{
			errors::add('Указанного Вами пользователя не существует.');
		}

		if (!errors::get())
		{
			if (site::auth($username, $password))
			{
				headers::redirect(RUDE_SITE_URL);
			}
			else
			{
				errors::add('Указанный Вами пароль не подходит к данному пользователю.');
			}
		}
	}
}