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
		</style>
	</head>
	<body>
		<div id="app-login" class="card">
			<div class="cover" style="background-image: url('<?= base_url() ?>/images/bg_003.jpg')">
				<div style="height: 100%; background-color: #00000066" class="f-c">
					<img src="<?= base_url() ?>/images/logo.svg" alt="arts book">
				</div>
			</div>
			<div class="p-4 f-c">
				<div style="width: 300px" class="f-c">
					<h3 class="mb-0">LOG-IN</h3>
					<div class="grey-text">Acceso para administradores arts book</div>
					<div class="w100 pt-6">
						<form method="post" @submit.prevent="submit">
							<cg-field :watchisvalid.sync="user.isvalid" required name="user" v-model="user.val" sizechars="0-10" label="Usuario" placeholder="ingrese credenciales"></cg-field>
							<cg-field :watchisvalid.sync="pass.isvalid" required name="password" v-model="pass.val" sizechars="0-16" label="Contraseña" type="password" placeholder="ingrese clave de acceso secreto"></cg-field>
							<div class="r">
								<a href="<?= base_url() ?>" class="btn bg-white"><span>REGRESAR</span> </a>
								<button :disabled="!isvalid" type="submit" class="btn waves waves-effect waves-light">
									<i class="mdi mdi-key right"></i>
									<span>ACCEDER</span>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>
		<script>

			new Vue({
				el: '#app-login',
				data: {
					user: {val: 'dlarico', isvalid: false},
					pass: {val: '123', isvalid: false}
				},
				mounted: function () {
				},
				computed:{
					isvalid: function () {
						return this.user.isvalid && this.pass.isvalid
					}
				},
				methods: {

					submit: function () {
						if (this.isvalid) {
							const data = {user: this.user.val, password: this.pass.val}
							$.post('<?= base_url() ?>/services/getaccess',data ,function (d) {
								window.location.href = '<?= base_url() ?>/administrador';
							})
						}
					}
				}
			})
		</script>
	</body>
</html>
