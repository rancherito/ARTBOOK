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
	}
	.versus-list-reverse{
		/*flex-direction: row-reverse;*/
	}
	.versus-list > div{
		width: 50%;
	}
	.versus-list-winner{
		text-align: center;
	}
	.versus-list-winner > div{
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.versus-list-info > div{
		display: flex;
		flex-direction: column;
	}
	.versus-list-info-participient{
		display: flex;
		align-items: center;
	}
	.title-5, h5{
		font-size: 1.1rem;
	}
</style>
<?php template_start() ?>
	<div class="">
		<?php $count = 0 ?>
		<?php foreach ($versus_list as $key => $versus): ?>
			<?php $count++ ?>
			<article class="versus-list <?= $count%2 == 0 ? 'versus-list-reverse' : '' ?>">
				<div class="versus-list-winner">
					<h4 class="title-4"><?php echo count($winners[$key]) > 1 ? 'GANADORES' : 'GANADOR' ?></h4>
					<div class="">
						<?php foreach ($winners[$key] as $key2 => $winner): ?>
							<?php if ($winner['ranking'] == 1): ?>

								<img src="<?= base_url()."/images/artworks_lite/$winner[artwork].$winner[extension]" ?>" alt="artwork">

							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="versus-list-info">
					<h5 class="title-5">OTRAS PARTICIPACIONES</h5>

					<div class="">
						<?php foreach ($versus as $key => $others): ?>
							<div class="versus-list-info-participient">
								<img style="width: 100px" src="<?= base_url()."/images/artworks_lite/$others[artwork].$others[extension]" ?>" alt="artwork">
								<div><?php print_r($others) ?></div>
							</div>

						<?php endforeach; ?>
					</div>

				</div>
			</article>

			<br>
			<br>
		<?php endforeach; ?>
	</div>
<?php $templade = template_end() ?>
<script type="text/javascript">
	$_module = {
		template: `<?= $templade ?>`
	}
</script>
