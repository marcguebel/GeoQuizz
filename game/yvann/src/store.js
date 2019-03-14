import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
	state : {
		series : false
	},
	mutations: {
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
		setSerie(state, serie){
			state.serie = serie;
		},
		setNameOfSeries(state, name){
			state.name = name;
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