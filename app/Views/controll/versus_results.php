<style media="screen">
	.card-panel{
		box-shadow: none;
		border-radius: 10px;
	}
	#c-app-title{
		display: flex;
		align-items: center;
	}
	#c-app-title a{
		transform: scale(.8);
		transform-origin: center left;
	}
	.versus-participient{
		display: flex;
		align-items: center;
		padding: .5rem 0;
	}
	.versus-participient-artwork img{
		width: 90px;
		border-radius: 10px;
		margin-right: 1rem;
	}
	frame-winner, .frame-winner{
		width: 200px;
	}
</style>
<?php module_start() ?>
	<div id="app-events">
		<br>
		<div id="c-app-title" class="pb-4">
			<a href="<?= base_url() ?>/c/events" class="btn-flat mr-4">
				<i class="mdi mdi-arrow-left"></i>
			</a>
			<div class="title-2">RESULTADO VERSUS</div>
		</div>
		<?php foreach ($versus_list as $key => $versus): ?>
			<article class="card-panel">
				<?php foreach ($versus as $key => $participient): ?>
					<?php if ($participient['ranking'] == '1'): ?>
						<section class="versus-participient col s12 m6 l4" >
							<frame-winner versus="<?= $participient['versus_name'] ?>" artwork="<?= base_url()."/images/artworks_lite/$participient[artwork].$participient[extension]" ?>"></frame-winner>
							<div>ARTISTA: <?= $participient['nickname'] ?></div>
						</section>
					<?php endif; ?>

				<?php endforeach; ?>
				<div class="row m-0">
					<?php foreach ($versus as $key => $participient): ?>
						<section class="versus-participient col s12 m6 l4" >
							<div class="versus-participient-artwork">
								<img src="<?= base_url()."/images/artworks_lite/$participient[artwork].$participient[extension]" ?>" alt="">
							</div>
							<div>
								<div>
									ARTISTA: <?= $participient['nickname'] ?>
								</div>

								<div class="">
									OBRA: <?= $participient['artwork_name'] ?>
								</div>
								<div class="">
									RAKING: <?= $participient['ranking'] ?>
								</div>
								<div>
									VOTOS: <?= $participient['votes'] ?>
								</div>
							</div>
						</section>
					<?php endforeach; ?>
				</div>


			</article>


		<?php endforeach; ?>

<br>
<div class="title-4">
	TEXTO PARA WHATSAPP
</div>
		<section class="card-panel">

<pre class="">
(っ◔◡◔)っ 🗳️ *RESUMEN* 🗳️

┌⌯━━━━━━⊰⍣⊱━━━━━━⌯┐
       GANADORES
└⌯━━━━━━⊰⍣⊱━━━━━━⌯┘

⋆◦⋅⍣⋅◦⋆ ⋆◦⋅⍣⋅◦⋆ ⋆◦⋅⍣⋅◦⋆
</pre>
			<?php foreach ($winners as $key => $versus): ?>
<pre>
🎖️ VERSUS 🎖️
✨ <?= '*'.$versus[0]['versus_name']."*" ?> ✨

</pre>
				<?php foreach ($versus as $key => $winner): ?>
<pre>

<?= '*'.$winner['nickname']."*\n" ?>
<?php if ($winner['total_participients'] == 1): ?>
_Ganador por default_
<?php else: ?>
Ganador con <?= $winner['votes'] ?> votos
<?php endif; ?>

ARTBOOK LINK:
▪️<?= base_url().'/'.$winner['account']."\n" ?>
</pre>
				<?php endforeach; ?>
<pre>

⋆◦⋅⍣⋅◦⋆ ⋆◦⋅⍣⋅◦⋆ ⋆◦⋅⍣⋅◦⋆

</pre>
			<?php endforeach; ?>
<pre>

*Felicidades a los ganadores, sus dibujos serán publicados en la página de Instagram del grupo*
</pre>
		</section>




	</div>
<?php module_end() ?>
<?php
$path = 'images/frame.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
?>
<script type="text/javascript">
	Vue.component('frame-winner',{
		template: `
			<canvas class="frame-winner" ref="canvas" style="background: gray" height="432" width="432"></canvas>
		`,
		data: function () {
			return {
				frame: '<?= $base64 ?>',
				cc: 0
			}
		},
		props: ['artwork', 'versus'],
		methods: {
			draw: function (ctx, artwork, image) {
				ctx.drawImage(artwork, 16, 16)
				ctx.drawImage(image, 0, 0)

				/*ctx.beginPath();
				ctx.moveTo(52,380);
				ctx.lineTo(220,380);
				ctx.lineWidth = 36;
				ctx.strokeStyle = '#1c1c1c';
				ctx.lineCap = 'round';
				ctx.stroke();*/
				ctx.font = "18px Calibri";
				ctx.fillStyle = 'white';
				ctx.fillText(this.versus.toLocaleUpperCase(), 66, 389);
			}
		},
		mounted: function () {
			const canvas = this.$refs.canvas;
			const ctx = canvas.getContext('2d');
			let image = new Image();
			let artwork = new Image();
			artwork.src = this.artwork
			image.src = this.frame

			artwork.onload = () => {
				this.cc++
				if (this.cc == 2) this.draw(ctx, artwork, image)
			}
			image.onload = () => {
				this.cc++
				if (this.cc == 2) this.draw(ctx, artwork, image)
			}



		}
	});
	$_module = {
		mounted: function () {

		}
	}
</script>
