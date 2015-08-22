<?

namespace rude;

class page_user_settings
{

	public function __construct()
	{

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
			<form id="registration" method="post" enctype="multipart/form-data" action="javascript:void(null)" class="ui form error">

				<h4 class="ui header dividing">Change user settings</h4>

				<input type="hidden" name="action" value="edit">

				<?
				$errors = [];
				if (get('action') == 'edit')
				{

					$username        = get('username');
					$email           = get('email');
					$password        = get('password');
					$password_repeat = get('password_repeat');



					if (!string::is_email($email))
					{
						array_push($errors,'It\'s not an email address.');
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

					if ($password && !$password_repeat)
					{
						array_push($errors,'Fill the password confirmation field');
					}

					if ($password && $password != $password_repeat)
					{
						array_push($errors,'Passwords does not match.');
					}

					if (!site::is_username_valid($username))
					{
						array_push($errors,'Username should only contain letters, numbers, space, dash and underscore characters.');
					}

					if (users::is_exists_name($username) && $username!=$user->name)
					{
						array_push($errors,'User with such username already exist.');
					}

					if (!$errors)
					{


						$hash='';
						$salt='';
						if ($password){
							list($hash, $salt) = crypt::password($password);
						}
						if (users::update(current::user_id(),2, $username, $email, $hash, $salt)){
							?>
							<script>

								rude.crawler.open('?page=user');
								rude.crawler.init();
							</script>
						<?
						}
						else
						{
							array_push($errors,'Some error. Please report us about this.');

						}
					}
				}
				if ($errors){?>
					<div class="ui error message">
						<div class="ui header dividing">Setup aborted</div>

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
					<label>Username</label>
					<input name="username" type="text" placeholder="Username" value="<?= $user->name; ?>">
				</div>

				<div class="field">
					<label>E-mail</label>
					<input name="email" type="email" placeholder="E-mail" value="<?= $user->email; ?>">
				</div>

				<div class="field">
					<label>Password</label>
					<input name="password" type="password" placeholder="Password" value="">
				</div>

				<div class="field">
					<label>Password (confirm)</label>
					<input name="password_repeat" type="password" placeholder="Password (confirm)" value="">
				</div>

				<input class="ui button green fluid" type="submit" value="Save">
			</form>
			<script type="text/javascript">
				$('.ui.form')
					.form({

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
						url:'index.php?page=user&task=settings',
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

			</script>

		</div>

		<script>
			rude.semantic.init.dropdown();
		</script>



	<?
	}


}