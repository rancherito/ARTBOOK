<style media="screen">
	.card-panel{
		box-shadow: none;
		border-radius: 10px;
	}
</style>
<?php module_start() ?>
	<div id="app-events">
		<div class="title-2">RESULTADO VERSUS</div>
		<span> <i>EN CONSTRUCCION</i> </span>
		<br>
		<?php foreach ($event_list as $key => $event): ?>
			<section class="card-panel">
			 	<b><div class="title-4"><?= $event['name'] ?></div></b>
				<div class="pb-2">
					<?php if (!empty($event['description'])): ?>
						<i><?= $event['description'] ?></i>
					<?php else: ?>
						<i>No hay descripción</i>
					<?php endif; ?>

				</div>
				<div class="">📆 FECHA INICIO: <?= $event['event_start'] ?></div>
				<div class="">📆 FECHA FIN: <?= $event['event_end'] ?></div>
				<div class="py-4">
					<?php $type_event = $event['type_event'] == '2' ? 'versus' : 'challenges' ?>
					<a href="<?= base_url()."/c/$type_event/participients?tag=".$event['event_tag'] ?>" class="btn bg-secondary">PARTICIPANTES</a>
					<a href="<?= base_url()."/c/$type_event/results?tag=".$event['event_tag'] ?>" class="btn">RESULTADOS</a>
				</div>
				<div class="">
					TIPO <i><?= $event['type_event_name'] ?></i>
				</div>
			</section>
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
