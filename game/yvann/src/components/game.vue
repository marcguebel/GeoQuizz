<template>
    <div class="flex-row">
      <div class="col-md-12 p-0">
        <div class="col-md-12 p-3 text-center">
          <h1>Bonne chance {{pseudo}}</h1>
        </div>
        <div class="col-md-6 hauteur p-0">
          <img id="lImage" class="h-100 w-100" src="../../../../ressources/image/are-you-ready.jpg">
        </div>
        <div class="col-md-6 hauteur p-0" id="laMap">
          
        </div>
        <div class="col-md-12 text-center hauteur-2 pt-4" id="res">
          
        </div>
        <div class="col-md-2 pt-3">
          <p>Score : {{score}}</p>
        </div>
        <div class="col-md-offset-2 col-md-4 text-center pt-5">
          <button class="form-control background inline" id="pause" @click="pause()">pause</button> 
          <button class="form-control background inline" id="valider" @click="suivant()">Lancer la partie !</button>  
        </div>
        <div class="col-md-offset-2 col-md-2 pt-2">
          <p>Photos : {{nbrePhoto}} / {{gameNbrePhoto}}</p>
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
      gameNbrePhoto: 10,
    }
  },
  mounted(){
    if(this.$store.state.pseudo == "" || this.$store.state.pseudo === false){
      this.$router.push('/');
    }
    else{
      if(this.$store.state.pause == "F5"){
        this.$router.push("/");
      }
      else{
        if(this.$store.state.token != false){
          this.nbrePhoto = this.$store.state.page;
          this.createMap();
          console.log(this.$store.state.page);
          console.log(this.$store.state.pause);
          if(this.$store.state.pause == "pasPause"){
            this.nbrePhoto++;
          }
          if(this.$store.state.pause == "Lancer"){
            $("#valider").html("Lancer la partie !");
            $("#valider").css("width","100%");
            $("#valider").css("display","inline-block");
            $("#pause").css("width","0%");
            $("#pause").css("display","none");
          }
          else{
            $("#pause").html("reprendre");  
            $("#valider").html("prochaine photo");
            $("#valider").css("display","none");
            $("#valider").css("width","0%");
          }
        }
        else{
          $("#pause").css("display","none");
          $("#pause").css("width","0%");
          this.pseudo = this.$store.state.pseudo;
          this.serie = this.$store.state.laSerie;
          this.$store.commit('setPage',0);
          this.$store.commit('setPause',"Lancer");
          this.theSeries();
        }
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
          joueur: this.pseudo
        }).then(response => {
          this.$store.commit('setPhotos',response.data["photos"]);
          this.$store.commit('setPartie',response.data["partie"]);
          this.$store.commit('setLaSerie',response.data["serie"]);
          this.$store.commit('setToken',response.data["partie"].id);
          this.createMap();
          this.createGame();
        }).catch(error => {
          console.log(error);
        });
    },
    createGame(){
      let tab = [];
      if(this.$store.state.photos.length < 10){
        this.gameNbrePhoto = this.$store.state.photos.length;
      }
      while(tab.length != this.gameNbrePhoto){
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
        this.$store.commit('setPause',"pause");
        this.laValidation = false;
        this.dateFin = new Date();
        this.temps = Math.round((this.dateFin.getTime() - this.dateDeb.getTime()) / 1000);

        let result = this.Distance(this.lastlatlng.lat,this.lastlatlng.lng,this.$store.state.game[this.nbrePhoto - 1].latitude,this.$store.state.game[this.nbrePhoto - 1].longitude);

        result = (Math.round(result *1000)/1000) * 1000;

        let points = 0;

        let resultatWrite = document.createElement('p');
        let text = document.createTextNode("Vous avez répondu en " + this.temps.toString() + "s et vous êtes à " + result + " mètres");
        resultatWrite.appendChild(text);  
        document.getElementById("res").appendChild(resultatWrite);

        //$("#res").html("<p>Vous avez répondu en " + this.temps.toString() + "s et vous êtes à " + result + " mètres</p>");

        if(this.$store.state.laSerie.distance > result){
          points += parseInt(this.$store.state.laSerie.points['D']);
        }
        else if(this.$store.state.laSerie.distance  * 2 > result){
          points += parseInt(this.$store.state.laSerie.points["2D"]);
        }
        else if(this.$store.state.laSerie.distance  * 3 > result){
          points += parseInt(this.$store.state.laSerie.points["3D"]);
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
        this.$store.commit('setScore',this.score);
        this.$store.commit('setPage',this.nbrePhoto);

        if(this.nbrePhoto == this.gameNbrePhoto){
          this.$store.commit('setPause',"F5");
          $("#pause").css("width","45%");
          $("#valider").html("Ajouter au leaderboard");
          $("#valider").css("width","45%");
          $("#pause").html("Retour");
          this.$store.commit('setScore',this.score);

          this.$store.commit('setGame',false);
          this.$store.commit('setPhotos',false);
          this.$store.commit('setPartie',false);
          this.$store.commit('setPage',false);

          window.axios.put('https://player-lmaillard.pagekite.me/game/score/' + this.$store.state.token,{
            score: this.score,
          }).then(response => {

          }).catch(error => {
            console.log(error);
          });
          this.token = this.$store.state.token;
          this.$store.commit('setToken',false);
        }
      }
    },
    suivant(){ 
      this.$store.commit('setPause',"pasPause"); 
      if(this.nbrePhoto == 0){
        window.axios.put('https://player-lmaillard.pagekite.me/game/status/' + this.$store.state.token,{
          status: "ingame"
        }).then(response => {

        }).catch(error => {
          console.log(error);
        });
        $("#pause").css("display","inline-block");
        $("#pause").css("width","45%");
        $("#valider").html("Prochaine photo");
        $("#valider").css("width","45%");
      }

      if($("#maps").html() == undefined){
        this.createMap();
      }

      if(this.laValidation == false){
        $("#res").html("");
        this.laValidation = true;
        this.nbrePhoto++;

        if(this.nbrePhoto < this.gameNbrePhoto + 1){
          document.getElementById("laMap").removeChild(document.getElementById('maps'));        
          this.createMap();
          this.createImage();
        }

        if($("#valider").html() == "Ajouter au leaderboard"){
          this.nbrePhoto--;
          window.axios.put('https://player-lmaillard.pagekite.me/game/status/' + this.token,{
            status: "leaderboard"
          }).then(response => {
            this.$router.push("/leaderGame/"+ this.$store.state.laSerie.id);
          }).catch(error => {
            console.log(error);
          });
        }
        this.dateDeb = new Date();
      }
    },
    pause(){
      if($("#pause").html() == "Retour"){
        this.$store.commit('setLaSerie',false);
        this.$store.commit('setScore',false);
        this.$store.commit('setPause',false);
        this.$store.commit('setPause',"Lancer");
        this.$router.push('/');
      }
      if(this.laValidation == false && this.nbrePhoto != 0 && this.nbrePhoto < 10 && $("#pause").html() == "pause"){
        this.$store.commit('setPage',this.nbrePhoto);
        this.$store.commit('setPause',"pause");
        $("#pause").html("reprendre");
        $("#valider").css("display","none");
        $("#valider").css("width","0%");
        $("#pause").css("width","100%");
      }
      else if($("#pause").html() == "reprendre"){
        if($("#maps").html() == undefined){
          this.createMap();
        }
        this.$store.commit('setPause',"pasPause");
        $("#pause").css("width","45%");
        $("#valider").css("display","inline-block");
        $("#valider").css("width","45%");
        $("#pause").html("pause");
        $("#valider").html("prochaine photo");
        this.suivant();
      }
    },  
    createImage(){
      $("#lImage").attr('src',this.$store.state.game[this.nbrePhoto - 1].url);
      this.dateDeb = new Date();
    },
    createMap(){
      let newMaps = document.createElement('div');
      newMaps.id = "maps";
      newMaps.setAttribute("class","h-100 w-100");
      document.getElementById("laMap").appendChild(newMaps);

      let map = L.map('maps').setView([this.$store.state.laSerie["latitude"], this.$store.state.laSerie["longitude"]], this.$store.state.laSerie["zoom"]); // LIGNE 14

        let osmLayer = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', { // LIGNE 16
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
            //L.marker([this.lat, this.lng], {icon: myIcon}).addTo(map);

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
  .hauteur{
    height: 500px;  
  }
  .p-0{
    padding:0;
  }
  .hauteur-2{
    height: 2rem;
  }
  .form-control{
    background-color: white;
  }
  .background{
    background-color: darkblue;
    color:white;
  }
  .inline{
    display: inline-block;
  }
  .bas{
    height: 100px;
  }
</style>
