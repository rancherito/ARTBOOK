
<link rel="stylesheet" href="<?= base_url() ?>/css/home.css?v=1">
<style media="screen">
	#app-home-news-gallery{
		display: flex;
		width: 100%;

	}
	#app-home-gallery-container{
		width: calc(100% - 360px);
	}
	#app-home-news{
		padding: 0 1rem;
		width: 360px;
	}
	#app-home-news img{
		width: 100%;
		border-radius: 10px 10px 0 0;
	}
	.app-artwork-top-author{
		color: black;
		text-decoration: underline;
	}
	.app-artwork-top-picture{
		position: relative;
	}
	@media (max-width: 992px) {
		#app-home-news-gallery{
			flex-direction: column;
		}
		#app-home-gallery-container, #app-home-news{
			width: 100%;
		}
		#app-home-news{
			display: none;
		}
	}
	@media (max-width: 600px) {
		#app-home-news{
			display: block;
		}
	}
</style>
<?php module_start()?>
<div>

	<div id="app-home-navbar" class="f-b">


	</div>
	<div id="app-home-presentation" style="background-image: url('<?= base_url() ?>/images/bg_008.jpg');">
		<div class="bg-special">
		</div>
		<section id="app-home-start">
			<div id="app-home-start-info">
				<div id="app-home-title">
					<div id="app-home-icon" class="f-c mr-5">
						<img src="<?= base_url() ?>/images/icon_white.svg" alt="logo" style="width: 40px;">
					</div>
					<img src="<?= base_url() ?>/images/namepage_white.svg" alt="ARTSBOOK" id="app-title" style="">
					<div style="overflow: hidden; height: 0; width: 0;"><h1>ARTSBOOK</h1></div>
				</div>
				<div>
					<h2 id="app-home-subtitle" class="title-3">
						COMUNIDAD DE DIBUJATES
					</h2>
					<div id="app-home-description">
						<h3 class="pt-4 title-4" style="max-width: 500px">Somos una comunidad de artistas y dibujantes hispanohablantes. Ven, descubre y comparte trabajos artísticos en tradicional o digital, además de otras muchas cosas más.</h3>
						<h3 class="title-4 py-4">Ven, descubre y comparte</h3>
					</div>

				</div>

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
		<section id="app-home-feedworks-container">
			<h3 class="title-4 pt-4 pl-4 pr-4 white-text"><i class="mdi mdi-new-box"></i> NUEVOS</h3>
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
<div id="app-home-news-gallery" style="position: relative">
	<section id="app-home-news" style="position: relative; top:0px;">
		<div ref="styky_aside" style="position: relative; top:0px;">
			<h3 class="title-4 py-4 primary"> <i class="mdi mdi-apps"></i> TOP ARTWORK</h3>
			<div id="app-artwork-top">
				<?php $artwork = $artwork_top[0] ?>

					<div class="card" id="app-artwork-top-one">
						<a class="app-artwork-top-picture" href="<?= base_url()."/artwork/view/$artwork[artwork]" ?>"><img src="<?= base_url()."/images/artworks/$artwork[artwork].$artwork[extension]" ?>" alt="<?= $artwork['name'] ?>"></a>
						<div class="p-4 f-b">
							<a class="f-c white-text cover" style="height: 50px; width: 50px; border-radius: 50%; background-color: var(--primary); background-image: url(<?= account_avatar($artwork['user_avatar']) ?>)">
								<?php if (!has_account_avatar($artwork['user_avatar'])): ?>
									<?= $artwork['nickname'][0] ?>
								<?php endif; ?>
							</a>
							<div style="flex: 1" class="pl-4">
								<h4><?= $artwork['name'] ?></h4>
								<h5>por <a class="app-artwork-top-author" href="<?= base_url()."/$artwork[account]" ?>"><?= $artwork['nickname'] ?></a></h5>
							</div>

						</div>
					</div>
				<?php foreach ([$artwork_top[1],$artwork_top[2],$artwork_top[3]] as $key => $artwork): ?>
					<a class="app-artwork-top-picture" href="<?= base_url()."/artwork/view/$artwork[artwork]" ?>">
						<img src="<?= base_url()."/images/artworks_lite/$artwork[artwork].$artwork[extension]" ?>" alt="<?= $artwork['name'] ?>" style="width: 32%; border-radius: 10px;">
						<div class="c white-text" style="position: absolute; bottom: .5rem; left: 0; right: 0; background-color: rgba(0,0,0,0.2)"><?= $artwork['nickname'] ?></div>
					</a>
				<?php endforeach; ?>

			</div>


		</div>

	</section>
	<div id="app-home-gallery-container">
		<h3 class="title-4 p-4 primary"> <i class="mdi mdi-apps"></i> GALLERIA</h3>
		<div id="wrap_grid_gallery">
			<cg-grid :images="list_img" :stack_size="stack" base_url="<?= base_url() ?>" @sizewrapper="sizewrapper"></cg-grid>
		</div>
	</div>

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
	template: `<div class="slider-feed-nartwork-container" :style="{'min-height': 'calc(2rem + ' + size + 'px)'}">
		<div ref="wrap" :style="{'min-height': size + 'px'}">
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

$_module = {
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
		new Sticksy(this.$refs.styky_aside, true)

		//$(this.$refs.styky_aside).sticky({topSpacing:0});
		if ($('#modal1')) {
			this.modal = $('#modal1').modal()
			this.modal.modal('open')
		}

	}
}

</script>
