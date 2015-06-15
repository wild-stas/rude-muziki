<?

namespace rude;

class page_about
{
	public static function init($title = 'О нас')
	{
		site::doctype();

		?>
		<html>

		<? site::head($title) ?>

		<body>
		<div id="container">

			<? site::logo($title) ?>

			<div id="page-about">
				<? site::menu() ?>

				<div id="content">
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
		<div id="main" class="ui segment">
			<h4 class="ui header dividing">О нашей компании</h4>

			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce blandit, ligula et imperdiet placerat, tellus metus eleifend velit, nec gravida lectus felis sit amet lorem. Aenean porta velit nunc, nec posuere ex rutrum ut. Fusce suscipit, ipsum ac tristique tempor, magna magna dignissim erat, vel condimentum elit nisi ac turpis. Pellentesque sodales nunc sapien, id pellentesque odio fermentum semper. Nam sit amet quam non nisl ultrices lacinia quis ut ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean convallis eleifend efficitur. Mauris nisl diam, convallis et quam non, venenatis eleifend sem. Cras vel elit est. Fusce viverra lorem dapibus facilisis bibendum. Curabitur consectetur mauris quis nulla mattis aliquet. Ut bibendum ullamcorper nisl quis volutpat.</p>
			<p>Quisque mollis dapibus convallis. Phasellus dui neque, ultricies non nisi a, faucibus tincidunt sapien. Donec sed blandit turpis. Pellentesque congue ullamcorper libero. Fusce eu tortor pharetra, lacinia nulla non, placerat justo. Curabitur et convallis dui. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse potenti. Aliquam pretium metus lectus, et venenatis mauris finibus at.</p>
			<p>Donec pharetra varius lacinia. Nam hendrerit lacus massa, a accumsan lectus mollis et. Vivamus ultrices nisi ut elit iaculis suscipit. Donec sapien ante, tempor ut volutpat ut, scelerisque quis felis. Donec vitae purus iaculis, tempus arcu vel, interdum odio. Cras aliquet turpis orci, in aliquet quam porta et. Integer rhoncus, metus nec volutpat eleifend, metus nisl gravida tortor, quis mollis magna sem a libero. Aenean sed nulla ac dolor consequat aliquam at nec turpis. Nulla facilisi. Nunc suscipit lobortis maximus.</p>
			<p>Maecenas ac elit ut massa ornare suscipit nec sit amet nunc. Nunc luctus ornare malesuada. Fusce pretium, tellus quis rhoncus blandit, tellus risus sodales leo, vel porttitor ex dui at velit. Integer id massa nulla. In ut leo hendrerit orci venenatis lacinia. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque vitae porttitor est, in pharetra orci. Ut aliquet leo nec dignissim rutrum.</p>
			<p>Ut nulla sapien, ultricies ut mi quis, dignissim consectetur lacus. Vestibulum elementum ante et lectus malesuada, ac gravida nisi viverra. Curabitur dapibus libero quis odio varius ultricies. In hac habitasse platea dictumst. In ornare, est et luctus ornare, erat quam vehicula felis, non interdum odio lectus in elit. Suspendisse convallis aliquet odio ut bibendum. Nam eu sem convallis, vestibulum diam sit amet, gravida tortor. Praesent placerat hendrerit efficitur. Sed id rutrum nulla. Suspendisse potenti. Suspendisse ac ipsum ut nunc maximus imperdiet a lobortis massa. Donec enim felis, aliquam non magna et, lacinia ultricies eros. Duis risus ligula, viverra a tellus id, viverra placerat lacus.</p>
			<p>Nullam lacinia sapien ullamcorper ipsum euismod aliquam. Vivamus maximus cursus mi at facilisis. Proin in consequat lectus, eget hendrerit diam. Maecenas tellus felis, bibendum nec congue sit amet, dapibus vitae magna. Vestibulum et semper eros. Nullam quis purus ex. Praesent a arcu a tellus dictum auctor. Aliquam ornare velit massa, sed fermentum tellus consectetur et. Ut pellentesque metus eget est laoreet, ac cursus erat dignissim. Morbi ut ante hendrerit, sodales eros vitae, interdum tellus. Duis tincidunt purus ac gravida sollicitudin. Curabitur iaculis enim sit amet nisl egestas, at tincidunt elit laoreet. Vestibulum nec leo ut metus pharetra consequat eget non sem. Pellentesque vel dignissim nisi. Sed vel varius lacus. Etiam sodales pulvinar sollicitudin.</p>
			<p>Integer porta orci quis nulla laoreet, vel auctor lorem commodo. Aenean sed feugiat enim. Nam vestibulum ex quis lorem condimentum, scelerisque aliquet urna scelerisque. Proin sit amet tortor at leo accumsan euismod blandit pretium mauris. Cras eget ornare orci. In vel lorem at orci sagittis ultrices. Fusce lacinia risus id felis bibendum efficitur.</p>
			<p>Donec aliquet posuere risus. Vivamus dignissim a purus ut elementum. Aliquam erat volutpat. Nam in nisi et augue varius rhoncus ut vitae nulla. Mauris porta egestas dolor, non tempus velit finibus et. Integer hendrerit mollis sapien, varius tempor massa tristique eget. Fusce odio dolor, fringilla ac feugiat tempor, malesuada ut lorem. Quisque facilisis magna ac neque gravida euismod. Sed tristique arcu quis hendrerit consequat. Nullam et elit vel justo dapibus rutrum. Quisque accumsan, sapien quis gravida convallis, tellus nibh dictum justo, eget convallis risus est quis augue. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut ante nisi, egestas a finibus at, pretium id arcu. Nunc mattis convallis leo id tempor.</p>
		</div>
		<?
	}
}