
<?php
use Config\App;
$pre_metas = [
	'img' => base_url()."/images/meta.png",
	'title' => 'ARTS BOOK SITEWEB',
	'description' => 'Se bienvenid@ a nuestra comunidad de artistas y dibujantes Art\'s Book 😁'
];

$metas = array_merge($pre_metas, empty($metas) ? [] : $metas);


$links = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="description" content="<?= $metas['description'] ?>" />

	<!-- Twitter Card data -->
	<meta name="twitter:card" value="summary">

	<!-- Open Graph data -->
	<meta property="og:title" content="<?= $metas['title'] ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="<?= base_url() ?>" />
	<meta property="og:image" content="<?= $metas['img'] ?>" />
	<meta property="og:description" content="<?= $metas['description'] ?>" />
	<?php include APPPATH.'Views/layouts_parts/header.php' ?>
</head>
<body>
	<div id="app-body">
		<module></module>
	</div>
	<?= $body ?>
	<?php include APPPATH.'Views/layouts_parts/footer.php' ?>
	<?php if (!empty($GLOBALS['script'])) echo $GLOBALS['script']; ?>
	<script type="text/javascript">

	new Vue({
		el: '#app-body',
		mounted: function () {
			(adsbygoogle = window.adsbygoogle || []).push({});

			$('.fixed-action-btn').floatingActionButton();
			let drop = $('.dropdown-trigger').dropdown({constrainWidth: false});
			window.addEventListener('resize', function (e) {
				drop.dropdown('close');

			});
		},
		components: {
			module: $_module
		}
	})
</script>

</body>
</html>
