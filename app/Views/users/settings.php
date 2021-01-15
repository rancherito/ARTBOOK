<script src="<?= base_url() ?>/libs/vueadvancedcropper/cropper.js?v=3" ></script>
<style media="screen">
#app-body{
	height: 100vh;
}
#settings{
	height: 100%;
	width: 100%;
	overflow: hidden;
	position: relative;
}

#settings-avatar-content{
	padding: 2rem;
	padding-top: 4rem;
}
#settings-field-content{
	border-radius: 1rem;
}
#settings-avatar-img{
	background-color: #0000001a;
	height: 110px;
	width: 110px;
	border-radius: 50%;
	font-size: 3rem;
	text-transform: uppercase;
	color: gray;
	position: relative;
}
#settings-avatar-img img{
	width: 100%;
	height: 100%;
	border-radius: 50%;
}
#settings-decorations{
	position: absolute;
	right: 0;
	height: 100vh;
	width: calc(100vw - 500px);
}
#settings-decorations > img{
	position: relative;
}
#settings-field-content{
	padding: 2rem;
}
#settings-field-content form{
	max-width: 360px;
	width: 100%;
}
#settings-field-actions{
	display: flex;
	align-items: center;
	justify-content: space-between;
}
#settings-back-account{
	position: absolute;
	top: 1rem;
	right: 1rem;
}
#settings-take-newavatar{
	background: red;
	height: 42px;
	width: 42px;
	border-radius: 50%;
	position: absolute;
	font-size: 1.5rem;
	bottom: 0;
	right: 0;
	color: white;
	background-color: lightgray;
	cursor: pointer;
}
#settings-cropper{
	top: 0;
	left: 0;
	bottom: 0;
	right: 0;
	position: fixed;
	background-color: white;
}
#settings-cropper-avatar{
	height: calc(100% - 56px)
}
#settings-cropper-buttons{
	text-align: center;
	padding: .5rem
}
#app-module{
	height: 100%;
}
#modal_avatar{
	max-width: 400px;
	width: 100%;
	max-height: 400px;
	height: 100%;
}
@media (max-width: 600px) {
	#modal_avatar{
		position: fixed;
		top: 0 !important;
		bottom: 0;
		left: 0;
		right: 0;
		transform: translateY(0) !important;
		height: auto;
		max-height: inherit;
	}
}
canvas{
	image-rendering: optimizeSpeed;             /* Older versions of FF          */
	image-rendering: -moz-crisp-edges;          /* FF 6.0+                       */
	image-rendering: -webkit-optimize-contrast; /* Safari                        */
	image-rendering: -o-crisp-edges;            /* OS X & Windows Opera (12.02+) */
	image-rendering: pixelated;                 /* Awesome future-browsers       */
	-ms-interpolation-mode: nearest-neighbor;   /* IE                            */
}
</style>
<?= module_start() ?>
	<div id="settings">
		<div id="modal_avatar" ref="modal_avatar" class="modal" style="">

			<div id="settings-cropper" class="p-4">
				<div id="settings-cropper-avatar" class="f-c p-4">
					<cropper
					ref="cropper"
					:default-size="defaultSize"
					:stencil-props="{handlers: {},movable: false,scalable: false, aspectRatio: 1}"
					default-boundaries="fill"
					:src="img" @change="change_image" image-restriction="stencil" stencil-component="circle-stencil"></cropper>
					<div class="pt-4 w100">
						<input type="range" v-model="zoom" min="0" max="99">
					</div>
				</div>
				<div id="settings-cropper-buttons">
					<button class="btn" @click="sendimage" :disabled="image_send == null">ACEPTAR</button>
					<a class="modal-close btn-flat">CANCELAR</a>
				</div>
			</div>

		</div>

		<div class="f-c">
			<a id="settings-back-account" href="<?= user_site() ?>" class="btn-icon btn-light"><i class="mdi mdi-close mdi-18px"></i></a>
			<div id="settings-avatar-content" class="f-c">
				<div id="settings-avatar-img" class="f-c">
					<span style="display: none" v-show="avatar_image == null"><?= user_nickname()[0] ?></span>
					<img style="display: none" v-show="avatar_image" :src="avatar_image">
					<label id="settings-take-newavatar" class="f-c">
						<input type="file" style="display: none" @change="upload_avatar" accept="image/x-png,image/jpeg">
						<i class="mdi mdi-camera f-c"></i>
					</label>
				</div>

			</div>
			<div id="settings-field-content" class="f-c w100">
				<!--<form @submit.prevent="submitinsta" class="f-b">
					<i class="mdi mdi-instagram mdi-24px"></i>
					<cg-field :watchisvalid.sync="instagram_url.isvalid" required empty v-model="instagram_url.val" placeholder="ingrese la url de su Instagram" sizechars="15-60" label="Instagram url" style="flex: 1;" class="mx-4 mt-5"></cg-field>
					<button type="submit" class="btn">
						<i class="mdi mdi-content-save mdi-18px"></i>
					</button>
				</form>-->
				<form id="tatat" @submit.prevent="submit" autocomplete="off">
					<cg-field required label="Nickname" name="<?= rand() ?>" placeholder="ignrese nickname" v-model="nickname.val" sizechars="4-16" :watchisvalid.sync="nickname.isvalid"></cg-field>
					<cg-field autocomplete="off" type="password" name="<?= rand() ?>" required v-model="new_password.val" sizechars="4-20" :empty="!isNewPassword" :watchisvalid.sync="new_password.isvalid" v-show="isNewPassword" label="Nueva contraseña" placeholder="ignrese Contraseña"></cg-field>
					<cg-field autocomplete="off" type="password" name="<?= rand() ?>" required v-model="old_password.val" sizechars="4-20" :watchisvalid.sync="old_password.isvalid"  label="Ingrese contraseña para validar" placeholder="ignrese Contraseña"></cg-field>
					<div id="settings-field-actions">
						<label>
							<input type="checkbox" class="filled-in" v-model="isNewPassword" >
							<span>Editar clave</span>
						</label>
						<button type="submit" class="btn" :disabled="!isValid">SALVAR</button>
					</div>
				</form>

			</div>
		</div>

	</div>
