<?

namespace rude;

class page_user_dashboard
{	

	public function __construct()
	{
		
	}

	public function generateRandName($length = 13){
		$chars = 'abdefhiknrstyz0123456789';
		$numChars = strlen($chars);
		$string = '';
		for ($i = 0; $i < $length; $i++) {
			$string .= substr($chars, rand(1, $numChars) - 1, 1);
		}
		return $string;
	}

	public function init()
	{
		$user = users::get_by_id(current::user_id(),true);
		?>
		<script>
			rude.crawler.init();
		</script>
		<div id="main" class="">
			<div class=" ">
				<h4 class="ui header dividing">User profile</h4>
				<div class="">
					<img src="<? if ($user->avatar) { echo $user->avatar;}else{ echo 'src/img/avatar.png'; }?>"  onclick="$('#modal-add').modal({ closable: false }).modal('show')">
				</div>
				<div class="">
					<p>Username: <?=$user->name;?></p>
					<p>E-mail: <?=$user->email;?></p>
					<a href="?page=user&task=settings">
						<input class="ui button green fluid" type="submit" value="Change">
					</a>
				</div>
				<div class="ui divider">

				</div>
				<form id="registration" method="post" enctype="multipart/form-data" action="javascript:void(null)" class="ui form error">

					<h4 class="ui header dividing">Change user settings</h4>

					<input type="hidden" name="action" value="edit">

					<?
					$errors = [];
					if (get('action') == 'change_avatar')
					{
						$uploaddir_image = 'src/img/avatars/';
						$file_image = 'img_' . static::generateRandName(13) . '.' . pathinfo(basename($_FILES['image']['name']), PATHINFO_EXTENSION);
						$uploadfile_image  = $uploaddir_image . $file_image;

						if ( mime::is_image($_FILES['image']['type']) )
						{
							if ( move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile_image))
							{
								users::update(current::user_id(),2, null, null, null, null,null,null,null,$uploadfile_image);
?>
								<script>
									rude.crawler.open('?page=user');
									rude.crawler.init();
									$('#modal-add').modal({ closable: false }).modal('hide');
								</script>
								<?
							}
						}
						else
						{
							echo "An error has occurred, please try again.";
						}
					}
					if (get('action') == 'edit')
					{

						$lastname  = get('lastname');
						$firstname = get('firstname');
						$birthdate = get('birthdate');


						if (!$errors)
						{
							if (users::update(current::user_id(),2, null, null, null, null,null,null,null,null,$lastname,$firstname,$birthdate)){
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
						<label>Last name</label>
						<input name="lastname" type="text" placeholder="Last name" value="<?= $user->lastname; ?>">
					</div>

					<div class="field">
						<label>First name</label>
						<input name="firstname" type="text" placeholder="First name" value="<?= $user->firstname; ?>">
					</div>

					<div class="field">
						<label>Date of birth</label>
						<input name="birthdate" type="date" placeholder="Date of birth" value="<?= $user->birthdate; ?>">
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
								save_user_settings();
							}
						})
					;
					function save_user_settings(){
						$.ajax({
							type:'POST',
							url:'index.php?page=user',
							data: {
								ajax: 1,
								lastname  : $('input[name=lastname]').val(),
								firstname : $('input[name=firstname]').val(),
								birthdate : $('input[name=birthdate]').val(),
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



		</div>
		<form id="modal-add" class="ui modal transition coupled" method="post" enctype="multipart/form-data" action="javascript:void(null)">
			<i class="close icon"></i>
			<div class="header">
				Change your avatar
			</div>
			<div class="content">
				<div class="ui form">


						<div class="field">
							<label>Avatar image</label>
							<label id="image-label" for="image" class="ui icon button basic"><i class="icon folder open"></i> Click and select the image</label>

							<input id="image" name="image" type="file" style="display: none;">

							<script>
								$('#image').change(function()
								{
									$('#image-label').html('<i class="icon folder open"></i> ' + $('#image').val().split('\\').pop());
								});
							</script>
						</div>

				</div>
			</div>
			<div class="actions-fixed">
				<button class="ui positive right labeled icon button" type="submit">
					<i class="checkmark icon"></i>
					Save
				</button>
			</div>
		</form>
		<script type="text/javascript">
			$('#modal-add')
				.form({

				},
				{
					onSuccess: function()
					{
//						this.submit();
						change_avatar();
					}
				})
			;
			function change_avatar(){
				var fd = new FormData();
				fd.append('ajax', '1');
				fd.append('action', 'change_avatar');
				fd.append('image', $('#image')[0].files[0]);
				$.ajax({
//					type:'POST',
//					url:'index.php?page=user',
//					enctype: 'multipart/form-data',
//					data: fd,
					type: 'POST',
					url:'index.php?page=user',
					data: fd,
					processData: false,
					contentType: false,
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
		<?
	}
}