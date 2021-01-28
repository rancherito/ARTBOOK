<style media="screen">
:root{
	--margin-more: 400px;
}
#app-artwork{
}
#app-artwork-image-info{
	width: 100%;
	display: flex;
}
#app-artwork-image-content{
	background: #2d2d2d;
	padding: 2rem;
	width: calc(100% - var(--margin-more));
	min-height: 100vh;
}
#app-artwork-more{
	width: var(--margin-more);
	position: relative;
}
#app-artwork-image{
	width: auto;
	max-height: calc(100vh - 190px);
	max-width: 100%;
	display: block;
	margin: 0 auto;
	box-shadow: 0 17px 20px 6px rgba(0,0,0,.3);
}
#app-artwork-image-description{
	padding: 1rem 0 2rem;
	display: flex;

}
.app-artwork-author{
	padding: 1rem;
	width: 100%;
}
.author-avatar{
	height: 50px;
	width: 50px;
	background-color: var(--primary);
	font-size: 2rem;
	font-family: Calibri;
	color: white;
	text-transform: uppercase;
}
.author-avatar-info{
	width: calc(100% - 50px);
	padding-left: 1rem;
	display: flex;
	justify-content: space-around;
	flex-direction: column;
}
.author-avatar-info h1{
	font-size: 1.5rem;
	margin: 0;
	text-transform: uppercase;
}
.author-avatar-info h2{
	font-size: 1rem;
	margin: 0;
}
.author-link a:hover h2{
	text-decoration: underline !important;
}
.author-link * {
	display: inline-block;
}
.author-link span{
	color: gray;
}
.image-simple-grid{
	overflow: hidden;
	height: auto;
	display: block;
	position: relative;
	width: calc(33.333%);
	float: left;
}
.image-simple-grid img{
	display: block;
	width: 100%;
}
.image-simple-grid-content{
	overflow: hidden;
	padding: 1rem;
}
#app-author{
	display: flex;
}
@media (max-width: 1200px) {
	#app-artwork{
		flex-direction: column;

	}
	#app-artwork-image-info{
		flex-direction: column;
	}
	#app-artwork-image-content{
		min-height: auto;
	}
	#app-artwork-image-content, #app-artwork-more{
		width: 100%;
		height: auto;
	}
	.app-artwork-author{
		width: 100%;
		padding: 0 1rem;
	}
	#app-artwork-image-description{
		flex-direction: column;
	}
}
@media (max-width: 992px){
	#app-artwork-image{
		box-shadow: none;
	}
}
@media (max-width: 600px){

	.image-simple-grid-content, #app-artwork-more{
		padding: 0;
	}
	#app-artwork-image{
		max-width: 100%;
		max-height: inherit;
	}
	#app-artwork-image-content{
		padding: 0;
	}
}
.artwork-actions{
	display: flex;
	align-items: center;
	cursor: default;
	padding-left: 1.5rem;
}
.artwork-like {
	cursor: pointer;
}
.artwork-like i{
	transition: linear all .2s;
}

.artwork-like:hover i, .artwork-like-count i, .artwork-like.artwork-like-active i{
	color: var(--red);
}
</style>
<?php module_start() ?>
<div id="app-artwork-image-info">
	<div id="app-artwork-image-content">
		<img id="app-artwork-image"  src="<?= base_url() ?>/images/artworks/<?= $artwork['accessname'].'.'.$artwork['extension'] ?>" alt="<?= $artwork['accessname'] ?>">
		<div id="app-artwork-image-description" class="container">
			<div class="app-artwork-author white-text">
				<div class="pb-4 r" style="display: flex; align-items: center; justify-content: flex-end">
					<div class="artwork-actions artwork-like-count">
						<i class="mdi mdi-heart-multiple mdi-24px"></i><span class="pl-2">{{artwork.heart_count}}</span>
					</div>
					<div class="artwork-actions artwork-like" :class="{'artwork-like-active': artwork.heart}" @click="trigger_heart">
						<i class="mdi mdi-24px" :class="artwork.heart ? 'mdi-heart' : 'mdi-heart-outline'"></i><span class="pl-2">ME GUSTA</span>
					</div>
				</div>
				<div id="app-author" class="white-text">
					<div class="author-avatar cover f-c"><?= $artwork['nickname'][0] ?></div>
					<div class="author-avatar-info">
						<h1><?= $artwork['name'] ?></h1>
						<div class="author-link">
							<span>por</span> <a class="white-text" href="<?= base_url().'/'.$artwork['account'] ?>"><h2>@<?= $artwork['nickname'] ?></h2></a>
						</div>

					</div>
				</div>
				<div class="pt-4 pb-4 white-text">
					<h3 class="title-4 m-0 py-4"> <i class="mdi mdi-book-information-variant"></i> Descripción de la obra</h3>
					<?= strlen($artwork['description']) == 0 ? 'No hay detalles sobre la obra' : $artwork['description'] ?>
				</div>

				<div class="card-panel">
					<?php if ($_ENV['CI_ENVIRONMENT'] == 'development'): ?>
						SISTEMA DE COMENTARIOS DISCUS
					<?php else: ?>
						<div id="disqus_thread"></div>
					<?php endif; ?>
				</div>




			</div>
		</div>
	</div>
	<div id="app-artwork-more">
		<div ref="sticky" class="sticky">

			<h4 class="title-4 p-4 m-0">Otros trabajos del autor</h4>
			<div  class="image-simple-grid-content" >
				<?php foreach ($others_artworks as $key => $other_artwork): ?>
						<?php
						$path = base_url().'/images/artworks_lite/'.$other_artwork['accessname'].'.'.$other_artwork['extension'];
						$path_url = base_url().'/artwork/view/'.$other_artwork['accessname']
						?>
						<a class="image-simple-grid" href="<?= $path_url ?>">
							<img src="<?= $path ?>" alt="">
						</a>
				<?php endforeach; ?>
			</div>
			<?php if ($_ENV['CI_ENVIRONMENT'] != 'development'): ?>
			<!--<adsense-ins class="adsbygoogle"
			     style="display:block"
			     data-ad-client="ca-pub-1355252812560688"
			     data-ad-slot="6521651482"
			     data-ad-format="auto"
			     data-full-width-responsive="true"></adsense-ins>-->
			<?php endif; ?>

		</div>


	</div>


</div>

<?php module_end() ?>

<script>
<?php if ($_ENV['CI_ENVIRONMENT'] != 'development'): ?>
	(function() { // DON'T EDIT BELOW THIS LINE
	var d = document, s = d.createElement('script');
	s.src = 'https://artsbook-site.disqus.com/embed.js';
	s.setAttribute('data-timestamp', +new Date());
	(d.head || d.body).appendChild(s);
	})();
<?php endif; ?>


$_module = {
	data: function () {
		return {
			artwork: <?= json_encode($artwork) ?>
		}
	},
	methods: {
		trigger_heart: function () {
			if (this.$root.trigger_like != undefined) this.$root.trigger_like(this.artwork)
			else console.log('FUNCTION LIKE NO FOUND');
		}
	},
	mounted: function () {
		new Stickyfill.Sticky(this.$refs.sticky);
	}
}

/**/
</script>
