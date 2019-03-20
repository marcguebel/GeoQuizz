import Vue from 'nativescript-vue'	
import Login from './components/Login'

//Pour utiliser le router non implémenté-> on crée nous même un routeur, voir router/index.js
import routes from './router' 
Vue.prototype.$routes = routes;

//Intégration mabox
import Mapbox from 'mapbox-gl-vue';
Vue.registerElement("Mapbox", () => require("nativescript-mapbox").MapboxView) // Pour pouvoir utiliser l'element mapbox

Vue.config.silent = (TNS_ENV === 'production')

new Vue({
  	render: h => h('frame', [h(Login)])
}).$start()
