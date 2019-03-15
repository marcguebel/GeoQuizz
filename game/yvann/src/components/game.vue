<template>
    <div>
      <h1>Bonne chance {{pseudo}}</h1>
      <div id="game">
        <div id="image">
          <img id="lImage" src="../../../../ressources/image/are-you-ready.jpg">
        </div>
        <!--<div id="maps">
          
        </div>-->
        <div id="resultat">
          <h3 id="res"></h3>
        </div>
        <div id="detail">
          <h2 id="bas_gauche">Score : {{score}}</h2>
          <button id="pause" @click="pause()">pause</button> 
          <button id="valider" @click="suivant()">Lancer la partie !</button>      
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
      nbrePhoto: 0,
      lastlatlng: false,
      series: false,
      dateDeb: 0,
      dateFin: 0,
      temps: 0,
      laValidation: false,
    }
  },
  mounted(){
    if(this.$route.params.pseudo === undefined){
      this.$router.push('/');
    }
    else{
      if(this.$store.state.page != false){
        $("#pause").html("reprendre");
      }
      if(this.$store.state.token != false){
      
      }
      else{
        this.$store.commit('setPseudo',this.$route.params.pseudo);
        this.pseudo = this.$route.params.pseudo;
        this.serie = this.$route.params.idSerie;
        this.theSeries();
      }
    }   
  },
  methods:{
     getRandomInt(max) {
      return Math.floor(Math.random() * Math.floor(max));
    },
    theSeries(){
      window.axios.post('https://player-lmaillard.pagekite.me/game/new',{
          serie: this.serie,
          joueur: this.$store.state.pseudo
        }).then(response => {

          let tab = [response.data["photos"],response.data["partie"],response.data["serie"]];
          this.$store.commit('setPhotos',response.data["photos"]);
          this.$store.commit('setPartie',response.data["partie"]);
          this.$store.commit('setLaSerie',response.data["serie"]);
          this.$store.commit('setToken',response.data["partie"].id);
          this.createMap();
          this.createGame();
          //this.createImage();
        }).catch(error => {
          console.log(error);
        });
    },
    createGame(){
      let tab = [];
      while(tab.length != 10){
        let good = true;
        let nbre = this.getRandomInt(this.$store.state.photos.length);

        if(tab.length == 0){
          tab.push(this.$store.state.photos[nbre]);
        }
        else{
          for(var i = 0; i < tab.length; i++) {
            if(tab[i] == this.$store.state.photos[nbre]){
              good = false;
            }
          }
          if(good){
            tab.push(this.$store.state.photos[nbre]);
          }
        }
      }
      this.$store.commit('setGame',tab);
    },
    validation(){
      if(this.laValidation){
        this.laValidation = false;
        this.dateFin = new Date();
        this.temps = Math.round((this.dateFin.getTime() - this.dateDeb.getTime()) / 1000);

        let result = this.Distance(this.lastlatlng.lat,this.lastlatlng.lng,this.$store.state.game[this.nbrePhoto - 1].latitude,this.$store.state.game[this.nbrePhoto - 1].longitude);

        result = (Math.round(result *1000)/1000) * 1000;

        let points = 0;
        
        $("#res").html("Vous avez répondu en " + this.temps.toString() + "s et vous êtes à " + result + " mètres");
        if(this.$store.state.laSerie.distance > result){
          points += 5;
        }
        else if(this.$store.state.laSerie.distance  * 2 > result){
          points += 3;
        }
        else if(this.$store.state.laSerie.distance  * 3 > result){
          points += 1;
        }
        if(this.temps < 5){
          points = points * 4;
        }
        else if(this.temps < 10){
          points = points * 2;
        }
        else if(this.temps > 20){
          points = 0;
        }
        this.score += points;

        if(this.nbrePhoto == 10){
          $("#valider").html("Acces leaderboard");
          this.$store.commit('setScore',this.score);

          this.$store.commit('setGame',false);
          this.$store.commit('setPhotos',false);
          this.$store.commit('setPartie',false);
          this.$store.commit('setPage',false);

          window.axios.put('https://player-lmaillard.pagekite.me/game/score/' + this.$store.state.token,{
            score: this.score,
          }).then(response => {
            console.log(response.data);
          }).catch(error => {
            console.log(error);
          });

          this.$store.commit('setToken',false);
        }
      }
    },
    suivant(){
      if($("#maps").html() == undefined){
        this.createMap();
      }
      if(this.nbrePhoto == 0){
        $("#valider").html("prochaine photo");
      }
      if(this.$store.state.page == false){

        this.laValidation = true;
        this.nbrePhoto++;

        if(this.nbrePhoto < 11){
          document.getElementById("game").removeChild(document.getElementById('maps'));        
          this.createMap();
          this.createImage();
        }

        if($("#valider").html() == "Acces leaderboard"){
          this.$router.push("/leaderGame/"+ this.$store.state.laSerie.id);
        }
        this.dateDeb = new Date();
      }
    },
    pause(){
      if(this.laValidation == false && this.nbrePhoto != 0 && this.nbrePhoto < 10 && $("#pause").html() == "pause"){
        this.$store.commit('setPage',this.nbrePhoto);
        $("#pause").html("reprendre");
      }
      else if(this.$store.state.page != false){
        if($("#maps").html() == undefined){
          this.createMap();
        }
        this.nbrePhoto = this.$store.state.page;
        this.$store.commit('setPage',false);
        $("#pause").html("pause");
      }
    },
    createImage(){
      $("#lImage").attr('src',this.$store.state.game[this.nbrePhoto - 1].url);
      this.dateDeb = new Date();
    },
    createMap(){

      let newMaps = document.createElement('div');
      newMaps.id = "maps";
      let detail = document.getElementById("resultat");
      var parentDiv = document.getElementById("game");
      parentDiv.insertBefore(newMaps, detail);

      var map = L.map('maps').setView([this.$store.state.laSerie["latitude"], this.$store.state.laSerie["longitude"]], this.$store.state.laSerie["zoom"]); // LIGNE 14

        var osmLayer = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', { // LIGNE 16
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18
        });

        if(this.laValidation == false){
          var marker = L.marker([1,0]); 
        }
        else{
          var marker = L.marker([0,0]); 
        }
        var markerResultat = L.marker([0,0]);
    
        map.addLayer(osmLayer);
        let that = this;
        this.lastlatlng = map.on('click', function(e){
          if(marker.getLatLng().lat == 0 && marker.getLatLng().lng == 0){
            this.lat = e.latlng.lat;
            this.lng = e.latlng.lng;

              // Creating a marker
            marker.setLatLng(e.latlng);
            markerResultat.setLatLng([that.$store.state.game[that.nbrePhoto - 1].latitude,that.$store.state.game[that.nbrePhoto - 1].longitude])
              // Adding marker to the map
            marker.addTo(map);
            markerResultat.addTo(map);

            that.validation();

            return e.latlng;
          }
        });



        this.dateDeb = new Date();
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
  #pause{
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
