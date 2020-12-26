<script src="<?= base_url() ?>/libs/vueadvancedcropper/cropper.js?v=3" ></script>
<style media="screen">

.upload-editor{
	background: #1e1e2b;
	display: flex;
	align-items: center;
	justify-content: center;
	z-index: 10;
}

.upload-editor form{
	height: 460px;
	width: 400px;
	background: white;
}
.upload-editor form > div{
	width: 100%;
	max-width: 300px;
}
.upload-editor-wrapper-description{

	display: flex;
	justify-content: center;
	align-items: center;
	background: #1e1e2b;
}
.upload-editor-description{
	display: flex;
	border-radius: 10px;
	overflow: hidden;
}
.upload-editor-file{
	overflow: hidden;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
}
.upload-editor-close{
	position: absolute;
	top: 1rem;
	right: 1rem;
	background: #ffffff1a;
}
.upload-editor-close:hover{
	background: #ffffff1f;
}
.upload-editor-close i{

	color: white
}
.upload-editor-firts-upload{
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	background-color: white;
	border-radius: 10px;
	transition: linear .2s all;
	position: relative;
	cursor: pointer;
	width: 300px;
	height: 300px;
}
.upload-editor-firts-upload:hover::before{
	transform: scale(1.2);
}
.upload-editor-firts-upload::before{
	content: '';
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	border-radius: 10px;
	position: absolute;
	transition: linear all .2s;
	border: 3px solid white;
}
.upload-editor-buttons-upload{
	display: flex;
	align-items: center;
	justify-content: center;
	height: 56px;
}
.upload-editor-preview{
	position: relative;
	color: white;
	background: black;
	height: 460px;
	width: 460px;
}
.upload-editor-preview img{
	width: 100%;
}
.upload-editor-image-blur{
	object-fit: cover;
	opacity: .4
}
.upload-editor-image-view{
	position: absolute;
	top: 0;
	left: 0;
	object-fit: contain;
}
.upload-editor-preview span{
	z-index: 3;
	font-size: 3rem;
	position: absolute;
	left: 50%;
	right: 50%;
	transform: translate(-50%, -50%);
	display: block;
	width: 100%;
	text-align: center;
}
.upload-editor-wrapper-file{
	width: 100%;
	max-width: 500px;
	display: flex;
	flex-direction: column;
	justify-content: space-between;
}
.upload-editor-cropper{
	padding: 1rem;
	max-height: 600px;
}


@media (max-width: 992px) {
	.upload-editor-description{
		flex-direction: column;
		max-width: 400px;
		border-radius: 0;
	}
	.upload-editor form{
		height: auto;
		width: auto;
		padding: 4rem;
	}
}
@media (max-width: 600px) {
	.upload-editor-wrapper-description{
		overflow: hidden;
	}
	.upload-editor form{
		padding: 1rem;
		flex: 1;
	}
	.upload-editor-preview{
		max-width: 360px;
		width: 100%;
		height: 360px;
	}
	.upload-editor-preview img{
		height: 100%;
	}
	.upload-editor-description{
		height: 100%;
		width: 100%;
	}
	.upload-editor-cropper{
		height: calc(100% - 56px);
		padding-top: 5rem;
	}
	.upload-editor-cropper .vue-advanced-cropper{
		position: fixed !important;
		top: 5rem;
		bottom: 56px;
		height: auto;
		width: auto;
		left: 1rem;
		right: 1rem;
	}
	.upload-editor{
		align-items: flex-start;
	}
	.upload-editor-wrapper-file{
		height: 100%;
	}

	.upload-editor-file{
		max-height: none;
	}


}
</style>
<?php template_start() ?>
<div class="upload-editor" v-show="isOpen">
	<a class="btn btn-floating upload-editor-close" @click="close"> <i class="mdi-18px mdi mdi-close"></i> </a>
	<div class="upload-editor-file">
		<div class="upload-editor-wrapper-file">
			<div class="upload-editor-cropper">
				<cropper style="" ref="cropper" :src="img" @change="change" :default-size="defaultSize"></cropper>
			</div>
			<div class="upload-editor-buttons-upload">
				<label class="">
					<a class="btn" v-show="steps >= 0" v-if="!isModify">
						<i class="mdi mdi-upload left"></i>
						<span>{{ steps > 0 ? 'SUBIR OTRA IMAGEN' : 'SUBIR UNA IMAGEN'}}</span>
					</a>
					<input v-show="false" type="file" accept="image/x-png,image/jpeg" @change="onUploadFile">
				</label>

				<a class="btn ml-1" v-show="steps > 0" @click="steps = 2"> <i class="mdi mdi-arrow-right" :class="{right: isModify}"></i> <span v-if="isModify">Siguiente</span></a>
			</div>
		</div>
	</div>
	<div class="upload-editor-wrapper-description" style="display: none" v-show="steps == 2">
		<div class="upload-editor-description">
			<div class="upload-editor-preview f-c">
				<img :src="image" class="upload-editor-image-blur" width="460" height="460">
				<img :src="image" class="upload-editor-image-view" width="460" height="460">
			</div>
			<form class="f-c" @submit.prevent="submit">
				<div>
					<cg-field required v-model.trim="name" :watchisvalid.sync="name_isvalid" sizechars="4-20" label="Nombre de la obra" placeholder="ingrese credenciales"></cg-field>
					<cg-field required empty v-model.trim="description" :watchisvalid.sync="description_isvalid" sizechars="0-500" label="Descripcion de la obra" placeholder="descripcion..."></cg-field>
					<cg-select v-show="author != 'current'" required v-model="author" :watchisvalid.sync="author_isvalid" label="Autor" novalues="-1">
						<option value="-1" disabled>seleccione autor</option>
						<option :value="autor.id_user" v-for="autor in autors">{{autor.nickname}}</option>
					</cg-select>
					<div class="r">
						<a class="btn" @click="steps = 1"> <i class="mdi mdi-arrow-left"></i></a>
						<cg-button :disabled="!isvalid" :loading="load.isUploading" :progress="load.progress"></cg-button>
					</div>
				</div>


			</form>
		</div>
	</div>

