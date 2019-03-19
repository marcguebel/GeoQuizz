import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
	state : {
		laSerie: false,
		photos: false,
		partie: false,
		series : false,
		game : false,
		score: false,
		pseudo: false,
		token: false,
		page: false,	
	},
	mutations: {
		setLaSerie(state, laSerie){
			state.laSerie = laSerie;
		},
		setPhotos(state, photos){
			state.photos = photos;
		},
		setPartie(state, partie){
			state.partie = partie;
		},
		setSeries(state, series){
			state.series = series;
		},
		setGame(state, game){
			state.game = game;
		},
		setScore(state, score){
			state.score = score;
		},
		setPseudo(state, pseudo){
			state.pseudo = pseudo
		},
		setToken(state, token){
			state.token = token;
		},
		setPage(state, page){
			state.page = page;
		},
		initialiseStore(state){
			if(localStorage.getItem('store')){
                this.replaceState(
                    Object.assign(state, JSON.parse(localStorage.getItem('store')))
                );
            }
		}
	}
})