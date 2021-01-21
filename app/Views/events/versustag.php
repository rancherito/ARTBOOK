<?php
list($p_1, $p_2) = array_chunk($participients, ceil(count($participients) / 2));
$group_versus = [];

foreach ($participients as $key => $v) {
	if (empty($group_versus[$v['versus']])) $group_versus[$v['versus']] = [];

	$partial_path = "images/avatars/avatar_$v[user_avatar].jpg";
	if (file_exists($partial_path)) $v['avatar'] = base_url()."/$partial_path";
	$group_versus[$v['versus']][] = $v;
}
function getPathImage($artwork)
{
	return base_url()."/images/artworks/$artwork.jpg";
}
?>
<style>
#app-content{
	background-color: #030419;
}
#versustag-wall-pics{
	/*background: #aadfff96*/
}
#versustag-content{
	position: fixed;
	top: 1rem;
	bottom: 1rem;
	background: #f9f9f9;
	border-radius: 10px;
	overflow: hidden;
	width: 100%;
	max-width: 460px;
	left: 50%;
	transform: translateX(-50%);
	display: flex;
	flex-direction: column;
	transition: cubic-bezier(0.65, 0.05, 0.36, 1) all .2s;
}
#versustag-presentation-header{
	height: 260px;
	position: relative;
}
#versustag-presentation{
	height: 100%;
	transition: cubic-bezier(0.65, 0.05, 0.36, 1) all .2s;
	display: flex;
	flex-direction: column;
}
.versustag-pics{
	position: absolute;
}
.versustag-pics img{
	height: 260px;
	transform: translate(-50%, -50%);
	opacity: 0.5
}
.artist-content{
	position: relative;
	width: 90px;
}
.artist-content div{
	height: 50px;
	width: 50px;
	border-radius: 50%;
}
.artist-content span{
	width: 100%;
	display: block;
	overflow: hidden;
	text-overflow: ellipsis;
	text-align: center;
	color: gray;
	font-size: 0.8rem;
}
.group-versus-vs-text{
	height: 100%;
	width: 100%;
	position: absolute;
	top: 0;
	left: 0;
	padding: 0 3.25rem;
	display: flex;
	align-items: center;
	justify-content: space-around;
	font-size: 1.5rem;
	font-weight: lighter;
	font-family: sans-serif;
	color: gray;

}
.group-versus-vs-text span{
	color: gray;
}
.group-versus{
	color: gray;
	display: flex;
	flex-direction: column;
	padding: .5rem;
	border-radius: 5px;
	position: relative;
	background-color: white;
}
.group-versus .btn{
	transform: scale(.8);
}
.group-versus-avatar{
	font-size: 1.2rem;
	background-color: var(--primary);
	color: white;
}
.group-versus-avatar.yourwinner{
	box-shadow: 0 0 0 4px #876cedbf;
}
#versustag-vs-choser{
	display: none;
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
}
#versustag-content.versustag-onchoise{
	height: 700px;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
}
#versustag-header-img{
	height: 100px;
}
#versustag-body{
	flex: 1;
	overflow-y: auto;
}

.versustag-onchoise #versustag-vs-choser{
	display: block;
	background-color: black;
}
.versustag-onchoise #versustag-presentation{
	opacity: 0;
}

#versustag-vs-buttons{
	position: absolute;
	bottom: 1rem;
	top: 1rem;
	right: 1rem;
	flex-direction: column;
	justify-content: space-between;
	align-items: flex-end;
	display: flex;
}
#versustag-voting-button{
	box-shadow: 0 0 5px #0000003d;
	height: 56px;
	width: 56px;
	line-height: 56px;
	text-align: center;
	color: lightgray;
	border-radius: 50%;
	font-size: 2rem;
	background: white;
	transition: linear all .2s;
	cursor: pointer;
}
#versustag-vs-preview-images{
	position: absolute;
	bottom: 1rem;
	left: 1rem;
}
.versus-pic{
	height: 48px;
	width: 48px;
	border-radius: 50%;
	display: inline-block;
	margin-right: 1rem;
	box-shadow: 0 0 0 4px rgba(0,0,0,.5);
	transform: scale(0.8);
}
.versus-pic-active{
	box-shadow: 0 0 0 6px var(--primary);
	animation-duration: 3s;
	animation-name: bounce_shadow;
	animation-timing-function: linear;
	animation-iteration-count: infinite;
	transform: scale(1);
}
@keyframes bounce_shadow {
	0%{
		transform: scale(1) rotate(0);
	}
	100%{
		transform: scale(1) rotate(360deg);
	}
}
#versustag-vs-choser-currente-img-bg{
	height: 100%;
	width: 100%;
	position: relative;
	object-fit: cover;
	opacity: .1
}
#versustag-vs-choser-currente-img-view{
	height: 100%;
	width: 100%;
	position: absolute;
	top: 0;
	left: 0;
	object-fit: contain;
}
#challenges-arrows {
	position: fixed;
	padding: 1rem;
	top: 50%;
	width: 100%;
	display: flex;
	justify-content: space-between;
	transform: translateY(-50%);
	background: transparent;
	border-radius: 0;
}
#challenges-arrows a {
	color: var(--primary);
	cursor: pointer;
	height: 80px;
	width: 80px;
	border-radius: 50%;
	display: flex;
	justify-content: center;
	align-items: center;
	font-size: 4rem;
	background: rgba(0,0,0,.6);
	color: white;
}

