Vue.component('simplebar',{
	template: '<div ref="simplebar"> <slot></slot> </div>',
	data: function () {
		return {bar: null}
	},
	mounted: function () {
		this.bar = new SimpleBar(this.$refs.simplebar);
	},
	methods: {
		getScrollElement: function () {
			if (this.bar) return this.bar.getScrollElement();
			return null
		}
	}
})
