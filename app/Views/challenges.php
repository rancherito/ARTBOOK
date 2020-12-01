<style media="screen">
	#challenges,#challenges-bg-content{
		height: 100vh;
		width: 100vw;
		overflow: hidden;
		position: relative;
	}
	#challenges-bg-content{
		position: absolute;
		transform: scale(1.2);
	}
	#challenges-bg-content img{
		object-fit: cover;
		height: 100%;
		width: 100%;
		filter: blur(10px);
	}
	#challenges-bg-content::after{
		content: '';
		position: absolute;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		background: #000;
		opacity: 0.5
	}
	#challenges-active-artwork{
		position: relative;
		overflow: hidden;
		width: 100%;
		height: 600px;
		border-radius: 10px;
	}
	#challenges-active-artwork img{
		width: 100%;
		height: 100%;
		object-fit: contain;
		position: relative;
	}
	#challenges-gallery{
		position: relative;
		height: 100%;
		display: flex;
		align-items: center;
		justify-content: center;
		max-width: 500px;
		width: 100%;
		margin: 0 auto;
		flex-direction: column;
	}
	#challenges-active-bg{
		position: absolute;
		transform: scale(1.2);
		height: 100%;
		width: 100%;
		left: 0;
		top: 0;
		background: red;
	}
	#challenges-active-bg::after{
		content: '';
		position: absolute;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		background: #000;
		opacity: 0.5
	}
	#challenges-active-bg img{
		filter: blur(20px);
		object-fit: cover;
	}
	#challenges-counter{
		position: absolute;
		top: 1rem;
		left: 1rem;
		background: white;
		padding: .5rem;
		border-radius: 20px;
		box-shadow: 0 0 5px #0000003d;
	}
	#challenges-arrows{
		background: white;
		border-radius: 30px;
		overflow: hidden;
	}
	#challenges-arrows a{
		background: white;
		height: 42px;
		display: inline-block;
		line-height: 42px;
		width: 42px;
		text-align: center;
		font-size: 1.5rem;
		color: var(--primary);
		cursor: pointer;
	}
	@media (max-width: 600px) {
		#challenges-arrows{
			position: fixed;
			bottom: 23px;
			box-shadow: 0 0 5px #0000003d;
		}
		#challenges-active-artwork{
			height: 100%;
			border-radius: none;
		}
	}
</style>
<?php template_start() ?>
	<div id="challenges">
		<div id="challenges-bg-content">
			<img src="<?= base_url() ?>/images/bg_003.jpg" alt="">
		</div>
		<div id="challenges-gallery">
			<div id="challenges-active-artwork">
				<div id="challenges-active-bg">
					<img :src="image_active">
				</div>
				<img :src="image_active">
				<div id="challenges-counter">
					{{posimage + 1}} de {{images.length}}
				</div>
			</div>
			<div id="challenges-arrows" class="mt-2">
				<a @click="posimage = --posimage < 0 ? images.length - 1 : posimage"><i class="mdi mdi-arrow-left"></i></a>
				<a @click="posimage = ++posimage >= images.length ? 0 : posimage"><i class="mdi mdi-arrow-right"></i></a>
			</div>
		</div>

	</div>
<?php $template = template_end() ?>

<script type="text/javascript">
	function shuffle(array) {
	  var currentIndex = array.length, temporaryValue, randomIndex;
	  while (0 !== currentIndex) {
		randomIndex = Math.floor(Math.random() * currentIndex);
		currentIndex -= 1;
		temporaryValue = array[currentIndex];
		array[currentIndex] = array[randomIndex];
		array[randomIndex] = temporaryValue;
	  }

	  return array;
	}
	let images = <?= json_encode($images) ?>;

	images = shuffle(images);
	$_module = {
		template: `<?= $template ?>`,
		data: function () {
			return {
				images: images,
				posimage: 0
			}
		},
		computed: {
			image_active: function () {
				return '<?= base_url() ?>/images/artworks/' + this.images[this.posimage].image
			}
		},
		mounted: function () {

		}
	}
</script>
