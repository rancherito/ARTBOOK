<?php
$access = $_SESSION['access'];
$nickname = $access['nickname'];
$url = $access['account_site'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta name="robots" content="noindex,nofollow" />

	<?php
	include APPPATH.'Views/layouts_parts/header.php';
	?>
	<script type="text/javascript">
	function downScaleCanvas(cv, scale) {
		if (!(scale < 1) || !(scale > 0)) throw ('scale must be a positive number <1 ');
		var sqScale = scale * scale; // square scale = area of source pixel within target
		var sw = cv.width; // source image width
		var sh = cv.height; // source image height
		var tw = Math.floor(sw * scale); // target image width
		var th = Math.floor(sh * scale); // target image height
		var sx = 0, sy = 0, sIndex = 0; // source x,y, index within source array
		var tx = 0, ty = 0, yIndex = 0, tIndex = 0; // target x,y, x,y index within target array
		var tX = 0, tY = 0; // rounded tx, ty
		var w = 0, nw = 0, wx = 0, nwx = 0, wy = 0, nwy = 0; // weight / next weight x / y
		// weight is weight of current source point within target.
		// next weight is weight of current source point within next target's point.
		var crossX = false; // does scaled px cross its current px right border ?
		var crossY = false; // does scaled px cross its current px bottom border ?
		var sBuffer = cv.getContext('2d').
		getImageData(0, 0, sw, sh).data; // source buffer 8 bit rgba
		var tBuffer = new Float32Array(3 * tw * th); // target buffer Float32 rgb
		var sR = 0, sG = 0,  sB = 0; // source's current point r,g,b
		/* untested !
		var sA = 0;  //source alpha  */

		for (sy = 0; sy < sh; sy++) {
			ty = sy * scale; // y src position within target
			tY = 0 | ty;     // rounded : target pixel's y
			yIndex = 3 * tY * tw;  // line index within target array
			crossY = (tY != (0 | ty + scale));
			if (crossY) { // if pixel is crossing botton target pixel
				wy = (tY + 1 - ty); // weight of point within target pixel
				nwy = (ty + scale - tY - 1); // ... within y+1 target pixel
			}
			for (sx = 0; sx < sw; sx++, sIndex += 4) {
				tx = sx * scale; // x src position within target
				tX = 0 |  tx;    // rounded : target pixel's x
				tIndex = yIndex + tX * 3; // target pixel index within target array
				crossX = (tX != (0 | tx + scale));
				if (crossX) { // if pixel is crossing target pixel's right
					wx = (tX + 1 - tx); // weight of point within target pixel
					nwx = (tx + scale - tX - 1); // ... within x+1 target pixel
				}
				sR = sBuffer[sIndex    ];   // retrieving r,g,b for curr src px.
				sG = sBuffer[sIndex + 1];
				sB = sBuffer[sIndex + 2];

				/* !! untested : handling alpha !!
				sA = sBuffer[sIndex + 3];
				if (!sA) continue;
				if (sA != 0xFF) {
				sR = (sR * sA) >> 8;  // or use /256 instead ??
				sG = (sG * sA) >> 8;
				sB = (sB * sA) >> 8;
			}
			*/
			if (!crossX && !crossY) { // pixel does not cross
				// just add components weighted by squared scale.
				tBuffer[tIndex    ] += sR * sqScale;
				tBuffer[tIndex + 1] += sG * sqScale;
				tBuffer[tIndex + 2] += sB * sqScale;
			} else if (crossX && !crossY) { // cross on X only
				w = wx * scale;
				// add weighted component for current px
				tBuffer[tIndex    ] += sR * w;
				tBuffer[tIndex + 1] += sG * w;
				tBuffer[tIndex + 2] += sB * w;
				// add weighted component for next (tX+1) px
				nw = nwx * scale
				tBuffer[tIndex + 3] += sR * nw;
				tBuffer[tIndex + 4] += sG * nw;
				tBuffer[tIndex + 5] += sB * nw;
			} else if (crossY && !crossX) { // cross on Y only
				w = wy * scale;
				// add weighted component for current px
				tBuffer[tIndex    ] += sR * w;
				tBuffer[tIndex + 1] += sG * w;
				tBuffer[tIndex + 2] += sB * w;
				// add weighted component for next (tY+1) px
				nw = nwy * scale
				tBuffer[tIndex + 3 * tw    ] += sR * nw;
				tBuffer[tIndex + 3 * tw + 1] += sG * nw;
				tBuffer[tIndex + 3 * tw + 2] += sB * nw;
			} else { // crosses both x and y : four target points involved
				// add weighted component for current px
				w = wx * wy;
				tBuffer[tIndex    ] += sR * w;
				tBuffer[tIndex + 1] += sG * w;
				tBuffer[tIndex + 2] += sB * w;
				// for tX + 1; tY px
				nw = nwx * wy;
				tBuffer[tIndex + 3] += sR * nw;
				tBuffer[tIndex + 4] += sG * nw;
				tBuffer[tIndex + 5] += sB * nw;
				// for tX ; tY + 1 px
				nw = wx * nwy;
				tBuffer[tIndex + 3 * tw    ] += sR * nw;
				tBuffer[tIndex + 3 * tw + 1] += sG * nw;
				tBuffer[tIndex + 3 * tw + 2] += sB * nw;
				// for tX + 1 ; tY +1 px
				nw = nwx * nwy;
				tBuffer[tIndex + 3 * tw + 3] += sR * nw;
				tBuffer[tIndex + 3 * tw + 4] += sG * nw;
				tBuffer[tIndex + 3 * tw + 5] += sB * nw;
			}
		} // end for sx
	} // end for sy

	// create result canvas
	var resCV = document.createElement('canvas');
	resCV.width = tw;
	resCV.height = th;
	var resCtx = resCV.getContext('2d');
	var imgRes = resCtx.getImageData(0, 0, tw, th);
	var tByteBuffer = imgRes.data;
	// convert float32 array into a UInt8Clamped Array
	var pxIndex = 0; //
	for (sIndex = 0, tIndex = 0; pxIndex < tw * th; sIndex += 3, tIndex += 4, pxIndex++) {
		tByteBuffer[tIndex] = Math.ceil(tBuffer[sIndex]);
		tByteBuffer[tIndex + 1] = Math.ceil(tBuffer[sIndex + 1]);
		tByteBuffer[tIndex + 2] = Math.ceil(tBuffer[sIndex + 2]);
		tByteBuffer[tIndex + 3] = 255;
	}
	// writing result to canvas.
	resCtx.putImageData(imgRes, 0, 0);
	return resCV;
}
</script>
<script src="<?= base_url() ?>/libs/vueadvancedcropper/cropper.js?v=2" ></script>
<style media="screen">
#settings-bg-content, body,#settings{
	height: 100vh;
	width: 100vw;
	overflow: hidden;
	position: relative;
}
#settings-bg-content{
	position: absolute;
	height: 100%;
	width: 100%;
	transform: scale(1.2);
}
#settings-bg-content img{
	object-fit: cover;
	height: 100%;
	width: 100%;
	filter: blur(10px);
}
#settings-bg-content::after{
	content: '';
	position: absolute;
	left: 0;
	right: 0;
	top: 0;
	bottom: 0;
	background: var(--primary);
	opacity: .4
}
#settings-content{
	position: absolute;
	right: 0;
	background: white;
	max-width: 500px;
	width: 100%;
	height: 100%;
	padding: 1rem;
}
#settings-avatar-content{
	height: 240px;
}
#settings-field-content{
	border-radius: 1rem;
	background: white;
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
	max-width: 500px;
	width: 100%;
	height: 100vh;
	position: fixed;
	right: 0;
	background-color: white;
}
#settings-cropper-avatar{
	height: calc(100% - 56px)
}
#settings-cropper-buttons{
	text-align: center;
	padding: .5rem
}
@media (max-width: 600px) {

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
</head>
<body>
	<div id="settings">
		<div id="settings-decorations" class="f-c">
			<div id="settings-bg-content">
				<img src="<?= base_url() ?>/images/bg_003.jpg" alt="">
			</div>
			<img src="<?= base_url() ?>/images/logo.svg" class="animated zoomInLeft">
		</div>

		<div id="settings-content"  class="f-c">
			<a id="settings-back-account" href="<?= $url ?>" class="btn-icon btn-light"><i class="mdi mdi-close mdi-18px"></i></a>
			<div id="settings-avatar-content" class="f-c">
				<h5 class="pb-4">Modificar mi cuenta</h5>
				<div id="settings-avatar-img" class="f-c">
					<span style="display: none" v-show="avatar_image == null"><?= $nickname[0] ?></span>
					<img style="display: none" v-show="avatar_image" :src="avatar_image">
					<label id="settings-take-newavatar" class="f-c">
						<input type="file" style="display: none" @change="upload_avatar" accept="image/x-png,image/jpeg">
						<i class="mdi mdi-camera f-c"></i>
					</label>
				</div>

			</div>
			<div id="settings-field-content" class="f-c w100">
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
		<div id="settings-cropper"  style="display: none" v-show="isOpeneditor">
			<div id="settings-cropper-avatar" class="f-c p-4">
				<cropper :stencil-props="{handlers: {},movable: false,scalable: false, aspectRatio: 1}" :src="img" @change="change_image" image-restriction="stencil" stencil-component="circle-stencil"></cropper>
			</div>
			<div id="settings-cropper-buttons">
				<button class="btn" @click="sendimage" :disabled="image_send == null">ACEPTAR</button>
				<a class="btn-flat" @click="isOpeneditor = false">CANCELAR</a>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	new Vue({
		el: '#settings',
		data: {
			isNewPassword: false,
			showpass: false,
			old_password: {val: '', isvalid: false},
			new_password: {val: '', isvalid: false},
			nickname: {val: '<?= $nickname ?>', isvalid: false},
			img: null,
			isOpeneditor: false,
			image_send: null,
			avatar_image: <?= $path_image ?>,
		},
		computed: {
			isValid: function () {
				return this.old_password.isvalid && this.new_password.isvalid && this.nickname.isvalid
			}
		},
		methods: {
			upload_avatar: function (e) {
				if (e.target.files[0]) this.loadFile(e.target.files[0])
				this.isOpeneditor = true;
			},
			loadFile: function (file) {
				this.img = null
				const reader = new FileReader();
				this.isLoadImage = false
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

		}
	})
</script>
</body>
</html>
