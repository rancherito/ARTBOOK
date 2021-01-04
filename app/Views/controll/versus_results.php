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
		<?php print_r($winners) ?>
		<section class="card-panel">

<pre class="">
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

		<?php foreach ($versus_list as $key => $versus): ?>
			<article class="card-panel">
				<?php foreach ($versus as $key => $participient): ?>
					<section class="versus-participient">
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

			</article>


		<?php endforeach; ?>


	</div>
<?php module_end() ?>

<script type="text/javascript">
	$_module = {
		mounted: function () {
			console.log('hola');
		}
	}
</script>
