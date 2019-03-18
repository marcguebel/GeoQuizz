<template>
    <Page>
        <ActionBar :title="'Bienvenue ' + userLog">
             <ActionItem @tap="deco"
      ios.systemIcon="9" ios.position="left"
      android.systemIcon="ic_delete" android.position="actionBar"></ActionItem>
        </ActionBar>
        <StackLayout>
            <Button id="btnTP" text="Prendre une photo" @tap="takePicture" />
            <Button id="btnSP" text="Choisir une photo" @tap="selectPicture" />
            <FlexboxLayout id="img" flexDirection="column" justifyContent="space-around" >
                <Image v-if="link.length > 0" alignSelf="center" :src="link" height="70%"/>
            </FlexboxLayout>
            <button id="btnS" v-if="link.length > 0" text="Suivant" @tap="changeRoute('Position')"/>
            <button id="btnD" v-if="link.length < 1" text="Se déconnecter" @tap="deco"/>
        </StackLayout>
    </Page>
</template>

<script>
    import * as camera from "nativescript-camera";
    import * as imagepicker from "nativescript-imagepicker";
    import { Image } from "tns-core-modules/ui/image";
    import { ImageSource } from "tns-core-modules/image-source";
    let LS = require( "nativescript-localstorage" );

    export default {
        data() {
            return {
                image64 : [],
                link : '',
                userLog : LS.getItem('userLog')
            }
        },
        methods:{
            selectPicture() { // Prendre une photo stocker dans la mémoire du tel
                let context = imagepicker.create({
                    mode: 'multiple' 
                });
                context.authorize() // Demande d'autorisation
                .then(function() {
                    return context.present();
                })
                .then(selection => {
                    selection.forEach(selected => {
                        this.link = '';
                        let imgSource = new ImageSource();
                        imgSource.fromAsset(selected).then(imgSource => {
                            const base64image = imgSource.toBase64String("jpeg", 50);
                            this.image64.push("data:image/jpeg;base64," + base64image);
                            localStorage.setItem('img64', this.image64);
                        });
                        let img = new Image();
                        img.src = selected;
                        this.link = img.src._android
                        localStorage.setItem('img', img.src._android);
                    });
                }).catch(function (e) {
                    console.log('error avec la photo selectionnes', e);
                });
            },
            takePicture() {  // Prendre une photo avec l'appareil photo du mobile
                camera.requestPermissions() // Demande d'autorisation
                .then(() => {
                    camera.takePicture({ width: 300, height: 300, keepAspectRatio: true, saveToGallery:false })
                    .then(imageAsset => {
                        this.link = '';
                        let imgSource = new ImageSource();
                        imgSource.fromAsset(imageAsset).then(imgSource => {
                            const base64image = imgSource.toBase64String("jpeg", 50);
                            this.image64.push("data:image/jpeg;base64," + base64image);
                            localStorage.setItem('img64', this.image64);
                        });
                        let img = new Image();
                        img.src = imageAsset;
                        this.link = img.src._android
                        localStorage.setItem('img', img.src._android);
                    })
                    .catch(e => {
                        console.log('error:', e);
                    });
                })
                .catch(e => {
                    console.log('Error permission');
                });
            },
            changeRoute(to){this.$navigateTo(this.$routes[to], { clearHistory: true});},
            deco(){confirm({message: "Se déconnecter ?",okButtonText: "Confirmer",cancelButtonText: "Annuler"}).then(result => {if(result == true){this.changeRoute('Login')}});}
        },
        mounted() {        }
    }
</script>
    
<style scoped>
    #btnTP{margin-top : 10%; }
    #btnSP, #btnS, #btnD, #img{ margin-top : 50px; }
    #btnD{
        background-color: #c40000;
    }
</style>
