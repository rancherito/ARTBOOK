Vue.component('simplebar',{
	template: '<div ref="simplebar"> <slot></slot> </div>',
	mounted: function () {new SimpleBar(this.$refs.simplebar);}
})
