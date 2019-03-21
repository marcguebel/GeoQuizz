<template>
	<Page>
		<ActionBar :title="'Bienvenue ' + userLog">
			<NavigationButton android.systemIcon="ic_menu_back" @tap="changeRoute('Position')" />
			<ActionItem @tap="changeRoute('Login')" ios.systemIcon="9" ios.position="left" android.systemIcon="ic_lock_power_off" android.position="actionBar"></ActionItem>
		</ActionBar>
		<FlexboxLayout flexDirection="column">
			<Progress v-if="currentProgress != 0" id="pB" :value="currentProgress" />
			<Label>Latitude : {{lat}}</Label>
			<Label>Longitude : {{long}}</Label>
			<Image id="preview" :src="img" style="height:70%"/>
			<StackLayout orientation="horizontal" @tap="validation" id="btnV" class="btn">
				<Label width="80%">VALIDER</Label>
				<Image src="~/assets/images/check.png" height="90%" />
			</StackLayout>
		</FlexboxLayout>
	</Page>
</template>

<script>
	import axios from 'axios';
	let LS = require( "nativescript-localstorage" );
	export default {
		data() {
			return {
				img : LS.getItem('img'),
				img64 : LS.getItem('img64'),
				lat : parseFloat(LS.getItem('lat')),
				long : parseFloat(LS.getItem('long')),
				userLog : LS.getItem('userLog'),
				userToken : LS.getItem('userToken'),
				currentProgress : 0
			}
		},
		methods: {
			/*
			Envoir de l'image sur l'api:
			->Envoie de l'image en base 64 sur l'api de cloudinary, retourne un lien.
			->Enregistre le lien retourner et les coordonnées GPS de l'image dans l'api du backoffice.
			*/
			validation(){
				this.currentProgress = 10
				var bodyFormData = new FormData();
				bodyFormData.append("file", this.img64)
				bodyFormData.append("upload_preset", "rw2vmwqe")
				this.currentProgress = 20
				axios.post("https://api.cloudinary.com/v1_1/dvxlz9kaz/image/upload", bodyFormData)
				.then(res => {
					this.currentProgress = 50
					let urlImg = res.data.secure_url
					this.currentProgress = 70
					axios.post("https://backend-lmaillard.pagekite.me/photos", {
						latitude: this.lat,
						longitude: this.long,
						url: urlImg,
					}, {
						headers: {
							'Content-Type': 'application/json',
							'Authorization': this.userToken,
						}
					})
					.then(res => {
						this.currentProgress = 100
						this.changeRoute('End')
					})
					.catch((e)=>{
						this.currentProgress = 0
						console.log('error ' + e)
					})
				})
				.catch((e)=>{
					console.log('error ' + e.message)
				})
			},
			changeRoute(to){this.$navigateTo(this.$routes[to], { clearHistory: true});},
		},
	}
</script>
   
<style scoped>
	#preview, #btnV{ margin-top: 50px }
	#pb {background-color:50px; }
</style>
