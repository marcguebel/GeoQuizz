<template>
    <div>
      <h1>Bonne chance {{pseudo}}</h1>
      <div id="game">
        <div id="image">
          <img src="../../../../ressources/photos/place_stan.jpg">
        </div>
        <div id="maps">
          
        </div>
        <div id="detail">
          <h2 id="bas_gauche">Score : {{score}}</h2>
          <input id="valider" type="button" name="validation" value="valider" @click="validation(lastLat)" />
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
      nbrePhoto: 1,
      lastLat: 0,
      lastLng: false,
    }
  },
  mounted(){
    this.pseudo = this.$route.params.pseudo ;
    this.createMap();
  },
  methods:{
    validation(lat){
      console.log(lat);
      if(this.nbrePhoto + 1 <= 10){
        this.nbrePhoto++;
        console.log(this.Distance(this.lastLat,this.lastLng,48.6939,6.18291));
      }
    },
    createMap(){
      var map = L.map('maps').setView([48.681, 6.1789], 12); // LIGNE 14

        var osmLayer = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', { // LIGNE 16
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18
        });

        var marker = L.marker([0,0]); 
    
        map.addLayer(osmLayer);

        map.on('click', function(e){

          this.lastLat = e.latlng.lat;
          this.lastLng = e.latlng.lng;
          // Creating a marker
          
          marker.setLatLng(e.latlng);
           
          // Adding marker to the map
          marker.addTo(map);

          console.log(game.$data.lastLat);
        });
    },
    convertRad(input){
      return (Math.PI * input)/180;
    },
    Distance(lat_a_degre, lon_a_degre, lat_b_degre, lon_b_degre){
      console.log(lat_a_degre);
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
  img{
    border-radius: 15px;
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
    height: 10%;
    vertical-align: bottom;
    margin-top: 50px;
  }
  h2{
    display: inline-block;
  }
  input{
    display: inline-block;
  }
  #image{
    display: inline-block;
    border: 1.5px solid black;
    width: 48%;
    height: 75%;
    margin-top: 15px;
    border-radius: 15px;
  }
  #maps{
    display: inline-block;
    border: 1.5px solid black;
    width: 48%;
    height: 75%;
    border-radius: 15px;
  }
  h1{
    text-align: center;
  }
  #game{
    border-radius: 20px;
    border: 2px solid black;
    width: 75%;
    height: 600px;
    margin: auto;
    margin-top: 30px;
    text-align: center;
    background-color: white;
  }
</style>
