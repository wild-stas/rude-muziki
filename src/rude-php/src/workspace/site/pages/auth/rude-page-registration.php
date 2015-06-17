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
			<form id="registration" method="post" class="ui form error">
				<input type="hidden" name="action" value="registration">

				<? site::error('При попытке регистрации возникли некоторые трудности. Пожалуйста, проверьте корректность ввода данных со следующими рекомендациями:') ?>

				<div class="field">
					<input name="username" type="text" placeholder="Псевдоним" value="<?= get('username') ?>">
				</div>

				<div class="field">
					<input name="email" type="email" placeholder="E-mail" value="<?= get('email') ?>">
				</div>

				<div class="field">
					<input name="password" type="password" placeholder="Пароль" value="<?= get('password') ?>">
				</div>

				<div class="field">
					<input name="password-repeat" type="password" placeholder="Пароль (повторно)" value="<?= get('password-repeat') ?>">
				</div>


				<div class="field">
					<div class="ui selection dropdown">
						<input type="hidden" name="role-id" value="<?= get('role-id') ?>">
						<div class="default text">Выберите роль пользователя в системе</div>
						<i class="dropdown icon"></i>

						<div class="menu">
							<div class="item" data-value="<?= RUDE_ROLE_USER ?>">Пользователь</div>
							<div class="item" data-value="<?= RUDE_ROLE_COMPANY ?>">Компания</div>
						</div>
					</div>
				</div>

				<input class="ui button green to-left" type="submit" value="Зарегистрироваться">
			</form>
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
		$role_id         = get('role-id');

		if (!$username)
		{
			errors::add('Выберите себя имя пользователя.');
		}

		if (!$email)
		{
			errors::add('Укажите e-mail адрес.');
		}

		if (!string::is_email($email))
		{
			errors::add('Введите корректный e-mail адрес.');
		}

		if (!$password)
		{
			errors::add('Придумайте пароль для своего пользователя.');
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

		if (!$password_repeat)
		{
			errors::add('Введите свой пароль ещё раз в соответствующее поле.');
		}

		if ($role_id != RUDE_ROLE_USER and $role_id != RUDE_ROLE_COMPANY)
		{
			errors::add('Пожалуйста, выберите роль пользователя в системе из предложенных в выпадающем списке.');
		}

		if ($password != $password_repeat)
		{
			errors::add('Указанные пароли должны совпадать.');
		}

		if (!site::is_username_valid($username))
		{
			errors::add('Имя пользователя может содержать только цифры, буквы русского и английского алфавита, а также пробел, чёрточку и символ нижнего подчёркивания.');
		}

		if (users::is_exists_name($username))
		{
			errors::add('Пользователь с таким псевдонимом уже существует');
		}

		if (!errors::get())
		{
			if (site::register($username, $email, $password, $role_id))
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