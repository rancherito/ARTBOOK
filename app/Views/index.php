<style media="screen">
#app-title{
	position: relative;
}
#app-title span{
	position: absolute;
	bottom: -10px;
	right: -30px;
	background-color: var(--primary);
	color: white;
	padding: .25rem .5rem;
	border-radius: 30px;
	transform: scale(.8) rotate(-45deg);
}
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

.event-anunces{
	position: relative;
	overflow: hidden;
	display: flex;
	align-items: center;
	justify-content: center;
}

.context{
	text-align: center;
	color: #fff;
	font-size: 2rem;
	position: relative;
	z-index: 2;
	padding: .5rem
}
.context a{
	background: #ffffff47;
	color: white;
	border-radius: 30px;
	padding: .5rem 1rem;
	font-size: 1rem;
}
.modal{
	overflow: hidden;
	border-radius: 10px;
}
.btn-modal-close{
	position: absolute;
	top: 1rem;
	right: 1rem;
}
#content-spot{
	display: none;
}
#presentation-page-start{
	height: 200px;
}
@media (max-width: 600px) {

	.countdown{

	}
}
@media (max-width: 320px) {
	.countdown{
		font-size: 1.6rem;
	}
}
</style>
<!--<div id="adsense-square-ingrid">

	<ins class="adsbygoogle"
	style="display:block;height:100%; width:100%"
	data-ad-client="ca-pub-1355252812560688"
	data-ad-slot="5969213646"
	data-ad-format="auto"
	data-full-width-responsive="true">

</ins>

</div>
-->
<?php template_start()?>
<div>
	<div class="">
		<div id="presentation-page-start" class="f-c">
			<div class="combo-text-title" id="app-title">
				<h1 class="title-2 m-0">Bienvenido a Art's Book</h1>
				<span>BETA</span>
			</div>
			<span>Sitio web oficial de la comunidad de artistas art's book</span>

		</div>
		<div class="event-anunces" v-if="typeof versus[0] != 'undefined'">
			<div class="context">
				<div class="title-4">{{versus[0].name}}</div>
				<span class="white-text">Una vez finalizada la cuenta regresiva <b>inician las votaciones</b></span>
				<a href="<?= base_url() ?>/events/versus">PARTICIPA AQUI!</a>
			</div>
			<?= bg_animate_001() ?>
		</div>

		<div class="container">

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
			<div id="content-spot">
				<ins class="adsbygoogle"
				style="display:block; height:100px"
				data-ad-format="fluid"
				data-ad-layout-key="-6t+ed+2i-1n-4w"
				data-ad-client="ca-pub-1355252812560688"
				data-ad-slot="7585531731">
			</ins>
		</div>

	</div>
	</div>


<div class="p-4" style="background-color: #f9f9f9">
	<cg-grid :images="list_img" :stack_size="stack" base_url="<?= base_url() ?>" @sizewrapper="sizewrapper"></cg-grid>
</div>

<div class="container">
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
</div>
<?php foreach ($current_events as $key => $event): ?>
	<?php if ($event['is_voting'] == 1): ?>
		<div id="modal1" class="modal" style="max-width: 400px">
			<?= bg_default() ?>
			<div class="modal-close waves-effect btn-icon btn-dark btn-modal-close">
				<i class="mdi mdi-close"></i>
			</div>
			<div class="modal-content f-c white-text" style="position: relative; height: 540px">
				<img id="versustag-header-img" style="height: 160px; width: auto" src="<?= base_url() ?>/images/vs_logo.png">
				<br><br>
				<div class="title-3 combo-text-title"><?= $event['name'] ?></div>
				<span class="white-text" style="margin-top: -.5rem">Votaciones de versus abiertas</span>

					<span class="title-4 c pt-4">TERMINA EN</span>
					<cg-countdown class="title-3 c" datestring="<?= $event['event_end'] ?>"></cg-countdown>

				<a href="<?= base_url() ?>/events/versus/<?= $event['event_tag'] ?>" class="btn btn-dark">VAMOS!</a>

			</div>
		</div>
	<?php endif; ?>
<?php endforeach; ?>

</div>

<?php $template = template_end()?>



<script>
console.log();
let list_images_pre = <?= json_encode($images_list) ?>;
//list_images_pre.insert(4, {adsense: true, id: 'adsense-01'});


const $_module = {
	template: `<?= $template ?>`,
	data: function () {
		return {
			list_img: list_images_pre,
			stack: <?= $agent->isMobile() ? 170 : 280 ?>,
			versus: <?= json_encode($list_versus) ?>,
			modal: null,
			test: <?= json_encode($current_events) ?>
		}
	},

	methods: {
		formatdate: function (date) {
			var event = new Date(date);
			var options = { year: 'numeric', month: 'short', day: 'numeric'};
			const ophour = { hour: '2-digit', minute: '2-digit', hour12: true}

			return event.toLocaleDateString('es-ES', options).toUpperCase() + ' a las ' + event.toLocaleTimeString('es-ES', ophour)
		},
		sizewrapper: function (size) {
			$('.content_feed_and_gallery').width(size)
		},
		goevent: function () {
			window.location.href = '<?= base_url() ?>/events/challenges'
		}
	},
	mounted: function () {
		if ($('#modal1')) {
			this.modal = $('#modal1').modal()

			this.modal.modal('open')
			if (this.versus[0] != undefined) {
				this.datecoutdown(this.versus[0].voting)
			}
		}


		/*const body = $(document.body);
		this.stack = body.width() > 600 ? 320 : (body.width() > 300 ? 170 : 260);
		window.addEventListener('resize', () => {
		this.stack = body.width() > 600 ? 320 : (body.width() > 300 ? 170 : 260);
	});*/
	//$('#adsense-01').append($('#adsense-square-ingrid'));
}
}

</script>
