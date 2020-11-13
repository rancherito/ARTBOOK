<?php template_start()?>
	<cg-grid :images="list_img" :stack_size="320" base_url="<?= base_url() ?>"></cg-grid>
<?php $template = template_end()?>

<script>

const $_module = {
	template: `<?= $template ?>`,
	data: function () {
		return {
			list_img: <?= json_encode($images_list) ?>
		}
	}
}

</script>
