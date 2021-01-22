<?php
	$instagram = '';
	foreach ($social as $key => $url) {
		if ($url['type_socialnetwork'] == 'INSTA') $instagram = $url['url'];
	}
 ?>
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
	padding: 0 2rem;
	margin: 0 auto;
	position: relative;
}
#settings-field-content{
	border-radius: 1rem;
}
#settings-avatar-img{
	background-color: rgba(0,0,0,0.2);
	height: 110px;
	width: 110px;
	border-radius: 50%;
	font-size: 3rem;
	text-transform: uppercase;
	color: gray;
	position: relative;
	margin: 0 auto;
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
	padding: 1rem 2rem;
}
#settings-field-content form{
	max-width: 360px;
	width: 100%;
}
#settings-field-actions{
	display: flex;
	align-items: center;
	justify-content: flex-end;
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

		<div>
			<h3 class="p-6">PERFIL DE USUARIO</h3>
			<div class="" style="max-width: 400px; width: 100%">
				<div id="settings-avatar-content">

					<div id="settings-avatar-img" class="f-c">
						<span style="display: none" v-show="avatar_image == null"><?= user_nickname()[0] ?></span>
						<img style="display: none" v-show="avatar_image" :src="avatar_image">
						<label id="settings-take-newavatar" class="f-c">
							<input type="file" style="display: none" @change="upload_avatar" accept="image/x-png,image/jpeg">
							<i class="mdi mdi-camera f-c"></i>
						</label>
					</div>

				</div>
				<div id="settings-field-content" class="w100">
					<form @submit.prevent="submit_perfil" class="f-b">
						<i class="mdi mdi-account mdi-24px"></i>
						<cg-field name="<?= rand() ?>" :watchisvalid.sync="nickname.isvalid" required v-model="nickname.val" placeholder="ingrese nombre de usuario" sizechars="4-30" label="Nombre de usuario" style="flex: 1;" class="mx-4 mt-5"></cg-field>
						<button type="submit" class="btn" :disabled="!isValidAccount">
							<i class="mdi mdi-content-save mdi-18px"></i>
						</button>
					</form>
					<form @submit.prevent="submitinsta" class="f-b">
						<i class="mdi mdi-instagram mdi-24px"></i>
						<cg-field name="<?= rand() ?>" :watchisvalid.sync="instagram_url.isvalid" required v-model="instagram_url.val" placeholder="ingrese la el nombre de usuario de su Instagram" sizechars="4-60" label="Nombre de usuario Instagram " style="flex: 1;" class="mx-4 mt-5"></cg-field>
						<button type="submit" class="btn" :disabled="!isValidaInsta">
							<i class="mdi mdi-content-save mdi-18px"></i>
						</button>
					</form>

					<br>
					<br>
					<label class="w100">
						<input type="checkbox" class="filled-in" v-model="isNewPassword" >
						<span>Editar contraseña</span>
					</label>
					<form id="tatat" @submit.prevent="submit" autocomplete="off" style="display: none" v-show="isNewPassword">
						<cg-field autocomplete="off" type="password" name="<?= rand() ?>" required v-model="old_password.val" sizechars="4-20" :watchisvalid.sync="old_password.isvalid"  label="Contraseña actual" v-show="isNewPassword" placeholder="ignrese Contraseña"></cg-field>
						<cg-field autocomplete="off" type="password" name="<?= rand() ?>" required v-model="new_password.val" sizechars="4-20" :empty="!isNewPassword" :watchisvalid.sync="new_password.isvalid" v-show="isNewPassword" label="Nueva contraseña" placeholder="ignrese Contraseña"></cg-field>

						<div id="settings-field-actions">
							<button type="submit" class="btn" :disabled="!isValid"><i class="mdi mdi-content-save mdi-18px right"></i> <span>SALVAR</span> </button>
						</div>
					</form>
					<br>
					<br>
					<div class="w100 r">
						<a href="<?= user_site() ?>" class="btn">TERMINAR</a>
					</div>

				</div>
			</div>

		</div>

	</div>
<?php module_end() ?>
<script type="text/javascript">
$_module = {
	data: function() {
		return {
			instagram_url: {val: '<?= $instagram ?>', isvalid: false},
			nickname: {val: '<?= user_nickname() ?>', isvalid: false},
			modal_avatar: null,
			isNewPassword: false,
			showpass: false,
			old_password: {val: '', isvalid: false},
			new_password: {val: '', isvalid: false},
			img: null,
			isOpeneditor: false,
			image_send: null,
			avatar_image: <?= $path_image ?>,
			zoom: 0,
			reg_insta: new RegExp(/^(?!.*\.\.)(?!.*\.$)[^\W][\w.]{0,29}$/, 'igm')
		}
	},
	computed: {
		isValid: function () {
			return this.old_password.isvalid && this.new_password.isvalid
		},
		isValidaInsta: function () {
			return this.instagram_url.isvalid && this.instagram_url.val.match(this.reg_insta) != null
		},
		isValidAccount: function () {
			return this.nickname.isvalid
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
		submit_perfil: function () {
			const send = {account: '<?= user_account() ?>', nickname: this.nickname.val}
			$.post('<?= base_url() ?>/service/user/nickname/save', send, (req) => {
				if (req.message != undefined) {
					switch (req.message) {
						case 'OK': M.toast({html: 'Usuario GUARDADO', classes: 'rounded'}); break;
						case 'EXISTS': M.toast({html: 'Usuario ya existe o usado', classes: 'rounded'}); break;
						case 'CHARS_NOT_VALID': M.toast({html: 'Caracteres no validos', classes: 'rounded'}); break;
						case 'ERROR_DATA': M.toast({html: 'ERROR ingrese más tarde', classes: 'rounded'}); break;
					}
				}
				else M.toast({html: 'ERROR ingrese más tarde', classes: 'bg-alert rounded'})
			})
		},
		submitinsta: function () {
			if (this.isValidaInsta) {
				const send = {account: '<?= user_account() ?>', url: this.instagram_url.val};
				$.post('<?= base_url() ?>/service/user/sn_insta/save', send, (req) => {
					if (req.message != undefined) M.toast({html: 'Usuario de instagram GUARDADO', classes: 'rounded'})
					else M.toast({html: 'ERROR INTENTELO MÁS TARDE', classes: 'bg-alert'})
				})
			}
		},
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
					account: '<?= user_account() ?>'
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
