<!-- This is a Sub-component of Login_component.vue, used in \resources\assets\js\Wp_Login_Register_Rest\components -->
<!-- Uses Vuex store: this.$store.state.loggedUser + this.$store.state.passport_api_tokenY -->

<template>

    <div class="col-sm-12 col-xs-12 alert alert-info borderX">
        <center>
           <p> </br> <button class="btn btn-success" @click="logMeOut"> Log out </button> </br></br></p>
		   <p> <i class="fas fa-address-book" style="font-size:46px"></i></p>
		   <h3> Your name is  <b> {{this.store.loggedUser.name}}        </b> </h3> <!-- Piania store -->
           <p>  Your email is <b> {{this.store.loggedUser.email}}       </b></p>
		   <p>  Registered    <b> {{this.store.loggedUser.created_at}}  </b></p>
           <p style="word-wrap: break-word; font-size:0.8em;"> Token is  {{this.truncateText(this.store.passport_api_tokenY, 66) }} </p>
        </center>
    </div>

</template>

<script>
//Use Options API only vs Composition API only
import { useOwnerStore } from '@/store/index'; //Piania store, instead of Vuex

export default {
    name: 'all-posts',
    data() {
        return {
        };
    },
  
    //Vue 3 Piania changes
    computed: { 
        store() {
            return useOwnerStore();
        },
        sanctum_tokenCheck() {
            return this.store.passport_api_tokenY; // get posts directly from Pinia store reactively
        },
    },


    beforeMount() {
    },

    methods: {
        logMeOut(){
            const myStore = useOwnerStore();     //Vue 3 Piania changes
            myStore.logout(); //Vue 3 Piania changes
            //this.$store.dispatch('LogUserOut'); //trigger Vuex function LogUserOut(), which is executed in Vuex store
        },
		truncateText(text, length) {
            if (text.length > length) {
                    return `${text.substr(0, length)}...`;
            }
            return text;
        },
    },
}
</script>