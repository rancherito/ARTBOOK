<?php
$access_account = is_self_account($info['account']);

?>
<script src="<?= base_url() ?>/libs/vueadvancedcropper/cropper.js?v=3" ></script>
<style media="screen">
:root{
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
#app-profile{
	position: relative;
	height: 100%;
	display: flex;
}
#app-profile-avatar {
	background: #ffffff17;
	width: 130px;
	height: 130px;
	border-radius: 50%;
	box-shadow: 0 0 0 8px rgba(255, 255, 255, .15);
	text-transform: uppercase;
}
#app-profile-avatar{
	height: 130px;
	width: 130px;
}
#user-avatar-img{
	width: 100%;
	border-radius: 50%;
}
#app-profile-decorator{
	padding-top: 1rem;
}
#app-profile-content > div{
	height: 200px;
}
#app-profile-nickname{
	padding-top: 1rem;
	text-transform: uppercase;
	letter-spacing: 2px;
}
#user_grid{
	width: calc(100% - var(--profile-user));
	height: 100%; padding: 1rem;
}
#user-profile-info{
	padding: 0 1rem;
	width: var(--profile-user);
	background-color: white;
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
.box-events{
	padding: .5rem 1rem;
	border-radius: 10px;
	border: 1px solid var(--primary);
	color: var(--primary);
	text-align: center;
}
.box-events span{
	display: flex;
	justify-content: center;
}
@media (max-width: 1200px) {
	.artwork-title{
		padding: 0;
	}
	#app-profile{
		flex-direction: column;
	}
	#user-profile-info{
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
	#user-profile-info{
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


<?php template_start(); ?>
<div id="app-profile">
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

	<?php endif; ?>

	<div id="user-profile-info">
		<div id="app-profile-content">
			<div class="f-c">
				<div id="app-profile-avatar" class="f-c">
					<?php if ($path_image == ''): ?>
						<span><?= $info['nickname'][0] ?></span>
					<?php else: ?>
						<img src="<?= $path_image ?>" id="user-avatar-img">
					<?php endif; ?>
				</div>
				<div id="app-profile-nickname"><?= $info['nickname'] ?></div>

			</div>
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
							 <?php foreach ($current_events as $key => $event): ?>
								<?php if ($event['is_voting'] == 0): ?>
									<a class="col s12 m6 xl12" href="<?= base_url() ?>/events/versus">
										<div class="box-events w100">
											<div class="combo-text-title"><?= $event['name'] ?></div>
											<span> <div>Fin en: </div><cg-countdown datestring="<?= $event['event_end'] ?>"></cg-countdown> </span>
										</div>
									</a>
								<?php else: ?>
									<a class="col s12 m6 xl12" href="<?= base_url() ?>/events/versus/<?= $event['event_tag'] ?>">
										<div class="box-events w100">
											<div class="combo-text-title"><?= $event['name'] ?></div>
											<span> <div>Fin en: </div><cg-countdown datestring="<?= $event['voting'] ?>"></cg-countdown> </span>
										</div>
									</a>
								<?php endif; ?>


							<?php endforeach; ?>
						 <?php endif; ?>

					</div>
				</div>
			</div>
		</div>
	</div>

	<simplebar id="user_grid">
		<cg-grid base_url="<?= base_url() ?>" ref='grid' @events_list="events_list" :images="list_img" :stack_size="stack" is_on_profile <?= $access_account ? 'is_on_account' : '' ?>></cg-grid>

	</simplebar>



</div>
<?php $template = template_end()?>
<script>



const $_module = {
	template: `<?= $template ?>`,
	mounted: function () {

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
