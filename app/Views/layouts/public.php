
<?php
	use Config\App;
	$pre_metas = [
		'img' => base_url()."/images/meta.png",
		'title' => 'ARTS BOOK SITEWEB',
		'description' => 'Se bienvenid@ a nuestra comunidad de artistas y dibujantes Art\'s Book 😁'
	];

	$metas = array_merge($pre_metas, gettype($metas) == 'NULL' ? [] : $metas);


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

	<style media="screen">

		#app-body{
			height: 100vh;
		}
		#app-nav{
			padding: 1rem 0;
			color: white;
			display: flex;
			justify-content: space-between;
			align-items: center;
			font-size: 1.5rem;
			position: fixed;
			top: 50%;
			transform: translateY(-50%);
			right: 32px;
			width: 54px;
			background: white;
			z-index: 1;
			box-shadow: 0 0 5px 2px #0000000a;
			flex-direction: column;
			border-radius: 40px;
			background-color: var(--primary);
		}
		#app-nav-access a{
			color: white;
			display: flex;
			padding: .5rem;
			margin-top: 2px;
			border-radius: 20px;
			transition: linear all .2s;
			align-items: center;
			justify-content: center;
		}
		#app-nav-access a:hover{
			background: #ffffff33;
			padding: 1rem .5rem;
		}
		#app-nav-access a:hover i{
			transform: scale(1.1);
		}
		#app-content{
			height: 100%;
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
			#app-nav{
				right: 16px;
			}
		}

	  .fil0 {fill: white}
	</style>
