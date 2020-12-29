<style media="screen">
	#app-module-content{
		background: var(--primary);
		color: white;
	}
	.versus-list{
		display: flex;
	}
	.versus-list-reverse{
		flex-direction: row-reverse;
	}
	.versus-list > div{
		width: 50%;
	}
</style>
<?php template_start() ?>
	<div class="">
		<?php $count = 0 ?>
		<?php foreach ($versus_list as $key => $versus): ?>
			<?php $count++ ?>
			<div class="versus-list <?= $count%2 == 0 ? 'versus-list-reverse' : '' ?>">
				<div class="versus-list-winner">
					GANADOR(ES) <br>
					<?php foreach ($versus as $key => $winner): ?>
						<?php if ($winner['is_winner'] == 1): ?>

							<img style="width: 260px" src="<?= base_url()."/images/artworks_lite/$winner[artwork].$winner[extension]" ?>" alt="artwork">

							<br>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
				<div class="versus-list-info">
					OTRAS PARTICIPACIONES <br>
					<?php foreach ($versus as $key => $others): ?>
						<img style="width: 100px" src="<?= base_url()."/images/artworks_lite/$others[artwork].$others[extension]" ?>" alt="artwork">
					<?php endforeach; ?>
				</div>
			</div>

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
