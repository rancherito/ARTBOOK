Vue.component('cg-button',{
	template: `
		<button :disabled="disabled || loading" class="btn waves waves-effect waves-light">
			<i :class="classicon" class="right" v-if="!loading"></i> <span v-if="!loading">{{text}}</span>
			<div v-if="loading" class="cg-button-preloader" :style="{width: progress + '%'}"></div>
			<div v-if="loading">
				<div class="spinner">
				  <div class="rect1"></div>
				  <div class="rect2"></div>
				  <div class="rect3"></div>
				  <div class="rect4"></div>
				  <div class="rect5"></div>
				</div>
			</div>

		</button>
	`,
	props: {
		'disabled': Boolean,
		loading: {type: Boolean, default: false},
		progress: {type: Number, default: 0},
		classicon: {type: String, default: 'mdi mdi-content-save'},
		text: {type: String, default: 'ENVIAR'}
	}
})
Vue.component('cg-select', {
	template: `
	<div class="cg-select" :class="{'cg-select-notvalid': !validation && firstUse, 'cg-disabled': disabled, 'cg-field-isloading': loading}">
		<div class="cg-field-wrap">
			<div class="cg-field-loader"></div>
			<label v-if="this.label != undefined && !loading" class="cg-label" :for="name">{{label}}</label>
			<select class="cg-field-in browser-default" v-if="!loading" :disabled="disabled || loading" @blur="change" @input="inputchange" ref="select" :name="name" :value="value" @change="change"> <slot></slot></select>
			<div class="cg-field-loading-message" v-if="loading">CARGANDO {{label}}</div>
		</div>
		<div class="cg-field-details">
			<div v-if="required" class="cg-field-details-message">{{(!validation && firstUse) ? 'selección no valida': (firstUse ? 'correcto' : 'requerido')}}</div>
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
		let form = $(this.$el).parents('from:first')[0];
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
			<input @keydown="keydown" class="cg-field-in browser-default" :placeholder="placeholder" :type="type == 'password' ? 'password' : 'text'" v-if="!loading" :disabled="disabled || loading" @blur="change" @input="inputchange" ref="input" :name="name" :value="value" @change="change">
			<div class="cg-field-loading-message" v-if="loading">CARGANDO {{label}}</div>
		</div>
		<div class="cg-field-details">
			<div class="cg-field-details-message">
			  	<span v-if="required">{{(!validation && firstUse) ? messageaValidation : ( empty ? 'opcional' : (firstUse ? 'correcto' : 'requerido'))}}</span>
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
		chars: [Object, String],
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
							else if (value.replace(' ','').match(/^[0-9]+\-[0-9]+$/gi) !== null) return parseInt(value.split('-')[1]);
						}
					}).filter(val => typeof val == 'number')
				)
			}
			return this.maxchardefault
		},
		minchar: function () {
			if (this.sizechars != undefined) {
				let a = Array.isArray(this.sizechars) ? this.sizechars : [this.sizechars]
				return Math.min.apply(null,
					a.map(function (value) {
						if (typeof value === "number") return value;
						else if (typeof value === "string") {
							if (!isNaN(value)) return parseInt(value);
							else if (value.replace(' ','').match(/^[0-9]+\-[0-9]+$/gi) !== null) return parseInt(value.split('-')[0]);
						}
					}).filter(val => typeof val == 'number')
				)
			}
			return 0
		},
		validation: function () {
			let val = this.caculedvalidation()
			this.$emit('update:watchisvalid',val)
			return val
		}
	},
	mounted: function () {
		this.$emit('update:isvalid', this.isValid)
		let form = $(this.$el).parents('from:first')[0];
		if (form) {
			form.addEventListener('submit', (e) => {
				if (!this.isValid()) e.preventDefault()
			});
		}

	},
	methods: {
		validateEmail: function () {
			if (this.type == 'email') {
				this.messageaValidation = 'ingrese un email valido'
				const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				return re.test(this.value);
			 }
			 return !0
	  	},
		caculedvalidation: function () {
			if (this.required) {
				if (this.empty && this.value == '') return !0
				return this.validatevoid() && this.validatenotvalus() && this.validatesize() && this.validateEmail()
			}
			return !0
		},
		validatesize: function () {
			if (this.sizechars != undefined) {
				const min = this.minchar;

				this.messageaValidation = this.value.length < min ? 'minimo ' + min +' caracteres' : 'caracteres exedidos'
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
		inputchange: function (ff) {
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
