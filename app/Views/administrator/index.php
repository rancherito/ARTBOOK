<?php
$images = [];
foreach (scandir('./images/others') as $key => $value) {
	if (!is_dir($value) && $value != 'others') $images[] = base_url()."/images/others/$value";
}

?>
<script src="<?= base_url() ?>/libs/gridStack/gridStack.js" charset="utf-8"></script>
<style media="screen">
	#app-content{
		padding: 0;
	}
	#app{
		height: 100%;
		width: 100%;
		display: flex;
	}

	#grid-images{
		width: 100%;
	}
	.box-image{
		height: 100%;
		border: 1px solid #ccc;
		border-radius: 10px;;
		background-position: center top;
		background-repeat: no-repeat;
		background-size: cover;
	}
	#edit-image{
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: white;
		display: flex;
	}
	#edit-image > div:nth-child(1){
		flex-grow: 1;
	}
	#edit-image > div:nth-child(2){
		width: 100%;
		max-width: 460px;
	}
</style>
<script type="text/x-template" id="app-template">
	<div style="height: 100%; overflow-y: auto">
		<div id="edit-image" class="p-4">
			<div class="f-c">
				<i class="mdi mdi-camera-outline grey-text" style="font-size: 8rem"></i>
				<div>SUBIR UNA IMAGEN</div>
			</div>
			<div class="red">sda</div>
		</div>
		<div class="p-4" id="grid-images">
			<div class="wrap-grid">
				<?php foreach ($images as $key => $image): ?>
					<div class="p-1 white-text" style="float: left; width: 260px; height: 260px">
						<div class="p-4 grey box-image" style=" background-image: url('<?= $image?>')">
						</div>
					</div>
				<?php endforeach; ?>

			</div>
		</div>
	</div>

</script>
<script>
	Vue.component('module',{
		template: '#app-template',
		mounted: function () {
			new gridStack($('.wrap-grid'),260,4)
		}
	})
</script>
