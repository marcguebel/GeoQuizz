<template>
    <div>
      <h1>Bien joué {{pseudo}}</h1>
      <div id="comp">
      	<div id='score'>
      		<h2>Vous avez eu un score total de {{score}} lors de cette série</h2>
      	</div>
      	<div id='leaderboard'>
      		
      	</div>
      	<div id='rematch'>
      		<input type="button" name="rematch" value='Rejouer' @click='rejouer()'>
      	</div>
      </div>
    </div>
</template>

<script>
export default {
 	name: 'leaderboard',
 	data () {
	    return {
	    	pseudo: '',
	        score: 0,
	        serie: false,
	    }
  	},
 	mounted(){
 		this.pseudo = this.$store.state.pseudo
	    this.score = this.$store.state.score;
	    this.serie = this.$route.params.idSerie
	    this.leaderboard();
	    this.$store.commit('setLaSerie',false);
  	},
  	methods:{
  		rejouer(){
  			this.$router.push("/game/" + this.serie + "/" + this.pseudo);
  		},
  		leaderboard(){
	  		window.axios.get("https://player-lmaillard.pagekite.me/game/leaderboard/" + this.serie).then(response => {
	           	let HTML = "<p id='title'>LEADERBOARD</p>";
	           	response["data"]["score"].forEach(function(element){
	           		HTML += "<p id='pseudo'>" + element.joueur + "</p>";
	           		if(response["data"]["score"][9] != element){
	           			HTML += "<p id='scorePlayer'>" + element.score + "</p>";
 						HTML += "<hr class='style3'/>"
	           		}
	           		else{
	           			HTML += "<p id='scorePlayerFinish'>" + element.score + "</p>";
	           		}

	           		

	           	});
	           	$("#leaderboard").html(HTML);
	        }).catch(error => {
	           console.log(error);
	        });
  		},
	}
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
	#rematch{
		width: 100%;
	}
	h2{
		margin:auto;
		padding-top: 200px;
		width: 75%;
	}
	#leaderboard{
		/*justify-content: flex-start;*/
		background-color: #f3f3f3;
		margin-top:5%;
		display: flex;
		flex-direction: row wrap;
		flex-wrap: wrap;
		width: 38%;
		height: 80%;
		border: 1.5px solid black;
		margin-left: 4%;
		box-shadow: 3px 3px 0px #c0c0c0;
	}
	#score{
		background-color: #f3f3f3;
		margin-top:5%;
		text-align: center;
		margin-left: 3%;
		width: 52%;
		height: 80%;
		border: 1.5px solid black;
		box-shadow: 3px 3px 0px #c0c0c0;
	}
  	h1{
    	text-align: center;
  	}	
	#comp{
		background-color: #d5d8e0;
	    display: flex;
	    flex-direction: row wrap;
	    border: 2px solid black;
	    width: 75%;
	    height: 600px;
	    margin: auto;
	    margin-top: 30px;
	    text-align: center;
	    box-shadow: 5px 5px 0px #c0c0c0;
	    flex-wrap: wrap;
	}
</style>
