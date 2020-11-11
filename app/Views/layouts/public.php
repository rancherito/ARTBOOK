
<?php use Config\App;?>
<!DOCTYPE html>
<html lang="en">
<head>
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
			padding: 1rem;
			color: white;
		}
		.app-nav-left{
			display: flex;
			align-items: center;
			color: var(--primary)
		}
		.btn-nav-desktop{
			display: inline-block;
		}
		.btn-nav-movil{
			display: none !important;
		}
		@media (max-width: 600px) {
			.btn-nav-desktop{
				display: none;
			}
			.btn-nav-movil{
				display: block !important;
			}
		}
	</style>
</head>
<body>
	<div id="app-body">
		<div id="app-nav">
			<div class="app-nav-left">
				<img src="<?= base_url() ?>/images/icon.svg" alt="ARTSBOOK" height="30px">  <span class="pl-4">ARTSBOOK</span>
			</div>
			<div>
				<?php if (empty($_SESSION['access'])): ?>
					<a href="<?= base_url() ?>/login" class="btn-nav-desktop btn"> <i class="mdi mdi-account left mdi-18px"></i>ACCESO</a>
				<?php endif; ?>
				<?php if (!empty($_SESSION['access'])): ?>
					<a href="<?= base_url() ?>/administrador" class="btn-nav-desktop btn"> <i class="mdi mdi-book-minus left mdi-18px"></i>ADMINISTRAR</a>
					<a href="<?= base_url() ?>/close" class="btn-nav-desktop btn"> <i class="mdi mdi-power-standby mdi-18px"></i></a>
				<?php endif; ?>

				<a href="<?= base_url() ?>" class="btn btn-nav-desktop"> <i class="mdi mdi-home-outline mdi-18px"></i></a>
				<a class="btn-nav-movil dropdown-trigger btn" data-target='dropdown_menu_public'> <i class="mdi mdi-menu mdi-18px"></i></a>
				<ul id='dropdown_menu_public' class='btn-nav-movil dropdown-content'>
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
			<?= $body ?>
		</div>

	</div>
	<script type="text/javascript">
		let drop = $('.dropdown-trigger').dropdown({constrainWidth: false});
		window.addEventListener('resize', function (e) {
			if ($(window).width() < 600) {
				drop.dropdown('recalculateDimensions');
			}
		});
	</script>
</body>
</html>
