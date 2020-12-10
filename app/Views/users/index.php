<?php
	$access = $_SESSION['access'];
	$access_account = !empty($access['account']) && $access['account'] == $info['account'] && $access['validate'] != 0;

?>
<script src="<?= base_url() ?>/libs/vueadvancedcropper/cropper.js?v=2" ></script>
<style media="screen">

#user_header{
	background: black;
	position: relative;
	height: 260px;
}
#user_header_bg{

}
#user_header_bg::before{
	content: '';
	position: 	absolute;
	left: 0;
	top: 0;
	height: 100%;
	width: 100%;
	background-repeat: no-repeat;
	background-size: cover;
	background-position: center;
	background-image: url('<?= base_url() ?>/images/bg_003.jpg');
	filter: blur(10px);
}
#user_header_bg::after{
	position: absolute;
	content: '';
	left: 0;
	top: 0;
	height: 100%;
	width: 100%;
	background: black;
	opacity: .4
}
#user_header_info_content{
	height: calc(100% - 20px);
	position: relative;
	padding: 1rem;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	color: white;

}

#user_header_info_content img{
	width: 100%;
	height: 100%;
	position: relative;
}

#user_header_info_content h5{
	color: white;
}
#user_info_photo{
	background: #876ced;
	box-shadow: 0 0 0px 8px #e6e6e633;
    height: 140px;
    width: 140px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 3rem;
    font-family: Calibri;
    text-transform: uppercase;
    color: white;
    position: absolute;
    top: 100%;
    z-index: 5;
    transform: translateY(-50%);
	overflow: hidden;
}
.content-grid{
	background: white;
	border-radius: 10px;
	margin-top: -20px;
	position: relative;
	padding-top: 6rem;
}
#user_header_decorator{
	height: 100%;
	width: 100%;
	transform: scale(1.2);
	position: absolute;
}
#user_options{
	position: absolute;
	z-index: 2;
	width: 100%;
	padding: 1rem;
	display: flex;
	flex-direction: row-reverse;
}
@media (max-width: 600px) {
	#user_header{
		height: 200px;
	}

	#user_info_photo{
		height: 110px;
		width: 110px;
	}
	.content-grid{
		padding-top: 5rem;
	}

}
</style>

<style media="screen">

</style>

<?php template_start(); ?>
<div>
	<div id="user_header">
		<div id="user_options">
			<?php if (!empty($_SESSION['access'])): ?>
				<a class="btn-icon btn-dark" href="<?= base_url() ?>/user/settings">
					<i class="mdi mdi-cog mdi-18px"></i>
				</a>
			<?php endif; ?>
		</div>
		<div id="user_header_decorator">
			<div id="user_header_bg"></div>
		</div>
		<div id="user_header_info_content">
			<div id="user_info_photo" :style="{background: avatar_image == null ? '' : 'transparent'}">
				<span  style="display: none" v-show="avatar_image == null"><?= $info['nickname'][0] ?></span>
				<img style="display: none" v-show="avatar_image" :src="avatar_image">
			</div>

			<h5><?= $info['nickname'] ?></h5>
		</div>
	</div>
	<div class="content-grid">
		<cg-grid ref='grid' @changeimage="modify_image" :images="list_img" :stack_size="stack" :details="false" ></cg-grid>
	</div>
	<upload-editor base_url="<?=base_url()?>" ref="editor" :autors="autoraccess" @onfinish="onfinish"></upload-editor>
</div>
<?php $template = template_end()?>
<script>



const $_module = {
	template: `<?= $template ?>`,
	mounted: function () {
		const body = $(document.body);
		this.stack = body.width() > 600 ? 320 : (body.width() > 300 ? 170 : 260);
		window.addEventListener('resize', () => {
			this.stack = body.width() > 600 ? 320 : (body.width() > 300 ? 170 : 260);
		});
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
			stack: <?= $agent->isMobile() ? 170 : 320 ?>,
			avatar_image: <?= $path_image ?>
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
