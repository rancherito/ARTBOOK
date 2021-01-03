<?php $_SESSION['redirect_access'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>
<style>
	#app-pre-voting-main{
		height: 300px;
		width: 100%;
		max-width: 300px;
		position: relative;
	}
	#app-pre-voting-info{
		position: relative;
	}
	#app-pre-voting-deco{
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	#app-pre-voting-deco > * {
		position: absolute;
		border-radius: 50%;
		transform: translate(-999%, -999%) scale(1);
	}
	#app-pre-voting-deco .deco-1{
		transform: translate(-90%, 20%) scale(.6) rotate(30deg);
	}
	#app-pre-voting-deco .deco-2{
		transform: translate(-90%, -100%) scale(.3) rotate(10deg);
	}
	#app-pre-voting-deco .deco-3{
		transform: translate(-10%, -60%) scale(.2) rotate(-10deg);
	}
	#app-pre-voting-deco .deco-4{
		transform: translate(0%, -130%) scale(.5) rotate(-30deg);
	}
	#app-pre-voting-deco .deco-5{
		transform: translate(80%, -00%) scale(.3) rotate(20deg);
	}
	#app-pre-voting-deco .deco-6{
		transform: translate(-180%, -120%) scale(.2) rotate(45deg);
	}
	#app-pre-voting-deco .deco-7{
		transform: translate(-240%, 10%) scale(.8) rotate(-45deg);
	}
	#app-pre-voting-deco .deco-8{
		transform: translate(120%, -160%) scale(.1) rotate(180deg);
	}

</style>
<?php template_start() ?>
	<div id="app-pre-voting" class="f-c fixed-full">
		<section id="app-pre-voting-main" class="f-c c">
			<div id="app-pre-voting-deco">
				<?php foreach ($participients as $key => $artwork): ?>
					<img class="deco-<?= ($key + 1) ?>" src="<?= base_url() ?>/images/artworks_lite/<?= $artwork['accessname'] ?>.jpg"></img>
				<?php endforeach; ?>

			</div>
			<div id="app-pre-voting-info">
				<img src="<?= base_url() ?>/images/logo_primary.svg" alt="">
				<div class="py-4" >PARA PODER PARTICIPAR DE LAS VOTACIONES EN NECESARIO INICIAR SESION</div>
				<a class="btn-flat" href="<?= base_url() ?>/user/login?fromurl=<?= base64_encode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]")?>">ACCEDER</a>
			</div>

		</section>

	</div>
<?php $template = template_end()  ?>
<script type="text/javascript">
	$_module = {
		template: `<?= $template ?>`
	}
</script>
