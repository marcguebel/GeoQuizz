<template>
	<Page>
		<ActionBar :title="'Bienvenue ' + userLog">
			<NavigationButton android.systemIcon="ic_menu_back" @tap="changeRoute('Picture')" />
			<ActionItem @tap="changeRoute('Login')" ios.systemIcon="9" ios.position="left" android.systemIcon="ic_lock_power_off" android.position="actionBar"></ActionItem>
		</ActionBar>
		<StackLayout>
			<StackLayout orientation="horizontal" @tap="enableLocationTap" id="btnL" class="btn">
				<Label width="80%">LOCALISATION ACTUELLE</Label>
				<Image src="~/assets/images/currentLocation.png" height="90%" />
			</StackLayout>
			<StackLayout orientation="horizontal" @tap="changeRoute('MapBox')" id="btnM" class="btn">
				<Label width="80%">CHOISIR SUR LA MAP</Label>
				<Image src="~/assets/images/map.png" height="90%" /> 
			</StackLayout>

			<FlexboxLayout flexDirection="column" v-for="item in locations">
				<Label>Latitude : {{item.latitude}}</Label>
				<Label>Longitude : {{item.longitude}}</Label>
			</FlexboxLayout>
			<StackLayout v-if="locations.length > 0" orientation="horizontal" @tap="changeRoute('Validation')" id="btnS" class="btn">
				<Label width="80%">SUIVANT</Label>
				<Image src="~/assets/images/next.png" height="80%" />
			</StackLayout>
			<ActivityIndicator :busy="busy" />
		</StackLayout>
	</Page>
</template>

<script>
	import * as geolocation from "nativescript-geolocation";
	import { Accuracy } from "tns-core-modules/ui/enums";
	let LS = require( "nativescript-localstorage" );
	export default {
		data() {
			return {
				locations: [],
				userLog : LS.getItem('userLog'),
				busy : false
			}
		},
		methods: {
			/*
			Recupère la position de l'appareil :
			->Demande l'authorisation d'accées à la position de l'appareil.
			->Stock les coordonnées GPS de l'appareil dans le localStorage (affiche un chargement pendant la recherche).
			*/
			enableLocationTap: function() {
				this.busy = true
				geolocation.enableLocationRequest().then(() => { 
					let that = this;
					geolocation.getCurrentLocation({
						desiredAccuracy: Accuracy.high,
						maximumAge: 5000,
						timeout: 10000
					}).then(function (loc) {
						if (loc) {
							that.locations = [];
							that.locations.push(loc);
							localStorage.setItem('lat', loc.latitude); 
							localStorage.setItem('long', loc.longitude); 
						}
					}, function (e) {
						this.busy = false
						console.log('error ' + e);
					});
				});
				this.busy = false
			},
			changeRoute(to){this.$navigateTo(this.$routes[to], { clearHistory: true});},
		},
		mounted() {
			localStorage.setItem('lat', null)
			localStorage.setItem('long', null)
		}
	}
</script>

<style scoped>
	#btnL{ margin-top: 25%; }
	#btnM, #btnS{ margin-top: 50px; }
</style>