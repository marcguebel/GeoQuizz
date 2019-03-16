import Vue from 'nativescript-vue'
import Picture from './components/Picture'
//import VueDevtools from 'nativescript-vue-devtools'

//Pour utiliser le router non implémenté-> on crée nous même un routeur, voir router/index.js
import routes from './router' 
Vue.prototype.$routes = routes;

//Intégration mabox
import Mapbox from 'mapbox-gl-vue';
Vue.registerElement("Mapbox", () => require("nativescript-mapbox").MapboxView) // Pour pouvoir utiliser l'element mapbox

//Intégration axios
import axios from 'axios'; 

//Intégration geolocation
var geolocation = require("nativescript-geolocation");

//Intégration localstorage
require( "nativescript-localstorage" ); 

/*if(TNS_ENV !== 'production') {
  	Vue.use(VueDevtools)
}*/

Vue.config.silent = (TNS_ENV === 'production')

new Vue({
  	render: h => h('frame', [h(Picture)])
}).$start()
