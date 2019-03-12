<template>
    <Page>
        <GridLayout class="weather-box" columns="1*,6*,1*" rows="auto">
             <StackLayout col="1" row="0" style="margin-top:25%;">
                <button text="MapBox" @tap="changeRoute('MapBox')"/>
                <button text="Photo" @tap="changeRoute('Picture')"/>
            </StackLayout>
            </GridLayout>
    </Page>
    
</template>

<script>
    export default {
        methods: {
            changeRoute(to){
                this.$navigateTo(this.$routes[to], { clearHistory: true});
            },
        }
    }
</script>

<style scoped>
    
</style>
