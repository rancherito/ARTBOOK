
<style media="screen">
.feed-users{
	display: flex;
	padding: 1rem;
}
.feed-users-wrapper-item{
	height: 80px;
	width: 80px;
	border-radius: 50%;
	background: lightgray;
	position: relative;
}
.feed-users-item{
	margin-right: 1rem;
	position: relative;
}
.feed-users-wrapper-item > div:nth-child(1){
	display: flex;
	position: absolute;
	left: 0;
	top: 0;
	right: 0;
	bottom: 0;
	animation-name: rotate;
	animation-duration: 4s;
	animation-iteration-count: infinite;
	animation-timing-function: linear;
	border-radius: 50%;
	overflow: hidden;
}
@keyframes rotate {
	0% {
		transform: rotate(0deg);
	}
	100%{
		transform: rotate(360deg);
	}
}
.feed-users-wrapper-item > div:nth-child(1)::before,.feed-users-wrapper-item > div:nth-child(1)::after{
	content: '';
	width: 50%;
	height: 100%;
	background-color: var(--primary);
}
.feed-users-wrapper-item > div:nth-child(1)::before{
	background-color: var(--secondary)
}
.feed-users-wrapper-item > div:nth-child(2){
	z-index: 2;
	position: relative;
	height: 84%;
	background: white;
	width: 84%;
	border-radius: 50%;
}
.feed-users-icon span{
	font-family: Calibri;
	font-size: 1.5rem;
	text-transform: uppercase;
}
.feed-users-count{
	position: absolute;
	top: 0rem;
	right: 0rem;
	height: 26px;
	width: 26px;
	z-index: 4;
	border-radius: 50%;
	background: white;
	color: var(--primary);
	box-shadow: 0 0 0px 4px #876ced40;
}
.feed-users-item a{
	color: gray;
}

.bg_animation_boxes{
	height: 160px;
	position: relative;
	overflow: hidden;
	display: flex;
	align-items: center;
	justify-content: center;
	cursor: pointer;
}

.context{
	text-align: center;
	color: #fff;
	font-size: 2rem;
	position: relative;
	z-index: 2;
}
.context a{
	background: #ffffff47;
	color: white;
	border-radius: 30px;
	padding: .5rem 1rem;
	font-size: 1rem;
}

.area{
	background: #4e54c8;
	background: var(--bg-purple);
	width: 100%;
	height:100%;
	position: absolute;
	top: 0;
	left: 0;

}

.circles{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	overflow: hidden;
	margin: 0;
}

.circles li{
	position: absolute;
	display: block;
	list-style: none;
	width: 20px;
	height: 20px;
	background: rgba(255, 255, 255, 0.2);
	animation: animate 25s linear infinite;
	bottom: -150px;

}

.circles li:nth-child(1){
	left: 25%;
	width: 80px;
	height: 80px;
	animation-delay: 0s;
}


.circles li:nth-child(2){
	left: 10%;
	width: 20px;
	height: 20px;
	animation-delay: 2s;
	animation-duration: 12s;
}

.circles li:nth-child(3){
	left: 70%;
	width: 20px;
	height: 20px;
	animation-delay: 4s;
}

.circles li:nth-child(4){
	left: 40%;
	width: 60px;
	height: 60px;
	animation-delay: 0s;
	animation-duration: 18s;
}

.circles li:nth-child(5){
	left: 65%;
	width: 20px;
	height: 20px;
	animation-delay: 0s;
}

.circles li:nth-child(6){
	left: 75%;
	width: 110px;
	height: 110px;
	animation-delay: 3s;
}

.circles li:nth-child(7){
	left: 35%;
	width: 150px;
	height: 150px;
	animation-delay: 7s;
}

.circles li:nth-child(8){
	left: 50%;
	width: 25px;
	height: 25px;
	animation-delay: 15s;
	animation-duration: 45s;
}

.circles li:nth-child(9){
	left: 20%;
	width: 15px;
	height: 15px;
	animation-delay: 2s;
	animation-duration: 35s;
}

.circles li:nth-child(10){
	left: 85%;
	width: 150px;
	height: 150px;
	animation-delay: 0s;
	animation-duration: 11s;
}

@keyframes animate {

	0%{
		transform: translateY(0) rotate(0deg);
		opacity: 1;
		border-radius: 0;
	}

	100%{
		transform: translateY(-1000px) rotate(720deg);
		opacity: 0;
		border-radius: 50%;
	}

}
@media (max-width: 600px) {
	.bg_animation_boxes{
		height: 100px;
	}
}
</style>
<?php template_start()?>
<div>
	<div class="f-c pt-6 pb-4">
		<div class="title-2 combo-text-title">Bienvenido a Art's Book</div>
		<span>Sitio web oficial de la comunidad de artistas art's book</span>

	</div>
	<div class="bg_animation_boxes" @click="goevent">
		<div class="context">
			<div class="combo-text-title">Retos de artistas</div>
			<span class="white-text">Ayudanos a elegir un ganador con tu voto</span>
			<a>VAMOS!</a>
		</div>


		<div class="area" >
			<ul class="circles">
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
		</div >

	</div>
	<div class="content_feed_and_gallery" style="margin: 0 auto">
		<simplebar>
			<div class="feed-users">
				<?php foreach ($feed as $key => $f): ?>
					<div class="feed-users-item f-c">
						<div class="feed-users-count f-c"><span><?= $f['total'] ?></span></div>
						<div class="feed-users-wrapper-item f-c">
							<div></div>
							<div class="f-c feed-users-icon">
								<span><?= $f['nickname'][0] ?></span>
							</div>
						</div>
						<a href="<?= base_url() ?>/<?= $f['account'] ?>" class="pt-2"><?= $f['nickname'] ?></a>
					</div>

				<?php endforeach; ?>
			</div>
		</simplebar>
	</div>


	<cg-grid :images="list_img" :stack_size="stack" base_url="<?= base_url() ?>" @sizewrapper="sizewrapper"></cg-grid>
</div>

<?php $template = template_end()?>

<script>
console.log();
const $_module = {
	template: `<?= $template ?>`,
	data: function () {
		return {
			list_img: <?= json_encode($images_list) ?>,
			stack: <?= $agent->isMobile() ? 170 : 320 ?>
		}
	},
	methods: {
		sizewrapper: function (size) {
			$('.content_feed_and_gallery').width(size)
		},
		goevent: function () {
			window.location.href = '<?= base_url() ?>/events/challenges'
		}
	},
	mounted: function () {
		const body = $(document.body);
		this.stack = body.width() > 600 ? 320 : (body.width() > 300 ? 170 : 260);
		window.addEventListener('resize', () => {
			this.stack = body.width() > 600 ? 320 : (body.width() > 300 ? 170 : 260);
		});
	}
}

</script>
