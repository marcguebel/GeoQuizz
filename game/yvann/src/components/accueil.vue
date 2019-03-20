<template>
  <div>
    <div class="fond">
      
    </div>
    <div class="flex-row">
      <div class="col-md-12">
        <div class="col-md-12 p-5">
          <h1 class="text-center">GeoQuizz</h1>
        </div>
        <div class="col-md-offset-4 col-md-4 text-center">
          <p>Nom du joueur : </p>
        </div>
        <div class="col-md-offset-4 col-md-4 text-center">
          <input class="form-control text-center" type="text" name="pseudo" v-model="pseudo"/>
        </div>
        <div class="col-md-offset-4 col-md-4 text-center p-3">
          <p>sur quelle série voulez-vous jouer : </p>
        </div>
        <div class="col-md-offset-4 col-md-4 text-center">
          <select id="select" class="form-control aligner">
          
          </select>
        </div>
        <div class="col-md-offset-4 col-md-4 text-center mt-4">
          <router-link to="/game"><input class='w-100 form-control background' type="button" name="valider" @click="test()" value="Lancer la partie"/></router-link>
        </div>
        <div class="col-md-offset-4 col-md-4 text-center mt-4">
          <router-link to="/leaderboard"><input class='w-100 form-control background' type="button" name="leaderboard" value="Accéder au leaderboard"/></router-link>
        </div>
      </div>
      
    </div>
  </div>
</template>

<script>
export default {
  name: 'accueil',
  data () {
    return {
      pseudo: '',
      idSerie: 1,
    }
  },
  mounted(){
    if(this.$store.state.token != false){
      this.$router.push('/game');
    }
    else{
      this.series();
      this.$store.commit('setPause',false);
      this.$store.commit('setPseudo',false);
      this.$store.commit('setPhotos',false);
      this.$store.commit('setPartie',false);
      this.$store.commit('setLaSerie',false);
      this.$store.commit('setGame',false);
      this.$store.commit('setScore',false);
    }
  },
  methods:{
    series(){
      window.axios.get('https://player-lmaillard.pagekite.me/series').then(response => {
        this.$store.commit('setSeries',response.data["series"]);
        this.$store.state.series.forEach(function(element){
          var select = document.getElementById ("select");
          var newOption = new Option (element["libelle"], "value");
          select.options.add (newOption);
        });
      }).catch(error => {
        console.log(error);
      });
    },
    test(){
      this.$store.commit('setLaSerie',this.$store.state.series[document.getElementById('select').selectedIndex].id);
      this.$store.commit('setPseudo',this.pseudo);
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    h1{
      font-size: 7rem;
      font-weight: bold;
    }
    .fond{
    background-image: url("../../../../ressources/image/fond_accueil.png");
    background-repeat: no-repeat;
    background-size: cover;
    position: fixed;
    left: 0;
    right: 0;
    z-index: 0;
    display: block;
    -webkit-filter: blur(3px);
    width: 100%;
    height: 800px;  
  }
  .flex-row{
    z-index: 2;
  }
  p{
    color:darkblue;
    font-weight: bold;
  }
  .form-control{
    background-color: white;
  }
  a{
    width: 100%;
  }
  .background{
    background-color: darkblue;
    color:white;
  }
  .aligner{
    text-align: center;
    text-align-last: center;
  }
  option{
    text-align-last: center;
    text-align: center;
  }
</style>
