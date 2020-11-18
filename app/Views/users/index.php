<?php
	$access_account = !empty($_SESSION['access']['account']) && $_SESSION['access']['account'] == $info['account'];
?>
<script src="<?= base_url() ?>/libs/vueadvancedcropper/cropper.js" ></script>
<style media="screen">
#user_header{
	height: 300px;
	background: black;
	position: relative;
	overflow: hidden;
}
#user_header_bg{
	position: 	absolute;
	left: 0;
	top: 0;
	height: 100%;
	width: 100%;

}
#user_header_bg::before{
	content: '';
	position: 	absolute;
	left: 0;
	top: 0;
	height: 100%;
	width: 100%;
	background-repeat: no-repeat;
	background-size: cover;
	background-position: center;
	background-attachment: fixed;
	background-image: url('<?= base_url() ?>/images/bg_003.jpg');
}
#user_header_bg::after{
	position: absolute;
	content: '';
	left: 0;
	top: 0;
	height: 100%;
	width: 100%;
	background-color: black;
	opacity: .4;
}
#user_header_bg_content{
	height: 100%;
	position: relative;
	padding: 1rem;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	color: white;
	backdrop-filter: blur(10px);
	-webkit-backdrop-filter: blur(10px);
}
.user-foto{
	background: #ffffff55;
	height: 140px;
	width: 140px;
	border-radius: 50%;
	display: flex;
	justify-content: center;
	align-items: center;
	font-size: 4rem;
	font-family: Calibri;
}
@media (max-width: 600px) {
	#user_header{
		height: 160px;
	}
	#user_header_bg_content{
		flex-direction: row;
	}
	.user-foto{
		height: 80px;
		width: 80px;
	}
	#user_header_bg_content h5{
		padding-left: 1rem;
	}
}
</style>

<style media="screen">

</style>

<?php template_start(); ?>
<div>
	<div class="" id="user_header">
		<div id="user_header_bg"></div>
		<div id="user_header_bg_content">
			<div class="user-foto"><?= $info['nickname'][0] ?></div>
			<h5><?= $info['nickname'] ?></h5>
		</div>
	</div>
	<div class="p-4">
		<cg-grid ref='grid' @changeimage="change" :images="list_img" :stack_size="320" :details="false" ></cg-grid>
	</div>
	<upload-editor ref="editor" :autors="autoraccess" @onfinish="onfinish"></upload-editor>
</div>
<?php $template = template_end()?>
<?php template_start() ?>
<div class="upload-editor cover" v-show="isOpen">
	<a class="btn btn-floating upload-editor-close" @click="close"> <i class="mdi-18px mdi mdi-close"></i> </a>
	<div class="upload-editor-file" v-show="steps < 2">

		<cropper style="max-height: 600px;" ref="aaaaa" :src="img" @change="change"></cropper>
		<div class="upload-editor-buttons-upload my-4">
			<label class="">
				<a class="btn" v-show="steps > 0" >
					<i class="mdi mdi-upload left"></i>
					<span>SUBIR OTRA IMAGEN</span>
				</a>
				<div class="upload-editor-firts-upload" v-show="steps == 0">
					<i class="mdi mdi-image-outline" style="font-size: 8rem"></i>
					<div class="title-2 ">SUBIR UNA IMAGEN</div>
				</div>
				<input v-show="false" type="file" accept="image/x-png,image/jpeg" @change="onUploadFile">
			</label>

			<a class="btn ml-1" v-show="steps > 0" @click="steps = 2"> <i class="mdi mdi-arrow-right"></i> </a>
		</div>
	</div>
	<div class="upload-editor-description" v-show="steps == 2">
		<div class="cover f-c" :style="{'background-image': 'url(' + image + ')'}">
			<h4><?= $_SESSION['access']['nickname'] ?></h4>
		</div>
		<form class="f-c" @submit.prevent="submit">
			<div class="w100">
				<cg-field required v-model.trim="name" :watchisvalid.sync="name_isvalid" sizechars="4-20" label="Nombre de la obra" placeholder="ingrese credenciales"></cg-field>
				<cg-field required empty v-model.trim="description" :watchisvalid.sync="description_isvalid" sizechars="0-500" label="Descripcion de la obra" placeholder="descripcion..."></cg-field>
				<cg-select v-show="author != 'current'" required v-model="author" :watchisvalid.sync="author_isvalid" label="Autor" novalues="-1">
					<option value="-1" disabled>seleccione autor</option>
					<option :value="autor.id_user" v-for="autor in autors">{{autor.nickname}}</option>
				</cg-select>
				<div class="r">
					<a class="btn bg-white" @click="close"> <i class="mdi mdi-close right"></i> <span>CANCELAR</span> </a>
					<cg-button :disabled="!isvalid" :loading="load.isUploading" :progress="load.progress"></cg-button>
				</div>
			</div>


		</form>

	</div>

</div>
<?php $editor = template_end() ?>
<script>


Vue.component('upload-editor',{
	template: `<?= $editor ?>`,
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
			isOpen: false,
			isLoadImage: false,
			image: null,
			extensionimage: '',
			load: {
				isUploading: false,
				progress: 0
			},
			steps: 0
		}
	},
	watch: {
		isOpen: function (val) {

		}
	},
	props: {
		autors: Array,
	},
	mounted: function () {
		this.$refs.aaaaa.setCoordinates((coordinates, imageSize) => ({width: imageSize.width,height: imageSize.height}))
	},
	computed: {
		isvalid: function () {
			return this.author_isvalid && this.name_isvalid && this.description_isvalid && this.isLoadImage
		}
	},
	methods: {
		setData: function (newData) {
			this.img = newData.img
			this.id = newData.id
			this.author = newData.author
			this.description = newData.description
			this.name = newData.name
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
				url: "<?= base_url() ?>/services/artwork/save",
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
			this.image = canvas.toDataURL(this.extensionimage, 0.9)
			this.steps = 1
			if (!this.isLoadImage) {
				this.isLoadImage = true
				this.$refs.aaaaa.setCoordinates((coordinates, imageSize) => ({width: imageSize.width,height: imageSize.height}))
			}

			this.current_coordinates = coordinates
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
})
const $_module = {
	template: `<?= $template ?>`,
	mounted: function () {
		<?php
		if ($access_account) {
			echo "
				this.\$refs.grid.setEdit(true);
				this.autoraccess.push({id_user: 'current', nickname: 'current'});
				$('#app-nav-access').prepend($(\"<a class='btn'><i class='mdi-18px mdi mdi-plus'></i></a>\").click(this.openeditor),' ');
			";

		}

		?>

	},
	data: function () {
		return {
			list_img: <?= json_encode($images_list) ?>,
			autoraccess: []
		}
	},
	methods: {
		change: function (data) {
			this.$refs.editor.open()
			this.$refs.editor.setData({
				author: 'current',
				description: data.description,
				name: data.name,
				id: data.id_image,
				img: '<?= base_url() ?>/images/artworks/' + data.accessname + '.' + data.extension
			})
		},
		onfinish: function (data) {
			$.post('<?= base_url() ?>/services/artworks/recover',{account: '<?= $_SESSION['access']['account'] ?>'}, (res) => {
				this.list_img = res;
			})
		},
		openeditor: function () {
			this.$refs.editor.open()
			this.$refs.editor.setData({
				author: 'current',
				description: '',
				name: '',
				id: '',
				img: null
			})
		},

	}
}

</script>
