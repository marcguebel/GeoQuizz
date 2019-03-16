<template>
    <Page>
        <ActionBar title="Validation">
            <NavigationButton text="Retou" android.systemIcon="ic_menu_back" @tap="changeRoute('Position')" />
        </ActionBar>
        <FlexboxLayout flexDirection="column">
            <label>{{lat}}</label><label>{{long}}</label>
            <Image id="preview" :src="img" style="height:70%"/>
            <button text="Valider" @tap="validation"/>
        </FlexboxLayout>
    </Page>
</template>

<script>
    import axios from 'axios';
    // const fileUrl = require('file-url');

    let LS = require( "nativescript-localstorage" );
    export default {
        data() {
            return {
                img: LS.getItem('img'),
                img64: LS.getItem('img64'),
                lat: LS.getItem('lat'),
                long: LS.getItem('long'),
                cloudinary: {
                   uploadPreset: 'rw2vmwqe',
                   apiKey: '568647459451891',
                   cloudName: 'dvxlz9kaz'
                 },
            }
        },
        methods: {
            changeRoute(to){
                this.$navigateTo(this.$routes[to], { clearHistory: true});
            },
            validation(){
                var bodyFormData = new FormData();
                bodyFormData.append("file", this.img64)
                bodyFormData.append("upload_preset", "rw2vmwqe")

                axios.post("https://api.cloudinary.com/v1_1/dvxlz9kaz/image/upload", bodyFormData)
                .then(res => {
                      console.log(res.data.secure_url)
                })
                .catch((e)=>{
                    console.log(e.response)
                })
            },

        },
        mounted() {
            console.log(this.img64)




            

              
            /*var url = 'https://i.dailymail.co.uk/i/pix/2015/09/01/18/2BE1E88B00000578-3218613-image-m-5_1441127035222.jpg';
            base64Img.requestBase64(url, function(err, res, body) {
              
            });*/
        }
    }
</script>

<style scoped>
    
</style>
