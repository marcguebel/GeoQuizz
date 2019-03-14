import Vue from 'nativescript-vue'
import Picture from './components/Picture'
import VueDevtools from 'nativescript-vue-devtools'
import routes from './router'
import Mapbox from 'mapbox-gl-vue';
import axios from 'axios';
var geolocation = require("nativescript-geolocation");

require( "nativescript-localstorage" );
localStorage.setItem('Another Plugin', 'By Master Technology');

Vue.registerElement("Mapbox", () => require("nativescript-mapbox").MapboxView)

if(TNS_ENV !== 'production') {
  Vue.use(VueDevtools)
}

Vue.prototype.$routes = routes;

// Prints Vue logs when --env.production is *NOT* set while building
Vue.config.silent = (TNS_ENV === 'production')

/*window.axios = axios.create({
	baseURL: '',
	params: {
		token : false
	},
	headers : {
		Authorization: 'Client-ID c0c7cb0b6d1041e',
        Authorization: 'Bearer 26981291d8de19e64af6cba81ce4bcf65476e29e'
	}
});*/

new Vue({
  render: h => h('frame', [h(Picture)])
}).$start()
