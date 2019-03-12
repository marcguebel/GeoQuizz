import Vue from 'nativescript-vue'
import Picture from './components/Picture'
import VueDevtools from 'nativescript-vue-devtools'
import routes from './router'
import Mapbox from 'mapbox-gl-vue';
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

new Vue({
  render: h => h('frame', [h(Picture)])
}).$start()
