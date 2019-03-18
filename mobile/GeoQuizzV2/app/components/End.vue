<template>
    <Page>
        <ActionBar :title="'Bienvenue ' + userLog">
            <ActionItem @tap="deco" ios.systemIcon="9" ios.position="left" android.systemIcon="ic_delete" android.position="actionBar"></ActionItem>
        </ActionBar>
        <FlexboxLayout flexDirection="column" >
            <label textWrap="true">Bonne nouvelle :Votre Image a bien étais mise en ligne !</label>
            <Button id="btnA" text="Retour a l'accueil" @tap="changeRoute('Picture')"/>
            <Button id="btnD" text="Se déonnecter" @tap="deco"/>
        </FlexboxLayout>
    </Page>
</template>

<script>
    let LS = require( "nativescript-localstorage" );
    export default {
        data() {
            return {
                userLog : LS.getItem('userLog'),
            }
        },
        methods:{
            changeRoute(to){this.$navigateTo(this.$routes[to], { clearHistory: true});},
            deco(){confirm({message: "Se déconnecter ?",okButtonText: "Confirmer",cancelButtonText: "Annuler"}).then(result => {if(result == true){this.changeRoute('Login')}});}
        },
        mounted() {
        }
    }
</script>
    
<style scoped>
    #btnA, #btnD{ margin-top: 100px; }
    #btnD{ background-color: #c40000; }
    label{
        width: 80%;
        margin-left: 10%;
        margin-right: 10%;
    }
</style>