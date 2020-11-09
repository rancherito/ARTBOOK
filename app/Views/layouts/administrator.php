
<?php use Config\App;?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include APPPATH.'Views/layouts_parts/header.php' ?>
	<style media="screen">
		:root{
			--width-aside: 80px;
		}
		#app-body{
			background: #141827;
			height: 100vh;
		}
		#app-nav{
			height: 64px;
			width: calc(100% - var(--width-aside));
			transform: translateX(var(--width-aside));
			background: white;
			padding: 0 1rem;
			color: white;
			display: flex;
			justify-content: space-between;
			align-items: center;
			font-size: 1.5rem;
		}
		#app-aside{
			width: var(--width-aside);
			position: fixed;
			height: 100vh;
			background-color: #131725;
			padding: 1rem 0;
			display: flex;
			justify-content: center;
			align-items: center;
			flex-direction: column;
		}
		#app-aside a{
			border-radius: 10px;
			background-color: rgba(255,255,255,.05);
			color: white;
			height: 60px;
			width: 60px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 2rem;
			transition: linear all .2s;
			cursor: pointer;
			margin-bottom: 2px;
		}
		#app-aside a:hover{
			background-color: var(--primary)
		}
		#app-content{
			transform: translateX(var(--width-aside));
			width: calc(100% - var(--width-aside));
			height: calc(100vh - 64px);
			overflow: hidden auto;
		}

	</style>
</head>
<body>
	<div id="app-body">
		<div id="app-aside">
		</div>
		<div id="app-nav">
			<div><span class="secondary">ART'S BOOK</span></div>
			<div>
				<?php if (!empty($_SESSION['access'])): ?>
					<a href="<?= base_url() ?>/close" class="btn bg-secondary"> <i class="mdi mdi-power-standby"></i></a>
				<?php endif; ?>

				<a href="<?= base_url() ?>" class="btn bg-secondary"> <i class="mdi mdi-home-outline"></i></a>
			</div>
		</div>
		<div id="app-content" class="white">
			<module></module>
		</div>
	</div>
	<?= $body ?>
	<script type="text/javascript">
		new Vue({
			el: '#app-body'
		})
	</script>
</body>
</html>
