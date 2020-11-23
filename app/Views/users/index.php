<?php
	$access = $_SESSION['access'];
	$access_account = !empty($access['account']) && $access['account'] == $info['account'] && $access['validate'] != 0;
?>
<script src="<?= base_url() ?>/libs/vueadvancedcropper/cropper.js" ></script>
<style media="screen">

#user_header{
	height: 260px;
	background: black;
	position: relative;
	overflow: hidden;
}
#user_header_bg{
	position: 	absolute;
	left: 0;
	top: 0;
	height: 100%;
	width: 100%;

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
	background-attachment: fixed;
	background-image: url('<?= base_url() ?>/images/bg_003.jpg');
}
#user_header_bg::after{
	position: absolute;
	content: '';
	left: 0;
	top: 0;
	height: 100%;
	width: 100%;
	background-color: black;
	opacity: .4;
}
#user_header_bg_content{
	height: 100%;
	position: relative;
	padding: 1rem;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	color: white;
}
.user-foto{
	background: #ffffff55;
	height: 140px;
	width: 140px;
	border-radius: 50%;
	display: flex;
	justify-content: center;
	align-items: center;
	font-size: 4rem;
	font-family: Calibri;
}
@media (max-width: 600px) {
	#user_header{
		height: 160px;
	}
	#user_header_bg_content{
		flex-direction: row;
	}
	.user-foto{
		height: 80px;
		width: 80px;
	}
	#user_header_bg_content h5{
		padding-left: 1rem;
	}
}
</style>

<style media="screen">

</style>

<?php template_start(); ?>
<div>
	<div class="" id="user_header">
		<div id="user_header_bg"></div>
		<div id="user_header_bg_content">
			<div class="user-foto"><?= $info['nickname'][0] ?></div>
			<h5><?= $info['nickname'] ?></h5>
		</div>
	</div>
	<div class="p-4">
		<cg-grid ref='grid' @changeimage="change" :images="list_img" :stack_size="320" :details="false" ></cg-grid>
	</div>
	<upload-editor base_url="<?=base_url()?>" ref="editor" :autors="autoraccess" @onfinish="onfinish"></upload-editor>
</div>
<?php $template = template_end()?>
<script>



const $_module = {
	template: `<?= $template ?>`,
	mounted: function () {
		<?php
		if ($access_account) {
			echo "
				this.\$refs.grid.setEdit(true);
				this.autoraccess.push({id_user: 'current', nickname: 'current'});
				$('#app-nav-access').prepend($(\"<a><i class='mdi-24px mdi mdi-plus'></i></a>\").click(this.openeditor),' ');
			";

		}

		?>

	},
	data: function () {
		return {
			list_img: <?= json_encode($images_list) ?>,
			autoraccess: []
		}
	},
	methods: {
		change: function (data) {
			this.$refs.editor.open()
			this.$refs.editor.setData({
				author: 'current',
				description: data.description,
				name: data.name,
				id: data.id_image,
				img: '<?= base_url() ?>/images/artworks/' + data.accessname + '.' + data.extension
			})
		},
		onfinish: function (data) {
			$.post('<?= base_url() ?>/services/artworks/recover',{account: '<?= $_SESSION['access']['account'] ?>'}, (res) => {
				this.list_img = res;
			})
		},
		openeditor: function () {
			this.$refs.editor.open()
			this.$refs.editor.setData({
				author: 'current',
				description: '',
				name: '',
				id: '',
				img: null
			})
		},

	}
}

</script>
