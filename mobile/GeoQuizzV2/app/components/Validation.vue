<template>
    <Page>
        <ActionBar :title="'Bienvenue ' + userLog">
            <NavigationButton text="Retou" android.systemIcon="ic_menu_back" @tap="changeRoute('Position')" />
            <ActionItem @tap="deco" ios.systemIcon="9" ios.position="left" android.systemIcon="ic_delete" android.position="actionBar"></ActionItem>
        </ActionBar>
        <FlexboxLayout flexDirection="column">
            <Progress id="pB" :value="currentProgress" />
            <Label>Latitude : {{lat}}</Label>
            <Label>Longitude : {{long}}</Label>
            <Image id="preview" :src="img" style="height:70%"/>
            <button id="btnV" text="Valider" @tap="validation"/>
        </FlexboxLayout>
    </Page>
</template>

<script>
    import axios from 'axios';
    let LS = require( "nativescript-localstorage" );
    export default {
        data() {
            return {
                img : LS.getItem('img'),
                img64 : LS.getItem('img64'),
                lat : parseFloat(LS.getItem('lat')),
                long : parseFloat(LS.getItem('long')),
                userId : LS.getItem('userId'),
                userLog : LS.getItem('userLog'),
                currentProgress : 0
            }
        },
        methods: {
            validation(){
                this.currentProgress = 10
                var bodyFormData = new FormData();
                bodyFormData.append("file", this.img64)
                bodyFormData.append("upload_preset", "rw2vmwqe")
                this.currentProgress = 20
                axios.post("https://api.cloudinary.com/v1_1/dvxlz9kaz/image/upload", bodyFormData)
                .then(res => {
                    this.currentProgress = 50
                    let urlImg = res.data.secure_url
                    this.currentProgress = 70
                    axios.post("https://backend-lmaillard.pagekite.me/photos", {
                        latitude: this.lat,
                        longitude: this.long,
                        url: urlImg,
                        idUser: this.userId
                    })
                    .then(res => {
                        this.currentProgress = 100
                        console.log ('ok')
                        this.changeRoute('End')
                    })
                    .catch((e)=>{
                        this.currentProgress = 0
                        console.log('error :/')
                    })
                })
                .catch((e)=>{
                    console.log(e.response)
                })
            },
            changeRoute(to){this.$navigateTo(this.$routes[to], { clearHistory: true});},
            deco(){confirm({message: "Se déconnecter ?",okButtonText: "Confirmer",cancelButtonText: "Annuler"}).then(result => {if(result == true){this.changeRoute('Login')}});}
        },
        mounted() {
        }
    }
</script>
   
<style scoped>
    #preview, #btnV{ margin-top: 50px }
    #pb {background-color:50px;}
</style>
