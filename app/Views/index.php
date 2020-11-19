<style media="screen">
	.feed-users{
		display: flex;
		padding: 1rem;
		margin: 0 auto;
	}
	.feed-users-wrapper-item{
		height: 80px;
		width: 80px;
		border-radius: 50%;
		background: lightgray;
		position: relative;
	}
	.feed-users-item{
		margin-right: 1rem;
		position: relative;
	}
	.feed-users-wrapper-item > div:nth-child(1){
		display: flex;
		position: absolute;
		left: 0;
		top: 0;
		right: 0;
		bottom: 0;
		animation-name: rotate;
		animation-duration: 4s;
		animation-iteration-count: infinite;
		animation-timing-function: linear;
		border-radius: 50%;
		overflow: hidden;
	}
	@keyframes rotate {
		0% {
			transform: rotate(0deg);
		}
		100%{
			transform: rotate(360deg);
		}
	}
	.feed-users-wrapper-item > div:nth-child(1)::before,.feed-users-wrapper-item > div:nth-child(1)::after{
		content: '';
		width: 50%;
		height: 100%;
		background-color: var(--primary);
	}
	.feed-users-wrapper-item > div:nth-child(1)::before{
		background-color: var(--secondary)
	}
	.feed-users-wrapper-item > div:nth-child(2){
		z-index: 2;
		position: relative;
		height: 84%;
		background: white;
		width: 84%;
		border-radius: 50%;
	}
	.feed-users-icon span{
		font-family: Calibri;
		font-size: 1.5rem;
		text-transform: uppercase;
	}
	.feed-users-count{
		position: absolute;
		top: 0rem;
		right: 0rem;
		height: 26px;
		width: 26px;
		z-index: 4;
		border-radius: 50%;
		background: white;
		color: var(--primary);
		box-shadow: 0 0 0px 4px #876ced40;
	}
	.feed-users-item a{
		color: gray;
	}
</style>
<?php template_start()?>
<div>
	<div class="feed-users">
		<?php foreach ($feed as $key => $f): ?>
			<div class="feed-users-item f-c">
				<div class="feed-users-count f-c"><span><?= $f['total'] ?></span></div>
				<div class="feed-users-wrapper-item f-c">
					<div></div>
					<div class="f-c feed-users-icon">
						<span><?= $f['nickname'][0] ?></span>
					</div>
				</div>
				<a href="<?= base_url() ?>/<?= $f['account'] ?>" class="pt-2"><?= $f['nickname'] ?></a>
			</div>

		<?php endforeach; ?>
	</div>
	<cg-grid :images="list_img" :stack_size="stack" base_url="<?= base_url() ?>" @sizewrapper="sizewrapper"></cg-grid>
</div>

<?php $template = template_end()?>

<script>

const $_module = {
	template: `<?= $template ?>`,
	data: function () {
		return {
			list_img: <?= json_encode($images_list) ?>,
			stack: 320
		}
	},
	methods: {
		sizewrapper: function (size) {
			$('.feed-users').width(size)
			console.log(size);
		}
	},
	mounted: function () {
		const body = $(document.body);
		this.stack = body.width() > 600 ? 320 : 170;
		window.addEventListener('resize', () => {
			this.stack = body.width() > 600 ? 320 : 170;
		});
	}
}

</script>
