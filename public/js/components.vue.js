Vue.component('lateral-modal',{
	template: `
	<div class="lateral-modal animated fadeIn" style="display: none" v-show="!is_close">
		<div class="lateral-modal-container">
			<slot></slot>
		</div>
		<div class="lateral-modal-out" @click="is_close = true"></div>
	</div>
	`,
	data: function () {
		return {
			is_close: true
		}
	},
	methods: {
		toggle: function () {
			this.is_close = !this.is_close
		}
	},
	mounted: function () {
		document.onkeydown = (evt) => {
			if (!this.is_close) {
				evt = evt || window.event;
			    var isEscape = false;
			    if ("key" in evt) isEscape = (evt.key === "Escape" || evt.key === "Esc");
			    else isEscape = (evt.keyCode === 27);
			    if (isEscape) this.is_close = true;
			}


		};
	}
})
Vue.component('upload-editor',{
	template: `
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
	`,
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
})

Vue.component('cg-grid-image', {
	template: `
	<div class="cg-grid-image">
		<a v-show="is_on_profile" ref="drop" :data-target="info.accessname" class="cg-grid-image-options btn btn-floating waves waves-effect waves-light">
			<i class="mdi-24px mdi mdi-dots-vertical"></i>
		</a>
		<ul :id="info.accessname" class="dropdown-content">
			<li tabindex="0"><a @click="send"><i class="mdi mdi-image-edit-outline"></i>Modificar</a></li>
			<li tabindex="0"><a><i class="mdi mdi-bell-alert-outline"></i>Aplicar a evento</a></li>
		</ul>
		<div class="cg-grid-artwork-content">
			<img ref="image" loading="lazy" class="cg-grid-img" :height="info.height" :width="info.width" :src="calculeimage()">
			<div class="cg-grid-artwork-name">{{info.name}}</div>
		</div>

		<div class="cg-grid-info"  v-if="!is_on_profile">
			<div  class="cg-grid-avatar" @click="redirect">{{info.nickname[0]}}</div>
			<div class="cg-grid-autor">
				<span class="grid-images" @click="redirect">{{info.nickname}}</span>
			</div>
		</div>
	</div>
	`,
	data: function () {
		return {
			base64: null
		}
	},
	methods: {
		calculeimage: function () {
			return `images/artworks/${this.info.accessname}.${this.info.extension}`;
		},
		redirect: function () {
			window.location.href = this.info.account
		},
		send: function () {
			const info = {
				description: this.info.description,
				name: this.info.name,
				id_image: this.info.id_image,
				img: this.$refs.image.src,
				extension: this.info.extension
			}
			this.$emit('changeimage', info)
		}
	},
	props: {
		info: Object,
		is_on_account:  Boolean,
		is_on_profile: Boolean
	},

	mounted: function () {
		M.Dropdown.init(this.$refs.drop,{constrainWidth: false, alignment: 'left'});
	}
})
Vue.component('cg-grid',{
	template: `
	<div class="cg-grid-wrapper">
		<div ref="menu" class="cg-grid">
			<div v-for="img of images" class="cg-grid-wrapper-img" :style="{ width: stack_size + 'px', height: (img.adsense ? stack_size + 'px' : 'auto')}">
				<cg-grid-image v-if="!img.adsense" @changeimage="$emit('changeimage', $event)" :info="img" :is_on_profile="is_on_profile" :is_on_account="is_on_account"></cg-grid-image>
				<div class="cg-grid-adsense" v-else style="height: 100%; width: 100%" :id="img.id"></div>
			</div>
		</div>
	</div>
	`,
	data: function () {
		return {
			current_stacks: 0
		}
	},
	props: {
		images: Array,
		stack_size: { type: Number, default: 200},
		is_on_account: Boolean,
		is_on_profile: Boolean,
		base_url: String
	},
	updated: function () {
	  this.$nextTick(function () {
		setTimeout(() => { this.calcule(true)}, 500)
	  })
	},
	watch: {
		images: {
			deep: true,
			handler: function () {

			}
		}
	},
	methods: {
		calcule: function (option) {

			var top_height = 0;
			var count_stack = parseInt(this.$el.clientWidth / this.stack_size);

			if (count_stack !== this.current_stacks || typeof option != 'undefined') {

				let stacks = Array(count_stack).fill(0);
				this.$refs.menu.style.width = (count_stack * this.stack_size) + 'px'
				this.$emit('sizewrapper', count_stack * this.stack_size)
				for (var el of this.$el.querySelectorAll('.cg-grid-wrapper-img')) {
					var near_index = stacks.findIndex(a => a == Math.min.apply(null, stacks));
					var img_height = el.offsetHeight;
					el.style.top = stacks[near_index] + 'px'
					el.style.left = (near_index * this.stack_size) + 'px'
					stacks[near_index] += img_height;
					if (top_height < img_height) top_height = img_height
				}
				this.$refs.menu.style.height = Math.max.apply(null, stacks) + 'px'

			}
			this.current_stacks = count_stack;
		}
	},
	mounted: function () {
		new ResizeSensor(this.$el, () => {this.calcule()});
		this.calcule()
	}
})
