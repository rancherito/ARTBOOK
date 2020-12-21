<?php
$access_account = !empty($_SESSION['access']['account']) && $_SESSION['access']['account'] == $info['account'] && $_SESSION['access']['validate'] != 0;

?>
<script src="<?= base_url() ?>/libs/vueadvancedcropper/cropper.js?v=3" ></script>
<style media="screen">
:root{
	--aside-user: 80px;
	--profile-user: 320px;
}
.user-events-list{
	border-radius: 5px;
	padding: 1rem;
	border: 1px solid #f3f3f3;
	margin-top: .5rem;
	position: relative;
}
.user-apply-image{
	position: absolute;
	top: 1rem;
	right: 1rem;
	transform: scale(.8);
	transform-origin: top right;
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
#user_content_app{

}
#user-content{
	height: 100%;
	position: absolute;
	top: 0;
	bottom: 0;
	left: var(--aside-user);
	right: 0;
	padding: 1rem 1rem 1rem 0;

}
#content-grid{
	height: 100%;
	overflow: hidden;
	background: #f9f9f9;
	padding: 1rem 0.5rem;
	border-radius: 10px;
	position: relative;
}
#content-grid::before{
	position: absolute;
	top: 0;
	bottom: 0;
	left: 0;
	width: var(--profile-user);
	background-color: white;
	content: '';
	z-index: 0;
}
#app-aside-nav{
	height: 100%;
	width: var(--aside-user);
	padding: 1rem 0;
	color: white;
	position: relative;
}
#app-aside-nav-avatar {
	background: #ffffff17;
	width: 130px;
	height: 130px;
	border-radius: 50%;
	box-shadow: 0 0 0 8px rgba(255, 255, 255, .15);
	text-transform: uppercase;
}
#app-aside-nav-avatar{
	height: 130px;
	width: 130px;
}
#user-avatar-img{
	width: 100%;
	border-radius: 50%;
}
#app-aside-nav-decorator{
	padding-top: 1rem;
}
#app-aside-nav-conent > div{
	height: 200px;
}
#app-aside-nav-nickname{
	padding-top: 1rem;
	text-transform: uppercase;
	letter-spacing: 2px;
}
#user_grid{
	margin-left: var(--profile-user);
}
#user_profile{
	position: fixed;
	left: 6rem;
	top: 2rem;
	padding: 1rem;
	padding-left: 0;
	width: var(--profile-user);
}
#app-aside-decorator{
	height: 160px;
}
#app-aside-decorator img{
	width: 50%;
}
.access-btn{
	display: flex;
	color: white;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	cursor: pointer;
	transition: linear all .2s;
	height: 90px;
	width: 100%;
}
.access-btn span{
	font-size: .8rem;
}
.access-btn i{
	font-size: 1.8rem;
}
.access-btn:hover{
	background: rgba(255, 255, 255, 0.1);
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
#app-aside-nav-toggle{
	position: absolute;
	right: 0;
	top: 50%;
	transform: translate(calc(100% - 1px), 50%);
	z-index: 1;
	height: 50px;
	width: 40px;
	align-items: center;
	justify-content: center;
	border-radius: 0 30px 30px 0;
	cursor: pointer;
	display: none;
}
#app-aside-nav-toggle i{
	transform: translateX(-10%);
	font-size: 1.6rem;
}
.modal-image-preview{
	width: calc(100% - 360px);
	background: black;
	position: relative;
}
.modal-image-preview img{
	width: 100%;
	height: 100%;
}
.modal-image-preview img:nth-child(1){
	object-fit: cover;
	opacity: .4
}
.modal-image-preview img:nth-child(2){
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
@media (max-width: 1200px) {
	.artwork-title{
		padding: 0;
	}
	#user_profile{
		position: relative;
		width: 100%;
		margin: 0;
		top: 0;
		left: 0;
		background-color: white;
		border-radius: 10px;
	}
	#user_grid{
		margin-left: 0;
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
	#app-aside-nav-toggle{
		display: flex;
	}
	#bar-grid{
		padding: 0;
	}
	#user_profile{
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
	#app-aside-nav{
		background-color: var(--primary);
		z-index: 2;
		transform: translateX(-100%);
	}
	.app-aside-nav-close#app-aside-nav{
		transform: translateX(0);
	}
	#user-content{
		left: 0;
	}
}
</style>


