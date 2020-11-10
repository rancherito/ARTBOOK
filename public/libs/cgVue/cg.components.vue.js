Vue.component('cg-grid',{
	template: `
	<div class="cg-grid-wrapper">
		<div ref="menu" class="cg-grid">
			<div v-for="img of images" class="cg-grid-wrapper-img" :style="{ width: stack_size + 'px'}">
				<img loading="lazy" class="cg-grid-img" :height="img.height" :width="img.width" :src="img.url">
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
		'images': Array,
		stack_size: { type: Number, default: 200}
	},
	methods: {
		calcule: function () {
			var top_height = 0;
			var count_stack = parseInt(this.$el.clientWidth / this.stack_size);
			if (count_stack !== this.current_stacks) {
				let stacks = Array(count_stack).fill(0);
				this.$refs.menu.style.width = (count_stack * this.stack_size) + 'px'
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
Vue.component('cg-select', {
	template: `
	<div class="cg-select" :class="{'cg-select-notvalid': !validation && firstUse, 'cg-disabled': disabled, 'cg-field-isloading': loading}">
		<div class="cg-field-wrap">
			<div class="cg-field-loader"></div>
			<label v-if="this.label != undefined && !loading" class="cg-label" :for="name">{{label}}</label>
			<select v-if="!loading" :disabled="disabled || loading" @blur="change" @input="inputchange" ref="select" :name="name" :value="value" @change="change"> <slot></slot></select>
			<div class="cg-field-loading-message" v-if="loading">CARGANDO {{label}}</div>
		</div>
		<div class="cg-field-details">
			<div v-if="required" class="cg-field-details-message">{{(!validation && firstUse) ? 'selección no valida': (firstUse ? 'correcto' : 'obligatorio')}}</div>
		</div>
	</div>
	`,
	data: function () {
		return {
			firstUse: false,
		}
	},
	props: {
		name: {type: String, default: 'cg-input-' + (parseInt(Math.random() * 100000))},
		label: String,
		value: [String, Number],
		novalues: [Array, Number, String],
		required: Boolean,
		disabled: Boolean,
		loading: Boolean,
		isvalid: [Function, Object],
		watchisvalid: [Boolean, Number],
	},
	computed: {
		validation: function () {
			let val = this.caculedvalidation()
			this.$emit('update:watchisvalid',val)
			return val
		}
	},
	mounted: function () {
		this.$emit('update:isvalid', this.isValid)
		let form = this.$el.closest('form');
		if (form) {
			form.addEventListener('submit', (e) => {
				if (!this.isValid()) e.preventDefault()
			});
		}
	},
	methods: {
		caculedvalidation: function () {
			if (this.required) {
				if (this.empty && this.value == '') return !0
				return this.validatevoid() && this.validatenotvalus()
			}
			return !0
		},
		validatenotvalus: function () {
			if (this.novalues != undefined) {
				let valid = true;

				this.messageaValidation = 'Selecion no valida'
				let list = Array.isArray(this.novalues) ? this.novalues : [this.novalues]
				for (var v of list) valid &= !((this.value + '').toLowerCase() == (v + '').toLowerCase())
				return valid == 1
			}
			return !0
		},
		validatevoid: function () {
			this.messageaValidation = 'Seleccion una opcion'
			return !(this.value == undefined || this.value == null || this.value == '')
		},
		isValid: function () {
			this.change()
			return this.validation;
		},
		inputchange: function () {
			this.$emit('input', this.$refs.select.value)
		},
		change: function () {this.firstUse = true}
	}
})
Vue.component('cg-field', {
	template: `
	<div class="cg-field" :class="{'cg-field-notvalid': !validation && firstUse, 'cg-disabled': disabled, 'cg-field-isloading': loading}">
		<div class="cg-field-wrap">
			<div class="cg-field-loader"></div>
			<label v-if="this.label != undefined && !loading" class="cg-label" :for="name">{{label}}</label>
			<input @keydown="keydown" class="browser-default" :placeholder="placeholder" :type="type" v-if="!loading" :disabled="disabled || loading" @blur="change" @input="inputchange" ref="input" :name="name" :value="value" @change="change">
			<div class="cg-field-loading-message" v-if="loading">CARGANDO {{label}}</div>
		</div>
		<div class="cg-field-details">
			<div class="cg-field-details-message">
			  	<span v-if="required">{{(!validation && firstUse) ? messageaValidation : ( empty ? 'opcional' : (firstUse ? 'correcto' : 'obligatorio'))}}</span>
			</div>
			<div>{{value.length}}/{{maxchar}}</div>
		</div>
	</div>
	`,
	data: function () {
		return {
			firstUse: false,
			messageaValidation: 'Entrada no valida',
			maxchardefault: 50,
			button: null
		}
	},
	props: {
		name: {type: String, default: 'cg-input-' + (parseInt(Math.random() * 100000))},
		label: String,
		type: {type: String, default: 'text'},
		value: {type: String, default: ''},
		novalues: [Array, Number, String],
		sizechars: [Array, Number, String],
		required: Boolean,
		disabled: Boolean,
		loading: Boolean,
		watchisvalid: [Boolean, Number],
		isvalid: [Function, Object],
		number: Boolean,
		placeholder: String,
		empty: Boolean
	},
	computed: {
		maxchar: function () {
			if (this.sizechars != undefined) {
				let a = Array.isArray(this.sizechars) ? this.sizechars : [this.sizechars]
				return Math.max.apply(null,
					a.map(function (value) {
						if (typeof value === "number") return value;
						else if (typeof value === "string") {
							if (!isNaN(value)) return parseInt(value);
							else if (value.replaceAll(' ','').match(/^[0-9]+\-[0-9]+$/gi) !== null) return parseInt(value.split('-')[1]);
						}
					}).filter(val => typeof val == 'number')
				)
			}
			return this.maxchardefault
		},

		validation: function () {
			let val = this.caculedvalidation()
			this.$emit('update:watchisvalid',val)
			return val
		}
	},
	mounted: function () {
		this.$emit('update:isvalid', this.isValid)
		let form = this.$el.closest('form');
		if (form) {
			form.addEventListener('submit', (e) => {
				if (!this.isValid()) e.preventDefault()
			});

		}

	},
	methods: {
		caculedvalidation: function () {
			if (this.required) {
				if (this.empty && this.value == '') return !0
				return this.validatevoid() && this.validatenotvalus() && this.validatesize()
			}
			return !0
		},
		validatesize: function () {
			if (this.sizechars != undefined) {
				this.messageaValidation = 'corregir nro de carracteres'
				var valDim = false;
				let list = Array.isArray(this.sizechars) ? this.sizechars : [this.sizechars]
				for (var value of list) {
					if (typeof value === "number") valDim |= this.value.length === value;
					if (typeof value === "string") {
						if (!isNaN(value)) valDim |= this.value.length === parseInt(value);
						else {
							if (value.match(/^[0-9]+[ ]{0,1}\-[ ]{0,1}[0-9]+$/gi) !== null) {
								var arrg = value.split('-');
								arrg[0] = parseInt(arrg[0]);
								arrg[1] = parseInt(arrg[1]);
								valDim |= this.value.length >= arrg[0] && this.value.length <= arrg[1];
							}
						}
					}
				}
				return valDim;
			}
			return !0
		},
		validatenotvalus: function () {
			if (this.novalues != undefined) {
				let valid = true;

				this.messageaValidation = 'Entrada no valida'
				let list = Array.isArray(this.novalues) ? this.novalues : [this.novalues]
				for (var v of list) valid &= !((this.value + '').toLowerCase() == (v + '').toLowerCase())
				return valid == 1
			}
			return !0
		},
		validatevoid: function () {
			this.messageaValidation = 'Entrada vacia'
			return !(this.value == undefined || this.value == null || this.value == '')
		},
		isValid: function () {
			this.change()
			return this.validation;
		},
		inputchange: function () {
			this.$emit('input', this.$refs.input.value)
		},
		change: function () {
			this.firstUse = true
		},
		keydown: function (evt) {
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			this.change()
			if (this.value.length >= this.maxchar && !(charCode == 13 || charCode == 8 || charCode == 9)) evt.preventDefault()
			if(this.number) if (!(charCode == 13 || charCode == 8 || charCode == 9 || (charCode >= 96 && charCode <= 105) || (charCode >= 48 && charCode <= 57))) evt.preventDefault();
		}
	}
})

Vue.component('cg-button',{
	template: `
		<button type="submit" class="btn waves waves-effect waves-light">
			<i class="mdi mdi-key right"></i>
			<span>ACCEDER</span>
		</button>
	`,
	data: function () {
		return {
			list: []
		}
	},
	props: ['items']
})
