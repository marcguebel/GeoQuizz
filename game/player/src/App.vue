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

<style lang="css">
@import '/css/style.css';
@import '/css/bootstrap.css';
  p{
    color:darkblue;
    font-weight: bold;
  }
  #white{
    color: white;
    font-size: 20px;
  }
  .dark-blue{
    color: darkblue;
  }
</style>
