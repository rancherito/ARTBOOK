<!DOCTYPE html>
<html lang="en">
<head>
	<?php include APPPATH.'Views/layouts_parts/header.php' ?>
	<script src="<?= base_url() ?>/libs/vueadvancedcropper/cropper.js?v=3" ></script>
	<link rel="stylesheet" href="<?= base_url() ?>/css/layouts/publicv2.css?v=<?= $version ?>">
	<style media="screen">
	.sticky {
		position: -webkit-sticky;
		position: sticky;
		top: 0;
		}
		.sticky:before,
		.sticky:after {
		content: '';
		display: table;
	}
	</style>
	<?= $body ?>
	<?php if (!empty($GLOBALS['style'])) echo $GLOBALS['style']; ?>
</head>
<body>
	<div id="app-body">
		<?php if (is_access()): ?>
			<upload-editor ref="upload_artwork" base_url="<?= base_url() ?>" author="<?= user_account() ?>"></upload-editor>
		<?php endif; ?>

		<aside :class="{'app-aside-nav-close': toggle_nav}">
			<div id="app-aside-nav-toggle" class="bg-primary" @click="toggle_nav = !toggle_nav"><i class="mdi mdi-menu"></i></div>
			<div class="f-c w100">
				<a href="<?= base_url() ?>" id="app-aside-decorator" class="f-c"><img src="<?= base_url() ?>/images/icon_white.svg"></a>
			</div>
			<div class="w100 f-c">

				<?php if (is_access()): ?>
					<a href="<?= user_site() ?>" class="access-btn"><i class="mdi mdi-account"></i> <span>MI PERFIL</span></a>
					<a @click="open_editor" class="access-btn"><i class="mdi mdi-upload"></i> <span>SUBIR ARTWORK</span></a>
					<?php if ($_SESSION['access']['accesstype'] == 'ADMINISTRADOR'): ?>
						<a href="<?= base_url().'/c/events' ?>" class="access-btn"><i class="mdi mdi-account-box"></i> <span>ADMINISTRAR</span></a>
					<?php endif; ?>
				<?php else: ?>
					<a href="<?= base_url() ?>/user/login" class="access-btn"><i class="mdi mdi-account"></i> <span>ACCEDER</span></a>
				<?php endif; ?>
			</div>
			<div class="w100 f-c">
				<a href="<?= base_url() ?>" class="f-c access-btn-bottom"><i class="mdi mdi-home"></i></a>
				<?php if (is_access()): ?>
					<a href="<?= base_url() ?>/user/close" class="f-c access-btn-bottom"><i class="mdi mdi-power-standby"></i></a>
				<?php endif; ?>
			</div>
		</aside>
		<section id="app-module">
				<?php if (is_access()): ?>
					<a id="app-user-card" href="<?= user_site() ?>">
						<?php if (has_user_avatar()): ?>
							<i class="cover" style="background-image: url('<?= user_avatar() ?>')"></i>
						<?php else: ?>
							<i class="f-c"> <?= user_nickname()[0] ?> </i>
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
	<script type="text/javascript">
	Vue.component('adsense-ins',{
		template: `<ins></ins>`,
		mounted: function () {
			(adsbygoogle = window.adsbygoogle || []).push({})
		}
	})
	new Vue({
		el: '#app-body',
		data: function () {
			return {
				toggle_nav: false
			}
		},
		methods: {
			open_editor: function () {
				if (this.$refs.upload_artwork) {
					this.$refs.upload_artwork.open()
				}
			},
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