</head>
<body>
	<div id="app-body">
		<div id="app-nav">
			<div id="app-nav-left">
				<a href="<?= base_url() ?>" class="pb-4">
					<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="30" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
					viewBox="0 0 1497.42 1664.17">
					 <g>
					  <metadata id="CorelCorpID_0Corel-Layer"/>
					  <path class="fil0" d="M851.6 228.49c-12.95,-50.94 -54.68,-166.33 -82.47,-217.69 -11.8,-10.23 -27.48,-16.82 -38.98,-2.71 -26.47,48.07 -67.46,159.93 -82.87,214.24 -0.44,2.19 -0.8,4.24 -1.06,6.16l205.38 0zm54.74 1142.06l-3.64 -686.14 -0.57 -107.9 0 -0.03 -0.2 -37.81c8.49,-7.46 16.95,-14.47 25.4,-21.09 1.85,-1.72 3.8,-3.38 5.85,-4.97 136.29,-105.97 308.15,-156.43 480.1,-163.02 22.65,-0.87 42.46,6.67 58.8,22.38 16.34,15.71 24.66,35.21 24.69,57.88l0.66 607.19c0.05,43.28 -34.19,78.84 -77.44,80.43 -139.07,5.12 -277.08,44.11 -385.66,126.46 -2.45,1.86 -4.96,3.56 -7.53,5.11 -38.8,30.55 -73.67,66.81 -103.24,109.23 -5.82,8.92 -11.52,17.97 -17.13,27.17l0 121.35c0,86.58 -70.83,157.41 -157.41,157.41 -86.58,0 -157.42,-70.83 -157.42,-157.41l0 -64.21 0 -54c0.16,-3.52 0.32,-7.08 0.48,-10.69 6.33,80.89 74.49,145.11 156.93,145.11 67.47,0 125.38,-43.01 147.65,-102.97 5.76,-15.5 9.14,-32.13 9.68,-49.46zm-315.33 14.87l3.72 -701.02 0.57 -107.9 0 -0.03 0.2 -37.81c-8.77,-7.7 -17.5,-14.96 -26.22,-21.84 -1.6,-1.45 -3.28,-2.85 -5.03,-4.22 -136.29,-105.97 -308.15,-156.43 -480.09,-163.02 -22.65,-0.87 -42.46,6.67 -58.8,22.38 -16.34,15.71 -24.66,35.21 -24.69,57.88l-0.66 607.19c-0.05,43.28 34.19,78.84 77.44,80.43 139.07,5.12 277.08,44.11 385.66,126.46 2.45,1.86 4.96,3.56 7.53,5.11 37.75,29.72 71.77,64.84 100.83,105.79 6.71,10.05 13.23,20.25 19.55,30.61zm-354.54 -856.04c73.74,17.82 144.19,46.92 207.25,90.79 0.71,0.49 8.08,5.67 8.08,5.74l0 304.47 0 120.99c-33.57,-17.08 -68.11,-31.57 -103.42,-43.68 -0.99,-0.49 -1.91,-0.88 -2.77,-1.17 -44.17,-14.96 -89.53,-26.17 -135.64,-33.95 -39.01,-6.59 -67.01,-39.71 -67.01,-79.28l0 -284.57c0,-25.62 10.76,-47.66 30.97,-63.41 18.43,-14.37 40.04,-19.85 62.55,-15.94zm1024.49 0c-73.73,17.82 -144.18,46.92 -207.25,90.79 -0.71,0.49 -8.08,5.67 -8.08,5.74l0 304.47 0 120.99c33.67,-17.14 68.35,-31.68 103.78,-43.8 0.85,-0.44 1.66,-0.79 2.4,-1.05 44.17,-14.96 89.53,-26.17 135.64,-33.95 39.01,-6.59 67.01,-39.71 67.01,-79.28l0 -284.57c0,-25.62 -10.76,-47.66 -30.96,-63.41 -18.43,-14.37 -40.04,-19.85 -62.55,-15.94zm-512.24 79.92l0 0c-15.98,0 -29.04,13.07 -29.04,29.04l0 755.07c0,15.98 13.07,29.04 29.04,29.04l0 0c15.97,0 29.04,-13.07 29.04,-29.04l0 -755.07c0,-15.97 -13.07,-29.04 -29.04,-29.04zm156.66 -207.34c132.95,-109.63 244.74,-176.63 365.35,-216.83 43.82,-7.65 78.46,28.6 78.96,58.69l0.78 46.41c-160.15,33.37 -329.9,113.78 -445.78,225.45l0.68 -113.72zm-29.34 -110.01c34.62,-48.22 162.4,-178.3 204.79,-192.67 41.7,-14.13 60.48,18.94 61.5,42.39l1.27 29.17c-95.77,58.03 -159.95,105.69 -248.13,173.32l-19.43 -52.2zm-283.99 110.01c-132.95,-109.63 -244.74,-176.63 -365.35,-216.83 -43.82,-7.65 -78.46,28.6 -78.96,58.69l-0.78 46.41c160.15,33.37 329.9,113.78 445.78,225.45l-0.68 -113.72zm29.34 -110.01c-34.62,-48.22 -162.4,-178.3 -204.79,-192.67 -41.69,-14.13 -60.48,18.94 -61.5,42.39l-1.28 29.17c95.77,58.03 159.95,105.69 248.14,173.32l19.43 -52.2z"/>
					 </g>
					</svg>
				</a>
			</div>
			<div id="app-nav-access">
				<?php if (isset($_SESSION['access']) && base_url().$_SERVER['REQUEST_URI'] != $_SESSION['access']['account_site']):?>
					<a href="<?= $_SESSION['access']['account_site'] ?>"> <i class="mdi mdi-account mdi-24px"></i></a>
				<?php endif; ?>
				   <?php foreach ($links as $key => $link): ?>
	   			<a href="<?= $link['url'] ?>">
					<i class="mdi-24px <?= $link['classicon'] ?>"></i>
				</a>
			   <?php endforeach; ?>

			</div>
		</div>
		<div id="app-content" ref="content">
			<module></module>
		</div>

	</div>
	<?= $body ?>

	<script type="text/javascript">

		new Vue({
			el: '#app-body',
			mounted: function () {
				console.log();
				this.$refs.content.addEventListener('scroll', e => {
					//console.log(this.$refs.content.scrollTop);
				})
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
