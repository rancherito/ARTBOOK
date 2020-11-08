<?php
$images = [];
foreach (scandir('./images/artworks') as $key => $value) {
	if (!is_dir($value) && $value != 'others') $images[] = base_url()."/images/artworks/$value";
}

?>
<script src="<?= base_url() ?>/libs/gridStack/gridStack.js" charset="utf-8"></script>
<style media="screen">
	#app-content{
		padding: 0;
	}
	#app{
		height: 100%;
		width: 100%;
		display: flex;
	}

	#grid-images{
		width: 100%;
	}
	.box-image{
		height: 100%;
		border: 1px solid #ccc;
		border-radius: 10px;;
		overflow: hidden;
		background-position: center top;
		background-repeat: no-repeat;
		background-size: cover;
	}
	#edit-image{
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: white;
		display: flex;
	}
	#edit-image > div:nth-child(1){
		flex-grow: 1;
	}
	#edit-image > div:nth-child(2){
		width: 100%;
		max-width: 460px;
	}
	#choise-file{
		border: 1px solid #f7f7f7;
		min-width: 300px;
		min-height: 300px;
		border-radius: 10px;
		cursor: pointer;
		display: block;
		position: relative;
		overflow: hidden;
		text-shadow: 1px 0 0 lightgray
	}
	#choise-file::after{
		width: 100%;
		height: 100%;
		left: 0;
		top: 0;
		position: absolute;
		content: '';
		transition: linear background .2s
	}
	#choise-file:hover::after{

		background: #00000010;
	}
	#choise-watermark{
		position: absolute;
		left: 50%;
		top: 50%;
		transform: translate(-50%, -50%);
		width: 300px;
		text-align: center;
		padding: 2rem;
	}
	.loadded-image label{
		color: white;
	}
</style>
<script type="text/x-template" id="app-template">
	<div style="height: 100%; overflow-y: auto">
		<div id="edit-image" class="p-4">
			<div class="f-c"  :class="{'loadded-image': isloadedfile}">

				<canvas ref="imageCanvas" style="display: none"></canvas>
				<label id="choise-file">
					<img ref="imagePut" @load="onLoadImage" style="display: block">
					<div class="f-c" id="choise-watermark">
						<i class="mdi mdi-image-outline" style="font-size: 8rem"></i>
						<div class="title-2 ">{{isloadedfile ? 'CAMBIAR IMAGEN' : 'SUBIR UNA IMAGEN'}}</div>
					</div>
					<input type="file" style="display: none" accept="image/x-png,image/jpeg" @change="onUploadFile">
				</label>


			</div>
			<div class="f-c">
				<h5 class="pb-5 primary">Informacion de la obra</h5>
				<form class="w100" style="max-width: 360px" @submit.prevent="submit">
					<cg-field required v-model.trim="nombre.value" :watchisvalid.sync="nombre.isvalid" sizechars="6-20" label="Nombre de la obra" placeholder="ingrese credenciales"></cg-field>
					<cg-select required v-model="autor.value" :watchisvalid.sync="autor.isvalid" label="Autor" novalues="-1">
						<option value="-1" disabled>seleccione autor</option>
						<option value="1">Anonimus</option>
					</cg-select>
					<div class="r">
						<button :disabled="!isvalid" class="btn"> <i class="mdi mdi-content-save right"></i> <span>SALVAR</span> </button>
					</div>

				</form>

			</div>
		</div>
		<div class="p-4" id="grid-images">
			<div class="wrap-grid">
				<?php foreach ($images as $key => $image): ?>
					<div class="p-1 white-text" style="float: left; width: 260px; height: 260px">
						<div class="p-4 grey box-image" style=" background-image: url('<?= $image?>')">
						</div>
					</div>
				<?php endforeach; ?>

			</div>
		</div>
	</div>

</script>
<script>
	Vue.component('module',{
		template: '#app-template',
		data: function () {
			return {
				autor: {value: '-1', isvalid: false},
				nombre: {value: '', isvalid: false},
				iscanvasload: false,
				isloadedfile: false,
				extensionimage: ''
			}
		},
		mounted: function () {
			new gridStack($('.wrap-grid'),260,4)
		},
		computed: {
			isvalid: function () {
				return this.autor.isvalid && this.nombre.isvalid && this.iscanvasload
			}
		},
		methods: {
			submit: function () {
				const data = {author: this.autor.value, workname: this.nombre.value, image: this.$refs.imageCanvas.toDataURL(this.extensionimage, 0.9)}
				$.post('<?= base_url() ?>/services/artwork/save', data, res =>{
					console.log(res);
				})
			},
			onLoadImage: function () {
				this.isloadedfile = true
				const scale_max = 600
				const img = this.$refs.imagePut
				const [w, h] = [img.naturalWidth,img.naturalHeight]
				let [fh, fw] = [0, 0]
				if (h > w) {
					fh = scale_max
					fw = (w * fh)/ h
				}
				else {
					fw = scale_max
					fh = (h * fw)/ w
				}
				img.style.width = fw + 'px'
				img.style.height = fh + 'px'

				const canvas = this.$refs.imageCanvas
				let ctx = this.$refs.imageCanvas.getContext('2d')
				canvas.height = h
				canvas.width = w
				ctx.drawImage(img,0,0);
				this.iscanvasload = true
			},
			onUploadFile: function (e) {
				if (e.target.files[0]) this.loadFile(e.target.files[0])
			},
			loadFile: function (file) {
				console.log(file);
				const reader = new FileReader();
				this.iscanvasload = false
				reader.addEventListener("load", e => {
					this.$refs.imagePut.src = reader.result
					this.extensionimage = file.type
				}, false);
				reader.readAsDataURL(file);
			}
		}
	})
</script>
