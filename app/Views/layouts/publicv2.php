<!DOCTYPE html>
<html lang="en">
<head>
	<?php include APPPATH.'Views/layouts_parts/header.php' ?>

	<link rel="stylesheet" href="<?= base_url() ?>/css/layouts/publicv2.css?v=<?= $_ENV['version'] ?>">
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
	<script src="<?= base_url() ?>/libs/vueadvancedcropper/cropper.js?v=<?= $_ENV['version'] ?>" ></script>
	<?= $body ?>
	<?php if (!empty($GLOBALS['style'])) echo $GLOBALS['style']; ?>
</head>
<body>
	<div id="app-body">
		<?php if (is_access()): ?>
			<upload-editor ref="upload_artwork" base_url="<?= base_url() ?>" author="<?= user_account() ?>"></upload-editor>
		<?php endif; ?>

		<aside :class="{'app-aside-nav-close': toggle_nav}">
			<div id="app-aside-nav-toggle" class="white primary" @click="toggle_nav = !toggle_nav"><i class="mdi mdi-text"></i></div>
			<div class="f-c w100">
				<a href="<?= base_url() ?>" id="app-aside-decorator" class="f-c"><img src="<?= base_url() ?>/images/icon_white.svg"></a>
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
	<?php if (!empty($GLOBALS['script'])) echo $GLOBALS['script']; ?>
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
				toggle_nav: false,
				base_url: '<?= base_url() ?>',
				current_account: '<?= user_account() ?>',
				is_mobile: <?= isMovil() ? 'true' : 'false' ?>,
				event_vs_register_user: [],
				event_vs_artwork_apply_user: {},
			}
		},
		methods: {
			load_event_vs_register_user (){
				$.get(this.base_url + '/service/events/apply_list', (res_list) => {
					this.event_vs_register_user = res_list;
				})
			},
			open_editor: function () {
				if (this.$refs.upload_artwork) {
					this.$refs.upload_artwork.open()
				}
			},
			trigger_like: function (info) {
				<?php if (is_access()): ?>
				info.heart = info.heart ? 0 : 1;
				$.post("<?= base_url() ?>/service/artwork/like_save", {artwork: info.accessname}, (d) => {
					if (d.state != undefined) {
						info.heart = d.state;
						if (info.heart_count != undefined) info.heart_count += d.state == 1 ? +1 : -1;
					}
				}).fail(function() {
					info.heart = info.heart ? 0 : 1;
					alert('INICIAR SESION PRIMERO');
				})
				<?php else: ?>
				alert('INICIAR SESION PRIMERO');
				<?php endif; ?>
			}
		},
		created(){
			this.load_event_vs_register_user();
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
