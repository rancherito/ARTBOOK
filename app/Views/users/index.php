<?php
$access = $_SESSION['access'];
$access_account = !empty($access['account']) && $access['account'] == $info['account'] && $access['validate'] != 0;

?>
<script src="<?= base_url() ?>/libs/vueadvancedcropper/cropper.js?v=3" ></script>
<style media="screen">
:root{
	--aside-user: 380px;
}
#user_header{
	position: relative;
}
#user-content{
	margin-left: var(--aside-user);
}
#user_header_info_content{
	position: relative;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	color: white;

}

.content-grid{
	position: relative;
	padding: 2rem 0;
}

#user_options{
	z-index: 2;
	width: 100%;
	padding: 2rem;
	display: flex;
	position: relative;
}
#user-profile{
	position: fixed;
	width: 100%;
	max-width: var(--aside-user);
	top: 0;
	bottom: 0;
	left: 0;
	background: #15202b;
	z-index: 3;
}
#user-profile-decorator{
	position: absolute;
	top: 300px;
	height: calc(100% - 300px);
	width: 100%;
	background: #15202b;
	border-radius: 0 100px 0 0;
}
#user-profile-conent{
	color: white;
	padding: 1rem;
	position: relative;
}
#user-profile-conent > div{
	height: 300px;
}
#app-content{
	background:
	#111a23;
}
.cg-grid-wrapper-img{
	color: white;
}
.bg_full_default{
	opacity: 0.2;
	height: 400px;
}
#user-profile-avatar{
	background: #ffffff17;
	width: 140px;
	height: 140px;
	border-radius: 50%;
	box-shadow: 0 0 0 8px #ffffff0a;
	text-transform: uppercase;
}
#user-avatar-img{
	width: 100%;
	border-radius: 50%;
}
#user-profile-nickname{
	padding-top: 2rem;
	letter-spacing: 4px;
	text-transform: uppercase;
}
#user-profile-description{
	padding: 2rem;
	color: white;
}
div#user_options + div#user-profile-description{
	padding-top: 0;
}
@media (max-width: 992px) {
	#user-profile-decorator{
		height: auto;
		position: relative;
		top: 0;
		background: #111a23;
	}

	#user-profile{
		position: relative;
		width: 100%;
		max-width: 100%;
	}
	#user-content{
		margin-left: 0;
	}
}
@media (max-width: 600px) {

	#user_info_photo{
		height: 110px;
		width: 110px;
	}

}
</style>
<style media="screen">

</style>

<?php template_start(); ?>
<div>
	<div id="user-profile">
		<?= bg_default() ?>
		<div id="user-profile-conent">
			<div class="f-c">
				<div id="user-profile-avatar" class="f-c">
					<?php if ($path_image == ''): ?>
						<span><?= $info['nickname'][0] ?></span>
					<?php else: ?>
						<img src="<?= $path_image ?>" id="user-avatar-img">
					<?php endif; ?>
				</div>
				<div id="user-profile-nickname"><?= $info['nickname'] ?></div>

			</div>
		</div>
		<div id="user-profile-decorator" >
			<div id="user_header">

				<?php if ($access_account): ?>
					<div id="user_options">
						<a class="mr-2 btn-icon btn-dark" href="<?= base_url() ?>/user/settings">
							<i class="mdi mdi-cog mdi-18px"></i>
						</a>
						<a class="mr-2 btn btn-dark" @click="openeditor">
							<i class="mdi mdi-upload left"></i>
							<span>SUBIR ARTWORK</span>
						</a>
					</div>
				<?php endif; ?>

				<div id="user-profile-description">
					<div class="title-3">Bienvenido</div>
					<p>
						Espero que disfrutes tu estadia en mi perfil de trabajos, subo contenido regularmente

					</p>


				</div>
			</div>
		</div>
	</div>
	<div id="user-content">


		<div class="content-grid">
			<cg-grid ref='grid' @changeimage="modify_image" :images="list_img" :stack_size="stack" :details="false" ></cg-grid>
		</div>
		<upload-editor base_url="<?=base_url()?>" ref="editor" :autors="autoraccess" @onfinish="onfinish"></upload-editor>
	</div>

</div>
<?php $template = template_end()?>
<script>



const $_module = {
	template: `<?= $template ?>`,
	mounted: function () {
		/*const body = $(document.body);
		this.stack = body.width() > 600 ? 320 : (body.width() > 300 ? 170 : 260);
		window.addEventListener('resize', () => {
		this.stack = body.width() > 600 ? 320 : (body.width() > 300 ? 170 : 260);
	});*/
	<?php
	if ($access_account) {

		echo "
		this.\$refs.grid.setEdit(true);
		this.autoraccess.push({id_user: 'current', nickname: 'current'});
		$('#app-nav-access').prepend($(\"<a><i class='mdi-24px mdi mdi-plus'></i></a>\").click(this.openeditor));
		$('#nav-movil').prepend($(\"<li><a class='btn-floating'><i class='mdi-24px mdi mdi-plus'></i></a></li>\").click(this.openeditor));
		";

	}

	?>

},
data: function () {
	return {
		list_img: <?= json_encode($images_list) ?>,
		autoraccess: [],
		stack: 280
	}
},
methods: {
	modify_image: function (data) {
		this.$refs.editor.open()
		this.$refs.editor.setData({
			author: 'current',
			description: data.description,
			name: data.name,
			id: data.id_image,
			img: data.img,
			extension: data.extension
		})
	},
	onfinish: function (data) {
		$.post('<?= base_url() ?>/services/artworks/recover',{account: '<?= $_SESSION['access']['account'] ?>'}, (res) => {
			this.list_img = res;
		})
	},
	openeditor: function () {
		this.$refs.editor.open()
		this.$refs.editor.newRegister()
	},

}
}

</script>
