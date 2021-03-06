<?php
$access_account = is_self_account($info['account']);
$instagram = '';
foreach ($social as $key => $url) {
	if ($url['type_socialnetwork'] == 'INSTA') $instagram = $url['url'];
}

?>
<script src="<?= base_url() ?>/libs/vueadvancedcropper/cropper.js?v=3" ></script>
<style media="screen">
:root{
	--profile-user: 320px;
}
body{

}
.user-event-image-preview{
	height: 80px;
	display: flex;
	overflow: hidden;
	border-radius: 5px;
}
.user-event-image-preview > div{
	width: 80px;
	height: 80px;
	object-fit: cover;
	image-rendering: auto;
}
.user-event-image-preview span{
	flex: 1;
	background-color: var(--primary);
	color: white;
	letter-spacing: 2px;
	position: relative;
}
#app-user-card{
	display: none;
}
#content-grid{
	height: 100%;
	overflow: hidden;
	background: #f9f9f9;
	padding: 1rem 0.5rem;
	border-radius: 10px;
	position: relative;
}
#app-module-content, body{
	background: white;
}
#app-profile{
	position: relative;
	display: flex;
	min-height: 100%;
}
#app-profile-avatar {
	background: rgba(0,0,0,0.1);
	width: 130px;
	height: 130px;
	border-radius: 50%;
	box-shadow: 0 0 0 8px rgba(255, 255, 255, .15);

}
#app-profile-avatar span{
	font-size: 3rem;
	font-family: Calibri;
	font-weight: lighter;
	text-transform: uppercase;
	color: white;
}
#user-avatar-img{
	width: 100%;
	border-radius: 50%;
}
#app-profile-decorator{
	padding-top: 1rem;
}
#app-profile-content > div{
	height: 216px;
	padding-top: 3rem;
}
#app-profile-nickname{
	padding-top: 1rem;
	text-transform: uppercase;
	letter-spacing: 2px;
}
#user_grid{
	width: calc(100% - var(--profile-user));
	background: var(--light-gray);
}
#app-profile-info{
	padding: 0 1rem;
	width: var(--profile-user);
	background-color: white;
	position: relative;
	min-height: 100%;
}
#app-profile-info-edit{
	position: absolute;
	top: 1rem;
	right: 1rem;
}

#modal_image{
	width: 1000px;
	height: 600px;
	overflow: hidden;
	border-radius: 10px;
}
#modal_image > div{
	height: 100%;
	display: flex;
}

.modal-image-preview{
	width: calc(100% - 360px);
	background: black;
	position: relative;
}
.modal-image-preview img{
	width: 100%;
	height: 100%;
	object-fit: contain;
	position: absolute;
	top: 0;
	left: 0;
}
.modal-image-info-content{
	width: 360px;
	padding: 1rem;
}
#bar-grid{
	height: 100%; padding: 0 0.5rem;
}
#settings-back-account {
	position: absolute;
	top: 1rem;
	right: 1rem;
	z-index: 2;
}
.artwork-title{
	padding-top: 2rem;
}
.box-events{
	padding: .5rem 1rem;
	border-radius: 10px;
	border: 1px solid var(--primary);
	color: var(--primary);
	text-align: center;
	margin: 1px 0;
}
.box-events span{
	display: flex;
	justify-content: center;
}
.app-profile-social{
	display: flex;
	justify-content: center;
	margin-top: .5rem;
}
.app-profile-social a{
	display: flex;
	align-items: center;
}
.app-profile-social a i{
	padding-right: .5rem;
}
@media (max-width: 1200px) {
	.artwork-title{
		padding: 0;
	}
	#app-profile{
		flex-direction: column;
	}
	#app-profile-info{
		position: relative;
		width: 100%;
		margin: 0;
		top: 0;
		left: 0;
		background-color: white;
		border-radius: 10px;
	}
	#user_grid{
		width: 100%;
		height: auto;
		padding: 0;
	}
	#content-grid::before{
		height: 0;
		width: 0;
	}

}
@media (max-width: 992px) {

	.modal-image-preview, .modal-image-info-content{
		width: 100%;
	}
	.btn-light{
		color: white;
	}
	.modal-image-preview{
		height: 300px;
	}
	#modal_image{
		max-width: 400px;
		width: 100%;
		height: auto;
	}
	#modal_image > div{
		flex-direction: column;
	}
}
@media (max-width: 600px) {

	#bar-grid{
		padding: 0;
	}
	#app-profile-info{
		padding: 1rem;
		border-radius: 0;
	}
	#user-content{
		padding: 0;
	}
	#content-grid{
		border-radius: 0;
		padding: 0;
	}

	#user-content{
		left: 0;
	}
}
</style>


