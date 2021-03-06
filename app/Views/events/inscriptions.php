<?php $_SESSION['redirect_access'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>
<style media="screen">
.dashbox {
	background: white;
	display: flex;
	flex-direction: column;
	justify-content: space-between;
	width: 100%;
	border-radius: 10px;
	height: 100%;
	position: relative;
}

.dashbox-info {
	display: flex;
	width: 100%;
	align-items: center;
	height: 40px;
	padding: 0 1rem;
	margin: .5rem 0;

	color: var(--primary);
}
.dashbox-info > i{
	font-size: 1.5rem;
	color: var(--primary);
	padding-right: .5rem;
}
.dashbox-info-description{
	flex: 1;
}
.dashbox-promoter-mark{
	position: absolute;
	top: 1rem;
	right: 1rem;
	padding: 0 .5rem;
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: 20px;
	background: lightgray;
}
.dashbox-promoter-mark a{
	color: gray;
}
.dashbox-promoter-mark span::before{
	display: block;
}
.dashbox-info-promoter{
	padding: 1rem;
	padding-top: 0;
	width: 100%;
	font-size: .8rem;
	display: flex;
	flex-wrap: nowrap;
}
.dashbox-info-promoter a{
	padding: .25rem .5rem;
	border-radius: 20px;
	background-color: var(--gray);
	margin: 2px;
	max-width: 33%;
	overflow: hidden;
	text-overflow: ellipsis;
	white-space: nowrap;
	color: gray;
}
.dashbox-info-promoter a:hover{
	text-decoration: underline;
}
.dashbox-title{
	font-size: 1.2rem;
	text-transform: uppercase;
}
.dashbox-description{
	font-size: .9rem;
	overflow: hidden;
	text-overflow: ellipsis;
	padding-bottom: .5rem;
}

#versus-content-off, #versus-list{
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
#versus-apply-content{
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	padding: 1rem;
}
#versus-apply-content > div {
	max-width: 320px;
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
	z-index: 2
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

<?php module_start() ?>
<div id="versus">
	<div ref="modal_confirmar" class="modal" style="max-width: 400px">
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
	<div ref="modal_confirmar_invitation" class="modal" style="max-width: 400px">
		<div class="modal-content f-c">

				<i class="mdi mdi-fire primary pt-4" style="font-size: 2rem;"></i>
				<h4 class="pb-4">{{vs_invitation.name}}</h4>
				<div class="py-4 c" v-if="is_acepted_invitation">
					YA ESTAS INSCRITO EN ESTE VERSUS <br>
					😊
				</div>
				<div v-else v-html="jumplinereplace(vs_invitation.description)"></div>

				<b>Inscritos ({{vs_invitation.participients}})</b>
				<div class="dashbox-info-promoter w100">
					<a v-for="applicant of vs_invitation.applicants">{{applicant.nickname}}</a>
				</div>

		</div>
		<div class="modal-footer">
			<?php if (is_access()): ?>
				<template v-if="!is_acepted_invitation">
					<span class="btn" @click="confirm_invitation" :disabled="is_send_apply">ACEPTAR VERSUS</span>
				</template>
			<?php else: ?>
				<a href="<?= base_url() ?>/user/login?fromurl=<?= base64_encode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]")?>" class="btn">INICIAR SESION</a>
			<?php endif; ?>
			<a class="modal-close waves-effect" :class="is_acepted_invitation ? 'btn' : 'btn-flat'">{{is_acepted_invitation ? 'ACEPTAR' : 'CERRAR'}}</a>

		</div>
	</div>
	<div ref="modal_versus_add" class="modal" style="max-width: 400px">
		<form @submit.prevent="submit">
			<div id="versus-apply-content">
				<div class="w100">
					<div class="c py-5">
						<div class="title-3 combo-text-title">Registrar un versus</div>
						<span>Cree un versus y espere a un retador</span>
					</div>

					<cg-field required sizechars="4-26" :watchisvalid.sync="title.isvalid" v-model="title.val" label="Titulo versus" placeholder="elija un titulo para su versus"></cg-field>
					<cg-textbox required sizechars="10-200" :watchisvalid.sync="description.isvalid" v-model="description.val" label="Detalles" placeholder="describa las caracteristicas de su versus"></cg-textbox>
					<div class="py-4">
						<label >
							<input v-model="versus_isPublic" type="checkbox" class="filled-in" checked="checked" />
							<span>{{
								versus_isPublic ?
								'Este versus es publico para otros participantes'	:
								'Este versus requiere el LINK de INVITACIÓN para otros participantes'
							}}</span>
						</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn" :disabled="!isvalid || is_send">Registrar</button>
				<a class="btn-flat modal-close">CERRAR</a>
			</div>
		</form>
	</div>


		<div class="container">
			<div class="f-c py-5">
				<div class="combo-text-title title-1"><?= $list_versus['name'] ?></div>
				<span>Encuentra un contrincante o inscribe tu versus :D</span>
				<h4 class="f-b">
					<span class="pr-2"> Votaciones en </span>
					<cg-countdown :datestring="versus.voting"></cg-countdown>

				</h4>
				<?php if (is_access()): ?>
					<button class="btn mt-4" @click="add_versus">CREAR UN VERSUS</button>
				<?php else: ?>
					<a href="<?= base_url() ?>/user/login?fromurl=<?= base64_encode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>" class="btn mt-4">
						ACCEDE Y PARTICIPA
					</a>
				<?php endif; ?>
			</div>
				<div id="versus-list-container" class="row">
					<div class="col s12 py-4" v-if="my_participations.length > 0">
						<i class="mdi mdi-account primary pr-2"></i>
						MIS PARTICIPACIONES
					</div>
					<div class="col s12 m6 l4 xl3 mb-4" v-for="item in my_participations">
						<dashbox :data="item"></dashbox>
					</div>
					<div class="col s12 py-4">
						<i class="mdi mdi-apps primary pr-2"></i>
						LISTA DE VERSUS
					</div>
					<div class="col s12 m6 l4 xl3 mb-4" v-if="!calcule_participation(item.applicants)" v-for="item in participients">
						<dashbox :data="item"></dashbox>
					</div>
				</div>
		</div>
