<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex">
	<link rel="icon" type="image/png" href="<?= base_url() ?>/images/icon.png">
	<title>Whoops!</title>

	<style type="text/css">
		<?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
	</style>
</head>
<body>

	<div class="container text-center">

		<h1 class="headline">Whoops!</h1>

		<p class="lead">Parece que tenemos un error con esta pagina, regrese más tarde :c</p>
		<a href="<?= base_url() ?>">Regresar al inicio</a>
	</div>

</body>

</html>
