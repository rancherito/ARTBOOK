
<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<?php include APPPATH.'Views/layouts_parts/header.php' ?>
	<link rel="stylesheet" href="<?= base_url() ?>/css/layouts/controll.css">
	<?= $body ?>
	<?php if (!empty($GLOBALS['style'])) echo $GLOBALS['style']; ?>
</head>
<body>

	<div id="app-body">



		<aside :class="{'app-aside-nav-close': toggle_nav}">
			<div id="app-aside-nav-toggle" class="bg-primary" @click="toggle_nav = !toggle_nav"><i class="mdi mdi-menu"></i></div>
			<div class="f-c w100">
				<a href="<?= base_url() ?>" id="app-aside-decorator" class="f-c"><img src="<?= base_url() ?>/images/icon_white.svg"></a>
			</div>
			<div class="w100 f-c">
				<?php if (is_access()): ?>
					<a href="<?= base_url() ?>/c/users" class="access-btn"><i class="mdi mdi-camera-account"></i> <span>Control de usuarios</span></a>
					<a href="<?= base_url() ?>/c/artworks" class="access-btn"><i class="mdi mdi-image-frame"></i> <span>Control de artworks</span></a>
					<a href="<?= base_url() ?>/c/events" class="access-btn"><i class="mdi mdi-calendar-star"></i> <span>Control de eventos</span></a>
					<a href="<?= base_url() ?>/c/versus/results" class="access-btn"><i class="mdi mdi-fire"></i> <span>Resultado de versus</span></a>
				<?php endif; ?>
			</div>
			<div class="w100 f-c">
				<?php if (is_access()): ?>
					<a href="<?= user_site() ?>" class="f-c access-btn-bottom"><i class="mdi mdi-account"></i></a>
				<?php else: ?>
					<a href="<?= base_url() ?>/user/login" class="f-c access-btn-bottom"><i class="mdi mdi-account"></i></a>
				<?php endif; ?>
				<a href="<?= base_url() ?>" class="f-c access-btn-bottom"><i class="mdi mdi-home"></i></a>
			</div>
		</aside>
		<section id="app-module">

			<?php if (is_access()): ?>
				<a id="app-user-card" href="<?= user_site() ?>">
					<?php if (has_user_avatar()): ?>
						<i class="cover" style="background-image: url('<?= user_avatar() ?>')"></i>
					<?php else: ?>
						<i class="f-c"> <?= user_account()[0] ?> </i>
					<?php endif; ?>
					<span><?= user_nickname() ?></span>
				</a>
			<?php else: ?>
				<a id="app-user-card" href="<?= base_url() ?>/user/login">
					<i class="mdi mdi-account"></i>
					<span>LOGIN</span>
				</a>
			<?php endif; ?>

			<module inline-template>
				<?php if (empty($GLOBALS['module'])): ?>
					<div>
						MODULO CARGADO INCORRECTAMENTE
					</div>
				<?php else: ?>
					<?= $GLOBALS['module'] ?>
				<?php endif; ?>
			</module>

		</section>

	</div>

	<?php include APPPATH.'Views/layouts_parts/footer.php' ?>
	<?php if (!empty($GLOBALS['script'])) echo $GLOBALS['script']; ?>
	<script type="text/javascript">

	new Vue({
		el: '#app-body',
		data: function () {
			return {
				toggle_nav: false
			}
		},
		methods: {
			open_editor: function () {

			}
		},
		mounted: function () {


		},
		components: {
			module: $_module
		}
	})
</script>

</body>
</html>
