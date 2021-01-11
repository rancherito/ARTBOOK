<?php
	//print_r($winners);
 ?>

<style media="screen">
	#app-module-content{
		background: var(--primary);
		color: white;
	}
	.versus-list{
		display: flex;
		flex-direction: column;
		align-items: center;
		padding: 3rem 0;
	}
	.versus-list-reverse{
		/*flex-direction: row-reverse;*/
	}
	.versus-list > div{
	}
	.versus-list-winner{
		text-align: center;
	}
	.versus-list-winner-artworks{
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.versus-list-winner-artworks img{
		margin: 0 .5rem;
		border-radius: 10px;
	}
	.versus-list-info > div{
		display: flex;
		justify-content: space-around;
		width: 100%;
	}
	.versus-list-info-participient{
		display: flex;
		align-items: center;
		padding: .5rem 2rem;
		flex-direction: column;
		position: relative;
	}
	.versus-list-info-participient > *{
		width: 100%;
	}
	.versus-list-info-participient-wrap-artwork{
		width: 100px;
		height: 100px;
		position: relative;
		margin-bottom: 1rem;
	}
	.versus-list-info-description{
		width: 100%;
		text-align: center;
	}
	.versus-list-info-participient img:nth-child(1){
		width: 100%;
		display: block;
		border-radius: 10px;
	}
	.versus-list-name{
		padding: 2rem 0;
		display: flex;
		justify-content: center;
	}
	.versus-list-name h4{
		margin-top: -4px;
		font-size: 2rem
	}
	.versus-list-name img{
		height: 80px;
	}
	img.versus-list-medal{
		position: absolute;
		width: 60px;
		bottom: -10px;
		right: 0;
	}
	.scroll-indicator{
		position: fixed;
		top: 50%;
		right: 100px;
		padding: 1rem;
		overflow: hidden;
		transform: translate(0, -50%);
		display: flex;
		flex-direction: column;
	}
	a.scroll-indicator-target{
		background-color: rgba(255,255,255,0.2);
		width: 8px;
		height: 8px;
		border-radius: .5rem;
		overflow: hidden;
		margin: .5rem 0;
		transition: linear all .2s
	}
	a.scroll-indicator-target-active{
		height: 2rem;
		background-color: white;
	}
	#app-event-versus-presentation{
		padding: 10rem 1rem 4rem;
	}
	#app-event-versus-presentation img{
		width: 180px;
	}
	#app-event-versus-presentation div{
		letter-spacing: 4px;
	}
	@media (max-width: 1200px) {
		#app-event-versus-presentation{
			padding: 4rem 1rem 2rem;
		}
		.versus-list-winner-artworks img{
			width: 300px;
			height: 300px;
			object-fit: cover;
		}
		.scroll-indicator{
			right: 2rem;
		}
	}
	@media (max-width: 600px) {
		.versus-list-winner-artworks{
			flex-direction: column;
			padding: 1rem;
		}
		.versus-list-winner-artworks img{
			margin: .5rem 0;
			width: 100%;
			height: auto;

		}
		.versus-list-info > div{
			flex-direction: column;
			justify-content: flex-start;
		}
		.versus-list-info-participient{
			flex-direction: row;
		}
		.versus-list > div{
			width: 100%;
		}
		.versus-list-info-description{
			width: calc(100% - 100px)
		}
		.scroll-indicator {
		    right: 1rem;
		}
	}
