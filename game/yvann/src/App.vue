<template>
  <div id="app">
    <router-view/>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  
  color: #2c3e50;
}
.valider{
  margin-top: 20px;
  height: 40px;
  width: 70%;
  background-color: #085394;
  color:white;
  box-shadow: 2px 2px 0px #555;
  border:1px solid black;
}
body{
  background-color: #f3f3f3;
}
.res{
  width: 60%;
  height: 80%;
  border: 1px solid black;
  display: inline-block;
  box-sizing: border-box;
  margin:0;
  padding:0;
}
.leader{
  width:30%;
  height: 80%;
  border: 1px solid black;
  display: inline-block;
  box-sizing: border-box;
  margin:0;
  padding:0;
}
  #maps{
    border: 1.5px solid black;
    width: 48%;
    height: 75%;
    margin-top:15px;
    flex-basis: auto;
    margin-left: 1%;
  }
  hr{
    margin:auto;
    width: 90%;
    height: 1px;
    background-color:black;
    margin-top: 7px;
  }
  #pseudo{
    width: 48%;
    height: 3%;
    margin-top: 5px;
    margin-bottom: 5px;
  }
  #scorePlayer{
    width: 48%;
    height: 3%;
    margin-top: 5px;
    margin-bottom: 5px;
  }
  #scorePlayerFinish{
    width: 48%;
    height: 3%;
    margin-top: 5px;
    margin-bottom: 50px;
  }
  #title{
    width: 100%;
    margin-top:26px;
    margin-bottom: 40px;
    /*text-decoration: underline overline #000000;*/
    font-weight: bold;
  }
</style>
