
<style media="screen">
#app-title{
	position: relative;
	color: var(--primary);
	font-size: 3rem;
	font-family: sans-serif;
	font-weight: bold;
}
#beta-text{
	background-color: var(--primary);
	color: white;
	padding: .25rem .5rem;
	border-radius: 30px;
	transform: scale(.8);
}
#wrap_grid_gallery{
	background-color: #f9f9f9;
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
	width: 300px;
	height: 400px;
	padding: .5rem 1rem;
	border-radius: 10px;
	margin: .5rem
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
#app-home-start{
	padding: 0 1rem;
	height: 500px;
	display: flex;
	align-items: center;
	justify-content: space-around;
	flex: 1;
}
#app-home-events{
	display: flex;
}
#app-home-navbar img{
	width: 40px;
}
#app-home-navbar{
	background-color: var(--alter);
	padding: .5rem 1rem;
}
#app-home-presentation{
	background-color: var(--alter);
	color: white;
	position: relative;
	height: calc(100vh - 52px);
	display: flex;
	justify-content: space-between;
	flex-direction: column;
	overflow: hidden;
}
#app-home-start-info{
	padding: 2rem 0;
}
#app-home-title{
	display: flex;
}
@media (max-width: 1200px) {
	.event-anunces{
		width: 270px;
	}
}
@media (max-width: 992px) {
	#app-home-presentation{
		height: auto;
	}

	#app-home-title{
		flex-direction: column;
	}
	#app-home-events{
		width: 100%;
	}
	#app-home-start{
		align-items: center;
		flex-direction: column;
		height: auto;
	}
	#app-home-start-info{
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: column;
		text-align: center;
	}
	.event-anunces{
		height: 180px;
		width: auto;
		flex: 1
	}
}
@media (max-width: 600px) {
	#app-home-navbar img{
		width: 30px;
	}
	#app-home-events{
		flex-direction: column;
	}
	#wrap_grid_gallery{
		padding: 0;
	}
	#app-home-start{
		padding-top: 1rem;
	}
	.cg-countdown{
		font-size: 1.4rem;
	}
}
@media (max-width: 320px) {

}
slider-feed-nartwork-container{
	display: flex;
	overflow: hidden;
}
slider-feed-nartwork-container, .slider-feed-nartwork-container{
	width: 100%;
	overflow: hidden;
	position: relative;
}
slider-feed-nartwork-container > div, .slider-feed-nartwork-container > div{
	display: flex;
	overflow: hidden;
}
slider-feed-nartwork, .slider-feed-nartwork{
	min-height: 240px;
	min-width: 240px;
	height: 240px;
	width: 240px;
	padding: .25rem;
	position: relative;
}
.slider-feed-nartwork img{
	width: 100%;
	height: 100%;
	border-radius: 10px;
	background-color: lightgray;
}
.slider-feed-nartwork-heart{
	position: absolute;
	bottom: .5rem;
	right: .5rem;
	cursor: pointer;
	transition: linear all .2s;
	height: 30px;
	display: flex;
	align-items: center;
	justify-content: center;
}
.slider-feed-nartwork-heart i{

	font-size: 2rem;
}
.slider-feed-nartwork-heart:hover{
	color: #e91e63;
}
.slider-feed-nartwork-heart.feed-heart-active{
	color: #e91e63;
}
</style>

<?php module_start()?>
<div>

	<div id="app-home-navbar" class="f-b">

		<img src="<?= base_url() ?>/images/icon_white.svg" alt="logo">
		<?php if (is_access()): ?>
			<a class="btn" href="<?= $_SESSION['access']['account_site']?>">
				<i class="mdi mdi-account mdi-18px right"></i>
				<span><?= $_SESSION['access']['nickname'] ?></span>
			</a>
		<?php else: ?>
			<div>
				<a class="btn bg-secondary" href="<?= base_url() ?>/user/login?register=true">
					<span>REGISTRASE</span>
				</a>
				<a class="btn" href="<?= base_url() ?>/user/login">
					<span>ACCEDER</span>
				</a>
			</div>

		<?php endif; ?>

	</div>
	<div id="app-home-presentation">
		<?= bg_animate() ?>
		<section id="app-home-start">
			<div id="app-home-start-info">
				<div id="app-home-title">
					<img src="<?= base_url() ?>/images/namepage_primary.svg" alt="ARTSBOOK" id="app-title">
					<div style="overflow: hidden; height: 0;"><h1>ARTSBOOK</h1></div>

				</div>
				<h2 style="font-family: sans-serif;" class="pt-2 title-4">
					COMUNIDAD DE DIBUJATES
				</h2>
				<h3 class="pt-4 title-5" style="max-width: 420px">Somos una comunidad de artistas y dibujantes hispanohablantes. Ven, descubre y comparte trabajos artísticos en tradicional o digital, además de otras muchas cosas más.</h3>
			</div>
			<div id="app-home-events">
				<?php foreach ($current_events as $key => $event): ?>
					<?php if ($event['is_voting'] == 0): ?>

						<div class="event-anunces">
							<?php if ($event['type_event'] != 1): ?>
								<?= bg_animate_001() ?>
							<?php else: ?>
								<?= bg_animate_002() ?>
							<?php endif; ?>

							<div class="context">
								<div class="title-4"><?= $event['name'] ?></div>
								<cg-countdown class="title-3 c" datestring="<?= $event['voting'] ?>"></cg-countdown>
								<span class="white-text" style="font-size: .9rem; margin-top: -.2rem; display: block">Una vez finalizada la cuenta regresiva <b>inician las votaciones</b></span>
								<a href="<?= base_url() ?>/events/versus">PARTICIPA AQUI!</a>
							</div>

						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</section>
		<section class="py-4">
			<h3 class="title-4 p-4 white-text"><i class="mdi mdi-new-box"></i> NUEVOS</h3>
			<slider-feed-nartwork-container class="p-4" :data="images_feed">
				<?php foreach ($images_feed as $key => $artwork): ?>
					<div class="slider-feed-nartwork">
						<img src="<?= base_url()."/images/artworks_lite/$artwork[accessname].$artwork[extension]" ?>" alt="<?= $artwork['name'] ?>">
					</div>
				<?php endforeach; ?>
			</slider-feed-nartwork-container>
		</section>

