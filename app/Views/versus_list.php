<style media="screen">
.dashbox {
	background: white;
	display: flex;
	min-height: 120px;
	color: gray;
	width: 100%;
	border: 1px solid #0000001f;
	border-radius: 10px;
	height: 100%;
}
.dashbox i {
	padding: 16px;
	padding-right: 0;
	font-size: 1.5rem;
	color: var(--primary);
}
.dashbox-info {
	overflow: hidden;
	display: flex;
	justify-content: space-between;
	flex-direction: column;
	flex: 1;
}
.dashbox-info-description{
	padding: 1rem;
	padding-bottom: 0;
}
.dashbox-info-promoter{
	padding: 1rem;
	padding-top: 0;
	font-size: .8rem;
}
.dashbox-info-promoter a{
	color: gray;
}
.dashbox-info-promoter a:hover{
	text-decoration: underline;
}
.dashbox-title{
	font-size: 1.1rem;
	margin: 0;
	margin-bottom: .5rem;
	text-transform: uppercase;
}
.dashbox-description{
	font-size: .9rem;
	overflow: hidden;
	text-overflow: ellipsis;
	padding-bottom: .5rem;
}
#versus{
	height: 100%; width: 100%
}
#versus-content-off, #versus-list{
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	overflow-y: auto;
}
#versus-content-off img{
	height: 240px;
}
#versus-open{
	margin-top: 1rem;
	border-radius: 20px;
	background: transparent;
	color: var(--primary);
	border: 1px solid var(--primary)
}
article{
	padding: 1rem;
	padding-top: 3rem;
	max-width: 300px;
	font-size: .9rem;
	color: white;
	text-align: center;
}
article h1{
	font-size: 2rem;
	margin: 0;
}
.versus-info{
	width: 100%;
	display: flex;
	justify-content: space-between;
	align-items: center;
}
#versus-access-account-movil{
	display: none;
	height: 36px;
	color: white;
	background-color: var(--primary);
	border-radius:  20px;
	position: fixed;
	bottom: 2.2rem;
	line-height: 36px;
	padding: 0 1rem;
	left: 23px;
}
@media (max-width: 600px) {
	#versus-access-account{
		display: none;
	}
	#versus-access-account-movil{
		display: block;
	}
	#versus-content-off img{
		height: 200px;
	}
	.dashbox{
		height: auto;
		min-height: 0;
	}
	.dashbox-description{
		height: auto;
	}
}
.lateral-modal{
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background: #0000001f;
	z-index: 3;
	backdrop-filter: blur(2px);
	display: flex;
}
.lateral-modal-out{
	width: calc(100% - 400px)
}
.lateral-modal-container{
	height: 100%;
	position: relative;
	background-color: white;
	width: 100%;
	padding: 1rem;
	justify-content: center;
	display: flex;
	align-items: center;
	max-width: 400px;
	flex-direction: column;
}
.animated{
	animation-duration: .2s
}
</style>

