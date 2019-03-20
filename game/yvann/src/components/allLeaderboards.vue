<template>
	<div class="flex-row">
      	<div class="col-md-12 p-0">
        	<div class="col-md-12 p-3 text-center">
        		<select id="select" class="classic">
          
        		</select>
        	</div>
        	<div class="col-md-offset-4 col-md-4 bordure background" id='leaderboard'>
        	
        	</div>
        </div>
    </div>
    <!--<div class='leaderBoards'>
    	<select id="select" class="classic">
          
        </select>
        <div id='leader'>
        	
        </div>
    </div>-->
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
	  			document.getElementById('leaderboard').innerHTML = "";
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
</style>
