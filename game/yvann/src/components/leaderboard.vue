<template>
	<div class="flex-row">
      	<div class="col-md-12 p-0">
        	<div class="col-md-12 p-3 text-center">
        		<h1>Bien joué {{pseudo}}</h1>
        	</div>
        	<div class="col-md-12 text-center pt-4">
        		<h2 class="dark-blue">Vous avez eu un score total de {{score}} lors de cette série</h2>
        	</div>
        	<div class="col-md-offset-4 col-md-4 flex-row bordure text-center background" id="leaderboard">
        		<div class="col-md-12 text-center">
        			<h2 class="py-5">LEADERBOARD</h2>
        		</div>
        	</div>
        	<div class="col-md-offset-4 col-md-2 text-center">
        		<input class="form-control background" type="button" name="retourAccueil" value='Accueil' @click='accueil()'>
        	</div>
        	<div class="col-md-2 text-center marg-bot">
        		<input class="form-control background" type="button" name="rematch" value='Rejouer' @click='rejouer()'>
        	</div>
    	</div>
    </div>
    <!--<div>
      <h1>Bien joué {{pseudo}}</h1>
      <div id="comp">
      	<div id='score'>
      		<h2>Vous avez eu un score total de {{score}} lors de cette série</h2>
      	</div>
      	<div id='leaderboard'>
      		
      	</div>
      	<div id='rematch'>
      		<input type="button" name="rematch" value='Rejouer' @click='rejouer()'>
      		<input type="button" name="retourAccueil" value='Accueil' @click='accueil()'>
      	</div>
      </div>
    </div>-->
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
 		if(this.$store.state.token != false){
 			this.$router.push('/game/' + this.$store.state.laSerie.id + "/" + this.$store.state.pseudo);
 		}
 		else if(this.$store.state.score === false){
 			this.$router.push('/');
 		}
 		else{
 			this.pseudo = this.$store.state.pseudo
		    this.score = this.$store.state.score;
		    this.serie = this.$store.state.laSerie.id;
		    this.leaderboard();
 		}
  	},
  	methods:{
  		rejouer(){
  			this.$store.commit('setLaSerie',this.$store.state.laSerie.id);
  			this.$router.push("/game");
  		},
  		leaderboard(){
	  		window.axios.get("https://player-lmaillard.pagekite.me/game/leaderboard/" + this.serie).then(response => {

	           	response["data"]["score"].forEach(function(element){
	           		let laDiv = document.createElement('div');
	           		laDiv.setAttribute("class","col-md-offset-2 col-md-3 text-center");
	           		let resultatWrite = document.createElement('p');
	           		resultatWrite.id = "white";
	           		let text = document.createTextNode(element.joueur);
	           		resultatWrite.appendChild(text); 
	           		laDiv.appendChild(resultatWrite); 
	           		document.getElementById("leaderboard").appendChild(laDiv);

	           		laDiv = document.createElement('div');
	           		laDiv.setAttribute("class","col-md-offset-2 col-md-3 text-center");
	           		resultatWrite = document.createElement('p');
	           		resultatWrite.id = "white";
	           		text = document.createTextNode(element.score);
	           		resultatWrite.appendChild(text); 
	           		laDiv.appendChild(resultatWrite); 
	           		document.getElementById("leaderboard").appendChild(laDiv);
	           		if(response["data"]["score"][response["data"]["score"].length - 1] != element){
	           			laDiv = document.createElement('div');
		       			laDiv.setAttribute("class","col-md-12 text-center");
		           		let ligne = document.createElement('hr');
		           		laDiv.appendChild(ligne); 
		           		document.getElementById("leaderboard").appendChild(laDiv);
	           		}
	           	});
	           	$("#leaderboard").html(HTML);
	        }).catch(error => {
	           console.log(error);
	        });
  		},
  		accueil(){
  			this.$store.commit('setLaSerie',false);
		    this.$store.commit('setScore',false);
  			this.$router.push("/");
  		}
	}
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
	.dark-blue{
		color: darkblue;
	}
	hr{
		width: 95%;
		color: white;
		margin:0;
		box-sizing: border-box;
	}
	.vertAlign{
		vertical-align: middle;
	}
	h2{
		margin:auto;
		width: 75%;
		color: white;
	}
	.bordure{
		border: 1.5px solid black;
		border-radius: 10px;
		margin-top: 30px;
		box-shadow: 2px 2px 2px gray;
		margin-bottom: 30px;
	}
	.background{
		background-color: darkblue;
    	color:white;
	}
	.marg-bot{
		margin-bottom: 30px;
	}
</style>
