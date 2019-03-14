<template>
    <Page>
    <ActionBar title="My App">
        <NavigationButton text="Go ba" android.systemIcon="ic_menu_back" @tap="changeRoute('Position')" />
    </ActionBar>
    <FlexboxLayout flexDirection="column">

        <label>{{lat}}</label><label>{{long}}</label><label>{{img64}}</label>
        <Image id="preview" :src="img" style="height:70%"/>
        <button text="Valider" @tap="validation"/>
    </FlexboxLayout>
    </Page>
    
</template>

<script>
    import axios from 'axios';
    //var base64Img = require('base64-img');
    let LS = require( "nativescript-localstorage" );
    export default {
        data() {
            return {
                img: LS.getItem('img'),
                lat: LS.getItem('lat'),
                long: LS.getItem('long'),
                img64: '',
            }
        },
        methods: {
            changeRoute(to){
                this.$navigateTo(this.$routes[to], { clearHistory: true});
            },
            validation(){
                /*let axiosConfig = {
                  headers: {
                      'Authorization': 'Client-ID c0c7cb0b6d1041e',
                      'Authorization': 'Bearer 26981291d8de19e64af6cba81ce4bcf65476e29e',
                  }
                };
                axios.post('https://api.imgur.com/3/image', this.img64, axiosConfig)
                .then((res) => {
                  console.log("RESPONSE RECEIVED: ", res);
                })
                .catch((err) => {
                  console.log("AXIOS ERROR: ", err);
                })*/
            },
        },
        mounted() {
            //this.img64 = base64Img.base64(this.img, function(err, data) {})
        }
    }
</script>

<style scoped>
    
</style>
