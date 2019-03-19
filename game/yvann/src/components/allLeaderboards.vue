<template>
    <div class='leaderBoards'>
    	<select id="select" class="classic">
          
        </select>
        <div id='leader'>
        	
        </div>
    </div>
</template>

<script>
export default {
 	name: 'game',
 	data () {
	    return {
	    	pseudo: '',
	        score: 0,
	        leader: 0,
	    }
  	},
 	mounted(){
 		this.theSeries();
 		$("#select").change(this.onCompare);
  	},
  	methods:{
  		onCompare(){
  			this.leaderboard(this.$store.state.series[$("#select").prop('selectedIndex')].id);
  		},
  		theSeries(){
  			window.axios.get('https://player-lmaillard.pagekite.me/series').then(response => {
		        this.$store.commit('setSeries',response.data["series"]);
		        this.$store.state.series.forEach(function(element){
		          var select = document.getElementById ("select");
		          var newOption = new Option (element["libelle"], "value");
		          select.options.add (newOption);
		        });
		        this.leaderboard(this.$store.state.series[0].id);
		      }).catch(error => {
		        console.log(error);
		      });
  		},
  		leaderboard(idSerie){
	  		window.axios.get("https://player-lmaillard.pagekite.me/game/leaderboard/" + idSerie).then(response => {
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
	           	$("#leader").html(HTML);
	        }).catch(error => {
	           console.log(error);
	        });
  		}
	}
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
	#leader{
		background-color: #f3f3f3;
		width: 70%;
		height: 75%;
		border: 1.5px solid black;
		margin:auto;
		margin-top: 50px;
		box-shadow: 3px 3px 0px #c0c0c0;
		display: flex;
		flex-direction: row wrap;
		flex-wrap: wrap;
		text-align: center;
	}
 	.leaderBoards{
 		background-color: white;
 		width: 50%;
 		height: 650px;
 		margin:auto;
 		border: 2px solid black;
 		margin-top: 2%;
 		box-shadow: 5px 5px 0px #c0c0c0;
 	}

 	select{
	    width: 60%;
	    /* styling */
	    background-color: white;
	    border: thin solid black;
	    display: inline-block;
	    font: inherit;
	    line-height: 1.5em;
	    padding: 0.5em 3.5em 0.5em 1em;

	    /* reset */

	    margin: 0;      
	    -webkit-box-sizing: border-box;
	    -moz-box-sizing: border-box;
	    box-sizing: border-box;
	    -webkit-appearance: none;
	    -moz-appearance: none;
	    box-shadow: 1px 1px 0px #085394;
	    margin-left: 20%;
	    margin-top: 20px;
	}

  	select.classic {
	    background-image:
	      linear-gradient(45deg, transparent 50%, white 50%),
	      linear-gradient(135deg, white 50%, transparent 50%),
	      linear-gradient(to right, #085394, #085394);
	    background-position:
	      calc(100% - 20px) calc(1em + 2px),
	      calc(100% - 15px) calc(1em + 2px),
	      100% 0;
	    background-size:
	      5px 5px,
	      5px 5px,
	      2.5em 2.5em;
	    background-repeat: no-repeat;
	  }

  	select.classic:focus {
	    background-image:
	      linear-gradient(45deg, white 50%, transparent 50%),
	      linear-gradient(135deg, transparent 50%, white 50%),
	      linear-gradient(to right, #085394, #085394);
	    background-position:
	      calc(100% - 15px) 1em,
	      calc(100% - 20px) 1em,
	      100% 0;
	    background-size:
	      5px 5px,
	      5px 5px,
	      2.5em 2.5em;
	    background-repeat: no-repeat;
	    border-color: grey;
	    outline: 0;
	  }
</style>