<?php template_start(); ?>
<div class="bg-primary fixed-full" id="user_content_app">
	<?php if ($access_account): ?>
		<div id="modal_image" ref="modal_openimage" class="modal">
			<a id="settings-back-account" class="modal-close btn-icon btn-light"><i class="mdi mdi-close mdi-18px"></i></a>
			<div>
				<div class="modal-image-preview">
					<template v-if="image_apply != null">
						<img :src="image_apply.path" alt="image fill">
						<img :src="image_apply.path" alt="image preview">
					</template>
				</div>
				<div class="modal-image-info-content">
					<div class="title-4 combo-text-title artwork-title">TITULO</div>
					<div v-if="image_apply != null" style="position: relative">{{image_apply.name}}</div>
					<br>
					<div class="user-events-list" v-for="event of list_events">

						<div v-if="dateCheck(event.event_start, event.voting, image_apply.uploaded_date)" class="btn user-apply-image" @click="apply_artwork(event)" :disabled="event.is_artwork_register == 1">{{event.is_artwork_register ? 'Registrado' : 'Adjuntar'}}</div>
						<div>
							<div class="combo-text-title title-4">{{event.name}}</div>
							<span>{{event.name_event}}</span>
						</div>
						<div class="f-b pt-2">
							<div>Promotor {{event.nickname_promoter}}</div>
							<div>Evento {{event.type_event}}</div>
						</div>
						<div v-if="!dateCheck(event.event_start, event.voting, image_apply.uploaded_date)" class="red-text">
							Fecha de registro fuera de este evento
						</div>
					</div>
				</div>

			</div>

		</div>
		<div id="modal1" ref="modal-events" class="modal" style="max-width: 400px">
			<div class="modal-content" >
				<div class="title-3 combo-text-title">Lista de eventos </div>
				<span>Eventos a los que me he inscrito</span>
				<div class="user-event-image-preview" v-if="image_apply != null">
					<div class="cover" :style="{'background-image': 'url(' + image_apply.path + ')'}"></div>
					<span class="f-c">
						<?= bg_animate_001() ?>
						<div style="position: relative">{{image_apply.name}}</div>
					</span>
				</div>
				<div class="user-events-list" v-for="event of list_events">

					<div v-if="dateCheck(event.event_start, event.voting, image_apply.uploaded_date)" class="btn user-apply-image" @click="apply_artwork(event)" :disabled="event.is_artwork_register == 1">{{event.is_artwork_register ? 'Registrado' : 'Adjuntar'}}</div>
					<div>
						<div class="combo-text-title title-4">{{event.name}}</div>
						<span>{{event.name_event}}</span>
					</div>
					<div class="f-b pt-2">
						<div>Promotor {{event.nickname_promoter}}</div>
						<div>Evento {{event.type_event}}</div>
					</div>
					<div v-if="!dateCheck(event.event_start, event.voting, image_apply.uploaded_date)" class="red-text">
						Fecha de registro fuera de este evento
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<a class="modal-close waves-effect btn-flat">CERRAR</a>

			</div>
		</div>
	<?php endif; ?>

	<div id="app-aside-nav" class="f-c f-b" :class="{'app-aside-nav-close': toggle_nav}">
		<div id="app-aside-nav-toggle" class="bg-primary" @click="toggle_nav = !toggle_nav">
			<i class="mdi mdi-menu"></i>
		</div>
		<div class="f-c w100">
			<div id="app-aside-decorator" class="f-c">
				<img src="<?= base_url() ?>/images/icon_white.svg">
			</div>
			<a class="access-btn" href="<?= base_url() ?>">
				<i class="mdi mdi-home"></i>
				<span>INICIO</span>
			</a>
			<?php if ($access_account): ?>
				<a class="access-btn" href="<?= base_url() ?>/user/settings">
					<i class="mdi mdi-cog"></i>
					<span>OPCCIONES</span>
				</a>
				<a class="access-btn" @click="openeditor">
					<i class="mdi mdi-upload"></i>
					<span>SUBIR</span>
				</a>
			<?php else: ?>
				<a class="access-btn" href="<?= base_url() ?>/user/login">
					<i class="mdi mdi-account"></i>
					<span>Acceder</span>
				</a>
			<?php endif; ?>

		</div>
		<div class="w100">
			<?php if ($access_account): ?>
				<a class="access-btn" href="<?= base_url() ?>/user/close">
					<i class="mdi mdi-power-standby"></i>
				</a>
			<?php endif; ?>

		</div>
	</div>
	<div id="user-content">


		<div id="content-grid">
			<simplebar id="bar-grid">
				<div id="user_feed">
					<div id="user_profile">
						<div id="app-aside-nav-conent">
							<div class="f-c">
								<div id="app-aside-nav-avatar" class="f-c">
									<?php if ($path_image == ''): ?>
										<span><?= $info['nickname'][0] ?></span>
									<?php else: ?>
										<img src="<?= $path_image ?>" id="user-avatar-img">
									<?php endif; ?>
								</div>
								<div id="app-aside-nav-nickname"><?= $info['nickname'] ?></div>

							</div>
						</div>
						<div id="app-aside-nav-decorator" >
							<div id="user_header">

								<div id="app-aside-nav-description" class="c">
									<div class="title-3">Bienvenido</div>
									<p>
										Espero que disfrutes tu estadia en mi perfil de trabajos, subo contenido regularmente

									</p>


								</div>
							</div>
						</div>
					</div>
					<cg-grid id="user_grid" ref='grid' @changeimage="modify_image" @events_list="events_list" :images="list_img" :stack_size="stack" is_on_profile <?= $access_account ? 'is_on_account' : '' ?>></cg-grid>

				</div>

			</simplebar>

		</div>
		<upload-editor base_url="<?=base_url()?>" ref="editor" :autors="autoraccess" @onfinish="onfinish"></upload-editor>
	</div>

