<template>
    <Page>
        <ActionBar title="Camera Tests F"/>
        <StackLayout>
            <Button text="Prendre une photo" @tap="takePicture" />
            <Button text="Choisir une photo" @tap="selectPicture" />
            <FlexboxLayout flexDirection="column" justifyContent="space-around" backgroundColor="#3c495e">
                <Image alignSelf="center" v-for="img in images" :src="img.src" height="70%"/>
            </FlexboxLayout>

            <button v-if="images.length > 0" text="Suivan" @tap="changeRoute('Position')"/>
        </StackLayout>
    </Page>
</template>

<script>
import * as camera from "nativescript-camera";
import * as imagepicker from "nativescript-imagepicker";

import { Image } from "tns-core-modules/ui/image";

export default {
    data() {
        return {
            images:[]
        }
    },
    methods:{
        selectPicture() {
            let context = imagepicker.create({
                mode: 'multiple' 
            });
            context.authorize()
            .then(function() {
                return context.present();
            })
            .then(selection => {
                selection.forEach(selected => {
                    console.log(JSON.stringify(selected));
                    let img = new Image();
                    img.src = selected;
                    this.images = [];
                    this.images.push(img);
                    localStorage.setItem('img', img.src._android);
                });
            }).catch(function (e) {
                console.log('error in selectPicture', e);
            });
        },
        takePicture() {
            camera.requestPermissions()
            .then(() => {
                camera.takePicture({ width: 300, height: 300, keepAspectRatio: true, saveToGallery:false })
                .then(imageAsset => {
                    let img = new Image();
                    img.src = imageAsset;
                    this.images = [];
                    this.images.push(img);
                    console.log('ive got '+this.images.length+' images now.');
                })
                .catch(e => {
                    console.log('error:', e);
                });
            })
            .catch(e => {
                console.log('Error requesting permission');
            });
        },
        changeRoute(to){
            this.$navigateTo(this.$routes[to], { clearHistory: true});
        },
    }
}
</script>
