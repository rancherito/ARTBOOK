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
		border-radius: 10px;
		border: 1px solid #f8f8f8;
		background: #fcfcfc
	}
	.box-image-content{
		background-position: center top;
		background-repeat: no-repeat;
		background-size: cover;
		background-color: gray;
	}
	.box-image-title, .box-image-autor{
		color: gray;
		height: 2rem;
		text-align: center;
		display: flex;
		align-items: center;
		justify-content: center;
		position: relative;
	}
	.box-image-options{
		background: transparent;
		position: absolute;
		top: 50%;
		right: 6px;
		transform: translateY(-50%);
	}
	.box-image-options:hover{
		background: transparent
	}
	.box-image-options i{
		color: lightgray;
	}
	.box-image-title {
		height: 3.5rem;
		font-size: 1.2rem;
	}
	.box-image-autor{
		text-transform: lowercase;
	}
	#edit-image{
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: white;
		z-index: 2;
		overflow-y: auto;
	}
	#edit-image > div{
		display: flex;
		height: 100%;
		padding: 1rem;
	}
	#edit-image .edit-image-photo{
		flex-grow: 1;
	}
	#edit-image .edit-image-info{
		width: 460px;
	}
	#choise-file{
		border: 1px solid #f7f7f7;
		min-width: 300px;
		min-height: 300px;
		max-width: 600px;
		border-radius: 10px;
		cursor: pointer;
		display: block;
		position: relative;
		overflow: hidden;
		width: 100%;
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
	#choise-file img{
		width: 100%;
		height: auto;
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
	@media (max-width: 992px) {
		#choise-file{
			max-width: 400px;
		}
		#edit-image > div{
			display: block;
			height: auto;
			padding: 2rem 1rem;
		}
		#edit-image .edit-image-info{
			width: 100%;
			padding: 1rem 0
		}
	}

</style>
<script type="text/x-template" id="app-template">
	<div style="height: 100%; overflow-y: auto">
		<div id="edit-image" v-show="isopeneditor">
			<div>
				<div class="edit-image-photo f-c"  :class="{'loadded-image': isloadedfile}">

					<canvas ref="imageCanvas" style="display: none"></canvas>
					<label id="choise-file">
						<img ref="imagePut" @load="onLoadImage" v-show="isloadedfile">
						<div class="f-c" id="choise-watermark">
							<i class="mdi mdi-image-outline" style="font-size: 8rem"></i>
							<div class="title-2 ">{{isloadedfile ? 'CAMBIAR IMAGEN' : 'SUBIR UNA IMAGEN'}}</div>
						</div>
						<input type="file" style="display: none" accept="image/x-png,image/jpeg" @change="onUploadFile">
					</label>


				</div>
				<div class="f-c edit-image-info">
					<h5 class="pb-5 primary">Informacion de la obra</h5>
					<form class="w100" style="max-width: 360px" @submit.prevent="submit">
						<cg-field required v-model.trim="nombre.value" :watchisvalid.sync="nombre.isvalid" sizechars="4-20" label="Nombre de la obra" placeholder="ingrese credenciales"></cg-field>
						<cg-select required v-model="autor.value" :watchisvalid.sync="autor.isvalid" label="Autor" novalues="-1">
							<option value="-1" disabled>seleccione autor</option>
							<option :value="n.id_user" v-for="n in users">{{n.nickname}}</option>
						</cg-select>
						<div class="r">
							<a class="btn bg-white" @click="isopeneditor = false"> <i class="mdi mdi-close right"></i> <span>CANCELAR</span> </a>
							<cg-button :disabled="!isvalid" :loading="load.isUploading" :progress="load.progress"></cg-button>
						</div>

					</form>

				</div>
			</div>

		</div>
		<div class="p-4" id="grid-images">
			<div class="wrap-grid">
				<card-image :data="image" v-for="(image, index) in images" :item="index" :openeditor="openeditor"></card-image>
			</div>
		</div>
	</div>

</script>
<script>

	Vue.component('card-image',{
		template: `
		<div class="white-text p-1 pb-4" style="float: left; width: 260px;">
			<div class="box-image">
				<div class="box-image-title">
				{{data.name}}
				<a ref="trigger" class="box-image-options btn btn-floating waves waves-effect waves-light" style="" :data-target='iddrop'>
					<i class="mdi-24px mdi mdi-dots-vertical"></i>
				</a>
				</div>
				<div class="box-image-content r" :style="{'background-image': image}" style="height: 260px">

					<ul :id='iddrop' class='dropdown-content'>
					    <li><a @click="edit"><i class="mdi mdi-image-edit-outline"></i>Modificar</a></li>
					  </ul>
				</div>
				<div class="box-image-autor">by {{data.nickname}}</div>
			</div>
		</div>
		`,
		props: ['data', 'item', 'openeditor'],
		mounted: function () {
			M.Dropdown.init(this.$refs.trigger, {constrainWidth: false, alignment: 'right'});
		},
		computed: {
			image: function () {
				return `url('<?= base_url()?>/images/artworks/${this.data.accessname}.${this.data.extension}')`
			},
			iddrop: function () {
				return 'dropdown-card-image' + this.item
			}
		},
		methods: {
			edit: function () {
				if (typeof this.openeditor == 'function') this.openeditor(this.data);
			}
		}
	})
	Vue.component('module',{
		template: '#app-template',
		data: function () {
			return {
				load: {
					isUploading: false,
					progress: 0
				},
				autor: {value: '-1', isvalid: false},
				nombre: {value: '', isvalid: false},
				iscanvasload: false,
				isloadedfile: false,
				extensionimage: '',
				isopeneditor: false,
				keyide: '',
				images: <?= json_encode($images_list) ?>,
				users: <?= json_encode($users) ?>
			}
		},
		mounted: function () {
			new gridStack($('.wrap-grid'),260,1)
			$('#app-nav-access').append($(`<a class="btn"><i class="mdi-18px mdi mdi-plus left"></i><span>Nuevo</span></a>`).click(() => {
				this.isopeneditor = true
				this.autor.value = -1
				this.nombre.value = ''
				this.$refs.imagePut.src = ''
				this.isloadedfile = false
				this.keyide = ''
			}));


		},
		computed: {
			isvalid: function () {
				return this.autor.isvalid && this.nombre.isvalid && this.iscanvasload
			}
		},
		methods: {
			openeditor: function (data) {
				this.isopeneditor = true
				const urlimage = `<?= base_url() ?>/images/artworks/${data.accessname}.${data.extension}`
				this.autor.value = data.autor
				this.nombre.value = data.name
				this.$refs.imagePut.src = urlimage
				this.keyide = data.id_image
				console.log(this.keyide);
			},
			submit: function () {
				const datos = {key: this.keyide, author: this.autor.value, workname: this.nombre.value, image: this.$refs.imageCanvas.toDataURL(this.extensionimage, 0.9)}



				this.load.progress = 0;
				this.load.isUploading = true
				axios.request( {
		        method: "post",
		        url: "<?= base_url() ?>/services/artwork/save",
		        data: datos,
		        onUploadProgress: (p) => {
				  this.load.progress = parseInt((p.loaded / p.total) * 100)
		        }
		      }).then (data => {
				  this.isopeneditor = false
  				$.get('<?= base_url() ?>/services/artwork/list', list => {
  					this.images = list
					this.load.isUploading = false
  				})
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
				img.width = fw
				img.height = fh

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
