<template>
    <Page>
    <ActionBar title="My App">
        <NavigationButton text="Go back" android.systemIcon="ic_menu_back" @tap="changeRoute('Position')" />
    </ActionBar>
    <GridLayout class="weather-box" columns="1*,6*,1*" rows="auto">
             <StackLayout col="1" row="0">
        <label>{{lat}}</label><label>{{long}}</label>
        <Image :src="img" height="10%"/>
        
    </StackLayout></GridLayout>
    </Page>
    
</template>

<script>
    let LS = require( "nativescript-localstorage" );
    export default {
        data() {
            return {
                img: LS.getItem('img'),
                lat: LS.getItem('lat'),
                long: LS.getItem('long'),
            }
        },
        methods: {
            changeRoute(to){
                this.$navigateTo(this.$routes[to], { clearHistory: true});
            },
        },
        mounted() {
        }
    }
</script>

<style scoped>
    
</style>
