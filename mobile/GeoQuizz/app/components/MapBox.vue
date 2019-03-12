<template>
    <Page class="page">
        <ActionBar class="action-bar" title="Smarche Po Vue Mapbox Examp">
            <NavigationButton text="Go back" android.systemIcon="ic_menu_back" @tap="changeRoute('Position')" />
        </ActionBar>
        <GridLayout >
                <Mapbox
                    accessToken="pk.eyJ1IjoiZ3VlYmVsbWFyYyIsImEiOiJjanQ0ZnVuYnQxZWV6NDlwMXQ0bmllczVjIn0.zZjRU66_jfwxBHLmgnCdMQ"
                    mapStyle="dark"
                    latitude="48.682968"
                    longitude="6.161096"
                    hideCompass="false"
                    zoomLevel="12"
                    showUserLocation="false"
                    disableZoom="false"
                    disableRotation="true"
                    disableScroll="false"
                    disableTilt="false"
                    @mapReady="onMapReady($event)"
                    @onTap="addMarker()"
                    ref="map">
                </Mapbox>
        </GridLayout>
    </Page>
</template>

<script>
    import * as utils from "utils/utils";
    import Mapbox from 'mapbox-gl-vue';
    export default {
        data () {
            return { };
        },
        methods: {
            onMapReady(args) {
                console.log(args)
                /*var vm = this;
                setTimeout(function () {
                    vm.addMarker();
                },5000);*/
            },
            addMarker(){
                console.log('salut')
                alert('c casse?')
                


                /*this.$refs.map.nativeView.addMarkers([
                    {
                        lat: 48.682968,
                        lng: 6.161096,
                        title: 'One-line title here',
                        subtitle: 'Really really nice location',
                        selected: true, // makes the callout show immediately when the marker is added (note: only 1 marker can be selected at a time)
                        onCalloutTap: function(){console.log("'Nice location' marker callout tapped");}
                    }]
                );*/
            },
            changeRoute(to){
                this.$navigateTo(this.$routes[to], { clearHistory: true});
            },
        },
        mounted(){

        }
    };
</script>

<style scoped>
    ActionBar {
        background-color: #53ba82;
        color: #ffffff;
    }

    .message {
        vertical-align: center;
        text-align: center;
        font-size: 20;
        color: #333333;
    }
</style>
