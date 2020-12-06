<style media="screen">
.dashbox {
	background: white;
	display: flex;
	min-height: 120px;
	color: gray;
	height: 128px;
	width: 100%;
	border: 1px solid #0000001f;
}
.dashbox i {
    padding: 16px;
    padding-right: 0;
    font-size: 1.5rem;
    color: var(--primary);
}
.dashbox-info {
    padding: 16px;
}
.dashbox-title{
	font-size: 1.5rem;
	margin: 0;
	margin-bottom: .5rem;
}
</style>
<?php template_start() ?>
	<div id="versus-list">
		<div class="container">
			<div class="c py-6">
				<div class="combo-text-title title-1">Art's Book Versus</div>
				<span>Encuentra un contrincante o inscribe tu versus :D</span>
			</div>
			<div id="versus-list-container" class="row">
				<div class="col s12 m6 l4" v-for="n in 6">
					<a class="dashbox mb-2">
						<i class="mdi mdi-apps"></i>
						<div class="dashbox-info">
							<h4 class="dashbox-title">Tema de mi versus</h4>
							<div class="dashbox-description">
								Aqui va la descripcion de tu versus, puedes explayarte con los detalles en un maximo de 120 letras
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="">
				<cg-field></cg-field>
				<cg-textbox></cg-textbox>
			</div>
		</div>
	</div>
<?php $template = template_end() ?>
<script type="text/javascript">
	const $_module = {
		template: `<?= $template ?>`,
	}
</script>
