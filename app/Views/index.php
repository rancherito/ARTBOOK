<?php

$images = [];
foreach (scandir('./images/artworks') as $key => $value) {

	if (!is_dir($value)) {
		list($ancho, $alto) = getimagesize("images/artworks/$value");
		$images[] = [
			'url' => base_url()."/images/artworks/$value",
			'height' => $alto,
			'width' => $ancho
		];
	}
}
?>
<div id="app-start">
	<cg-grid :images="list_img" :stack_size="340"></cg-grid>
</div>
<script type="text/javascript">

let images = <?= json_encode($images) ?>;

console.table(images);

new Vue({
	el: '#app-start',
	data: {
		list_img: images
	}
})

</script>
