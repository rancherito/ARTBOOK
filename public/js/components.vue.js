Vue.component('cg-grid',{
	template: `
	<div class="cg-grid-wrapper">
		<div ref="menu" class="cg-grid">
			<div v-for="img of images" class="cg-grid-wrapper-img" :style="{ width: stack_size + 'px'}">
				<div>
					<img loading="lazy" class="cg-grid-img" :height="img.height" :width="img.width" :src="calculeimage(img)">
					<div class="cg-grid-info">
						<span>{{img.name}}</span>
					</div>

				</div>
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
		calculeimage: function (image) {
			return `images/artworks/${image.accessname}.${image.extension}`
		},
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
