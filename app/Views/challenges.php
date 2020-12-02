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
		opacity: 0.2
	}
	#challenges-active-artwork{
		position: relative;
		overflow: hidden;
		width: 100%;
		height: 700px;
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
	}
	#challenges-active-bg::after{
		content: '';
		position: absolute;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		background: black;
		opacity: 0.2
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
		padding: .5rem 1rem;
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
	#challenges-vote{
		position: absolute;
		right: 23px;
		top: 23px;

	}
	#challenges-vote i{
		box-shadow: 0 0 5px #0000003d;
		height: 56px;
		width: 56px;
		line-height: 56px;
		text-align: center;
		color: lightgray;
		border-radius: 50%;
		font-size: 2rem;
		background: white;
		transition: linear all .2s;
		cursor: pointer;
	}
	#challenges-vote span{
		color: white;
		text-shadow: 0 0 8px black;
	}
	#challenges-vote i:hover{
		background: var(--primary);
		color: white;
	}
	#challenges-active-artwork.challenges-vote #challenges-vote i{
		background: #8bc34a;
		color: white;
	}
	#challenges-description{
		position: absolute;
		bottom: 2.4rem;
		left: 1rem;
		background: var(--primary);
		padding: .5rem 1rem;
		border-radius: 20px;
		color: white;
	}
	@media (max-width: 600px) {
		#challenges-arrows{
			position: fixed;
			top: 50%;
			width: 100%;
			display: flex;
			justify-content: space-between;
			transform: translateY(-50%);
			background: transparent;
			border-radius: 0;
		}
		#challenges-arrows a{
			height: 80px;
			display: flex;
			justify-content: center;
			align-items: center;
			font-size: 3rem;
			background: #0000000f;
			color: white;
		}
		#challenges-arrows a:nth-child(1){
			border-radius: 0 50px 50px 0;
		}
		#challenges-arrows a:nth-child(1) i{
			transform: translateX(-20%);
		}
		#challenges-arrows a:nth-child(2){
			border-radius: 50px 0 0 50px
		}
		#challenges-arrows a:nth-child(2) i{
			transform: translateX(20%);
		}
		#challenges-active-artwork{
			height: 100%;
			border-radius: 0;
		}
		#challenges-description{
			position: fixed;
		}
	}
</style>
<?php template_start() ?>
	<div id="challenges">
		<div id="challenges-bg-content">
			<img src="<?= base_url() ?>/images/bg_003.jpg" alt="">
		</div>
		<div id="challenges-gallery">
			<div id="challenges-active-artwork" :class="{'challenges-vote': images[posimage].my_votes}">
				<div id="challenges-active-bg">
					<img :src="image_active">
				</div>
				<img :src="image_active" ref="imageartwork">
				<div id="challenges-counter">{{posimage + 1}} de {{images.length}}</div>
				<div id="challenges-description" ref="nameartwork" class="animated">{{images[posimage].name}}</div>
				<div id="challenges-vote" ref="btnvote" class="f-c">
					<i  class="mdi" :class="images[posimage].my_votes ? 'mdi-check' : 'mdi-vote-outline'" @click="vote(images[posimage])"></i>
				</div>
			</div>
			<div id="challenges-arrows" class="mt-2">
				<a @click="posimage = --posimage < 0 ? images.length - 1 : posimage"><i class="mdi mdi-chevron-left"></i></a>
				<a @click="posimage = ++posimage >= images.length ? 0 : posimage"><i class="mdi mdi-chevron-right"></i></a>
			</div>
		</div>

	</div>
<?php $template = template_end() ?>

<script type="text/javascript">
	/*function shuffle(array) {
	  var currentIndex = array.length, temporaryValue, randomIndex;
	  while (0 !== currentIndex) {
		randomIndex = Math.floor(Math.random() * currentIndex);
		currentIndex -= 1;
		temporaryValue = array[currentIndex];
		array[currentIndex] = array[randomIndex];
		array[randomIndex] = temporaryValue;
	  }

	  return array;
  }*/
	let images = <?= json_encode($images) ?>;

	//images = shuffle(images);
	$_module = {
		template: `<?= $template ?>`,
		data: function () {
			return {
				images: images,
				posimage: Math.floor(Math.random() * images.length),
				challenge: <?= json_encode($challenge) ?>,
				start_vote: false
			}
		},
		methods: {
			vote: function (image) {
				if (!this.start_vote) {
					const data = {image: image.accessname, challenge: this.challenge.event_tag}
					this.start_vote = true;
					$.post('<?= base_url() ?>/services/events/challenges/votes_save',data,(res) => {
						M.toast({html: res.message, classes: 'rounded'})
						this.start_vote = false;
						if (res.message == "VOTO GUARDADO") image.my_votes = 1
						else if(res.message == "VOTO ANULADO") image.my_votes = 0
					})
				}

			}
		},
		computed: {
			image_active: function () {
				return '<?= base_url() ?>/images/artworks/' + this.images[this.posimage].image
			}
		},
		watch:{
			posimage: function (val) {

				animateCSS(this.$refs.nameartwork, 'bounceInLeft');
				animateCSS(this.$refs.imageartwork, 'zoomInUp');
				animateCSS(this.$refs.btnvote, 'bounceIn');


				console.log(this.$refs.nameartwork);
			}
		}
	}
</script>
