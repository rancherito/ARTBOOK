<?php
?>
<?php
	$pre_metas = [
		'img' => base_url()."/images/meta.png",
		'title' => 'ARTS BOOK - Comunidad de artistas',
		'description' => 'Somos una comunidad de artistas y dibujantes hispanohablantes. Ven, descubre y comparte trabajos artísticos en tradicional o digital, además de otras muchas cosas más.'
	];

	$metas = array_merge($pre_metas, empty($metas) ? [] : $metas);

 ?>
<meta name="description" content="<?= $metas['description'] ?>" />

<!-- Twitter Card data -->
<meta name="twitter:card" value="summary">

<!-- Open Graph data -->
<meta http-equiv="Content-Language" content="es"/>
<meta property="og:title" content="<?= $metas['title'] ?>" />
<meta property="og:type" content="article" />
<meta property="og:url" content="<?= base_url() ?>" />
<meta property="og:image" content="<?= $metas['img'] ?>" />
<meta property="og:description" content="<?= $metas['description'] ?>" />
<title><?= $metas['title'] ?></title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="icon" type="image/png" href="<?= base_url() ?>/images/icon.png">
<link rel="stylesheet" href="<?= base_url() ?>/font/RobotoCondensed/RobotoCondensed.css">

<link rel="stylesheet" href="<?= base_url() ?>/libs/materialize/css/materialize.min.css">
<link rel="stylesheet" href="<?= base_url() ?>/css/helpers.css?v=<?= $_ENV['version'] ?>">

<link rel="stylesheet" href="<?= base_url() ?>/css/custom_materialize.css?v=<?= $_ENV['version'] ?>">
<script src="<?= base_url() ?>/js/script.js?v=<?= $_ENV['version'] ?>"></script>
<script src="<?= base_url() ?>/js/jquery-3.4.1.min.js"></script>


<link rel="stylesheet" href="<?= base_url() ?>/libs/cgVue/cg.components.vue.css?v=<?= $_ENV['version'] ?>">
<link rel="stylesheet" href="<?= base_url() ?>/css/main.css?v=<?= $_ENV['version'] ?>">
<link rel="stylesheet" href="<?= base_url() ?>/css/colors.css?v=<?= $_ENV['version'] ?>">
<link rel="stylesheet" href="<?= base_url() ?>/css/components.vue.css?v=<?= $_ENV['version'] ?>">
<link rel="stylesheet" href="<?= base_url() ?>/libs/simplebar/simplebar.css">

<link rel="stylesheet" href="<?= base_url() ?>/libs/animate/animate.min.css">
<link rel="stylesheet" href="<?= base_url() ?>/font/mdi/css/materialdesignicons.min.css">
<script src="<?= base_url() ?>/libs/materialize/js/materialize.min.js"></script>
<script src="<?= base_url() ?>/libs/vue/vue<?= $_ENV['CI_ENVIRONMENT'] != 'development' ? '.min' : '' ?>.js"></script>
<script src="<?= base_url() ?>/libs/cgVue/cg.components.vue.js?v=<?= $_ENV['version'] ?>"></script>
<script src="<?= base_url() ?>/libs/simplebar/simplebar.min.js"></script>
<script src="<?= base_url() ?>/js/components.vue.js?v=<?= $_ENV['version'] ?>"></script>
<script src="<?= base_url() ?>/libs/simplebar/simplebar.vue.js"></script>
<script src="<?= base_url() ?>/libs/hammer/hammer.min.js"></script>

<!--<script data-ad-client="ca-pub-1355252812560688" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>-->
