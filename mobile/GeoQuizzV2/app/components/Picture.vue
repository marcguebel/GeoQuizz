<template>
    <Page>
        <ActionBar title="Prendre photo"/>
        <StackLayout>
            <Button text="Prendre une phoo" @tap="takePicture" />
            <Button text="Choisir une photo" @tap="selectPicture" />
            <FlexboxLayout flexDirection="column" justifyContent="space-around" backgroundColor="#3c495e">
                <Image v-if="link.length > 0" alignSelf="center" :src="link" height="70%"/>
            </FlexboxLayout>
            <button v-if="link.length > 0" text="Suivant" @tap="changeRoute('Position')"/>
        </StackLayout>
    </Page>
</template>

<script>
import * as camera from "nativescript-camera";
import * as imagepicker from "nativescript-imagepicker";
import { Image } from "tns-core-modules/ui/image";

import { ImageSource } from "tns-core-modules/image-source";

export default {
    data() {
        return {
            image64 : [],
            link : '',
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
    }
}
</script>

<style scoped>
</style>