<?php

?>
<div id="app-start">
	<cg-grid :images="list_img" :stack_size="320"></cg-grid>
</div>
<script type="text/javascript">

let images = <?= json_encode($images_list) ?>;
new Vue({
	el: '#app-start',
	data: {
		list_img: images
	}
})

</script>
