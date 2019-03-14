<template>
  <div>
    <div class="fond">
      
    </div>
    <!--<img src='../../../../ressources/image/fond_accueil.png'>-->
    <div class='start'>
      <form name="lancerPartie" class='lancer' method="POST" submit='/game'>
        <b><p>Nom du joueur : </p></b>
        <input class="champTexte" type="text" name="pseudo" v-model="pseudo"/>
        <b><p id='laSerie'>sur quelle série voulez-vous jouer : </p></b>
        <select id="select" class="classic">
          
        </select>
        <router-link :to="'game/' + idSerie +'/' + pseudo "><input class='valider' type="button" name="valider" @click="test()" value="Lancer la partie"/></router-link>
        <router-link to="/leaderboard"><input class='valider' type="button" name="leaderboard" value="Accéder au leaderboard"/></router-link>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'accueil',
  data () {
    return {
      pseudo: '',
      idSerie: 0,
    }
  },
  mounted(){
    this.series();
  },
  methods:{
    series(){
      window.axios.get('https://player-lmaillard.pagekite.me/series').then(response => {
        this.$store.commit('setNameOfSeries',response.data["series"]);
        this.$store.state.name.forEach(function(element){
          var select = document.getElementById ("select");
          var newOption = new Option (element["libelle"], "value");
          select.options.add (newOption);
        });
      }).catch(error => {
        console.log(error);
      });
    },
    test(){
      this.idSerie = this.$store.state.name[document.getElementById('select').selectedIndex].id
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  select {
    width: 80%;
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

  .fond{
    background-image: url("../../../../ressources/image/fond_accueil.png");
    background-repeat: no-repeat;
    background-size: cover;
    position: fixed;
    left: 0;
    right: 0;
    z-index: 1;
    display: block;
    -webkit-filter: blur(3px);
    width: 100%;
    height: 800px;  
  }
  .champTexte{
    border:1px solid #085394;
    box-shadow: 1px 1px 0px #085394;
    height: 2.5em;
    text-align: center;
    margin-bottom: 20px;
    width: 80%;
  }
  .valider{
    height: 40px;
    width: 80%;
    background-color: #085394;
    color:white;
    box-shadow: 2px 2px 0px #555;
    border:1px solid black;
  }
  p{
    margin-bottom: 20px;
    font-size: 18px;
  }
  form{
    width: 60%;
    height: 100%; 
    margin:auto;
    text-align: center;
    padding-top: 2px;
  }
  .start{
    width: 40%;
    height: 400px;
    box-sizing: border-box;
    margin:auto; 
    margin-top: 50px;
    margin-top: 150px;
    z-index: 9999;
    position: fixed;
    left: 0;
    right: 0;
  }
  body{
    background-image:url(../../../../ressources/image/fond_accueil.png);
  }
  #laSerie{ 
    margin: auto;
    margin-bottom: 20px;
    width:70%;
  }
</style>
