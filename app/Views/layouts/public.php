
<?php use Config\App;?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include APPPATH.'Views/layouts_parts/header.php' ?>
	<meta name="description" content="Descripcion de pagina. No sueperar los 155 caracteres." />

	<!-- Twitter Card data -->
	<meta name="twitter:card" value="summary">

	<!-- Open Graph data -->
	
	<meta property="og:type" content="article" />
	<meta property="og:url" content="<?= base_url() ?>" />

	<meta property="og:description" content="Se bienvenid@ a nuestra comunidad de artistas y dibujantes Art's Book 😁" />
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
				    <li><a><i class="mdi mdi-home-outline  mdi-18px"></i>Inicio</a></li>
					<?php if (empty($_SESSION['access'])): ?>
				    	<li><a href="<?= base_url() ?>/login"><i class="mdi mdi-account mdi-18px"></i>ACCESO</a></li>
					<?php endif; ?>
					<?php if (!empty($_SESSION['access'])): ?>
						<li><a href="<?= base_url() ?>/administrador"><i class="mdi mdi-book-minus mdi-18px"></i>ADMINISTRAR</a></li>
						<li><a href="<?= base_url() ?>/close"><i class="mdi mdi-power-standby mdi-18px"></i>CERRAR SESION</a></li>
					<?php endif; ?>
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
