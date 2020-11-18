<?php template_start()?>
	<cg-grid :images="list_img" :stack_size="stack" base_url="<?= base_url() ?>"></cg-grid>
<?php $template = template_end()?>

<script>

const $_module = {
	template: `<?= $template ?>`,
	data: function () {
		return {
			list_img: <?= json_encode($images_list) ?>,
			stack: 170
		}
	},
	mounted: function () {
		const body = $(document.body);
		this.stack = body.width() > 600 ? 360 : 170;
		window.addEventListener('resize', () => {
			this.stack = body.width() > 600 ? 360 : 170;
		});
	}
}

</script>
