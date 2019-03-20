<template>
	<Page>
		<ActionBar :title="'Bienvenue ' + userLog">
			<ActionItem @tap="changeRoute('Login')" ios.systemIcon="9" ios.position="left" android.systemIcon="ic_lock_power_off" android.position="actionBar"></ActionItem>
		</ActionBar>
		<FlexboxLayout flexDirection="column" >
			<label id="lbE" textWrap="true">Bonne nouvelle : Votre Image à bien était mise en ligne ! </label>
			<StackLayout orientation="horizontal" @tap="changeRoute('Picture')" id="btnA" class="btn">
				<Label width="80%">RETOUR A L'ACCUEIL</Label>
				<Image src="~/assets/images/home.png" height="80%" />
			</StackLayout>
			<StackLayout orientation="horizontal" @tap="changeRoute('Login')" id="btnD" class="btn">
				<Label width="80%">SE DECONNECTER</Label>
				<Image src="~/assets/images/logout.png" height="80%" />
			</StackLayout>
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
		},
	}
</script>
	
<style scoped>
	#btnA, #btnD{ margin-top: 100px; }
	#btnD{ background-color: #c40000; }
	#lbE{
		width: 80%;
		margin-left: 10%;
		margin-right: 10%;
	}
</style>