<style media="screen">
	.avatar{
		height: 50px;
		width: 50px;
		font-family: Calibri;
		font-size: 2rem;
		background-color: var(--primary);
		color: white;
		border-radius: 50%;
		text-transform: uppercase;
	}
	.app-vs-participients-artwork{
		width: 80px;
		height: 80px;
		background-color: var(--light-gray);
		border-radius: 10px;
	}
</style>
<?php module_start() ?>
<div class="">
	<h4 class="py-4">VERSUS: <?= $event['name'] ?></h4>

	<p><?= $event['description'] ?></p>
	<i>FIN: <?= $event['event_end'] ?></i>
	<?php foreach ($versus as $key => $list): ?>
		<section class="card-panel">
			<h4><i class="mdi mdi-code-greater-than"></i> <?= $list[0]['versus_name'] ?></h4>
			<i><?= $list[0]['description'] ?></i>
			<br><br>
			<?php foreach ($list as $key => $participient): ?>
				<div class="f-b" style="align-items: flex-start">
					<div>
						<avatar avatar="<?= account_avatar($participient['user_avatar']) ?>" nickname="<?= $participient['nickname'] ?>"></avatar>
					</div>
					<div style="flex: 1" class="pl-4">
						<div class="">
							<i class="mdi mdi-account"></i> ARTISTA: <a target="_blank" href="<?= base_url().'/'.$participient['account'] ?>"><?= $participient['nickname'] ?></a>
						</div>
						<div class="">
							<i class="mdi mdi-image-edit"></i> REGISTRO DE DIBUJO: <?= $participient['is_artwork_register'] == '1' ? 'SI' : 'NO' ?>
						</div>
						<div class="">
							<i class="mdi mdi-calendar"></i> FECHA SUBIDA: <?= $participient['create_date']?>
						</div>
						<div class="">
							<?php if ($participient['is_artwork_register'] == '1'): ?>
								<a target="_blank" href="<?= base_url().'/artwork/view/'.explode('.', $participient['artwork'])[0] ?>"><img class="app-vs-participients-artwork" src="<?= base_url()."/images/artworks_lite/$participient[artwork]" ?>"></a>
							<?php else: ?>
									<img class="app-vs-participients-artwork">
							<?php endif; ?>
						</div>
					</div>

				</div>

				<br>
			<?php endforeach; ?>
		</section>
	<?php endforeach; ?>
</div>
<?php module_end() ?>

<script type="text/javascript">
	Vue.component('avatar',{
		template: `<div class="avatar cover f-c" :style="calcule_avatar()">
			{{avatar? '' : (nickname ? nickname[0] : 'A')}}
		</div>`,
		props: ['nickname', 'avatar'],
		methods:{
			calcule_avatar: function () {
				return this.avatar ? {'background-image': 'url('+ this.avatar +')'} : {}
			}
		}
	})
	$_module = {

	}
</script>
