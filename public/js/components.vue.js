Vue.component('upload-editor',{
	template: `
	<div class="upload-editor cover" v-show="isOpen">
		<a class="btn btn-floating upload-editor-close" @click="close"> <i class="mdi-18px mdi mdi-close"></i> </a>
		<div class="upload-editor-file">
			<div class="upload-editor-wrapper-file">
				<cropper style="" ref="aaaaa" :src="img" @change="change"></cropper>
				<div class="upload-editor-buttons-upload my-4">
					<label class="">
						<a class="btn" v-show="steps >= 0" >
							<i class="mdi mdi-upload left"></i>
							<span>{{ steps > 0 ? 'SUBIR OTRA IMAGEN' : 'SUBIR UNA IMAGEN'}}</span>
						</a>
						<input v-show="false" type="file" accept="image/x-png,image/jpeg" @change="onUploadFile">
					</label>

					<a class="btn ml-1" v-show="steps > 0" @click="steps = 2"> <i class="mdi mdi-arrow-right"></i> </a>
				</div>
			</div>
		</div>
		<div class="upload-editor-wrapper-description" style="display: none" v-show="steps == 2">
			<div class="upload-editor-description">
				<div class="upload-editor-preview cover f-c">
					<canvas ref="canvas" height="460" width="460"></canvas>
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

			if (this.image != null) {
				this.steps = 2
			}
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
			function drawImageProp(ctx, img) {

		        x = y = 0;
		        w = ctx.canvas.width;
		        h = ctx.canvas.height;
			    offsetX = 0;
			    offsetY = 0;

			    let iw = img.width,
			        ih = img.height,
			        r = Math.min(w / iw, h / ih),
			        nw = iw * r,   // new prop. width
			        nh = ih * r,   // new prop. height
			        cx, cy, cw, ch, ar = 1;

			    if (nw < w) ar = w / nw;
			    if (Math.abs(ar - 1) < 1e-14 && nh < h) ar = h / nh;  // updated
			    nw *= ar;
			    nh *= ar;

			    cw = iw / (nw / w);
			    ch = ih / (nh / h);

			    cx = (iw - cw) * offsetX;
			    cy = (ih - ch) * offsetY;

			    if (cx < 0) cx = 0;
			    if (cy < 0) cy = 0;
			    if (cw > iw) cw = iw;
			    if (ch > ih) ch = ih;

				ctx.save();

				ctx.filter = 'blur(10px)';
				ctx.scale(1.1, 1.1);
				ctx.translate(-23,-23)
			    ctx.drawImage(img, cx, cy, cw, ch,  0, 0, w, h);

				ctx.restore();

				var scale = Math.min(ctx.canvas.width / img.width, ctx.canvas.height / img.height);
			    // get the top left position of the image
			    var x = (ctx.canvas.width / 2) - (img.width / 2) * scale;
			    var y = (ctx.canvas.height / 2) - (img.height / 2) * scale;
			    ctx.drawImage(img, x, y, img.width * scale, img.height * scale);

			}
			this.image = canvas.toDataURL(this.extensionimage, 0.9)
			const ctx = this.$refs.canvas.getContext('2d')


			var image = new Image();
			image.onload = function() {
			  drawImageProp(ctx, image);
			};
			image.src = this.image

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

Vue.component('cg-grid-image', {
	template: `
	<div>
		<a v-show="edit" ref="drop" :data-target="info.accessname" class="cg-grid-image-options btn btn-floating waves waves-effect waves-light">
			<i class="mdi-24px mdi mdi-dots-vertical"></i>
		</a>
		<ul :id="info.accessname" class="dropdown-content">
			<li tabindex="0"><a @click="$emit('changeimage', info)"><i class="mdi mdi-image-edit-outline"></i>Modificar</a></li>
		</ul>
		<img loading="lazy" class="cg-grid-img" :height="info.height" :width="info.width" :src="calculeimage(info)">
		<div class="cg-grid-info">
			<span style="font-size: 1.2rem" :class="{primary: !details}">{{info.name}}</span>
			<div class="pt-1 cg-grid-autor" v-if="details">
				<div class="cg-grid-avatar"></div>
				<span class="pl-4 grid-images" @click="redirect">{{info.nickname}}</span>
			</div>
		</div>
	</div>
	`,
	methods: {
		calculeimage: function () {
			return `images/artworks/${this.info.accessname}.${this.info.extension}`
		},
		redirect: function () {
			window.location.href = this.info.account
		}
	},
	props: {
		info: Object,
		details: {type: Boolean, default: true},
		edit: Boolean
	},
	mounted: function () {
		M.Dropdown.init(this.$refs.drop,{constrainWidth: false, alignment: 'left'});
	}
})
Vue.component('cg-grid',{
	template: `
	<div class="cg-grid-wrapper">
		<div ref="menu" class="cg-grid">
			<div v-for="img of images" class="cg-grid-wrapper-img" :style="{ width: stack_size + 'px'}">
				<cg-grid-image @changeimage="$emit('changeimage', $event)" :info="img" :details="details" :edit="isEdit"></cg-grid-image>
			</div>
		</div>
	</div>
	`,
	data: function () {
		return {
			current_stacks: 0,
			isEdit: false
		}
	},
	props: {
		images: Array,
		stack_size: { type: Number, default: 200},
		details: {type: Boolean, default: true},
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
		setEdit: function (set) {
			this.isEdit = set
		},
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
