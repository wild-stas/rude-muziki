<?

namespace rude;

class page_admin_song_edit
{

	public function __construct()
	{		
		$this->song_genres = song_genres::get();
		$this->song_authors = song_authors::get();
	}	

	public function init()
	{
		if (get('step')!='2')
		{
		$song = songs::get_by_id(get('id'),true);
			?>
			<audio id="audio"></audio>
			<form class="ui form error" method="post" enctype="multipart/form-data" action="http://localhost/rude-muziki/?page=admin&task=edit_song&step=2">
				<input id="id" name="id" value="<?=$song->id;?>">			
				<div class="field">
					<label for="name">Название:</label>
					<input id="name" name="name" value="<?=$song->name;?>">
				</div>
				<div class="field">
					<label for="description">Описание:</label>
					<textarea id="description" name="description"><?=$song->description;?></textarea>
				</div>

				<div class="field">
					<label>Жанр</label>
					<div class="ui fluid selection dropdown">
						<div class="default text" >Выберите жанр</div>
						<input type="hidden" name="genre_id" id="genre_id" value="<?=$song->genre_id;?>">
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
					<label>Исполнитель</label>
					<div class="ui fluid selection dropdown">
						<div class="default text" >Выберите исполнителя</div>
						<input type="hidden" name="author_id" id="author_id" value="<?=$song->author_id;?>">
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
				
				<button type="submit" class="ui button green">Сохранить</button>
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
						}
					},
					{
						onSuccess: function()
						{
							this.submit();
						}
					})
				;				

				rude.semantic.init.dropdown();
			</script>
			<?
		}
		if (get('step')=='2'){			
			$timestamp = date('Y-m-d h:i:s', time());			
			
			if (songs::update(get('id'),get('name'), get('description'), get('author_id'), get('genre_id'), null, null, null, null, null, $timestamp, 1))
			{
			?>
				Композиция успешно изменена.
			<?
			}
			else
			{
				echo "Произошла ошибка, попробуйте еще раз.";
			}
		}
	}
}