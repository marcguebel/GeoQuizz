<template>
    <div>
      <h1>Bonne chance {{pseudo}}</h1>
      <div id="game">
        <div id="image">
          <img id="lImage" src="https://i.imgur.com/HBbbnGu.jpg">
        </div>
        <!--<div id="maps">
          
        </div>-->
        <div id="resultat">
          <h3 id="res"></h3>
        </div>
        <div id="detail">
          <h2 id="bas_gauche">Score : {{score}}</h2>
          <button id="valider" @click="validation()">Valider</button>      
          <h2 id="bas_droite">Photo : {{nbrePhoto}} / 10</h2>
        </div>
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
      serie: false,
      nbrePhoto: 1,
      lastlatlng:false,
      lastLat: false,
      lastLng: false,
      series: false,
    }
  },
  mounted(){
    if(this.$route.params.pseudo === undefined){
      this.$router.push('/');
    }
    else{
      this.pseudo = this.$route.params.pseudo ;
      this.serie = this.$route.params.idSerie;
      this.theSeries();
    }   
  },
  methods:{
     getRandomInt(max) {
      return Math.floor(Math.random() * Math.floor(max));
    },
    theSeries(){
      window.axios.post('https://player-lmaillard.pagekite.me/game/new',{
          serie: this.serie,
          joueur: this.pseudo
        }).then(response => {
          //console.log(response.data);
          let tab = [response.data["photos"],response.data["partie"],response.data["serie"]];
          this.$store.commit('setSeries',tab);
           this.createMap();
           this.createGame();
           this.createImage();
        }).catch(error => {
          console.log(error);
        });
    },
    createGame(){
      let tab = [];
      while(tab.length != 10){
        let nbre = this.getRandomInt(this.$store.state.series[0].length);

        if(tab.indexOf(nbre) >= 0 ){
        }
        else{
          tab.push(nbre);
        }
      }
      this.$store.commit('setGame',tab);

    },
    validation(){

      if(this.nbrePhoto < 10){
        let result = this.Distance(this.lastlatlng.lastLat,this.lastlatlng.lastLng,this.$store.state.series[0][this.$store.state.game[this.nbrePhoto - 1]].latitude,this.$store.state.series[0][this.$store.state.game[this.nbrePhoto - 1]].longitude);
        result = (Math.round(result *1000)/1000) * 1000;
        
        $("#res").html("vous êtes à " + result + " mètres");

        if(this.$store.state.series[2]["distance"] > result){
          this.score += 5;
        }
        else if(this.$store.state.series[2]["distance"]  * 2 > result){
          this.score += 3;
        }
        else if(this.$store.state.series[2]["distance"]  * 3 > result){
          this.score += 1;
        }
        document.getElementById("game").removeChild(document.getElementById('maps'));        
        this.createMap();
        this.createImage();
      }
      this.nbrePhoto++;

      if($("#valider").html() == "Acces leaderboard"){
        this.$router.push("/game/"+ this.$store.state.series[2].id + "/" + this.score + "/" + this.pseudo);
      }

      if(this.nbrePhoto == 11){
        this.nbrePhoto--;
        $("#valider").html("Acces leaderboard");
        this.$store.commit('setScore',this.score);
        window.axios.put('https://player-lmaillard.pagekite.me/game/score/' + this.$store.state.series[1].id,{
          score: this.score,
        }).then(response => {
          console.log(response.data);
        }).catch(error => {
          console.log(error);
        });
      }
    },
    createImage(){
      $("#lImage").attr('src',this.$store.state.series[0][this.$store.state.game[this.nbrePhoto - 1]].url);
    },
    createMap(){

      let newMaps = document.createElement('div');
      newMaps.id = "maps";
      let detail = document.getElementById("resultat");
      var parentDiv = document.getElementById("game");
      parentDiv.insertBefore(newMaps, detail);

      var map = L.map('maps').setView([this.$store.state.series[2]["latitude"], this.$store.state.series[2]["longitude"]], this.$store.state.series[2]["zoom"]); // LIGNE 14

        var osmLayer = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', { // LIGNE 16
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18
        });

        var marker = L.marker([0,0]); 
    
        map.addLayer(osmLayer);

        this.lastlatlng = map.on('click', function(e){

          this.lastLat = e.latlng.lat;
          this.lastLng = e.latlng.lng;

            // Creating a marker
            
          marker.setLatLng(e.latlng);
             
            // Adding marker to the map
          marker.addTo(map);

          return e.latlng;
        });
    },
    convertRad(input){
      return (Math.PI * input)/180;
    },
    Distance(lat_a_degre, lon_a_degre, lat_b_degre, lon_b_degre){
      let R = 6378137 //Rayon de la terre en mètre
 
      let lat_a = this.convertRad(lat_a_degre);
      let lon_a = this.convertRad(lon_a_degre);
      let lat_b = this.convertRad(lat_b_degre);
      let lon_b = this.convertRad(lon_b_degre);

      let dlo = (lon_b - lon_a) / 2;
      let dla =(lat_b - lat_a) / 2;

      let a = (Math.sin(dla) * Math.sin(dla)) + Math.cos(lat_a) * Math.cos(lat_b) * (Math.sin(dlo) * Math.sin(dlo));
      let d = 2 * Math.atan2(Math.sqrt(a),Math.sqrt(1 - a));
       
      let meter = R * d;

      let km = meter / 1000;

      return km;
    }
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .accessory:after {
    position: absolute;
    top:  50%;
    left: 50%;
    display:block;
    background-color: hsl(0, 0%, 75%);
    height: 12px;
    width:  12px;
    transform: rotate(45deg);
    margin-top:  -10px;
    margin-left: -10px;
    border-radius: 4px 0;
    border: 4px solid hsla(0, 0%, 100%, 0.35);
    background-clip: padding-box;
    box-shadow: -10px 10px 0 hsla(0, 0%, 100%, 0.15), 10px -10px 0 hsla(0, 0%, 100%, 0.15);
  }
  #resultat{
    width: 100%;
    height: 10%;
    text-align: center;
  }
  img{
    box-sizing: border-box;
    width: 100%;
    height: 100%;
  }
  #bas_gauche{
    width:150px;
    float: left;
    margin-left: 10px;
  }
  #bas_droite{
    width: 200px;
    float: right;
    margin-right: 10px;
  }
  #valider{
    background-color: green;
    border: 1.5px solid black;
    box-shadow: 2px 2px 0px #555;
    color: white;
    width:150px;
    height: 40px;
    margin-left: 40px;
    margin-top: 10px;
  }
  #detail{
    width: 100%;
    height: 10%;
    vertical-align: bottom;
    /*flex-wrap: wrap;*/
  }
  h2{
    display: inline-block;
  }
  input{
    display: inline-block;
  }
  #image{
    border: 1.5px solid black;
    width: 48%;
    height: 75%;
    margin-top: 15px;
    flex-basis: auto;
    margin-left: 1%;
  }
  h1{
    text-align: center;
  }
  h3{
    padding-top: 20px;
    box-sizing: border-box;
    margin:0;
  }
  #game{
    display: flex;
    flex-direction: row wrap;
    border: 2px solid black;
    width: 75%;
    height: 600px;
    margin: auto;
    margin-top: 30px;
    text-align: center;
    background-color: white;
    box-shadow: 5px 5px 0px #c0c0c0;
    flex-wrap: wrap;
  }
</style>
