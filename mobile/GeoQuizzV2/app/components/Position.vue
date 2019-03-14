<template>
    <Page>
    <ActionBar title="My App">
        <NavigationButton text="Go back" android.systemIcon="ic_menu_back" @tap="changeRoute('Picture')" />
    </ActionBar>
    <StackLayout>
        <Button text="Localisation actuelle" @tap="enableLocationTap"/>
        <Button text="Choisir sur la carte" @tap="changeRoute('MapBox')"/>
        <ListView row="2" for="item in locations">
            <v-template>
                <Label :text="item.latitude + ', ' + item.longitude + ', ' + item.altitude" />
            </v-template>
        </ListView>
        <Button v-if="locations.length > 0" text="Suivant" @tap="changeRoute('Validation')"/>
    </StackLayout>
</Page>

    
</template>

<script>
    import * as geolocation from "nativescript-geolocation";
    import { Accuracy } from "tns-core-modules/ui/enums";
    export default {
        data() {
            return {
                watchIds: [],
                locations: []
            }
        },
        methods: {
            changeRoute(to){
                this.$navigateTo(this.$routes[to], { clearHistory: true});
            },
            enableLocationTap: function() {
                geolocation.enableLocationRequest().then(() => {
                    let that = this;
                    geolocation.getCurrentLocation({
                        desiredAccuracy: Accuracy.high,
                        maximumAge: 5000,
                        timeout: 10000
                    }).then(function (loc) {
                        if (loc) {
                            that.locations = [];
                            that.locations.push(loc);
                            localStorage.setItem('lat', loc.latitude);
                            localStorage.setItem('long', loc.longitude);
                        }
                    }, function (e) {
                        console.log("Error: " + (e.message || e));
                    });
                });
            },
            changeRoute(to){
                this.$navigateTo(this.$routes[to], { clearHistory: true});
            },
        },
    }
</script>

<style scoped>
    
</style>
