<template>
    <Page>
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
