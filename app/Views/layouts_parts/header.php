<?php $version = 'beta_0.084' ?>
<?php
	$pre_metas = [
		'img' => base_url()."/images/meta.png",
		'title' => 'ARTS BOOK - Comunidad de artistas',
		'description' => 'Se bienvenid@ a nuestra comunidad de artistas y dibujantes Art\'s Book 😁'
	];

	$metas = array_merge($pre_metas, empty($metas) ? [] : $metas);

 ?>
<meta name="description" content="<?= $metas['description'] ?>" />

<!-- Twitter Card data -->
<meta name="twitter:card" value="summary">

<!-- Open Graph data -->
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
<link rel="stylesheet" href="<?= base_url() ?>/font/mdi/css/materialdesignicons.min.css">

<link rel="stylesheet" href="<?= base_url() ?>/libs/materialize/css/materialize.min.css">
<link rel="stylesheet" href="<?= base_url() ?>/css/helpers.css?v=<?= $version ?>">
<link rel="stylesheet" href="<?= base_url() ?>/libs/animate/animate.min.css">
<link rel="stylesheet" href="<?= base_url() ?>/css/custom_materialize.css?v=<?= $version ?>">
<script src="<?= base_url() ?>/js/script.js?v=<?= $version ?>"></script>
<script src="<?= base_url() ?>/js/jquery-3.4.1.min.js"></script>
<script src="<?= base_url() ?>/libs/animate/animateCSS.js"></script>
<script src="<?= base_url() ?>/libs/materialize/js/materialize.min.js"></script>
<script src="<?= base_url() ?>/libs/ResizeSensor/ResizeSensor.js"></script>
<script src="<?= base_url() ?>/libs/ResizeSensor/ElementQueries.js"></script>
<script src="<?= base_url() ?>/libs/axios/axios.min.js"></script>
<script src="<?= base_url() ?>/libs/vue/vue.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>/libs/cgVue/cg.components.vue.css?v=<?= $version ?>">
<script src="<?= base_url() ?>/libs/cgVue/cg.components.vue.js?v=<?= $version ?>"></script>
<link rel="stylesheet" href="<?= base_url() ?>/css/main.css?v=<?= $version ?>">
<link rel="stylesheet" href="<?= base_url() ?>/css/colors.css?v=<?= $version ?>">
<link rel="stylesheet" href="<?= base_url() ?>/css/components.vue.css?v=<?= $version ?>">
<script src="<?= base_url() ?>/js/components.vue.js?v=<?= $version ?>"></script>
<script src="<?= base_url() ?>/libs/simplebar/simplebar.min.js"></script>
<script src="<?= base_url() ?>/libs/simplebar/simplebar.vue.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>/libs/simplebar/simplebar.css">
<script data-ad-client="ca-pub-1355252812560688" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
