<style media="screen">
#user_header{
	height: 100%;
	background: black;
	position: relative;
	overflow: hidden;
}
#user_header_bg{
	position: 	absolute;
	left: 0;
	top: 0;
	height: 100%;
	width: 100%;

}
#user_header_bg::before{
	content: '';
	position: 	absolute;
	left: 0;
	top: 0;
	height: 100%;
	width: 100%;
	background-repeat: no-repeat;
	background-size: cover;
	background-position: center;
	background-attachment: fixed;
	background-image: url('<?= base_url() ?>/images/bg_003.jpg');
}
#user_header_bg::after{
	position: absolute;
	content: '';
	left: 0;
	top: 0;
	height: 100%;
	width: 100%;
	background-color: black;
	opacity: .6;
}
#user_header_bg_content{
	height: 100%;
	position: relative;
	padding: 1rem;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	color: white;
	backdrop-filter: blur(10px);
	-webkit-backdrop-filter: blur(10px);
}
.user-foto{
	background: #ffffff55;
	height: 140px;
	width: 140px;
	border-radius: 50%;
	display: flex;
	justify-content: center;
	align-items: center;
	font-size: 4rem;
	font-family: Calibri;
}
#user_header_bg_content p{
	max-width: 360px;
	text-align: center;
}
</style>
<?php template_start() ?>
	<div id="user_header">
		<div id="user_header_bg"></div>
		<div id="user_header_bg_content">
			<div class="user-foto"><?= $info['account'][0] ?></div>
			<h5><?= $info['account'] ?></h5>
			<p>
				<?php if (!empty($_SESSION['access']) && $_SESSION['access']['account'] == $info['account']): ?>
					Parece ser que su cuenta no a sido verificada aun.<br>
					Revise el mensaje de validacion que hemos enviado al siguiente correo.
					<h5 class="secondary"><?= $info['email'] ?></h5>
				<?php else: ?>
					Este artista aún no a publicado ningun trabajo, vuelva en otra ocación :D
				<?php endif; ?>



			</p>
		</div>
	</div>
<?php $template = template_end() ?>
<script>
	$_module = {
		template: `<?= $template ?>`
	}
</script>