#versustag-vs-choser.versus-vote #versustag-voting-button, #versustag-voting-button:hover {
    background: #8bc34a;
    color: white;
}
.btn-dark {
    background: rgba(0,0,0,.6);
    color: white;
}
.fixed-action-btn{
	display: none;
}
.btn.group-versus-hasvote{
	background: #9ab80b
}
@media (max-width: 600px) {
	.fixed-action-btn{
		display: block;
	}
	.fixed-action-btn.enablebuttonfloat{
		display: none;
	}
	#versustag-header-img{
		height: 60px;
	}
	#versustag-presentation-header{
		height: 160px;
	}
	#versustag-content{
		top: 0;
		bottom: 0;
		border-radius: 0;
	}
	#versustag-content.versustag-onchoise{
		height: 100%;
	}
}
.pointer{
	cursor: pointer;
}
</style>
<?php module_start() ?>
<div class="">
	<?= bg_animate_001() ?>

	<div id="versustag-content" :class="{'versustag-onchoise': on_choise}">
		<div id="versustag-presentation">
			<div class="f-c" id="versustag-presentation-header">
				<?= bg_default() ?>
				<div style="position: relative" class="f-c">
					<img  id="versustag-header-img"src="<?= base_url() ?>/images/logo_white.svg">
					<span style="max-width: 300px" class="c white-text">Bienvenido a las votaciones de la comunidade de artistas de Art's Book</span>

				</div>

			</div>
			<div id="versustag-body" >
				<simplebar style="height: 100%">
					<div style="padding: 2rem;">

						<template v-for="(groups, index) of group_versus">
							<template v-if="groups.length >= 2 && !my_votes[index]">
								<div class="title-5">
									<span>VERSUS: {{groups[0].name}}</span>
								</div>
								<div class="group-versus">

									<div class="f-b" style="position: relative">
										<div class="group-versus-vs-text">
											<span v-for="n in (groups.length - 1)">VS</span>
										</div>

										<a v-for="artist of groups" class="artist-content f-c" target="_blank" :href="'<?= base_url()?>/' + artist.account">
											<div class="group-versus-avatar cover f-c" :class="{'yourwinner': artist.vote}" :style="{'background-image': artist.avatar == undefined ? '' : 'url(' + artist.avatar + ')'}">
												{{artist.avatar == undefined ? artist.nickname[0] : ''}}
											</div>
											<span>{{artist.nickname}}</span>
										</a>
									</div>
									<div class="c">
										<div class="btn" @click="openversus(groups)">Votar!</div>
									</div>

								</div>
								<br>
							</template>

						</template>
						<template v-for="(groups, index) of group_versus">
							<template v-if="groups.length >= 2 && my_votes[index]">
								<div class="title-5">
									<span>VERSUS: {{groups[0].name}}</span>
								</div>
								<div class="group-versus">

									<div class="f-b" style="position: relative">
										<div class="group-versus-vs-text">
											<span v-for="n in (groups.length - 1)">VS</span>
										</div>

										<a v-for="artist of groups" class="artist-content f-c" target="_blank" :href="'<?= base_url()?>/' + artist.account">
											<div class="group-versus-avatar cover f-c" :class="{'yourwinner': artist.vote}" :style="{'background-image': artist.avatar == undefined ? '' : 'url(' + artist.avatar + ')'}">
												{{artist.avatar == undefined ? artist.nickname[0] : ''}}
											</div>
											<span>{{artist.nickname}}</span>
										</a>
									</div>
									<div class="c">
										<div class="btn bg-success" @click="openversus(groups)">Cambiar mi voto</div>
									</div>

								</div>
								<br>
							</template>

						</template>
						<template v-for="groups of group_versus">
							<template v-if="groups.length == 1">
								<div class="title-5">
									<span>VERSUS: {{groups[0].name}}</span>
								</div>
								<div class="group-versus">
									<div class="f-b" style="position: relative">

										<a class="artist-content f-c" target="_blank" :href="'<?= base_url()?>/' + groups[0].account">
											<div class="group-versus-avatar cover f-c" :class="{'yourwinner': groups[0].vote}" :style="{'background-image': groups[0].avatar == undefined ? '' : 'url(' + groups[0].avatar + ')'}">
												{{groups[0].avatar == undefined ? groups[0].nickname[0] : ''}}
											</div>
											<span>{{groups[0].nickname}}</span>
										</a>
										<div style="flex: 1" class="c">
											Ganador por default
											<div class="btn bg-success" @click="openversus(groups)">Ver</div>
										</div>
									</div>

								</div>
								<br>
							</template>
						</template>
					</div>
				</simplebar>
			</div>
		</div>
		<div id="versustag-vs-choser" :class="{'versus-vote': calculevote()}">
			<img ref="imageartwork_bg" :src="calculeurl()" id="versustag-vs-choser-currente-img-bg">
			<img ref="imageartwork" :src="calculeurl()" id="versustag-vs-choser-currente-img-view">
			<div id="versustag-vs-preview-images" v-if="current_group">
				<div v-for="pic in current_group" class="cover versus-pic" :class="{'versus-pic-active': calculepic(pic)}" :style="calculeartwork(pic)"></div>
			</div>
			<div id="versustag-vs-buttons">
				<div>
					<a ref="btnvote" class="btn-icon" id="versustag-voting-button" @click="choise">
						<i class="mdi" :class="calculevote_class()"></i>
					</a>
				</div>
				<div class="f-c">
					<a class="mt-2 btn btn btn-dark pointer" @click="closeversus">
						<i class="mdi mdi-keyboard-return mdi-18px left"></i>
						<span>VOLVER</span>
					</a>
				</div>
			</div>
			<div id="challenges-arrows">
				<a @click="back"><i class="mdi mdi-chevron-left"></i></a>
				<a @click="advance"><i class="mdi mdi-chevron-right"></i></a>
			</div>
		</div>
	</div>


