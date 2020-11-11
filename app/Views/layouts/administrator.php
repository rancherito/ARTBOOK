
<?php use Config\App;?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include APPPATH.'Views/layouts_parts/header.php' ?>
	<style media="screen">
		:root{
			--width-aside: 60px;
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
			background-color: var(--primary);
			padding: 1rem 0;
			display: flex;
			justify-content: center;
			align-items: center;
			flex-direction: column;
			z-index: 3;
			transition: linear all .1s
		}
		#app-aside a{
			border-radius: 10px;
			background-color: rgba(255,255,255,.05);
			color: white;
			height: 50px;
			width: 50px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 2rem;
			transition: linear all .2s;
			cursor: pointer;
			margin-bottom: 2px;
		}
		#app-aside a:hover{
			background-color: rgba(255,255,255,.5);
		}
		#app-content{
			transform: translateX(var(--width-aside));
			width: calc(100% - var(--width-aside));
			height: calc(100vh - 64px);
			overflow: hidden auto;
		}
		#app-aside-toggle{
			position: absolute;
			top: 50%;
			transform: translateY(-50%);
			left: var(--width-aside);
			width: 50px;
			height: 50px;
			background: var(--primary);
			display: flex;
			justify-content: center;
			align-items: center;
			border-radius: 0 25px 25px 0;
			font-size: 1.5rem;
			color: white;
			box-shadow: inset 2px 0px 2px 0px #00000008;
			display: none;
			transition: linear all .1s
		}
		#app-aside-toggle i{
			transform: translateX(-10%);
			transition: linear all .1s
		}

	@media (max-width: 600px) {

		#app-aside-toggle{
			display: flex;
		}
		#app-nav, #app-content{
			width: 100%;
			transform: translateX(0);
		}
		#app-aside{
			transform: translateX(-100%);
			justify-content: flex-start;
		}
		#app-aside.app-aside-show{
			transform: translateX(0);
		}
		#app-aside.app-aside-show #app-aside-toggle{
			width: 35px;
		}
	}
	</style>
</head>
<body>
	<div id="app-body">
		<div id="app-aside" :class="{'app-aside-show' : show_aside}">
			<div id="app-aside-toggle" @click="show_aside = !show_aside">
				<i class="mdi mdi-menu" v-if="!show_aside"></i>
				<i class="mdi mdi-chevron-left" v-if="show_aside"></i>
			</div>
		</div>
		<div id="app-nav">
			<div></div>
			<div>
				<?php if (!empty($_SESSION['access'])): ?>
					<a href="<?= base_url() ?>/close" class="btn"> <i class="mdi-18px mdi mdi-power-standby"></i></a>
				<?php endif; ?>

				<a href="<?= base_url() ?>" class="btn"> <i class="mdi-18px mdi mdi-home-outline"></i></a>
			</div>
		</div>
		<div id="app-content" class="white">
			<module></module>
		</div>
	</div>
	<?= $body ?>
	<script type="text/javascript">
		new Vue({
			el: '#app-body',
			data: {
				show_aside: false
			}
		})
	</script>
</body>
</html>
