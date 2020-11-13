<style media="screen">
	#user_header{
		height: 300px;
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
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
		background-attachment: fixed;
		background-image: url('<?= base_url() ?>/images/bg_003.jpg');
		transform: scale(1.1);
		filter: blur(10px);
	}
	#user_header_bg_shadow{
		position: 	absolute;
		left: 0;
		top: 0;
		height: 100%;
		width: 100%;
		background-color: black;
		opacity: .4;
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
	@media (max-width: 600px) {
		#user_header{
			height: 160px;
		}
		#user_header_bg_content{
			flex-direction: row;
		}
		.user-foto{
			height: 80px;
			width: 80px;
		}
		#user_header_bg_content h5{
			padding-left: 1rem;
		}
	}
</style>

<?php template_start(); ?>
<div>
	<div class="" id="user_header">
		<div id="user_header_bg"></div>
		<div id="user_header_bg_shadow"></div>
		<div id="user_header_bg_content">
			<div class="user-foto"><?= $info['nickname'][0] ?></div>
			<h5><?= $info['nickname'] ?></h5>
		</div>
	</div>
	<div class="p-4">
		<cg-grid :images="list_img" :stack_size="320" :details="false"></cg-grid>
	</div>

</div>
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
