<template>
	<Page>
		<ActionBar title="Connexion"/>
		<StackLayout>
			<label class="infoLog">Login : </label>
			<TextField v-model="log" />
			<label class="infoLog">Mot de passe : </label>
			<TextField v-model="mdp" secure="true"/>
			<StackLayout orientation="horizontal" @tap="checkLog" id="btnC" class="btn">
				<Label width="80%">CONNEXION</Label>
				<Image src="~/assets/images/next.png" height="80%" />
			</StackLayout>
			<ActivityIndicator :busy="busy" />
			<label id="lbe" v-if="this.error == true" text="L'authentification a échoué!" />
		</StackLayout>
	</Page>
</template>

<script>
	import axios from 'axios';
	export default {
		data() {
			return {
				log : '',
				mdp : '',
				error : false,
				busy : false
			}
		},
		methods:{
			/*
			Vérifie les informations saisie par l'utilisateur (Chargement pendant l'exécution):
			->Si l'utilisateur est correcte, enregistre le token et le nom dans le local storage, redirection sur la page picture.
			->Sinon renvoie une erreur.
			*/
			checkLog(){	
				this.busy = true
				axios.post("https://backend-lmaillard.pagekite.me/login", {
					login: this.log,
					password: this.mdp,
				})
				.then(res => {
					localStorage.setItem('userToken', res.headers.authorization)
					localStorage.setItem('userLog', res.data.user.login)
					this.changeRoute('Picture')
				})
				.catch((e)=>{
					console.log('error ' + e)
					this.busy = false
					this.error = true
				})
			},
			changeRoute(to){this.$navigateTo(this.$routes[to], { clearHistory: true});},
		},
		mounted() {
			localStorage.setItem('userToken', null)
			localStorage.setItem('userLog', null)
		}
	}
</script>
		
<style scoped>
	#lbe{ color : red; }
	#btnC{ margin-top: 100px;}
	.infoLog{ margin-top:100px; }
	TextField{ 
		margin-top: 100px;
		text-align: center;
		width : 80%;
		margin-left : 10%;
		margin-right : 10%;
		background-color: white
	}
	
</style>
<style>
	ActivityIndicator{ margin-top: 200px; }
	.btn:active{ background-color: red}
	page{ 
		background-color : #3c495e; 
		font-size: 20px;
		font-family: Georgia;
	}
	.btn{
		height : 200px;
		width : 80%;
		margin-left : 10%;
		margin-right : 10%;
		color : white;
		background-color : #0084C6;
		border-radius : 10px;
	}
	label{ 
		text-align: center;
		color: white;
		margin-top: 50px;
	}
	@keyframes effect {
		from { background-color:#0084C6; }
		to { background-color:red; }
	}
</style>