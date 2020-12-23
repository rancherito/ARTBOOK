<?php
	$fb = new \Facebook\Facebook([
		'app_id' => '3301610373300333',
		'app_secret' => '1b1091d319cee49b6f19096bd442261e',
		'default_graph_version' => 'v3.2',
	]);

	$helper = $fb->getRedirectLoginHelper();

	$permissions = ['email'];
	$loginUrl = empty($_SESSION['access']) ? $helper->getLoginUrl(base_url().'/user/login_fbauth', $permissions) : base_url().'/'.$_SESSION['access']['account'];


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<?php
			include APPPATH.'Views/layouts_parts/header.php';
		?>

		<style media="screen">
			body{
				height: 100vh;
				background: #141827;
				position: relative;
				display: flex;
				justify-content: center;
				align-items: center;
			}
			#app-login{
				width: 100%;
				max-width: 1000px;
				height: 100%;
				max-height: 700px;
				margin: 0;
				display: flex;
			}
			#app-login > div:nth-child(1){
				width: calc(100% - 480px);
			}
			#app-login > div:nth-child(2){
				background: white;
				width: 480px;
			}
			.simple-link{
				color: gray;
			}
			.simple-link:hover{
				text-decoration: underline;
				cursor: pointer;
			}
			@media (max-width: 992px) {
				#app-login > div:nth-child(1){
					display: none;
				}
				#app-login{
					width: 480px;
				}
			}
			@media (max-width: 600px) {


				#app-login > div:nth-child(2){
					width: 100%;
				}
			}
		</style>
	</head>
	<body>
		<?= bg_animate_001() ?>
		<div id="app-login" class="card">
			<div class="f-c" style="position: relative">
				<?= bg_default() ?>
				<img src="<?= base_url() ?>/images/logo_white.svg" alt="logo web" style="position: relative">
			</div>
			<div class="p-4 f-c">
				<div style="max-width: 300px" class="w100 f-c">
					<div id="logger"></div>
					<h3 class="mb-0">{{newAccountMode ? 'REGISTRO' :'ACCESSO'}}</h3>
					<div class="grey-text">Acceso para usuarios Art's Book</div>
					<div class="l pb-4 pt-6 w100">
						<a href="<?= $loginUrl ?>" class="btn" style="background-color: #2139bf">
							<i class="mdi mdi-facebook"></i>
							<span>LOGIN FACEBOOK</span>
						</a>
					</div>
					<div class="w100 pt-1">
						<form method="post" @submit.prevent="submit" v-show="!newAccountMode">
							<cg-field :watchisvalid.sync="user.isvalid" required name="user" v-model="user.val" sizechars="4-16" label="Usuario" placeholder="ingrese credenciales"></cg-field>
							<cg-field :watchisvalid.sync="pass.isvalid" required name="password" v-model="pass.val" sizechars="4-20" label="Contraseña" type="password" placeholder="ingrese clave de acceso secreto"></cg-field>
							<div class="r">
								<a href="<?= base_url() ?>" class="btn bg-white"><span>REGRESAR</span> </a>
								<button :disabled="!isvalid" type="submit" class="btn waves waves-effect waves-light">
									<i class="mdi mdi-key right"></i>
									<span>ACCEDER</span>
								</button>
							</div>
						</form>
						<form method="post" style="display: none" @submit.prevent="submit_register" v-show="newAccountMode">
							<cg-field :watchisvalid.sync="new_user.isvalid" required name="user" v-model="new_user.val" sizechars="4-16" label="Usuario (solo letras, numeros ó subguiones)" placeholder="ingrese credenciales"></cg-field>
							<cg-field :watchisvalid.sync="new_pass.isvalid" required name="password" v-model="new_pass.val" sizechars="8-20" label="Contraseña" type="password" placeholder="ingrese clave de acceso secreto"></cg-field>
							<cg-field :watchisvalid.sync="email.isvalid" required name="email" v-model="email.val" label="Email" sizechars="0-50" type="email" placeholder="ingrese clave de acceso secreto"></cg-field>
							<div class="r">
								<a href="<?= base_url() ?>" class="btn bg-white"><span>REGRESAR</span> </a>
								<cg-button :loading="loading" :disabled="!isvalid_register" classicon="mdi mdi-account-plus" text="CREAR"></cg-button>

							</div>
						</form>
					</div>
					<div class="f-c pt-4 ">
						<a class="simple-link" @click="toogleMode">{{newAccountMode ? 'Acceder con una cuenta' : '¿No tienes una cuenta? Registrate aqui!!'}}</a>
						<h6 class="c primary" style="display: none" v-show="register_ok">Revise su E-mail para validar su registro</h6>
					</div>
				</div>
			</div>

		</div>
		<script>

			new Vue({
				el: '#app-login',
				data: {
					user: {val: '', isvalid: false},
					pass: {val: '', isvalid: false},
					new_user: {val: '', isvalid: false},
					new_pass: {val: '', isvalid: false},
					email: {val: '', isvalid: false},
					newAccountMode: false,
					loading: false,
					register_ok: false,
					fromurl: <?= empty($_GET['fromurl']) ? 'null' : "'".base64_decode($_GET['fromurl'])."'" ?>
				},
				computed:{
					isvalid: function () {
						return this.user.isvalid && this.pass.isvalid
					},
					isvalid_register: function () {
						return this.new_user.isvalid && this.new_pass.isvalid && this.email.isvalid
					}
				},
				methods: {
					toogleMode: function () {
						this.newAccountMode = !this.newAccountMode;
					},
					submit_register: function () {
						if (this.isvalid_register) {
							const data = {user: this.new_user.val, password: this.new_pass.val, email: this.email.val};
							this.loading = true
							$.post('<?= base_url() ?>/services/account/create',data, (d) => {
								for (var alert of d) M.toast({html: alert, classes: 'rounded bg-alert'})

								if (d.length == 0) {
									M.toast({html: 'Su cuenta ha sido creada', classes: 'rounded'})
									this.register_ok = true;
									this.toogleMode();
								}

								this.loading = false
							})
						}

					},
					submit: function () {
						if (this.isvalid) {
							const data = {user: this.user.val, password: this.pass.val}
							$.post('<?= base_url() ?>/services/getaccess',data , (d) => {

								if (d['access']) {
									if (this.fromurl) window.location.href = this.fromurl
									else window.location.href = '<?= base_url() ?>/' + d["account"];
								}
								else M.toast({html: 'CONTRASEÑA O USUARIOS INCORRECTO', classes: 'rounded bg-alert'});

							})
						}
					}
				}
			})

		</script>
	</body>
</html>
