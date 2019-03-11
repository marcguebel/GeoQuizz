<template>
  <div>
    <div class="fond">
      
    </div>
    <!--<img src='../../../../ressources/image/fond_accueil.png'>-->
    <div class='start'>
      <form name="lancerPartie" class='lancer' method="POST" submit='/game'>
        <b><p>Nom du joueur : </p></b>
        <input class="champTexte" type="text" name="pseudo" v-model="pseudo"/>
        <router-link :to="'game/' + pseudo"><input class='valider' type="button" name="valider" value="Lancer la partie"/></router-link>
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
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
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
    height: 25px;
    text-align: center;
    margin-bottom: 50px;
    width: 70%;
  }
  .valider{
    height: 40px;
    width: 70%;
    background-color: #085394;
    color:white;
    box-shadow: 2px 2px 0px #555;
    border:1px solid black;
  }
  p{
    margin-top: 100px;
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
</style>