</div>
<?php module_end() ?>
<script type="text/javascript">
$_module = {
	data: function () {
		return {
			on_choise: false,
			group_versus: <?= json_encode($group_versus) ?>,
			current_group: null,
			base_url: '<?= base_url() ?>',
			current_group_position: 0,
			start_vote: false
		}
	},
	computed: {
		my_votes: function () {
			let votes = {}
			for (var i in this.group_versus) {
				let current = this.group_versus[i]
				votes[i] = 0
				for (var artist of current) votes[i] += artist.vote;

			}
			return votes
		}
	},
	watch: {
		current_group_position: function () {
			//animateCSS(this.$refs.imageartwork, 'fadeIn');
			animateCSS(this.$refs.btnvote, 'bounceIn');
			//animateCSS(this.$refs.imageartwork_bg, 'fadeIn');

		},
		on_choise: function (val) {
			$('.fixed-action-btn').toggleClass('enablebuttonfloat')
		}
	},
	methods: {
		choise: function () {
			if (this.current_group && !this.start_vote) {
				let current = this.current_group[this.current_group_position];
				const data = {artwork: current.accessname, versus: current.versus}

				this.start_vote = true;
				$.post('<?= base_url() ?>/services/events/versus/votes_save', data, (res) => {
					console.log(res);
					//console.log($);

					if (res.message != undefined) {
						M.toast({html: res.message, classes: 'rounded'})
						if (res.message == "VOTO GUARDADO") current.vote = 1
						else if(res.message == "VOTO ANULADO") current.vote = 0
					}
					else M.toast({html: 'ERROR EN EL SISTEMA', classes: 'rounded bg-alert'})
				}).fail(() => {
					M.toast({html: 'ERROR EN EL SISTEMA', classes: 'rounded bg-alert'})
				}).always(() => {
				    this.start_vote = false;
				  });
			}
		},
		randomposition: function () {
			return {top: parseInt(Math.random()*100) + '%', left: parseInt(Math.random()*100) + '%', position: 'absolute', height: '10px', width: '10px'}
		},
		openversus: function (versus) {
			this.current_group_position = parseInt(Math.random() * versus.length)
			this.current_group = versus
			this.on_choise = true
		},
		closeversus: function () {
			this.current_group = null
			this.on_choise = false
		},
		advance: function () {
			if (this.current_group) this.current_group_position = ++this.current_group_position >= this.current_group.length ? 0 : this.current_group_position

		},
		back: function () {
			if (this.current_group) this.current_group_position = --this.current_group_position < 0 ? this.current_group.length - 1 : this.current_group_position
		},
		calculeartwork: function (pic) {
			return {'background-image': 'url(' + this.base_url + '/images/artworks_lite/' + pic.accessname + '.jpg)'}
		},
		calculepic: function (pic) {
			return pic.accessname == this.current_group[this.current_group_position].accessname
		},
		calculeurl: function () {

			return this.current_group ? this.base_url + '/images/artworks/' + this.current_group[this.current_group_position].accessname + '.jpg' : ''
		},
		calculevote_class: function(){
			return this.calculevote() ? 'mdi-check' : 'mdi-vote-outline'
		},
		calculevote: function(){
			return this.current_group != null && this.current_group[this.current_group_position].vote
		}
		//
	}
}
</script>
