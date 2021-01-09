Vue.component('event-list', {
	template: `<div class="w100">
		<div>
			<div class="combo-text-title">LISTA DE EVENTOS</div>
			<span>Adjunte su artwork a uno de los eventos pendientes que tiene</span>
		</div>
		<template v-if="dateCheck(event.event_start, event.voting, artwork_apply.uploaded_date)" v-for="event of list_events">
			<div class="app-events-list">
				<template v-if="is_registered">
					<div class="btn app-events-apply-button bg-secondary" v-if="event.artwork == artwork_apply.artwork">
						<i class="mdi mdi-check"></i>
					</div>
				</template>
				<template v-else>
					<div v-if="event.is_artwork_register == 1" class="btn app-events-apply-button" @click="apply_artwork(event)" disabled>
						{{event.is_artwork_register ? 'Registrado' : 'Adjuntar'}}
					</div>
					<div v-else class="btn app-events-apply-button" @click="apply_artwork(event)">Adjuntar</div>
				</template>

				<div v-if="event.is_artwork_register == 1" class="app-events-preview" :style="{'background-image': calcule_artwok_path(event)}"></div>
				<div class="app-events-info">
					<div class="combo-text-title title-4">{{event.name}}</div>
					<span>{{event.name_event}}</span>
				</div>
			</div>
		</template>
	</div>`,
	data: function () {
		return {
			list_events: {}
		};
	},
	props: {'artwork_apply': Object, base_url: String},
	computed: {
		is_registered: function () {
			if (this.artwork_apply.artwork != undefined) {
				for (var ev of this.list_events) if (ev.artwork == this.artwork_apply.artwork) return true;
			}
			return false
		}
	},
	methods: {
		calcule_artwok_path: function (e_item) {
			return  `url('${this.base_url}/images/artworks_lite/${e_item.artwork}.${e_item.extension}')`
		},
		dateCheck: function(from,to,check) {
			let [fDate,lDate,cDate] = [Date.parse(from), Date.parse(to), Date.parse(check)]
			return (cDate <= lDate && cDate >= fDate);
		},
		apply_artwork: function (event_info) {
			const data = {versus: event_info.versus, artwork: this.artwork_apply.artwork}

			$.post(this.base_url + '/service/events/apply_versus', data, (res) => {
				$.get(this.base_url + '/service/events/apply_list', (res_list) => {
					this.list_events = res_list;
				})
			})
		},
	},
	mounted: function () {
		$.get(this.base_url + '/service/events/apply_list', (res_list) => {
			//for (var item of res_list) if (item.artwork == image.artwork) {findartwork = true; this.list_events = [item];}
			this.list_events = res_list;
		})
	}
})

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
	<div class="upload-editor" v-show="isOpen" :class="{'upload-description-add': steps >= 2}">
		<a class="btn btn-floating upload-editor-close" @click="close"> <i class="mdi-18px mdi mdi-close"></i> </a>
		<div class="upload-editor-file">
			<div class="upload-editor-wrapper-file">
				<span class="upload-editor-text">Recorte y vista previa</span>
				<div class="upload-editor-cropper">
					<span class="upload-editor-text-waiting" v-if="!isLoadImage">{{loading_artwork_text}}</span>
					<cropper style="" ref="cropper" :src="img" @change="change" :default-size="defaultSize"></cropper>
				</div>
				<div class="upload-editor-buttons-upload">
					<a href="" class="btn-flat">CERRAR</a>
					<label class="">
						<a class="btn ml-1" v-show="steps >= 0" v-if="!isModify">
							<i class="mdi mdi-upload left"></i>
							<span>{{ steps > 0 ? 'SUBIR OTRA' : 'SUBIR'}}</span>
						</a>
						<input ref="input" v-show="false" type="file" accept="image/x-png,image/jpeg" @change="onUploadFile">
					</label>
					<a class="btn ml-1" v-show="steps > 0" @click="steps = 2"> <i class="mdi mdi-arrow-right" :class="{right: isModify}"></i> <span v-if="isModify">Siguiente</span></a>
				</div>
			</div>
		</div>
		<div class="upload-editor-wrapper-description" style="display: none" v-show="steps >= 2">
			<div class="upload-editor-description">
				<span class="upload-editor-text-details">{{steps > 2 ? 'Artwork cargado con exito' : 'Describa su obra'}}</span>
				<div class="upload-editor-preview f-c" v-show="steps == 2">
					<img :src="image" class="upload-editor-image-view">
				</div>
				<form class="f-c" @submit.prevent="submit" v-show="steps == 2">
					<div>

						<cg-field required v-model.trim="name" :watchisvalid.sync="name_isvalid" sizechars="4-20" label="Nombre de la obra" placeholder="ingrese credenciales"></cg-field>
						<cg-textbox required empty v-model.trim="description" :watchisvalid.sync="description_isvalid" sizechars="0-500" label="Descripcion de la obra" placeholder="descripcion..."></cg-textbox>

						<div class="r">
							<a class="btn" @click="steps = 1"> <i class="mdi mdi-arrow-left"></i></a>
							<cg-button :disabled="!isvalid" :loading="load.isUploading" :progress="load.progress"></cg-button>
						</div>
					</div>
				</form>
				<div class="p-4 upload-editor-after-finish f-c" v-show="steps == 3">
					<event-list :base_url="base_url" :artwork_apply="artwork_apply"></event-list>
					<i class="mdi mdi-check right" style="font-size: 4rem; color: var(--primary)"></i>
					<div class="p-4 c" style=" margin-top: -2rem;">SU TRABAJO A SIDO SUBIDO CON EXITO</div>
					<div class="c" style="padding-bottom: 2rem;">
						<a class="btn-flat" :href="base_url + '/' + author">
							<span>MI MURAL</span>
						</a>
						<a class="btn" @click="close">
							<span>ACEPTAR</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	`,
	data: function () {
		return {
			artwork_apply: {},
			loading_artwork_text: 'CARGANDO ARTWORK..',
			img: null,
			name: '',
			description: '',
			name_isvalid: false,
			description_isvalid: false,
			isOpen: false,
			isLoadImage: false,
			image: null,
			extensionimage: '',
			isModify: false,
			upload_finish: true,
			load: {
				isUploading: false,
				progress: 0
			},
			steps: 0
		}
	},

	props: {
		author: String,
		base_url: {type: String, default: ''}
	},
	mounted: function () {
		//this.$refs.cropper.setCoordinates((coordinates, imageSize) => ({width: imageSize.width,height: imageSize.height}))
	},
	computed: {
		isvalid: function () {
			return this.name_isvalid && this.description_isvalid && this.isLoadImage
		}
	},
	methods: {
		defaultSize: function({ imageSize }) {
		  return {
			width: imageSize.width,
			height: imageSize.height,
		  };
		},
		submit: function () {
			const datos = {
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
			}).then (res => {
				this.$emit('onfinish', res.data)
				this.steps = 3
				this.artwork_apply = res.data.artwork_info
				this.load.isUploading = false
			})
		},
		change({coordinates, canvas}) {

			this.image = canvas.toDataURL('image/jpeg', 0.8)

			this.steps = 1
			this.isLoadImage = true
				//this.$refs.cropper.setCoordinates((coordinates, imageSize) => ({width: imageSize.width,height: imageSize.height}))

		},
		onUploadFile: function (e) {
			if (e.target.files[0]) this.loadFile(e.target.files[0])
		},
		loadFile: function (file) {

			const reader = new FileReader();
			this.isLoadImage = false
			reader.addEventListener("load", e => {

				const image = new Image();
				image.addEventListener('load', () => {
					const limit = 2000


					const max = Math.max(image.naturalHeight, image.naturalWidth)
					if (max > limit) {
						this.loading_artwork_text = 'LIMITE DE ' + limit + 'px EXEDIDOS, REDIMENCIONANDO...'
						const new_canvas = $('<canvas></canvas>')[0];
						const ctx = new_canvas.getContext('2d');
						new_canvas.height = image.naturalHeight
						new_canvas.width = image.naturalWidth
						const scale = limit / max
						ctx.drawImage(image,0,0)
						this.img = downScaleCanvas(new_canvas, scale).toDataURL(file.type)
						//this.loading_artwork_text = 'LISTO'
					}
					else this.img = image.src
				})
				image.src = reader.result;
				this.loading_artwork_text = 'PREPARANDO ARTWORK...'
				this.extensionimage = file.type
			}, false);
			this.loading_artwork_text = 'CARGANDO ARTWORK...'
			reader.readAsDataURL(file);
		},
		close: function () {
			this.isOpen = false
			this.steps = 0
			this.img = null
			this.isLoadImage = false
			this.upload_finish = true
			location.reload();
		},
		open: function () {
			this.description = ''
			this.name = ''
			this.extensionimage = ''
			this.loading_artwork_text = 'CARGANDO ARTWORK...'
			this.isOpen = true
			this.steps = 0
			this.img = null
			this.isLoadImage = false
			this.upload_finish = true
			$(this.$refs.input).trigger('click')
		}
	}
})

Vue.component('cg-grid-image', {
	template: `
	<div class="cg-grid-image" :class="{'cg-grid-img-restricted': info.category_main == 'R18', 'cg-grid-image-mobile' : is_mobile}">
		<a @click="send_events" v-show="is_on_account" class="cg-grid-image-options btn-icon btn-dark waves waves-effect waves-light">
			<i class="mdi-24px mdi mdi-cog"></i>
		</a>
		<div class="cg-grid-artwork-content">
			<div class="cg-grid-img-restricted-indicator f-c w100 c p-4" v-if="info.category_main == 'R18'">CONTENIDO MADURO</div>

			<img ref="image" loading="lazy" class="cg-grid-img" :height="info.category_main == 'R18' ? 400 : info.height" :width="info.category_main == 'R18' ? 400 : info.width" :src="calculeimage()">
			<div class="cg-grid-artwork-name">
				<div class="cg-grid-info"  v-if="!is_on_profile">
					<a v-if="info.has_avatar" class="cg-grid-avatar cover" :href="site" :style="calcule_avatar()"></a>
					<a v-else class="cg-grid-avatar cover" :href="site" >{{info.nickname[0]}}</a>
					<div class="cg-grid-autor">
						<div>{{info.name}}</div>
						<span class="grid-images">{{info.nickname}}</span>
					</div>
				</div>
			</div>
			<div class="cg-grid-artwork-interaction">
				<a class="cg-grid-artwork-interaction-like" :class="{'cg-artwork-like': info.heart}" @click="trigger_like(info)">
					<i class="mdi mdi-24px" :class="info.heart ? 'mdi-heart' : 'mdi-heart-outline'"></i>
				</a>
			</div>
			<a class="cg-grid-artwork-curtain f-c" :href="site_image">
				<i class="mdi mdi-eye mdi-24px white-text"></i>
			</a>
		</div>
	</div>
	`,
	data: function () {
		return {
			base64: null,
			is_mobile: (Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0) < 992) || mobiledetector()
		}
	},
	computed: {
		site: function () {
			return this.base_url + '/' + this.info.account
		},
		site_image: function () {
			return this.base_url + '/artwork/view/' + this.info.accessname
		}
	},
	methods: {
		trigger_like: function (info) {
			if (this.$root.trigger_like != undefined) this.$root.trigger_like(info)
			else console.log('FUNCTION LIKE NO FOUND');
		},
		calcule_avatar: function () {
			return {'background-image': 'url("' + this.base_url + '/images/avatars/avatar_'+ this.info.user_avatar + '.jpg")'}
		},
		calculeimage: function () {
			if (this.info.category_main == 'R18') {
				return `images/artworks_lite/${this.info.accessname}.${this.info.extension}`;
			}
			return `images/artworks/${this.info.accessname}.${this.info.extension}`;
		},

		redirect: function () {
			window.location.href = this.info.account
		},
		send_events: function () {
			const info = {
				name: this.info.name,
				artwork: this.info.accessname,
				path: this.$refs.image.src,
				uploaded_date: this.info.uploaded_date
			}
			this.$emit('events', info)
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
		is_on_profile: Boolean,
		base_url: String
	},

	mounted: function () {
		//M.Dropdown.init(this.$refs.drop,{constrainWidth: false, alignment: 'left'});
	}
})
Vue.component('cg-grid',{
	template: `
	<div class="cg-grid-wrapper" ref="wrap">
		<div ref="menu" class="cg-grid">
			<div v-for="img of images" class="cg-grid-wrapper-img" :style="{ width: stack_size + 'px', height: (img.adsense ? stack_size + 'px' : 'auto')}">
				<cg-grid-image :base_url="base_url" v-if="!img.adsense" @changeimage="$emit('changeimage', $event)" @events="$emit('events_list', $event)" :info="img" :is_on_profile="is_on_profile" :is_on_account="is_on_account"></cg-grid-image>
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
				let elementEndStack = Array(count_stack).fill(null);
				this.$refs.menu.style.width = (count_stack * this.stack_size) + 'px'
				this.$emit('sizewrapper', count_stack * this.stack_size)
				for (var el of this.$el.querySelectorAll('.cg-grid-wrapper-img')) {
					el.classList.remove("cg-grid-image-end-stack");
					el.classList.remove("cg-grid-image-hide-info");
					el.style.height = 'auto'
					var near_index = stacks.findIndex(a => a == Math.min.apply(null, stacks));
					var img_height = el.offsetHeight;
					el.style.top = stacks[near_index] + 'px'
					el.style.left = (near_index * this.stack_size) + 'px'
					elementEndStack[near_index] = el
					stacks[near_index] += img_height;
					if (top_height < img_height) top_height = img_height
				}


				this.$refs.menu.style.height =  (this.is_on_profile ? Math.max.apply(null, stacks) : Math.min.apply(null, stacks)) + 'px'
				if (!this.is_on_profile) {
					for (var el of elementEndStack) {
						const limit_el = parseInt(el.style.top.replace('px',''));
						const limit = this.$refs.menu.offsetHeight
						const ideal_height_el = limit - limit_el;
						el.style.height = ideal_height_el + 'px'
						el.classList.add("cg-grid-image-end-stack");
						if (el.offsetHeight < 70) el.classList.add("cg-grid-image-hide-info");
					}
				}

			}
			const scale = this.$el.clientWidth / this.$refs.menu.clientWidth;
			const wrap_height = this.$refs.menu.offsetHeight * scale;
			document.documentElement.style.setProperty('--dropeditor', `scale(${2 - scale})`);
			this.$refs.menu.style['transform'] = `scale(${scale})`;
			this.$el.style.height = wrap_height + 'px';
			this.current_stacks = count_stack;
		}
	},
	mounted: function () {
		new ResizeSensor(this.$el, () => {this.calcule()});
		this.calcule()
	}
})
