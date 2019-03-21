<template>
	<Page>
		<ActionBar :title="'Bienvenue ' + userLog">
			<ActionItem @tap="changeRoute('Login')" ios.systemIcon="9" ios.position="left" android.systemIcon="ic_lock_power_off" android.position="actionBar"></ActionItem>
		</ActionBar>
		<StackLayout horizontalAlignment="center">
			<StackLayout orientation="horizontal" @tap="takePicture" id="btnP" class="btn">
				<Label width="80%">PRENDRE UNE PHOTO </Label>
				<Image src="~/assets/images/takePhoto.png" height="85%" />
			</StackLayout>

			<StackLayout orientation="horizontal" @tap="selectPicture" id="btnSP" class="btn">
				<Label width="80%"> CHOISIR UNE PHOTO</Label>
				<Image src="~/assets/images/selectPicture.png" height="90%" />
			</StackLayout>

			<FlexboxLayout horizontalAlignment="center" id="img" flexDirection="column" justifyContent="space-around" >
				<Image v-if="link.length > 0" alignSelf="center" :src="link" height="70%"/>
			</FlexboxLayout>

			<StackLayout v-if="link.length > 0" orientation="horizontal" @tap="changeRoute('Position')" id="btnS" class="btn">
				<Label width="80%">SUIVANT</Label>
				<Image src="~/assets/images/next.png" height="80%" />
			</StackLayout>

			<StackLayout v-if="link.length < 1" orientation="horizontal" @tap="changeRoute('Login')" id="btnD" class="btn">
				<Label width="80%">SE DÉCONNECTER</Label>
				<Image src="~/assets/images/logout.png" height="80%" />
			</StackLayout>
			
		</StackLayout>
	</Page>
</template>

<script>
	import * as camera from "nativescript-camera";
	import * as imagepicker from "nativescript-imagepicker";
	import { Image } from "tns-core-modules/ui/image";
	import { ImageSource } from "tns-core-modules/image-source";
	import * as dialogs from "tns-core-modules/ui/dialogs";
	let LS = require( "nativescript-localstorage" );
	export default {
		data() {
			return {
				image64 : [],
				link : '',
				userLog : LS.getItem('userLog')
			}
		},
		methods:{
			/*
			Accées à l'appareil photo, pour prendre une photo et l'enregistrer :
			->Demande l'authorisation d'accées à l'appareil photo.
			->Enregistre la photo prise dans le local storage en base 64 et le lien path local de la photo.
			*/
			selectPicture() {
				let context = imagepicker.create({
					mode: 'multiple' 
				});
				context.authorize() 
				.then(function() {
					return context.present();
				})
				.then(selection => {
					selection.forEach(selected => {
						this.link = '';
						let imgSource = new ImageSource();
						imgSource.fromAsset(selected).then(imgSource => {
							const base64image = imgSource.toBase64String("jpeg", 50);
							this.image64.push("data:image/jpeg;base64," + base64image);
							localStorage.setItem('img64', this.image64);
						});
						let img = new Image();
						img.src = selected;
						this.link = img.src._android
						localStorage.setItem('img', img.src._android);
					});
				}).catch(function (e) {
					console.log('error ' + e);
				});
			},
			/*
			Accées aux stockage de l'appareil, pour choisir une photo et l'enregistrer :
			->Demande l'authorisation d'accées aux stockage de l'appareil.
			->Enregistre la photo choisie dans le local storage en base 64 et le lien path local de la photo.
			*/
			takePicture() {  
				camera.requestPermissions()
				.then(() => {
					camera.takePicture({ width: 300, height: 300, keepAspectRatio: true, saveToGallery:false })
					.then(imageAsset => {
						this.link = '';
						let imgSource = new ImageSource();
						imgSource.fromAsset(imageAsset).then(imgSource => {
							const base64image = imgSource.toBase64String("jpeg", 50);
							this.image64.push("data:image/jpeg;base64," + base64image);
							localStorage.setItem('img64', this.image64);
						});
						let img = new Image();
						img.src = imageAsset;
						this.link = img.src._android
						localStorage.setItem('img', img.src._android);
					})
					.catch(e => {
						console.log('error ' + e);
					});
				})
				.catch(e => {
					console.log('error ' + e);
				});
			},
			changeRoute(to){this.$navigateTo(this.$routes[to], { clearHistory: true});},
		},
		mounted() {
			localStorage.setItem('img', null)
			localStorage.setItem('img64', null)
		}
	}
</script>
	
<style scoped>
	#btnP{ margin-top : 10%; }
	#btnSP, #btnS, #btnD, #img{ margin-top : 50px; }
	#btnD{ background-color: #c40000; }
</style>
