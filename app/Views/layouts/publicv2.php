
<?php
use Config\App;
$pre_metas = [
	'img' => base_url()."/images/meta.png",
	'title' => 'ARTS BOOK',
	'description' => 'Se bienvenid@ a nuestra comunidad de artistas y dibujantes Art\'s Book 😁'
];

$metas = array_merge($pre_metas, empty($metas) ? [] : $metas);


$links = [];

if (empty($_SESSION['access']))
$links[] = ['classicon' => 'mdi mdi-account', 'text' => 'ACCESO', 'url' => base_url().'/user/login'];

if (isset($_SESSION['access']) && $_SESSION['access']['accesstype'] == 'ADMINISTRADOR')
$links[] = ['classicon' => 'mdi mdi-book-minus', 'text' => 'ADMINISTRAR', 'url' => base_url().'/administrador'];
if (!empty($_SESSION['access']))
$links[] = ['classicon' => 'mdi mdi-power-standby', 'text' => 'CERRAR SESION', 'url' => base_url().'/user/close'];
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
	<script src="<?= base_url() ?>/libs/vueadvancedcropper/cropper.js?v=3" ></script>
	<style media="screen">
	:root{
		--navaside_width: 80px;
	}
	#app-body{
		background-color: var(--primary);
	}
	#app-user-card{
		position: absolute;
		top: 1rem;
		right: 1rem;
		background-color: white;
		border-radius: 20px;
		height: 36px;
		display: flex;
		flex-direction: row-reverse;
		align-items: center;
		z-index: 4;
		color: gray;
		padding: 0 2px;
	}
	#app-user-card i{
		background-color: var(--primary);
		color: white;
		height: 34px;
		width: 34px;
		display: flex;
		align-items: center;
		justify-content: center;
		border-radius: 50%;
		font-style: normal;
		text-transform: capitalize;
		font-size: 1.5rem;
		font-family: Calibri;
	}
	#app-user-card span{
		padding: 1rem;
	}
	aside{
		width: var(--navaside_width);
		position: fixed;
		top: 0;
		bottom: 0;
		background-color: var(--primary);
		color: white;
		padding: 1rem 0;
		display: flex;
		justify-content: space-between;
		flex-direction: column;
		transition: linear all .1s
	}
	#app-module{
		position: fixed;
		top: 0;
		left: var(--navaside_width);
		background-color: var(--primary);
		right: 0;
		bottom: 0;
		padding: 1rem;
		padding-left: 0;
	}
	#app-module-content{
		position: relative;
		height: 100%;
		width: 100%;
		background: #f9f9f9;
		border-radius: 10px;
		overflow-y: auto;
		overflow-x: hidden;
	}
	.access-btn {
		display: flex;
		color: white;
		align-items: center;
		justify-content: center;
		flex-direction: column;
		cursor: pointer;
		transition: linear all .2s;
		height: 90px;
		width: 100%;
	}
	.access-btn:hover {
		background: rgba(255, 255, 255, 0.1);
	}
	.access-btn i {
		font-size: 1.8rem;
	}
	.access-btn span {
		font-size: .8rem;
		line-height: .8rem;
		text-align: center;
		margin-top: -4px;
		display: block;
		padding: 0 .5rem;
		padding-bottom: 8px;
	}
	#app-aside-decorator {
		height: 160px;
	}
	#app-aside-decorator img {
		width: 50%;
	}
	#app-aside-nav-toggle {
		position: absolute;
		right: 0;
		top: 50%;
		transform: translate(calc(100% - 1px), -50%);
		z-index: 1;
		height: 50px;
		width: 40px;
		align-items: center;
		justify-content: center;
		border-radius: 0 30px 30px 0;
		cursor: pointer;
		display: none;
	}
	@media (max-width: 600px){
		#app-user-card{
			top: 1rem;
			right: 1rem;
		}

		aside {
			z-index: 2;
			transform: translateX(-100%);
			width: 60px;
		}
		.access-btn{
			height: 80px;
		}
		#app-module{
			padding: 0;
			left: 0;
		}
		#app-aside-decorator{
			height: 120px;
		}
		#app-module-content{
			border-radius: 0;
		}
		#app-aside-nav-toggle {
			display: flex;
		}
		#app-aside-nav-toggle i {
			transform: translateX(-10%);
			font-size: 1.6rem;
		}
		aside.app-aside-nav-close{
			transform: translateX(0);
		}
	}
	.vue-simple-handler{
		border-radius: 50%;
	}

	</style>
</head>
<body>
	<div id="app-body">
		<?php if (is_access()): ?>
			<upload-editor ref="upload_artwork" base_url="<?= base_url() ?>" author="<?= user_account() ?>"></upload-editor>
		<?php endif; ?>


		<aside :class="{'app-aside-nav-close': toggle_nav}">
			<div id="app-aside-nav-toggle" class="bg-primary" @click="toggle_nav = !toggle_nav"><i class="mdi mdi-menu"></i></div>
			<div class="f-c w100">
				<div id="app-aside-decorator" class="f-c"><img src="<?= base_url() ?>/images/icon_white.svg"></div>
				<a href="<?= base_url() ?>" class="access-btn"><i class="mdi mdi-home"></i> <span>INICIO</span></a>
				<?php if (is_access()): ?>
					<a href="<?= user_site() ?>" class="access-btn"><i class="mdi mdi-account"></i> <span>MI PERFIL</span></a>
					<a @click="open_editor" class="access-btn"><i class="mdi mdi-upload"></i> <span>SUBIR ARTWORK</span></a>
				<?php else: ?>
					<a href="<?= base_url() ?>/user/login" class="access-btn"><i class="mdi mdi-account"></i> <span>ACCEDER</span></a>
				<?php endif; ?>
			</div>
			<div class="w100">
				<?php if (is_access()): ?>
					<a href="<?= base_url() ?>/user/close" class="access-btn"><i class="mdi mdi-power-standby"></i></a>
				<?php endif; ?>
			</div>
		</aside>
		<section id="app-module">

			<div id="app-module-content">
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
					<module></module>

			</div>
		</section>

	</div>
	<?= $body ?>

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
				if (this.$refs.upload_artwork) {
					this.$refs.upload_artwork.open()
				}
			}
		},
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