</div>
<article class="adsenseblock"></article>

<h3 class="title-4 p-4 primary"> <i class="mdi mdi-apps"></i> GALLERIA</h3>
<div id="wrap_grid_gallery">
	<cg-grid :images="list_img" :stack_size="stack" base_url="<?= base_url() ?>" @sizewrapper="sizewrapper"></cg-grid>
</div>
<article class="adsenseblock"></article>
<footer style="background: #09061b;" class="f-c f-b white-text footer">
	<div class="f-c">
		<div class="container">
			<div class="row m-0">
				<div class="col s12 m4 f-c"  style="height: 170px">
					<img src="<?= base_url() ?>/images/icon_white.svg" alt="icon" width="100">
				</div>
				<div class="col s12 m8">
					La vida es un gran libro de arte, cada experiencia, cada sentir, cada parte de ti, han de crear hoja a hoja, al final de todo, el gran lienzo de tu existencia.
				</div>
			</div>

		</div>
	</div>
	<div class="container p-4 f-c c" style="color: #ffffff75; font-size: .8rem;">
		Esta plataforma desarrollada por la comunidad de artistas artsbook, de artistas para artistas. <?= date('Y') ?>
	</div>
</footer>

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

<?php module_end()?>



<script>
let list_images_pre = <?= json_encode($images_list) ?>;
//list_images_pre.insert(4, {adsense: true, id: 'adsense-01'});
Vue.component('slider-feed-nartwork-container', {
	template: `<div class="slider-feed-nartwork-container">
		<div ref="wrap" :style="{height: size + 'px'}">
			<slider-feed-nartwork v-for="artwork of data" :data='artwork' base_url="<?= base_url() ?>"></slider-feed-nartwork>
		</div>
	</div>`,
	data: function () {
		return {
			size_stack: <?= $agent->isMobile() ? 100 : 200 ?>,
			size: <?= $agent->isMobile() ? 100 : 200 ?>
		}
	},
	props: ['data'],
	methods: {
		calcule_width: function () {
			const items_in_row = parseInt(this.$refs.wrap.offsetWidth/this.size_stack);
			const items_new_width = Math.round(this.$refs.wrap.offsetWidth/items_in_row)
			this.size = items_new_width
			for (var child of this.$children) child.size = items_new_width;
		}
	},
	mounted: function () {
		new ResizeSensor(this.$refs.wrap, () => {this.calcule_width()});
		this.calcule_width();

	},
	created: function () {

	}
})
Vue.component('slider-feed-nartwork',{
	template: `
	<div class="slider-feed-nartwork" :style="{'min-width': size + 'px', 'min-height': size + 'px', 'width': size + 'px', 'height': size + 'px'}">
		<div class="slider-feed-nartwork-heart" :class="{'feed-heart-active': data.heart}" @click="trigger_heart(data)">
			<i class="mdi" :class="data.heart ? 'mdi-heart' : 'mdi-heart-outline'"></i>
		</div>
		<a :href="base_url + '/artwork/view/' + data.accessname">
			<img :src="base_url+'/images/artworks_lite/'+data.accessname+'.'+data.extension" :alt="data.name">
		</a>
	</div>
	`,
	data: function () {
		return {
			size: 200
		}
	},
	props: ['data','base_url'],
	methods: {
		trigger_heart: function (info) {
			if (this.$root.trigger_like != undefined) this.$root.trigger_like(info)
			else console.log('FUNCTION LIKE NO FOUND');
		}
	},
	mounted: function () {
	}
})

const $_module = {
	data: function () {
		return {
			list_img: list_images_pre,
			images_feed: <?= json_encode($images_feed) ?>,
			stack: $(window).width() > 1200 ? 320 : <?= $agent->isMobile() ? 170 : 280 ?>,
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
		}
	}
}

</script>
