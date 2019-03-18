<template>
    <Page>
        <ActionBar :title="'Bienvenue ' + userLog">
            <NavigationButton text="Retou" android.systemIcon="ic_menu_back" @tap="changeRoute('Picture')" />
            <ActionItem @tap="deco" ios.systemIcon="9" ios.position="left" android.systemIcon="ic_delete" android.position="actionBar"></ActionItem>
        </ActionBar>
        <StackLayout>
            <Button id="btnL" text="Localisation actuelle" @tap="enableLocationTap"/>
            <Button id="btnM" text="Choisir sur la carte" @tap="changeRoute('MapBox')"/>
            <FlexboxLayout flexDirection="column" v-for="item in locations">
                <Label>Latitude : {{item.latitude}}</Label>
                <Label>Longitude : {{item.longitude}}</Label>
            </FlexboxLayout>
            <Button id="btnS" v-if="locations.length > 0" text="Suivant" @tap="changeRoute('Validation')"/>
        </StackLayout>
    </Page>
</template>

<script>
    import * as geolocation from "nativescript-geolocation";
    import { Accuracy } from "tns-core-modules/ui/enums";
    let LS = require( "nativescript-localstorage" );

    export default {
        data() {
            return {
                locations: [],
                userLog : LS.getItem('userLog')
            }
        },
        methods: {
            enableLocationTap: function() {
                geolocation.enableLocationRequest().then(() => { // Demande d'autorisation
                    let that = this;
                    geolocation.getCurrentLocation({
                        desiredAccuracy: Accuracy.high,
                        maximumAge: 5000,
                        timeout: 10000
                    }).then(function (loc) {
                        if (loc) {
                            that.locations = [];
                            that.locations.push(loc);
                            localStorage.setItem('lat', loc.latitude); // Latitude enregistre dans localStorage 
                            localStorage.setItem('long', loc.longitude); // Longitude enregistre dans localStorage 
                        }
                    }, function (e) {
                        console.log("Error: " + (e.message || e));
                    });
                });
            },
            changeRoute(to){this.$navigateTo(this.$routes[to], { clearHistory: true});},
            deco(){confirm({message: "Se déconnecter ?",okButtonText: "Confirmer",cancelButtonText: "Annuler"}).then(result => {if(result == true){this.changeRoute('Login')}});}
        },
    }
</script>

<style scoped>
    #btnL{ margin-top: 25%;}
    #btnM, #btnS{ margin-top: 50px;}
</style>