<?php template_start() ?>
<div id="versus">
	<div id="modal1" class="modal" style="max-width: 400px">
		<div class="modal-content" >
			<div class="title-3">Applicar a <b>{{current_versus_apply.name}}</b></div>
			<p>
				<div class="title-4">Descripción</div>
				<div v-html="jumplinereplace(current_versus_apply.description)" style="font-size: .8rem"></div>
			</p>

		</div>
		<div class="modal-footer">
			<button class="btn" @click="confirm_apply" :disabled="is_send_apply">CONFIRMAR</button>
			<a class="modal-close waves-effect btn-flat">CANCELAR</a>

		</div>
	</div>
	<lateral-modal ref="modal">
		<div class="w100" style="max-width: 320px">
			<div class="c pb-4">
				<div class="title-3 combo-text-title">Registrar un versus</div>
				<span>Cree un versus y espere a un retador</span>
			</div>
			<form @submit.prevent="submit">
				<cg-field required sizechars="4-20" :watchisvalid.sync="title.isvalid" v-model="title.val" label="Titulo versus" placeholder="elija un titulo para su versus"></cg-field>
				<cg-textbox required sizechars="10-100" :watchisvalid.sync="description.isvalid" v-model="description.val" label="Detalles" placeholder="describa las caracteristicas de su versus"></cg-textbox>
				<div class="r pt-4">
					<a class="btn-flat" @click="$refs.modal.toggle()">CERRAR</a>
					<button type="submit" class="btn" :disabled="!isvalid || is_send">Registrar</button>
				</div>
			</form>
			<div class="pt-4 grey-text c" style="font-size: .9rem">#{{current_register_event.event_tag}}</div>
		</div>
	</lateral-modal>
	<?=  count($list_versus) ? '' : bg_default()?>
	<div id="versus-content-off" class="f-c" style="display: <?= count($list_versus) ? 'none' : 'flex' ?>">
		<img src="<?= base_url() ?>/images/vs_logo.png">
		<article>
			<h1>Versus cerrado</h1>
			<span>Evento promovido por la comunidad de artistas de <b>Art's Book</b>.</span>

		</article>
	</div>
	<div id="versus-list" style="display: <?= count($list_versus) == 0 ? 'none' : 'block' ?>">
		<?php if (empty($_SESSION['access'])): ?>
			<a href="<?= base_url() ?>/user/login" id="versus-access-account-movil">
				ACCEDE AQUI Y PARTICIPA
			</a>
		<?php endif; ?>
		<div class="container">
			<div class="c py-6">
				<div class="combo-text-title title-1">Art's Book Versus</div>
				<span>Encuentra un contrincante o inscribe tu versus :D</span>
			</div>
			<div class="" v-for="versus of list_versus">
				<div class="row">
					<div class="col s12">
						<div class="versus-info">
							<div>
								<div class="title-4 combo-text-title">{{versus.name}}</div>
								<span>{{formatdate(versus.voting)}} - VOTACIONES</span>
							</div>
							<?php if (!empty($_SESSION['access'])): ?>
								<a class="btn" @click="add_versus(versus)">
									<i class="mdi mdi-plus left mdi-18px"></i>
									<span>Nuevo</span>
								</a>
							<?php else: ?>
								<a id="versus-access-account" class="btn" href="<?= base_url() ?>/user/login?fromurl=<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
									<span>ACCEDE AQUI Y PARTICIPA</span>
								</a>
							<?php endif; ?>

						</div>

					</div>
				</div>
				<div id="versus-list-container" class="row">
					<div class="col s12 m6 l4 mb-4" v-for="item in participients[versus.event_tag]">
						<a class="dashbox">
							<i class="mdi mdi-apps"></i>
							<div class="dashbox-info">
								<div class="dashbox-info-description">
									<h4 class="dashbox-title">{{item.name}}</h4>
									<div class="dashbox-description" v-html="jumplinereplace(item.description)"></div>
								</div>
								<div class="dashbox-info-promoter f-b">
									<div>
										<a :href="'<?= base_url() ?>/'+item.account_promoter">creado por {{item.promoter}}</a>
										<div style="margin-top: -.2rem">
											<span style="height: 4px; width: 4px; background: var(--primary); display: inline-block"></span>
											<span class="ml-2">Nro. inscritos {{item.participients}}</span>
										</div>
									</div>
									<?php if (!empty($_SESSION['access'])): ?>
										<span class="btn"  v-if="active_user != item.account_promoter" @click="versus_apply(item)">RETAR</span>
									<?php endif; ?>

								</div>
							</div>
						</a>

					</div>
					<div class="col s12 m6 l4" v-for="item in (3 - (participients[versus.event_tag].length > 3 ? 3 : participients[versus.event_tag].length))">
						<a class="dashbox mb-2 f-c p-4">
							<span>Versus pendiente</span>
						</a>
					</div>
				</div>
			</div>
			<div style="height: 4rem;"></div>
		</div>
	</div>
</div>

<?php $template = template_end() ?>
<script type="text/javascript">
const $_module = {
	template: `<?= $template ?>`,
	data: function () {
		return {
			list_versus: <?= json_encode($list_versus) ?>,
			participients: <?= json_encode($list_participients) ?>,
			title: {val: '', isvalid: false},
			description: {val: '', isvalid: false},
			current_register_event: {},
			current_versus_apply: {},
			is_send: false,
			is_send_apply: false,
			modal: null,
			active_user: '<?= !empty($_SESSION['access']) ? $_SESSION['access']['account'] : ''  ?>'
		}
	},
	computed: {
		isvalid: function () {
			return this.title.isvalid && this.description.isvalid && this.current_register_event.event_tag != undefined
		}
	},
	mounted: function () {

    	this.modal = $('.modal').modal();

	},
	methods: {
		clear: function () {
			this.title.val = ''
			this.description.val = ''
			this.current_register_event = {}
		},
		jumplinereplace: function (text) {
			if (text != undefined) return text.replace(/\n/g,'<br>')
			return '';
		},
		formatdate: function (date) {
			var event = new Date(date);
			var options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
			return event.toLocaleDateString('es-ES', options).toUpperCase()
		},
		versus_apply: function (apply) {
			this.current_versus_apply = apply
			this.modal.modal('open')
		},
		confirm_apply: function () {
			const data = {versus: this.current_versus_apply.versus}
			this.is_send_apply = true
			$.post('<?= base_url() ?>/service/events/apply_versus', data, (res) => {
				M.toast({html: res.message, classes: 'rounded'});
				this.modal.modal('close')
				this.is_send_apply = false
			}).fail(() => {
		        M.toast({html: 'ERROR EN LA PAGINA, VUELVA MÁS TARDE', classes: 'rounded bg-alert'});
				this.is_send_apply = false
		    });
		},
		submit: function () {
			if (this.isvalid) {
				const data = {title: this.title.val, description: this.description.val, tag: this.current_register_event.event_tag}
				this.is_send = true
				$.post('<?= base_url() ?>/service/events/versuslist_save', data, (res) => {

					if (res.message == 'REGISTRO EXITOSO') {
						this.$refs.modal.toggle()
						this.clear()
					}
					M.toast({html: res.message, classes: 'rounded'});
					this.is_send = false
				}).fail(() => {
			        this.is_send = false
					M.toast({html: 'ERROR EN LA PAGINA, VUELVA MÁS TARDE', classes: 'rounded bg-alert'});
			    });

			}
		},
		add_versus: function (versus) {
			this.clear()
			this.current_register_event = versus
			this.$refs.modal.toggle()
		}
	}
}
</script>
