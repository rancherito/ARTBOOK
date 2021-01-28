Vue.component('slider-feed-nartwork',{
	template: `
	<div class="slider-feed-nartwork">
		<div class="slider-feed-nartwork-heart" :class="{'feed-heart-active': data.heart}" @click="trigger_heart(data)">
			<i class="mdi" :class="data.heart ? 'mdi-heart' : 'mdi-heart-outline'"></i>
		</div>
		<time class="slider-feed-nartwork-date">{{data.diffHuman}}</time>

		<a ref="anchor">
			<img :src="$root.base_url+'/images/artworks_lite/'+data.accessname+'.'+data.extension" :alt="data.name">
		</a>
	</div>
	`,
	data: function () {
		return {
		}
	},
	props: ['data'],
	methods: {
		trigger_heart: function (info) {
			if (this.$root.trigger_like != undefined) this.$root.trigger_like(info)
			else console.log('FUNCTION LIKE NO FOUND');
		}
	},
	mounted: function () {
		this.$refs.anchor.addEventListener('click', (e) => {
			window.location = this.$root.base_url + '/artwork/view/' + this.data.accessname
		})
	}
})
Vue.component('slider-feed-nartwork-container', {
	template: `<div ref="wrapper" class="slider-feed-nartwork-container">
		<div ref="container" :style="{'min-width': width + 'px'}">
			<slider-feed-nartwork v-for="artwork of data" :data='artwork'></slider-feed-nartwork>
		</div>
	</div>`,
	data: function () {
		return {
			width: 3000
		}
	},
	props: ['data'],
	methods: {
		calcule_width: function () {

			//const items_in_row = parseInt(this.$refs.wrap.offsetWidth/this.size_stack);
			//const items_new_width = Math.round(this.$refs.wrap.offsetWidth/items_in_row)
			//this.size = items_new_width
			//for (var child of this.$children) child.size = items_new_width;
			this.width = this.$children.length * (this.size_stack)
		}
	},
	mounted: function () {
		new ResizeSensor(this.$refs.wrapper, () => {this.calcule_width()});
		this.calcule_width();

		/*var mc = new Hammer(this.$refs.wrapper);

		mc.on("panleft panright", (ev) => {
			console.log(ev);
			//$(this.$refs.wrapper).animatescroll();
			if (ev.isFinal) {
				this.$refs.wrapper.scrollLeft += ev.distance * (ev.type =='panleft' ? 1 : -1)
			}

		});*/

	},
	created: function () {

	}
})
Vue.component('event-list', {
	template: `
	<div class="w100 event-list">
		<div v-if="exists_events">
			<div class="combo-text-title"> <i class="mdi mdi-apps mdi-18px pr-2"></i> LISTA DE EVENTOS</div>
			<span>Adjunte su artwork a uno de los eventos pendientes que tiene</span>
		</div>
		<div v-else class="card-panel grey white-text">
			NO HAY EVENTOS DISPONIBLES PARA INSCRIBIR ESTE ARTWORK
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
		};
	},
	computed: {
		artwork_apply(){
			return this.$root.event_vs_artwork_apply_user;
		},
		list_events(){
			return this.$root.event_vs_register_user
		},
		is_registered: function () {
			if (this.artwork_apply.artwork != undefined) {
				for (var ev of this.list_events) if (ev.artwork == this.artwork_apply.artwork) return true;
			}
			return false
		},
		exists_events: function () {
			let exists = false;
			for (let evt of this.list_events) exists |= this.dateCheck(evt.event_start, evt.voting, this.artwork_apply.uploaded_date);
			return exists;
		},
	},
	methods: {
		load_data (){
			this.$root.load_event_vs_register_user();
		},
		calcule_artwok_path: function (e_item) {
			return  `url('${this.$root.base_url}/images/artworks_lite/${e_item.artwork}.${e_item.extension}')`
		},
		dateCheck: function(from,to,check) {
			let [fDate,lDate,cDate] = [Date.parse(from), Date.parse(to), Date.parse(check)]
			return (cDate <= lDate && cDate >= fDate);
		},

		apply_artwork: function (event_info) {
			const data = {versus: event_info.versus, artwork: this.artwork_apply.artwork}

			$.post(this.$root.base_url + '/service/events/apply_versus', data, (res) => {
				this.load_data();
			})
		},
	},
	mounted: function () {

		this.load_data();
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
					<div style="max-height: 360px; overflow-y: auto" class="w100">
						<event-list ></event-list>
					</div>
					<div class="c py-4">
						<a class="btn" @click="steps = 4">
							<span>SIGUINENTE</span>
						</a>
					</div>
				</div>
				<div class="p-4 upload-editor-after-finish f-c" v-show="steps == 4">
					<h3>TODO LISTO</h3>
					<i class="mdi mdi-check py-5 primary" style="font-size: 3.5rem;"></i>
					<div class="c py-4">
						<a class="btn-flat" @click="steps = 3">
							<i class="mdi mdi-arrow-left"></i>
						</a>
						<a class="btn" :href="$root.base_url + '/' + author">
							<span>MI MURAL</span>
						</a>

					</div>
				</div>
			</div>
		</div>
	</div>
	`,
	data: function () {
		return {
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
				this.$root.event_vs_artwork_apply_user = res.data.artwork_info
				this.load.isUploading = false
			})
		},
		change({coordinates, canvas}) {

			this.image = canvas.toDataURL('image/jpeg', 0.8)

			this.steps = 1
			this.isLoadImage = true

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
		<a @click="artwork_action" v-show="$parent.is_on_account" class="cg-grid-image-options btn-icon btn-dark waves waves-effect waves-light">
			<i class="mdi-24px mdi mdi-fire"></i>
		</a>
		<div class="cg-grid-artwork-content">
			<div class="cg-grid-img-restricted-indicator f-c w100 c p-4" v-if="info.category_main == 'R18'">CONTENIDO MADURO</div>

			<img ref="image" loading="lazy" class="cg-grid-img" :src="calculeimage()">
			<div class="cg-grid-artwork-name">
				<div class="cg-grid-info"  v-if="!$parent.is_on_profile">
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
				<i class="mdi mdi-image-filter-none mdi-24px white-text"></i>
			</a>
		</div>
	</div>
	`,
	data: function () {
		return {
			is_mobile: (Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0) < 992) || mobiledetector(),
			base_url: this.$root.base_url,
			module_user: null
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
		artwork_action: function () {
			if (this.module_user.modal_openimage) {
				this.info.artwork = this.info.accessname
				this.$root.event_vs_artwork_apply_user = this.info
				this.module_user.modal_openimage.modal('open')
			}
		},
		trigger_like: function (info) {
			if (this.$root.trigger_like != undefined) this.$root.trigger_like(info)
			else console.log('FUNCTION LIKE NO FOUND');
		},
		calcule_avatar: function () {
			return {'background-image': 'url("' + this.base_url + '/images/avatars/avatar_'+ this.info.user_avatar + '.jpg")'}
		},
		calculeimage: function () {
			if (this.info.category_main == 'R18') return `images/artworks_lite/${this.info.accessname}.${this.info.extension}`;
			return `images/artworks_small/${this.info.accessname}.${this.info.extension}`;
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
		}
	},
	props: {
		info: Object
	},
	mounted: function () {
		for (let compo of this.$root.$children) if (compo.$options._componentTag == 'module') {this.module_user = compo; break;}
	}
})
Vue.component('cg-grid',{
	template: `
	<div class="cg-grid-wrapper" ref="wrap">
		<div ref="menu" class="cg-grid" :style="{height: 'calc(' + wrap_height + 'px - 4px)'}">
			<div
				v-for="(img,i) of images" class="cg-grid-wrapper-img"
				:class="{'cg-grid-image-end-stack' : img.end_stack, 'cg-grid-image-hide-info': img.hide_info}"
				:style="{
					width: stack_size_adaptative + 'px',
					height: img.height_adatable + 'px',
					transform: 'translate(' + img.left + 'px,' + img.top + 'px)'
				}">
				<cg-grid-image
					:info="img"
					:is_on_profile="is_on_profile"
					:is_on_account="is_on_account">
				</cg-grid-image>
			</div>
		</div>
	</div>
	`,
	data: function () {
		return {
			current_stacks: 0,
			stack_size_adaptative: 200,
			count_stack: 0,
			wrap_height: 0,
			base_url: this.$root.base_url
		}
	},
	props: {
		images: Array,
		stack_size: { type: Number, default: 200},
		is_on_account: Boolean,
		is_on_profile: Boolean,
	},
	updated: function () {
	  this.$nextTick(this.calcule)
	},
	methods: {
		calcule: function () {
			this.count_stack = parseInt((this.$el.clientWidth + 4) / this.stack_size);
			this.stack_size_adaptative = ((this.$el.clientWidth + 4) / this.count_stack)
			let stacks = Array(this.count_stack).fill(0);
			let elementEndStack = Array(this.count_stack).fill(null);
			for (var el of this.images) {
				el.end_stack = false;
				el.hide_info = false;
				var near_index = stacks.findIndex(a => a == Math.min.apply(null, stacks));
				let is_r18 = el.category_main == 'R18';
				var img_height = ((this.stack_size_adaptative * (is_r18 ? 400 : el.height)) / (is_r18 ? 400 : el.width));
				el.height_adatable = img_height;
				el.top = stacks[near_index]
				el.left = (near_index * this.stack_size_adaptative)
				elementEndStack[near_index] = el
				stacks[near_index] += img_height;
			}
			this.wrap_height =  (this.is_on_profile ? Math.max.apply(null, stacks) : Math.min.apply(null, stacks))
			if (!this.is_on_profile) {
					for (var el of elementEndStack) {
						const limit_el = el.top;
						const limit = this.wrap_height
						const ideal_height_el = limit - limit_el;
						el.height_adatable = ideal_height_el
						el.end_stack = true
						if (el.height_adatable < 70) el.hide_info = true
					}
				}


		}
	},
	mounted: function () {
		new ResizeSensor(this.$el, () => {this.calcule()});
		this.calcule()
	}
})
