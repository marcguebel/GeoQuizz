<template>
	<Page class="page">
		<ActionBar class="action-bar" title="Map">
			<NavigationButton android.systemIcon="ic_menu_back" @tap="changeRoute('Position')" />
		</ActionBar>
		<GridLayout >
			<Mapbox
				accessToken="pk.eyJ1IjoibWFyY2d1ZWJlbCIsImEiOiJjanQ0ZWJpcXYxMDB3M3lwZ3U0YjZ3emliIn0.blWnH7mREgxkPfuOcA87zA"  
				mapStyle="dark"
				latitude="48.682968"
				longitude="6.161096"
				hideCompass="false"
				zoomLevel="12"
				showUserLocation="false"
				disableZoom="false"
				disableRotation="true"
				disableScroll="false"
				disableTilt="false"
				@mapReady="onMapReady($event)"
				@tap="addMarker()"
				ref="map">
			</Mapbox>
		</GridLayout>
	</Page>
</template>

<script>
	let LS = require( "nativescript-localstorage" );
	import * as utils from "utils/utils";
	export default {
		data () {
			return { };
		},
		methods: {
			onMapReady(args) { // Function appelé au chargement de la map
				console.log(args)
				/*var vm = this;
				setTimeout(function () {
					vm.addMarker();
				},5000);*/
			},
			addMarker(){ // Ajout d'un marker sur la map
			console.log('taped')
				/*this.$refs.map.nativeView.addMarkers([
					{
						lat: 48.682968,
						lng: 6.161096,
						title: 'One-line title here',
						subtitle: 'Really really nice location',
						selected: true, // makes the callout show immediately when the marker is added (note: only 1 marker can be selected at a time)
						onCalloutTap: function(){console.log("'Nice location' marker callout tapped");}
					}]
				);*/
			},
			changeRoute(to){this.$navigateTo(this.$routes[to], { clearHistory: true});},
		},
	};
</script>

<style scoped>
	ActionBar {
		background-color: #53ba82;
		color: #ffffff;
	}
	.message {
		vertical-align: center;
		text-align: center;
		font-size: 20;
		color: #333333;
	}
	#mapid { height: 180px; }
</style>