<?

namespace rude;

class page_admin_song_add
{

	public function __construct()
	{
		$this->song_genres = song_genres::get();
		$this->song_authors = song_authors::get();
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
			?>
			<audio id="audio"></audio>

			<form class="ui form error" method="post" enctype="multipart/form-data" action="?page=admin&task=add_song&step=2">

				<div class="field">
					<label>Song</label>
					<label id="audiofile-label" for="audiofile" class="ui icon button basic"><i class="icon folder open"></i> Click and select the file</label>

					<input id="audiofile" name="audiofile" type="file" style="display: none;" accept="audio/mp3,audio/mp4,audio/ogg,audio/opus,audio/wav">

					<script>
						$('#audiofile').change(function()
						{
							$('#audiofile-label').html('<i class="icon folder open"></i> ' + $('#audiofile').val().split('\\').pop());
						});
					</script>
				</div>

				<div class="field">
					<label>Song cover</label>
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
					<label for="name">Name:</label>
					<input id="name" name="name" value="">
				</div>
				<div class="field">
					<label for="description">Description:</label>
					<textarea id="description" name="description"></textarea>
				</div>

				<div class="field">
					<label>Genre</label>
					<div class="ui fluid selection dropdown">
						<div class="default text" >Select genre</div>
						<input type="hidden" name="genre_id" id="genre_id">
						<div style="max-height: 150px;" class="menu">
							<?
							foreach ($this->song_genres as $genre)
							{
								?>
								<div class="item" data-value="<?= $genre->id  ?>"><?= $genre->name  ?></div>
							<?
							}?>
						</div>
					</div>
				</div>

				<div class="field">
					<label>Author</label>
					<div class="ui fluid selection dropdown">
						<div class="default text" >Select author</div>
						<input type="hidden" name="author_id" id="author_id">
						<div style="max-height: 150px;" class="menu">
							<?
							foreach ($this->song_authors as $author)
							{
								?>
								<div class="item" data-value="<?= $author->id  ?>"><?= $author->name  ?></div>
							<?
							}?>
						</div>
					</div>
				</div>
				<div class="field">
					<div class="ui toggle checkbox">
						<label for="is_top">Mark as top</label>
						<input type="checkbox" name="is_top" id="is_top">
					</div>
				</div>

				<div class="field" hidden>
					<label for="duration">duration:</label>
					<input id="duration" name="duration" value="">
				</div>
				<button type="submit" class="ui button green">Add</button>
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
						},
						description:{
							identifier : 'description',
							rules: [
								{
									type   : 'empty'
								}
							]
						},
						genre_id: {
							identifier : 'genre_id',
							rules: [
								{
									type   : 'empty'
								}
							]
						},
						author_id: {
							identifier : 'author_id',
							rules: [
								{
									type   : 'empty'
								}
							]
						},
						audiofile: {
							identifier : 'audiofile',
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
				var objectUrl;

				$("#audio").on("canplaythrough", function(e){
					var seconds = e.currentTarget.duration;
					$("#duration").val(Math.round(seconds));
					URL.revokeObjectURL(objectUrl);
				});

				$("#file").change(function(e){
					var file = e.currentTarget.files[0];
					$("#name").val(file.name);
					$("#filesize").val(file.size);
					objectUrl = URL.createObjectURL(file);
					$("#audio").prop("src", objectUrl);
				});

				rude.semantic.init.dropdown();
				rude.semantic.init.checkbox();
			</script>
			<?
		}
		if (get('step')=='2'){
			$uploaddir_audio = 'src/audio/';
			$uploaddir_image = 'src/img/covers/';
			$file_audio = 'song_' . static::generateRandName(13) . '.' . pathinfo(basename($_FILES['audiofile']['name']), PATHINFO_EXTENSION);
			$file_image = 'img_' . static::generateRandName(13) . '.' . pathinfo(basename($_FILES['imagefile']['name']), PATHINFO_EXTENSION);
			$uploadfile_audio  = $uploaddir_audio . $file_audio;
			$uploadfile_image  = $uploaddir_image . $file_image;
			$file_audio_size = $_FILES['audiofile']['size'];
			$file_image_size = $_FILES['imagefile']['size'];
			$timestamp = date('Y-m-d h:i:s', time());
			$is_top = get('is_top');

			if ($is_top=='on'){
				$is_top=1;
			}else{
				$is_top=0;
			}
			
			if ( mime::is_audio($_FILES['audiofile']['type']) && mime::is_image($_FILES['imagefile']['type']) )
			{
				if ( move_uploaded_file($_FILES['audiofile']['tmp_name'], $uploadfile_audio) && move_uploaded_file($_FILES['imagefile']['tmp_name'], $uploadfile_image))
				{
					songs::add(get('name'), get('description'), get('author_id'), get('genre_id'), get('duration'), $file_audio, $file_audio_size, $file_image, $file_image_size, $timestamp,null,$is_top);
					?>
						Song succesfully added.
					<?
				}
			}
			else
			{
				echo "An error has occurred, please try again.";
			}
		}
	}
}