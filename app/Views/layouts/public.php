
<?php
use Config\App;



$links = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<?php include APPPATH.'Views/layouts_parts/header.php' ?>

	<link rel="stylesheet" href="<?= base_url() ?>/css/layouts/public.css?v=<?= $_ENV['version'] ?>">
	<?= $body ?>
	<?php if (!empty($GLOBALS['style'])) echo $GLOBALS['style']; ?>
</head>
<body>
	<div id="app-body">
		<div id="app-content" ref="content">
			<module inline-template>
				<?php if (empty($GLOBALS['module'])): ?>
					<div>
						MODULO CARGADO INCORRECTAMENTE
					</div>
				<?php else: ?>
					<?= $GLOBALS['module'] ?>
				<?php endif; ?>
			</module>
		</div>

	</div>
	<?php include APPPATH.'Views/layouts_parts/footer.php' ?>
	<?php if (!empty($GLOBALS['script'])) echo $GLOBALS['script']; ?>
	<script type="text/javascript">

	new Vue({
		el: '#app-body',
		methods: {
			trigger_like: function (info) {
				<?php if (is_access()): ?>
					info.heart = info.heart ? 0 : 1;
					$.post("<?= base_url() ?>/service/artwork/like_save", {artwork: info.accessname}, (d) => {
						if (d.state != undefined) info.heart = d.state
					}).fail(function() {
						info.heart = info.heart ? 0 : 1;
						alert('INICIAR SESION PRIMERO');
					})
				<?php else: ?>
					alert('INICIAR SESION PRIMERO');
				<?php endif; ?>
			}
		},
		mounted: function () {
			(adsbygoogle = window.adsbygoogle || []).push({});
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
