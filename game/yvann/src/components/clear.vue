<template>
    <div>

    </div>
</template>

<script>
export default {
  name: 'clear',
  data () {
    return {
      
    }
  },
  mounted(){
      this.$store.commit('setLaSerie',false);
      this.$store.commit('setPhotos',false);
      this.$store.commit('setPartie',false);
      this.$store.commit('setSeries',false);
      this.$store.commit('setGame',false);
      this.$store.commit('setScore',false);
      this.$store.commit('setPseudo',false);
      this.$store.commit('setToken',false);
      this.$store.commit('setPage',false);
      console.log(this.$store.state);
    },
  methods:{
    
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
