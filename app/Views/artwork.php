<style media="screen">
	#app-artwork{
		height: 100%;
	}
	#app-artwork-image-info{
		width: calc(100% - 400px);
		height: 100%;
	}
	#app-artwork-image-content{
		background: #2d2d2d;
		padding: 2rem;
	}
	#app-artwork-more{
		width: 400px;
		background: white;
		padding: 1rem;
		height: 100%;
		padding: 4rem 0;
	}
	#app-artwork-image{
		width: auto;
		max-width: 60%;
		display: block;
		margin: 0 auto;
	}
	#app-artwork-image-description{
		padding: 2rem;
	}
	.author-avatar{
		height: 70px;
		width: 70px;
		border-radius: 50%;
		background-color: var(--primary);
		font-size: 2rem;
		font-family: Calibri;
		color: white;
		text-transform: uppercase;
	}
	.author-avatar-info{
		width: calc(100% - 70px);
		padding-left: 1rem;
	}
	.author-avatar-info h1{
		font-size: 1.5rem;
		margin: 0;
	}
	.author-avatar-info h2{
		font-size: 1rem;
		margin: 0;
		color: black;
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
		position: relative;
		width: calc(50% - 2px);
		float: left;
		margin: 1px;
	}
	.image-simple-grid canvas{
		height: auto;
		display: block;
		width: 100%;
	}
	.image-simple-grid a{
		position: absolute;
		display: block;
		height: 100%;
		width: 100%;
		left: 0;
		top: 0;
	}
	.image-simple-grid-content{
		overflow: hidden;
		padding: 1rem;
	}
	@media (max-width: 1200px) {
		#app-artwork{
			flex-direction: column;

		}
		#app-artwork-image-info, #app-artwork-more{
			width: 100%;
			height: auto;
		}
		#app-artwork-more{
			padding: 1rem;
		}
	}
	@media (max-width: 600px){

		.image-simple-grid-content, #app-artwork-more{
			padding: 0;
		}
		#app-artwork-image{
			max-width: 100%;
		}
		#app-artwork-image-content{
			padding: 0;
		}
	}
</style>
<?php template_start() ?>
	<div id="app-artwork" class="f-b">
		<simplebar id="app-artwork-image-info">
			<div id="app-artwork-image-content">
				<img id="app-artwork-image"  src="<?= base_url() ?>/images/artworks/<?= $artwork['accessname'].'.'.$artwork['extension'] ?>" alt="<?= $artwork['accessname'] ?>">
			</div>
			<div id="app-artwork-image-description" class="container">
				<div class="author f-b">
					<div class="author-avatar cover f-c">C</div>
					<div class="author-avatar-info">
						<h1><?= $artwork['name'] ?></h1>
						<div class="author-link">
							<span>por</span> <a href="<?= base_url().'/'.$artwork['account'] ?>"><h2><?= $artwork['nickname'] ?></h2></a>
						</div>

					</div>
				</div>
				<div class="pt-4">
					<h3 class="title-4 m-0">Detalles</h3>
					<?= strlen($artwork['description']) == 0 ? 'No hay detalles sobre la obra' : $artwork['description'] ?>
				</div>

			</div>

		</simplebar>
		<simplebar id="app-artwork-more">
			<h4 class="title-4 p-4 m-0">Otros trabajos del autor</h4>
			<div class="image-simple-grid-content" >
				<?php foreach ($others_artworks as $key => $other_artwork): ?>
					<div class="image-simple-grid">
						<canvas width="160" height="160"></canvas>
						<?php
							$path = base_url().'/images/artworks/'.$other_artwork['accessname'].'.'.$other_artwork['extension'];
							$path_url = base_url().'/artwork/view/'.$other_artwork['accessname']
						?>
						<a href="<?= $path_url ?>" class="cover" style="background-image: url('<?= $path ?>')"></a>
					</div>
				<?php endforeach; ?>
			</div>

		</simplebar>
	</div>
<?php $template = template_end() ?>

<script>
	$_module = {
		template: `<?= $template ?>`
	}
</script>
