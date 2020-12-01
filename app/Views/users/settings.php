<?php
	$access = $_SESSION['access'];
	$nickname = $access['nickname'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta name="robots" content="noindex,nofollow" />

	<?php
	include APPPATH.'Views/layouts_parts/header.php';
	?>

	<title></title>
	<style media="screen">
	#settings-bg-content, body,#settings{
		height: 100vh;
		width: 100vw;
		overflow: hidden;
		position: relative;
	}
	#settings-bg-content{
		position: absolute;
		transform: scale(1.2);
	}
	#settings-bg-content img{
		object-fit: cover;
		height: 100%;
		width: 100%;
		filter: blur(10px);
	}
	#settings-bg-content::after{
		content: '';
		position: absolute;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		background: #000;
		opacity: 0.5
	}
	#settings-content{
		position: relative;
		margin: 0 auto;
		max-width: 500px;
		width: 100%;
		height: 100%;
		padding: 1rem;
	}
	#settings-avatar-content{
		height: 240px;
	}
	#settings-field-content{
		border-radius: 1rem;
		background: white;
	}
	#settings-avatar-img{
		background-color: white;
		height: 110px;
		width: 110px;
		border-radius: 50%;
		font-size: 3rem;
		text-transform: uppercase;
		color: gray;
	}
	#settings-field-content{
		padding: 2rem;
	}
	#settings-field-content form{
		max-width: 360px;
		width: 100%;
	}
	#settings-field-actions{
		display: flex;
		align-items: center;
		justify-content: space-between;
	}
	@media (max-width: 600px) {

	}
	</style>
</head>
<body>
	<div id="settings">
		<div id="settings-bg-content">
			<img src="<?= base_url() ?>/images/bg_003.jpg" alt="">
		</div>
		<div id="settings-content"  class="f-c">
			<div id="settings-avatar-content" class="f-c">
				<h5 class="white-text pb-4">Modificar mi cuenta</h5>
				<div id="settings-avatar-img" class="f-c">
					C
				</div>

			</div>
			<div id="settings-field-content" class="f-c w100">
				<form id="tatat" @submit.prevent="submit" autocomplete="off">
					<cg-field required label="Nickname" name="<?= rand() ?>" placeholder="ignrese nickname" v-model="nickname.val" sizechars="4-16" :watchisvalid.sync="nickname.isvalid"></cg-field>
					<cg-field autocomplete="off" type="password" name="<?= rand() ?>" required v-model="new_password.val" sizechars="4-20" :empty="!isNewPassword" :watchisvalid.sync="new_password.isvalid" v-show="isNewPassword" label="Nueva contraseña" placeholder="ignrese Contraseña"></cg-field>
					<cg-field autocomplete="off" type="password" name="<?= rand() ?>" required v-model="old_password.val" sizechars="4-20" :watchisvalid.sync="old_password.isvalid"  label="Ingrese contraseña para validar" placeholder="ignrese Contraseña"></cg-field>
					<div id="settings-field-actions">
						<label>
							<input type="checkbox" class="filled-in" v-model="isNewPassword">
							<span>Editar clave</span>
						</label>
						<button type="submit" class="btn" :disabled="!isValid">SALVAR</button>
					</div>
				</form>

			</div>
		</div>
	</div>
	<script type="text/javascript">
	new Vue({
		el: '#settings',
		data: {
			isNewPassword: false,
			showpass: false,
			old_password: {val: '', isvalid: false},
			new_password: {val: '', isvalid: false},
			nickname: {val: '<?= $nickname ?>', isvalid: false}
		},
		computed: {
			isValid: function () {
				return this.old_password.isvalid && this.new_password.isvalid && this.nickname.isvalid
			}
		},
		methods: {
			submit: function () {
				if (this.isValid) {
					const data = {
						old: this.old_password.val,
						new: this.new_password.val,
						is_new: this.isNewPassword,
						nickname: this.nickname.val
					}
					$.post('<?=  base_url() ?>/user/editinfo', data, (data) => {
						console.log(data);
					})
				}

			}
		},
		mounted: function () {

		}
	})
	</script>
</body>
</html>