<?php module_start(); ?>
<div id="app-profile">
	<?php if ($access_account): ?>
		<div id="modal_image" ref="modal_openimage" class="modal">
			<template v-if="artwork_apply.artwork != undefined">
				<a id="settings-back-account" class="modal-close btn-icon btn-light"><i class="mdi mdi-close mdi-18px"></i></a>
				<div>
					<div class="modal-image-preview">
						<template>
							<img :src="$root.base_url + '/images/artworks_small/' + artwork_apply.artwork + '.' + artwork_apply.extension " alt="image preview">
						</template>
					</div>
					<div class="modal-image-info-content">
						<div class="title-4 combo-text-title artwork-title">TITULO</div>
						<div style="position: relative">{{artwork_apply.name}}</div>
						<br>
						<event-list></event-list>
					</div>

				</div>
			</template>


		</div>

	<?php endif; ?>

	<div id="app-profile-info">
		<div ref="styky" class="sticky">
			<?php if (is_self_account($info['account'])): ?>
				<a class="btn" id="app-profile-info-edit" href="<?= base_url() ?>/user/settings">
					<i class="mdi mdi-account-edit mdi-18px"></i>
				</a>
			<?php endif; ?>
			<div id="app-profile-content">
				<div class="f-c">
					<div id="app-profile-avatar" class="f-c">
						<?php if ($path_image == ''): ?>
							<span><?= $info['nickname'][0] ?></span>
						<?php else: ?>
							<img src="<?= $path_image ?>" id="user-avatar-img">
						<?php endif; ?>
					</div>
					<h1 class="title-4" id="app-profile-nickname"><?= $info['nickname'] ?></h1>

				</div>
			</div>
			<div class="app-profile-social">
				<?php if ($access_account): ?>
					<?php if ($instagram == ''): ?>
						<a href="<?= base_url() ?>/user/settings" class="grey-text"><i class="mdi mdi-instagram mdi-18px"></i>Instagram</a>
					<?php else: ?>
						<a href="https://www.instagram.com/<?= $instagram ?>" target="_blank" class="primary"><i class="mdi mdi-instagram mdi-18px"></i><?= $instagram ?></a>
					<?php endif; ?>
				<?php elseif($instagram != ''): ?>
					<a href="https://www.instagram.com/<?= $instagram ?>" target="_blank" class="primary"><i class="mdi mdi-instagram mdi-18px"></i><?= $instagram ?></a>
				<?php endif; ?>
			</div>
			<div id="app-profile-decorator" >
				<div id="user_header">

					<div id="app-profile-description" class="c">
						<div class="title-3">Bienvenido</div>
						<p>
							Espero que disfrutes tu estadia en mi perfil de trabajos, subo contenido regularmente

						</p>

						<div class="row">
							<?php if ($access_account): ?>
								<template v-if="vs_register.length" v-for="vs of vs_register">
									<div class="col s12 m6 xl12 mb-2">
										<div class="w100 p-4" style="background-color: var(--light-gray)">
											<div class="W100 f-b">
												<img v-if="vs.is_artwork_register == 1" width="46" :src="$root.base_url + '/images/artworks_lite/' + vs.artwork + '.' + vs.extension" class="pr-2">
												<div class="l" style="flex: 1">
													<div class="combo-text-title">{{vs.name}}</div>
													<span>{{vs.name_event}}</span>
												</div>
											</div>
											<div class="pt-1 w100 f-b" style="font-size: .7rem">
												<span>{{vs.is_artwork_register == 1? 'artwork ok': 'artwork pendiente'}}</span>
												<span>{{vs.type_event}}</span>
											</div>
										</div>
									</div>
								</template>
							<?php endif; ?>
						</div>
						<?php if ($_ENV['CI_ENVIRONMENT'] != 'development'): ?>
							<!--<adsense-ins class="adsbygoogle"
							style="display:inline-block;width:260px;height:260px"
							data-ad-client="ca-pub-1355252812560688"
							data-ad-slot="5744606495"></adsense-ins>-->
						 <?php endif; ?>
					</div>
				</div>
			</div>
		</div>

	</div>

	<cg-grid id="user_grid" style="min-height: 100vh;" ref='grid' :images="list_img" :stack_size="stack" is_on_profile <?= $access_account ? 'is_on_account' : '' ?>></cg-grid>

</div>
<?php module_end()?>
<script>


$_module = {
	mounted: function () {
		new Stickyfill.Sticky(this.$refs.styky);
		<?php
		if ($access_account) {
			echo "this.modal_openimage = $(this.\$refs['modal_openimage']).modal();";
		}

		?>

	},
	computed: {
		artwork_apply: function(){
			return this.$root.event_vs_artwork_apply_user
		},
		vs_register(){
			return this.$root.event_vs_register_user;
		}
	},
	data: function () {
		return {
			list_img: <?= json_encode($images_list) ?>,
			stack: this.$root.is_mobile ? 160 : 260,
			modal_openimage: null,
			toggle_nav: false
		}
	},
	methods: {
		dateCheck: function(from,to,check) {
			let [fDate,lDate,cDate] = [Date.parse(from), Date.parse(to), Date.parse(check)]
			return (cDate <= lDate && cDate >= fDate);
		},

		onfinish: function (data) {
			<?php if ($access_account): ?>
			$.post('<?= base_url() ?>/services/artworks/recover',{account: '<?= $_SESSION['access']['account'] ?>'}, (res) => {
				this.list_img = res;
			})
			<?php endif; ?>

		}


	}
}

</script>
