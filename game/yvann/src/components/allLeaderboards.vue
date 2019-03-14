<template>
    <div class='leaderBoards'>

    </div>
</template>

<script>
export default {
 	name: 'game',
 	data () {
	    return {
	    	pseudo: '',
	        score: 0,
	    }
  	},
 	mounted(){
 		this.theSeries();
  	},
  	methods:{
  		theSeries(){
  			
  		},
  		leaderboard(){
	  		window.axios.get("https://player-lmaillard.pagekite.me/game/leaderboard/" + this.$route.params.serie).then(response => {
	           	console.log(response["data"]["score"]);
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
  		}
	}
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
 	.leaderBoards{
 		width: 50%;
 		height: 500px;
 		margin:auto;
 		border: 1px solid black;
 		margin-top: 8%;
 	}
</style>
