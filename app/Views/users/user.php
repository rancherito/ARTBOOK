<?php
$access_account = !empty($_SESSION['access']['account']) && $_SESSION['access']['account'] == $info['account'] && $_SESSION['access']['validate'] != 0;

?>
<script src="<?= base_url() ?>/libs/vueadvancedcropper/cropper.js?v=3" ></script>
<style media="screen">
:root{
	--aside-user: 380px;
}
#user_header{
	position: relative;
}
#user-content{
	margin-left: var(--aside-user);
}
#user_header_info_content{
	position: relative;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	color: white;

}

.content-grid{
	position: relative;
	padding: 2rem;
}

#user_options{
	z-index: 2;
	width: 100%;
	padding: 2rem;
	display: flex;
	position: relative;
}
#user-profile{
	position: fixed;
	width: 100%;
	max-width: var(--aside-user);
	top: 0;
	bottom: 0;
	left: 0;
	background: #15202b;
	z-index: 3;
}
#user-profile-decorator{
	position: absolute;
	top: 300px;
	height: calc(100% - 300px);
	width: 100%;
	background: #15202b;
	border-radius: 0 100px 0 0;
}
#user-profile-conent{
	color: white;
	padding: 1rem;
	position: relative;
}
#user-profile-conent > div{
	height: 300px;
}
#app-content{
	background:
	#111a23;
}
.cg-grid-wrapper-img{
	color: white;
}
.bg_full_default{
	opacity: 0.2;
	height: 400px;
}
#user-profile-avatar{
	background: #ffffff17;
	width: 140px;
	height: 140px;
	border-radius: 50%;
	box-shadow: 0 0 0 8px #ffffff0a;
	text-transform: uppercase;
}
#user-profile-avatar{
	font-family: Calibri;
	font-size: 2rem;
}
#user-avatar-img{
	width: 100%;
	border-radius: 50%;
}
#user-profile-nickname{
	padding-top: 2rem;
	letter-spacing: 4px;
	text-transform: uppercase;
}
#user-profile-description{
	padding: 2rem;
	color: white;
}
div#user_options + div#user-profile-description{
	padding-top: 0;
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
@media (max-width: 992px) {
	#user-profile-decorator{
		height: auto;
		position: relative;
		top: 0;
		background: #111a23;
	}

	#user-profile{
		position: relative;
		width: 100%;
		max-width: 100%;
	}
	#user-content{
		margin-left: 0;
	}
}
@media (max-width: 600px) {

	#user_info_photo{
		height: 110px;
		width: 110px;
	}

}
</style>
<style media="screen">

</style>

<?php template_start(); ?>
<div>
	<?php if ($access_account): ?>
		<div id="modal1" class="modal" style="max-width: 400px">
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

	<div id="user-profile">
		<?= bg_default() ?>
		<div id="user-profile-conent">
			<div class="f-c">
				<div id="user-profile-avatar" class="f-c">
					<?php if ($path_image == ''): ?>
						<span><?= $info['nickname'][0] ?></span>
					<?php else: ?>
						<img src="<?= $path_image ?>" id="user-avatar-img">
					<?php endif; ?>
				</div>
				<div id="user-profile-nickname"><?= $info['nickname'] ?></div>

			</div>
		</div>
		<div id="user-profile-decorator" >
			<div id="user_header">

				<?php if ($access_account): ?>
					<div id="user_options">
						<a class="mr-2 btn-icon btn-dark" href="<?= base_url() ?>/user/settings">
							<i class="mdi mdi-cog mdi-18px"></i>
						</a>
						<a class="mr-2 btn btn-dark" @click="openeditor">
							<i class="mdi mdi-upload left"></i>
							<span>SUBIR ARTWORK</span>
						</a>
					</div>
				<?php endif; ?>

				<div id="user-profile-description">
					<div class="title-3">Bienvenido</div>
					<p>
						Espero que disfrutes tu estadia en mi perfil de trabajos, subo contenido regularmente

					</p>


				</div>
			</div>
		</div>
	</div>
	<div id="user-content">


		<div class="content-grid">
			<cg-grid ref='grid' @changeimage="modify_image" @events_list="events_list" :images="list_img" :stack_size="stack" is_on_profile <?= $access_account ? 'is_on_account' : '' ?>></cg-grid>
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
		echo "this.modal = $('.modal').modal();";
	}

	?>

},
data: function () {
	return {
		list_img: <?= json_encode($images_list) ?>,
		autoraccess: [],
		stack: 280,
		modal: null,
		list_events: null,
		image_apply: null,
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
		this.image_apply = image
		$.get('<?= base_url() ?>/service/events/apply_list', (res_list) => {
			let findartwork = false;

			for (var item of res_list) if (item.artwork == image.artwork) {findartwork = true; this.list_events = [item];}

			if (!findartwork) this.list_events = res_list;

			if (this.modal) this.modal.modal('open')

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