<?php module_end() ?>
<script type="text/javascript">
$_module = {
	data: function() {
		return {
			instagram_url: {val: '', isvalid: false},
			modal_avatar: null,
			isNewPassword: false,
			showpass: false,
			old_password: {val: '', isvalid: false},
			new_password: {val: '', isvalid: false},
			nickname: {val: '<?= user_nickname() ?>', isvalid: false},
			img: null,
			isOpeneditor: false,
			image_send: null,
			avatar_image: <?= $path_image ?>,
			zoom: 0
		}
	},
	computed: {
		isValid: function () {
			return this.old_password.isvalid && this.new_password.isvalid && this.nickname.isvalid
		}
	},
	watch: {
		zoom: function (newvalue, oldvalue) {
			const ov = oldvalue/100
			const nv = newvalue/100
			const cropper = this.$refs.cropper;
			  if (cropper) {
				if (cropper.imageSize.height < cropper.imageSize.width) {
				  const minHeight = cropper.sizeRestrictions.minHeight;
				  cropper.zoom(
					((1 - ov) * cropper.imageSize.height + minHeight) /
					  ((1 - nv) * cropper.imageSize.height + minHeight)
				  );
				} else {
				  const minWidth = cropper.sizeRestrictions.minWidth;
				  cropper.zoom(
					((1 - ov) * cropper.imageSize.width + minWidth) /
					  ((1 - nv) * cropper.imageSize.width + minWidth)
				  );
				}
			  }
		}
	},
	methods: {

		defaultSize({ imageSize }) {
		  return {
			width: Math.min(imageSize.height, imageSize.width),
			height: Math.min(imageSize.height, imageSize.width),
		  };
		},
		upload_avatar: function (e) {
			if (e.target.files[0]) this.loadFile(e.target.files[0])
			this.isOpeneditor = true;
			if (this.modal_avatar) {
				this.modal_avatar.modal('open')
			}
		},
		loadFile: function (file) {
			this.img = null
			const reader = new FileReader();

			reader.addEventListener("load", e => {
				this.img = reader.result
			}, false);
			reader.readAsDataURL(file);
		},
		change_image: function ({coordinates, canvas}) {

			let c = canvas.width > 300 ? downScaleCanvas(canvas,300/canvas.width) : canvas
			this.image_send = c.toDataURL('image/jpeg', 0.8)
		},
		sendimage: function () {
			const data = {image: this.image_send};
			$.post('<?= base_url() ?>/services/user/avatarsave', data, (res) => {
				if (res.path_image) {
					M.toast({html: 'Exito al guardar imagen', classes: 'rounded'})
					this.isOpeneditor = false
					this.modal_avatar.modal('close')
					this.avatar_image = res.path_image
				}

			})
		},
		submit: function () {
			if (this.isValid) {
				const data = {
					old: this.old_password.val,
					new: this.new_password.val,
					is_new: this.isNewPassword ? 1 : 0,
					nickname: this.nickname.val
				}
				$.post('<?=  base_url() ?>/user/editinfo', data, (data) => {
					M.toast({html: (data.change != 'OK' ? 'ERROR: virifique contraseña' : 'Exito al Modificar'), classes: 'rounded'+ (data.change != 'OK' ? ' bg-alert' : '')})

				})
			}

		}
	},
	mounted: function () {
		this.modal_avatar = $(this.$refs.modal_avatar).modal();
		//modal.modal('open');
	}
}
</script>
