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
		M.Dropdown.init(this.$refs.drop,{constrainWidth: false, alignment: 'right'});
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