</style>
<?php module_start() ?>
<div ref="scroll">
		<div class="f-c" id="app-event-versus-presentation">
			<img src="<?= base_url() ?>/images/logo_white.svg" alt="logo">
			<h1 class="c">
				<div class="title-4">EVENTO DE VERSUS</div>
				<span class="title-1" style="margin-top: -.5rem; display: block"><?= $data['name'] ?></span>
			</h1>
			<p style="max-width: 900px" class="c px-4">
				Este es un evento de participacion de artistas promovido por la comunidad de Artsbook de artistas para artistas, esperamos que disfrutes de los trabajos presentados durante este evento.
			</p>
		</div>
		<div  class="scroll-position">
			<div class="scroll-indicator">
				<a v-for="n of anchor_access" :href="'#' + (n - 1) + '_pos'" class="scroll-indicator-target" :class="{'scroll-indicator-target-active': (n - 1) == access_pos}"></a>
			</div>
			<?php $count = 0 ?>
			<?php foreach ($versus_list as $key => $versus): ?>
				<?php $count++ ?>
				<article class="versus-list container <?= $count%2 == 0 ? 'versus-list-reverse' : '' ?>">
					<div class="versus-list-winner">
						<div class="versus-list-name">
							<span><img src="<?= base_url() ?>/images/corona_left.svg" alt=""></span>
							<div class="pb-4">
								<div class="title-5"><?php echo count($winners[$key]) > 1 ? 'GANADORES' : 'GANADOR' ?> VERSUS</div>
								<h4 class="title-4"><?php print_r($winners[$key][0]['versus_name']) ?></h4>
							</div>
							<span><img src="<?= base_url() ?>/images/corona_right.svg" alt=""></span>
						</div>

						<div class="versus-list-winner-artworks">
							<?php foreach ($winners[$key] as $key2 => $winner): ?>
								<?php if (isMovil()): ?>
									<img src="<?= base_url()."/images/artworks/$winner[artwork].$winner[extension]" ?>" alt="artwork">
								<?php else: ?>
									<img src="<?= base_url()."/images/artworks_lite/$winner[artwork].$winner[extension]" ?>" alt="artwork">
								<?php endif; ?>

							<?php endforeach; ?>
						</div>
					</div>
					<div class="versus-list-info">
						<h4 class="c pt-4"><?= $versus[0]['total_participients'] == 1 ? 'Ganador por default' : 'Raking de este versus' ?> </h4>

						<div class="">
							<?php foreach ($versus as $key => $others): ?>
								<div class="versus-list-info-participient">
									<div class="versus-list-info-participient-wrap-artwork">
										<img src="<?= base_url()."/images/artworks_lite/$others[artwork].$others[extension]" ?>" alt="artwork">
										<img class="versus-list-medal" src="<?= base_url()."/images/medalla_$others[ranking].svg" ?>" alt="medalla">
									</div>
									<div class="versus-list-info-description">
										<div class="title-5 combo-text-title"><?= $others['artwork_name'] ?></div>
										<span class="versus-list-artist">por <a href="<?= base_url()."/$others[account]" ?>"><?= $others['nickname'] ?></a> </span>
										<a class="btn-flat white mt-2" href="<?= base_url()."/artwork/view/$others[artwork]" ?>">ver artwork</a>
									</div>
								</div>

							<?php endforeach; ?>
						</div>

					</div>
				</article>
			<?php endforeach; ?>
		</div>

</div>

<?php module_end() ?>
<script type="text/javascript">
	$_module = {
		data: function () {
			return {
				scroll: null,
				sections: null,
				anchor_access: 0,
				access_pos: 0
			}
		},
		methods: {
			calcule_pos: function (){

					this.sections.each((i, el) => {
						const eTop = $(el).offset().top
						const relativeTop = (eTop - $(window).scrollTop());
						const middleScreen = $(window).height() / 2
						if (relativeTop > (0 - middleScreen) && relativeTop <= middleScreen) {
							this.access_pos = i
						}
					});

			}
		},
		mounted: function () {
			this.scroll = $('#app-body');
			this.sections = this.scroll.find('article');
			this.anchor_access = this.sections.length;
			this.sections.each((i, el) => {
				$(el).attr('id', i+'_pos')
			});
			this.calcule_pos()
			let s = this.scroll
			s.scroll((e) => {
				this.calcule_pos()
			})



		}
	}
</script>
