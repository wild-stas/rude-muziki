<?

namespace rude;

class page_admin_author_edit
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
		if (get('step')!='2')
		{
			$song_author = song_authors::get_by_id(get('id'),true);
			?>
			<form class="ui form error" method="post" enctype="multipart/form-data" action="/?page=admin&task=edit_author&step=2">
				<input type="hidden" id="id" name="id" value="<?=$song_author->id;?>">
				<div class="field">
					<label for="name">Name:</label>
					<input id="name" name="name" value="<?=$song_author->name;?>">
				</div>
				<div class="field">
					<label>Image</label>
					<label id="imagefile-label" for="imagefile" class="ui icon button basic"><i class="icon folder open"></i> Click and select the file</label>

					<input id="imagefile" name="imagefile" type="file" accept="image/*" style="display: none;">
					<script>
						$('#imagefile').change(function()
						{
							$('#imagefile-label').html('<i class="icon folder open"></i> ' + $('#imagefile').val().split('\\').pop());
						});
					</script>
				</div>
				<div class="field">
					<div class="ui toggle checkbox">
						<label for="in_homepage">Show in homepage</label>
						<input type="checkbox" name="in_homepage" id="in_homepage">
					</div>
				</div>
				<button type="submit" class="ui button green">Save</button>
			</form>
			<script>
				$('.ui.form')
					.form({
						name: {
							identifier : 'name',
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
							this.submit();
						}
					})
				;
				$("#file").change(function(e){
					var file = e.currentTarget.files[0];
					$("#name").val(file.name);
					$("#filesize").val(file.size);
					objectUrl = URL.createObjectURL(file);
					$("#audio").prop("src", objectUrl);
				});
				rude.semantic.init.checkbox();
				<? if ($song_author->in_homepage==1){?>
				$('#in_homepage').prop('checked', true);
				<?}?>
			</script>
			<?
		}
		if (get('step')=='2'){
			$in_homepage = get('in_homepage');

			if ($in_homepage=='on'){
				$in_homepage=1;
			}else{
				$in_homepage=0;
			}

if ($_FILES['imagefile']['name'])
{
	$uploaddir_image = 'src/img/author/';
	$file_image = 'img_' . static::generateRandName(13) . '.' . pathinfo(basename($_FILES['imagefile']['name']), PATHINFO_EXTENSION);

	$uploadfile_image = $uploaddir_image . $file_image;

	if (mime::is_image($_FILES['imagefile']['type']))
	{
		if (move_uploaded_file($_FILES['imagefile']['tmp_name'], $uploadfile_image))
		{
			if (song_authors::update(get('id'), get('name'), $in_homepage, $file_image, 1))
			{
				?>
				Artist successfully changed.
			<?
			}
		}
	}

	else
	{
		echo "An error has occurred, please try again.";
	}
}else{

			if (song_authors::update(get('id'), get('name'), $in_homepage, null, 1))
			{
				?>
				Artist successfully changed.
			<?
			}



	else
	{
		echo "An error has occurred, please try again.";
	}
}
		}
	}
}