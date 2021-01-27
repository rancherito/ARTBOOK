<?php style_start() ?>
<style media="screen">
	#app-dashboard-user{
		display: flex;
		min-height: 100vh;
	}
	#app-dashboard-user-extra{
		width: 340px;
	}
	#app-dashboard-user-general-gallery{
		width: calc(100% - 340px)
	}
	.card-event{
		background-color: #212121;
		color: white;
		position: relative;
	}
	.card-event-type{
		position: absolute;
		right: -.125rem;
		top: 1.5rem;
		color: white;
		padding: .125rem .5rem;
		border-radius: 2px 0 0 2px;
	}
</style>
<?php style_end() ?>
<?php module_start() ?>
	<div id="app-dashboard-user">
		<div id="app-dashboard-user-extra" style="background: #2d2d2d">
			<h4 class="white-text pt-4 px-4 c"><i class="mdi mdi-fire"></i> EVENTOS</h4>
			<div class="p-4 sticky">

				<?php foreach ($current_events as $key => $event): ?>
					<div class="card-panel card-event">
						<div class="card-event-type <?= $event['type_event'] == 1 ? 'bg-primary' : 'bg-secondary' ?>">
							<?= $event['type_event'] == 1 ? 'RETO' : 'V S' ?>
						</div>
						<h5 class="c"><?= $event['name'] ?></h5>
						<div class="py-4">
							<div class="f-b">
								<div><i class="secondary mdi mdi-plex mdi-18px mr-2"></i> Inicio</div>
								 <?= dateFormatDefault($event['event_start'])?>
							</div>
							<div class="f-b">
								<div>
									<i class="secondary mdi mdi-vote  mdi-18px mr-2"></i> Votación
								</div>
								<?= dateFormatDefault($event['voting'])?>
							</div>
							<div class="f-b">
								<div class="">
									<i class="secondary mdi mdi-flag  mdi-18px mr-2"></i> Fin
								</div>
								<?= dateFormatDefault($event['event_end'])?>
							</div>
						</div>
						<div class="c">
							<a href="<?= base_url()."/events".'/'.($event['type_event'] == 1 ? "challenge" : 'versus').'/'.$event['event_tag'] ?>" class="btn btn-small">
								IR AL EVENTO
							</a>
						</div>

					</div>
				<?php endforeach; ?>

			</div>

		</div>
		<div id="app-dashboard-user-general-gallery">
			<div class="">
				<h3 class="title-4 pt-4 px-4"><i class="mdi mdi-new-box"></i> NUEVOS</h3>
				<div class="p-4">
					<slider-feed-nartwork-container :data="images_feed">
						<?php foreach ($images_feed as $key => $artwork): ?>
							<div class="slider-feed-nartwork">
								<img src="<?= base_url()."/images/artworks_lite/$artwork[accessname].$artwork[extension]" ?>" alt="<?= $artwork['name'] ?>">
							</div>
						<?php endforeach; ?>
					</slider-feed-nartwork-container>
				</div>

			</div>
			<h3 class="title-4 px-4"><i class="mdi mdi-apps"></i> EXPLORAR</h3>
			<div class="p-4">
				<cg-grid :images="list_img" :stack_size="stack" :base_url="$root.base_url"></cg-grid>
			</div>
		</div>


	</div>


<?php module_end() ?>
<?php script_start() ?>
<script type="text/javascript">
	$_module = {
		data(){
			return {
				list_img: <?= json_encode($images_list) ?>,
				images_feed: <?= json_encode($images_feed) ?>,
				stack: this.$root.is_mobile ? 170 : 260
			}
		}
	}
</script>
<?php script_end() ?>
