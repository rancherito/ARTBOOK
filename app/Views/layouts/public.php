
<?php use Config\App;?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include APPPATH.'Views/layouts_parts/header.php' ?>
	<style media="screen">

		#app-body{
			background: #141827;
			height: 100vh;
		}
		#app-nav{
			background: #00000040;
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
	</style>
</head>
<body>
	<div id="app-body">
		<div id="app-nav">
			<div><span class="primary">A</span><span>RT'S BOOK</span></div>
			<div>
				<?php if (empty($_SESSION['access'])): ?>
					<a href="<?= base_url() ?>/login" class="btn"> <i class="mdi mdi-account left"></i>ACCESO</a>
				<?php endif; ?>
				<?php if (!empty($_SESSION['access'])): ?>
					<a href="<?= base_url() ?>/administrator" class="btn"> <i class="mdi mdi-book-minus left"></i>ADMINISTRAR</a>
					<a href="<?= base_url() ?>/close" class="btn"> <i class="mdi mdi-power-standby"></i></a>
				<?php endif; ?>

				<a href="<?= base_url() ?>" class="btn"> <i class="mdi mdi-home-outline"></i></a>
			</div>
		</div>
		<div id="app-content">
			<?= $body ?>
		</div>

	</div>
</body>
</html>