</div>

<?php module_end() ?>
<script type="text/javascript">
Vue.component('dashbox',{
	template : `
	<div class="dashbox">

		<div>
			<div class="dashbox-info">
				<div class="dashbox-info-description">
					<h3 class="dashbox-title">{{data.name}}</h3>
				</div>
			</div>
			<div v-if="false" class="dashbox-description" v-html="jumplinereplace(data.description)"></div>
			<div class="dashbox-info-promoter">
				<template v-if="data.applicants.length > 0">
					<a :href="$root.base_url + '/' + applicant.account" v-for="applicant of data.applicants">{{applicant.nickname}}</a>
				</template>
				<span v-else>NO HAY REGISTRADOS</span>
			</div>
		</div>
		<div class="pb-4 px-4 f-b w100">
			<div>
				<a class="btn-icon bg-secondary white-text" v-if="data.state_inscription == 'P' || data.account_promoter == $root.current_account" style="cursor: pointer" @click="generatelinkshare">
					<i class="px-1 mdi mdi-share-variant"></i>
				</a>
			</div>
		<?php if (is_access()): ?>
			<span v-if="calcule_participation(data.applicants)" disabled class="btn btn-small">ESTAS AQUI</span>
			<template v-else>
				<span v-if="data.state_inscription == 'P' || data.account_promoter == $root.current_account" class="btn btn-small" @click="versus_apply">RETAR</span>
				<span v-else class="btn btn-small" disabled >PRIVADO</span>
			</template>
		<?php endif; ?>

		</div>
	</div>
	`,
	data: function () {
		return {
		}
	},
	props: ['data'],
	methods: {
		generatelinkshare: function () {
			copyStringToClipboard(this.$root.base_url + `/events/versus/${this.data.tag}?id=${this.data.versus}`);
			M.toast({html: 'Link de ' + this.data.name +' copiado con exito', classes: 'rounded bg-primary'});
		},
		jumplinereplace: function (text) {
			if (text != undefined) return text.replace(/\n/g,'<br>')
			return '';
		},
		calcule_participation: function (applicants) {
			let active = false;
			for (var applicant of applicants) active |= applicant.account == this.$root.current_account
			return active
		},
		versus_apply: function () {
			this.$parent.current_versus_apply = this.data
			this.$parent.modal_confirmar.modal('open')
		},
	}
})
$_module = {
	data: function () {
		return {
			versus: <?= json_encode($list_versus) ?>,
			participients: <?= json_encode($list_participients) ?>,
			title: {val: '', isvalid: false},
			description: {val: '', isvalid: false},
			versus_isPublic: true,
			current_versus_apply: {},
			is_send: false,
			is_send_apply: false,
			modal_confirmar: null,
			modal_versus_add: null,
			modal_confirmar_invitation: null,
			vs_invitation: <?= json_encode($invitation) ?>,
			is_acepted_invitation: false
		}
	},
	computed: {
		my_participations: function () {
			let list = [];
				for (var versus of this.participients) if (this.calcule_participation(versus.applicants)) list.push(versus);
			return list;
		},
		isvalid: function () {
			return this.title.isvalid && this.description.isvalid && this.versus.event_tag != undefined
		}
	},
	mounted: function () {

		/*$.post('<?= base_url() ?>/service/events/artworks_candidates',{versus: 26}, res => {

	})*/
	this.modal_confirmar = $(this.$refs.modal_confirmar).modal();
	this.modal_versus_add = $(this.$refs.modal_versus_add).modal();
	this.modal_confirmar_invitation = $(this.$refs.modal_confirmar_invitation).modal();
	if (this.vs_invitation.versus != undefined) {
		this.is_acepted_invitation = this.calcule_participation(this.vs_invitation.applicants)
		this.modal_confirmar_invitation.modal('open')
	}
},
methods: {
	confirm_invitation: function () {
		this.current_versus_apply = this.vs_invitation
		this.confirm_apply();
	},
	calcule_participation: function (applicants) {
		let active = false;
		for (var applicant of applicants) active |= applicant.account == this.$root.current_account
		return active
	},
	clear: function () {
		this.title.val = ''
		this.description.val = ''
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
		this.modal_confirmar.modal('open')
	},
	confirm_apply: function () {
		const data = {versus: this.current_versus_apply.versus}
		this.is_send_apply = true
		$.post('<?= base_url() ?>/service/events/apply_versus', data, (res) => {
			M.toast({html: res.message, classes: 'rounded'});
			this.modal_confirmar.modal('close')
			this.modal_confirmar_invitation.modal('close');
			this.is_send_apply = false
			const dataupdate = {tag: this.current_versus_apply.tag}
			$.post('<?= base_url() ?>/service/events/versuslist', dataupdate, (res) => {
				this.participients = res
			})
		}).fail(() => {
			M.toast({html: 'ERROR EN LA PAGINA, VUELVA MÁS TARDE', classes: 'rounded bg-alert'});
			this.is_send_apply = false
		});
	},
	submit: function () {
		if (this.isvalid) {
			const data = {
				title: this.title.val,
				description: this.description.val,
				tag: this.versus.event_tag,
				account: this.$root.current_account,
				is_public: this.versus_isPublic ? 1 : 0
			}
			this.is_send = true
			$.post('<?= base_url() ?>/service/events/versuslist_save', data, (res) => {
				if (res.message != undefined) {
					if (res.message == 'REGISTRO EXITOSO') {
						this.modal_versus_add.modal('close')
						const dataupdate = {tag: this.versus.event_tag}
						this.clear()
						$.post('<?= base_url() ?>/service/events/versuslist', dataupdate, (res) => {
							this.participients = res
						})
					}
					M.toast({html: res.message, classes: 'rounded'});
				}
				else {
					M.toast({html: 'ERROR EN LA PAGINA, VUELVA MÁS TARDE', classes: 'rounded bg-alert'});
				}
				this.is_send = false
			}).fail(() => {
				this.is_send = false
				M.toast({html: 'ERROR EN LA PAGINA, VUELVA MÁS TARDE', classes: 'rounded bg-alert'});
			});

		}
	},
	add_versus: function () {
		this.clear()
		this.modal_versus_add.modal('open')
	}
}
}
</script>