</div>
<?php $template = template_end()?>
<script>



const $_module = {
	template: `<?= $template ?>`,
	mounted: function () {
		/*const body = $(document.body);
		this.stack = body.width() > 600 ? 320 : (body.width() > 300 ? 170 : 260);
		window.addEventListener('resize', () => {
		this.stack = body.width() > 600 ? 320 : (body.width() > 300 ? 170 : 260);
	});*/
	<?php
	if ($access_account) {
		echo "this.autoraccess.push({id_user: 'current', nickname: 'current'});";
		echo "this.modal = $(this.\$refs['modal-events']).modal();";
		echo "this.modal_openimage = $(this.\$refs['modal_openimage']).modal();";

	}

	?>

},
data: function () {
	return {
		list_img: <?= json_encode($images_list) ?>,
		autoraccess: [],
		stack: 260,
		modal: null,
		modal_openimage: null,
		list_events: null,
		image_apply: null,
		toggle_nav: false
	}
},
methods: {
	apply_artwork: function (event_info) {
		const data = {versus: event_info.versus, artwork: this.image_apply.artwork}

		$.post('<?= base_url() ?>/service/events/apply_versus', data, (res) => {
			$.get('<?= base_url() ?>/service/events/apply_list', (res_list) => {
				let findartwork = false;
				for (var item of res_list) if (item.artwork == this.image_apply.artwork) {findartwork = true; this.list_events = [item];}
				if (!findartwork) this.list_events = res_list;
			})
		})
	},
	events_list: function (image) {
		if (this.modal_openimage) this.modal_openimage.modal('open')
		this.image_apply = image
		$.get('<?= base_url() ?>/service/events/apply_list', (res_list) => {
			let findartwork = false;

			for (var item of res_list) if (item.artwork == image.artwork) {findartwork = true; this.list_events = [item];}

			if (!findartwork) this.list_events = res_list;



		})

	},
	dateCheck: function(from,to,check) {
		let [fDate,lDate,cDate] = [Date.parse(from), Date.parse(to), Date.parse(check)]
		return (cDate <= lDate && cDate >= fDate);
	},
	modify_image: function (data) {
		this.$refs.editor.open()
		this.$refs.editor.setData({
			author: 'current',
			description: data.description,
			name: data.name,
			id: data.id_image,
			img: data.img,
			extension: data.extension
		})
	},
	onfinish: function (data) {
		<?php if ($access_account): ?>
		$.post('<?= base_url() ?>/services/artworks/recover',{account: '<?= $_SESSION['access']['account'] ?>'}, (res) => {
			this.list_img = res;
		})
		<?php endif; ?>

	},
	openeditor: function () {
		this.$refs.editor.open()
		this.$refs.editor.newRegister()
	},

}
}

</script>
