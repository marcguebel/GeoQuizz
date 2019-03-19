<template>
    <Page>
        <ActionBar title="Connection"/>
        <FlexboxLayout flexDirection="column" >
            <label>Login : </label>
            <TextField v-model="log" />
            <label>Mot de passe : </label>
            <TextField v-model="mdp" />
            <Button id="btnC" text="Connexion" @tap="checkLog"/>
            <label id="lbe" v-if="this.error == true" text="L'authentification a échoué!" />
        </FlexboxLayout>
    </Page>
</template>

<script>
    import axios from 'axios';
    export default {
        data() {
            return {
               log : 'marc',
               mdp : 'marc',
               error : false
            }
        },
        methods:{
            checkLog(){
                axios.post("https://backend-lmaillard.pagekite.me/login", {
                    login: this.log,
                    password: this.mdp,
                })
                .then(res => {
                    localStorage.setItem('userLog', res.data.user.login)
                    localStorage.setItem('userId', res.data.user.id)
                    this.changeRoute('Picture')
                })
                .catch((e)=>{
                    console.log(e)
                    this.error = true
                })
            },
            changeRoute(to){this.$navigateTo(this.$routes[to], { clearHistory: true});},
        },
        mounted() {
        }
    }
</script>
    
<style scoped>
    #lbe{ color : red; }
    TextField{ 
        color: white; 
        margin-top: 100px;
        text-align: center;
        width : 80%;
        margin-left : 10%;
        margin-right : 10%;
    }
    #btnC{ margin-top: 100px; }
    label{
        margin-top:100px;
    }
</style>
<style>
    page{ 
        background-color : #3c495e; 
        font-size: 20px;
        font-family: Georgia;
    }
    button{
        height : 200px;
        width : 80%;
        margin-left : 10%;
        margin-right : 10%;
        color : white;
        background-color : #0084C6;
        border-radius : 300px;
    }
    label{ 
        text-align: center;
        color: white;
        margin-top: 50px;
    }
</style>