</div>
<?php $template = template_end() ?>

<script type="text/javascript">
	$_module = {
		template: `<?= $template ?>`,
		data: function () {
			return {
				img: null,
				id: '',
				author: '-1',
				name: '',
				description: '',
				author_isvalid: false,
				name_isvalid: false,
				description_isvalid: false,
				isOpen: true,
				isLoadImage: false,
				image: null,
				extensionimage: '',
				isModify: false,
				load: {
					isUploading: false,
					progress: 0
				},
				steps: 0
			}
		},

		props: {
			autors: Array,
			base_url: {type: String, default: ''}
		},
		mounted: function () {
			//this.$refs.cropper.setCoordinates((coordinates, imageSize) => ({width: imageSize.width,height: imageSize.height}))
		},
		computed: {
			isvalid: function () {
				return this.author_isvalid && this.name_isvalid && this.description_isvalid && this.isLoadImage
			}
		},
		methods: {
			defaultSize: function({ imageSize }) {
			  return {
				width: imageSize.width,
				height: imageSize.height,
			  };
			},
			setData: function (newData) {
				this.isModify = true
				this.img = newData.img
				this.id = newData.id
				this.author = newData.author
				this.description = newData.description
				this.name = newData.name
				this.extensionimage = newData.extension

			},
			newRegister: function () {
				this.isModify = false
				this.img = null
				this.id = ''
				this.author = 'current'
				this.description = ''
				this.name = ''
				this.extensionimage = ''
			},
			submit: function () {
				const datos = {
					key: this.id,
					author: this.author,
					workname: this.name,
					description: this.description,
					image: this.image
				}

				this.load.progress = 0;
				this.load.isUploading = true
				axios.request( {
					method: "post",
					url: this.base_url + "/services/artwork/save",
					data: datos,
					onUploadProgress: (p) => {
						this.load.progress = parseInt((p.loaded / p.total) * 100)
					}
				}).then (data => {
					this.close();
					this.$emit('onfinish', data.data)
					this.load.isUploading = false
				})
			},
			change({coordinates, canvas}) {

				this.image = canvas.toDataURL('image/jpeg', 0.8)

				this.steps = 1
				if (!this.isLoadImage) {
					this.isLoadImage = true
					//this.$refs.cropper.setCoordinates((coordinates, imageSize) => ({width: imageSize.width,height: imageSize.height}))
				}
			},
			onUploadFile: function (e) {
				if (e.target.files[0]) this.loadFile(e.target.files[0])
			},
			loadFile: function (file) {

				const reader = new FileReader();
				this.isLoadImage = false
				reader.addEventListener("load", e => {
					this.img = reader.result
					this.extensionimage = file.type
				}, false);
				reader.readAsDataURL(file);
			},
			close: function () {
				this.isOpen = false
				this.steps = 0
				this.img = null
				this.isLoadImage = false
			},
			open: function () {
				this.isOpen = true
				this.steps = 0
				this.img = null
				this.isLoadImage = false
			}
		}
	}
</script>
