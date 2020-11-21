
<?php
	use Config\App;
	$pre_metas = [
		'img' => base_url()."/images/meta.png",
		'title' => 'ARTS BOOK SITEWEB',
		'description' => 'Se bienvenid@ a nuestra comunidad de artistas y dibujantes Art\'s Book 😁'
	];

	$metas = array_merge($pre_metas, gettype($metas) == 'NULL' ? [] : $metas);


	$links = [['classicon' => 'mdi mdi-home-outline', 'text' => 'Inicio', 'url' => base_url()]];

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

	<style media="screen">

		#app-body{
			height: 100vh;
		}
		#app-nav{
			height: 64px;
			padding: 0 1rem;
			color: white;
			display: flex;
			justify-content: space-between;
			align-items: center;
			font-size: 1.5rem;
		}
		#app-content{
			height: calc(100% - 64px);
			overflow-x: hidden;
			overflow-y: auto;
		}
		#app-nav-left{
			display: flex;
			align-items: center;
			color: var(--primary)
		}
		#app-nav-left a{
			color: var(--primary);
			display: flex;
		}
		@media (max-width: 600px) {

		}
	</style>
</head>
<body>
	<div id="app-body">
		<div id="app-nav">
			<div id="app-nav-left">
				<a href="<?= base_url() ?>"><img src="<?= base_url() ?>/images/icon.svg" alt="ARTSBOOK" height="30px">  <span class="pl-4">ARTSBOOK</span></a>
			</div>
			<div id="app-nav-access">
				<?php if (isset($_SESSION['access']) && base_url().$_SERVER['REQUEST_URI'] != $_SESSION['access']['account_site']):?>
					<a class="btn" href="<?= $_SESSION['access']['account_site'] ?>"> <i class="mdi mdi-account mdi-18px"></i></a>
				<?php endif; ?>
				<a class="btn-nav-movil dropdown-trigger btn" data-target='dropdown_menu_public'> <i class="mdi mdi-menu mdi-18px"></i></a>
				<ul id='dropdown_menu_public' class=' dropdown-content'>
				   <?php foreach ($links as $key => $link): ?>
				   		<li>
				   			<a href="<?= $link['url'] ?>">
								<i class="mdi-18px <?= $link['classicon'] ?>"></i>
								<?= $link['text'] ?>
							</a>
				   		</li>
				   <?php endforeach; ?>
				</ul>
			</div>
		</div>
		<div id="app-content">
			<module></module>
		</div>

	</div>
	<?= $body ?>

	<script type="text/javascript">

		new Vue({
			el: '#app-body',
			mounted: function () {
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
