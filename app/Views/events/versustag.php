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
	return base_url()."/images/artworks_small/$artwork.jpg";
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
	background: var(--light-gray);
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
	height: 140px;
	position: relative;
}
#versustag-presentation{
	height: 100%;
	transition: cubic-bezier(0.65, 0.05, 0.36, 1) all .2s;
	display: flex;
	flex-direction: column;
}
#versustag-title-vs{
	position: absolute;
	top: 4rem;
	left: 1rem;
	padding: .5rem 1rem;
	background-color: rgba(255,255,255,.2);
	color: white;
	border-radius: 30px;
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
	width: 50px;
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
	font-size: 0.7rem;
	width: 50px;
	overflow: hidden;
	text-overflow: ellipsis;
	white-space: nowrap;
}
.group-versus-vs-text{
	height: 100%;
	width: 100%;
	position: absolute;
	top: 0;
	left: 0;
	padding: 0 25px;
	display: flex;
	align-items: center;
	justify-content: space-around;
	font-size: 1.2rem;
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
	border-radius: 5px;
	position: relative;
}
.group-versus .btn{
	transform: scale(.8);
	transform-origin: right center;
}
.group-versus-avatar{
	font-size: 1.2rem;
	background-color: var(--gray);
	color: gray;
}
.group-versus-avatar.yourwinner{
	box-shadow: 0 0 0 4px #876cedbf;
}
.group-versus > div:nth-child(1){
	padding: 1rem  1rem .25rem;
	background-color: white;
	border-radius: 10px;
}
.group-vs-actions{
	padding: .25rem  1rem;
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
	height: 30px;
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
	top: 1rem;
	right: 1rem;
	left: 1rem;
	justify-content: space-between;
	align-items: center;
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
	right: 1rem;
	bottom: 1rem;
	display: flex;
	flex-direction: column;
	cursor: pointer;
}
#versus-vs-area-action{
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	transition: linear all .2s
}
#versus-vs-area-action.area_actions-fade{
	opacity: 0;
	pointer-events: none;
}
#versustag-vs-aa-hidden{
	position: absolute;
	bottom: 1rem;
	left: 1rem;
}
.versus-pic{
	height: 40px;
	width: 40px;
	border-radius: 50%;
	display: inline-block;
	margin-top: 1rem;
	box-shadow: 0 0 0 2px rgba(0,0,0,.5);
	filter: grayscale();
}
.versus-pic-active{
	box-shadow: 0 0 0 2px var(--bg-lime);
	animation-duration: 3s;
	animation-name: bounce_shadow;
	animation-timing-function: linear;
	animation-iteration-count: infinite;
	filter: none;
}
#versustag-btn-vote{
	position: absolute;
	bottom: 1rem;
	left: 50%;
	transform: translateX(-50%);
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
		height: 30px;
	}
	#versustag-presentation-header{
		height: 100px;
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
					<div class="f-b">
						<img id="versustag-header-img" src="<?= base_url() ?>/images/icon_white.svg">
						<h3 class="pl-4 white-text">VERSUS ARTSBOOK</h3>
					</div>
				</div>

			</div>
			<div id="versustag-body" >
					<div style="padding: 2rem;">

						<template v-for="(groups, index) of group_versus">
							<template v-if="groups.length >= 2 && !my_votes[index]">
								<div class="group-versus">

									<div class="f-b" style="position: relative">
										<div class="group-versus-vs-text">
											<span v-for="n in (groups.length - 1)">V S</span>
										</div>

										<a v-for="artist of groups" class="artist-content f-c" target="_blank" :href="'<?= base_url()?>/' + artist.account">
											<div class="group-versus-avatar cover f-c" :class="{'yourwinner': artist.vote}" :style="{'background-image': artist.avatar == undefined ? '' : 'url(' + artist.avatar + ')'}">
												{{artist.avatar == undefined ? artist.nickname[0] : ''}}
											</div>
											<span>{{artist.nickname}}</span>
										</a>
									</div>
									<div class="f-b group-vs-actions">
										<span><i class="mdi mdi-star-box"></i> {{groups[0].name}}</span>
										<div class="btn" @click="openversus(groups, index)">Votar!</div>
									</div>

								</div>
								<br>
							</template>

						</template>
						<template v-for="(groups, index) of group_versus">
							<template v-if="groups.length >= 2 && my_votes[index]">
								<div class="group-versus">

									<div class="f-b" style="position: relative">

										<a v-for="artist of groups" v-if="artist.vote" class="artist-content f-c" target="_blank" :href="'<?= base_url()?>/' + artist.account">
											<div class="group-versus-avatar cover f-c" :style="{'background-image': artist.avatar == undefined ? '' : 'url(' + artist.avatar + ')'}">
												{{artist.avatar == undefined ? artist.nickname[0] : ''}}
											</div>
											<span>{{artist.nickname}}</span>
										</a>
										<div style="flex: 1" class="r">
											Tu ganador
											<div class="btn bg-success" @click="openversus(groups, index)">Cambiar</div>
										</div>
									</div>
									<div class="f-b group-vs-actions">
										<span> <i class="mdi mdi-star-box"></i> {{groups[0].name}}</span>
									</div>

								</div>
								<br>
							</template>

						</template>
						<template v-for="(groups, index) of group_versus">
							<template v-if="groups.length == 1">
								<div class="group-versus">
									<div class="f-b" style="position: relative">

										<a class="artist-content f-c" target="_blank" :href="'<?= base_url()?>/' + groups[0].account">
											<div class="group-versus-avatar cover f-c" :style="{'background-image': groups[0].avatar == undefined ? '' : 'url(' + groups[0].avatar + ')'}">
												{{groups[0].avatar == undefined ? groups[0].nickname[0] : ''}}
											</div>
											<span>{{groups[0].nickname}}</span>
										</a>
										<div style="flex: 1" class="r">
											Ganador por default
											<div class="btn bg-success" @click="openversus(groups, index)">Ver</div>
										</div>
									</div>
									<div class="f-b group-vs-actions">
										<span> <i class="mdi mdi-star-box"></i> {{groups[0].name}}</span>
									</div>
								</div>
								<br>
							</template>
						</template>
					</div>
			</div>
		</div>
		<div id="versustag-vs-choser" :class="{'versus-vote': calculevote()}">
			<img ref="imageartwork" :src="calculeurl()" id="versustag-vs-choser-currente-img-view">
			<div id="versus-vs-area-action" :class="{'area_actions-fade': toggle_fade_area_actions}">
				<div id="versustag-vs-preview-images" v-if="current_group">
					<div v-for="(pic, index) in current_group" class="cover versus-pic" @click="current_group_position = index" :class="{'versus-pic-active': calculepic(pic)}" :style="calculeartwork(pic)"></div>
				</div>
				<div id="versustag-btn-vote">
					<a v-show="my_votes[current_index] == 0 || calculevote()" ref="btnvote" class="btn-icon" id="versustag-voting-button" @click="choise">
						<i class="mdi" :class="calculevote_class()"></i>
					</a>
				</div>
				<div id="versustag-title-vs" class="btn-dark" style="max-width: calc(100% - 100px)">
					<i class="mdi mdi-star-box"></i>
					<span class="pl-2">{{current_group ? current_group[0].name : ''}}</span>
				</div>
				<div id="versustag-vs-buttons" class="f-b">
						<a class="btn btn btn-dark pointer" @click="closeversus">
							<i class="mdi mdi-keyboard-return mdi-18px"></i>
						</a>
						<a  v-if="group_free.length && (next_index != null && next_index != current_index)" class="ml-1 btn btn btn-dark pointer" @click="next_versus">
							<i class="mdi mdi-arrow-right mdi-18px right"></i>
							<span>SIGT. VS</span>
						</a>
				</div>
				<div id="challenges-arrows">
					<a @click="back"><i class="mdi mdi-chevron-left"></i></a>
					<a @click="advance"><i class="mdi mdi-chevron-right"></i></a>
				</div>
			</div>
			<div id="versustag-vs-aa-hidden" class="btn-icon btn-dark" @click="toggle_fade_area_actions = !toggle_fade_area_actions">
				<i class="mdi mdi-image mdi-24px"></i>
			</div>
		</div>
	</div>


</div>
<?php module_end() ?>
<script type="text/javascript">
$_module = {
	data: function () {
		return {
			toggle_fade_area_actions: false,
			on_choise: false,
			group_versus: <?= json_encode($group_versus) ?>,
			current_group: null,
			next_index: null,
			base_url: '<?= base_url() ?>',
			current_group_position: 0,
			start_vote: false,
			current_index: null
		}
	},
	computed: {
		group_free: function () {
			let list = [];
			for (var i in this.my_votes) {
				if (!this.my_votes[i])  list.push(i)
			}
			return list;
		},
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
		next_versus: function () {
			this.openversus(this.group_versus[this.next_index], this.next_index);
		},
		openversus: function (versus, i) {
			this.current_index = i
			let last_index = this.group_free.indexOf(i);
			this.next_index = this.group_free[++last_index >= this.group_free.length ? 0 : last_index];
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

			return this.current_group ? this.base_url + '/images/artworks_small/' + this.current_group[this.current_group_position].accessname + '.jpg' : ''
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
