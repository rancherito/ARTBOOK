<?php

$images = [];
foreach (scandir('./images/others') as $key => $value) {

	if (!is_dir($value) && $value != 'others') {
		list($ancho, $alto) = getimagesize("images/others/$value");
		$images[] = [
			'url' => base_url()."/images/others/$value",
			'height' => $alto,
			'width' => $ancho
		];
	}
}
?>
<div id="app-start">
	<cg-grid :images="list_img"></cg-grid>
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
