<!-- Show all owners from open api /'api/owners', api request is in /store/index.js-->

<template>
    <div class="container">
	    <div class="col-sm-12 col-xs-12">
        <!--<h7> {{title}} </h7> -->
		
		  
		   <!-- Check if 'value' is falsy (null, undefined, or empty) -->
           <!--<div v-if="!checkOwnerStore[0]"> Store posts do not exist! </div>-->
           <!--<div v-else> The Store posts exists: {{ checkOwnerStore[0].first_name }} </div>-->
	       <!-- End  Check if 'value' is falsy (null, undefined, or empty) -->
		   <!--<button class='btn btn-success' @click="checkAlert"> Click Me! </button>-->
		   <hr>
		   
		   
		    <!-- If there is no blog records so far ----->
			<div v-if="posts.length == 0"> 
                <hr>			
			    <p class="text-danger">No records found so far</p>
			</div>
			<!-- End If there is no blog records so far -->
			
            <div class="row">
			    <hr>
                <!-- Displays post articles from Vuex Store /store/index.js -->
                <div v-for="(post, i) in posts" :key=i class="col-sm-4 col-xs-4"> <!-- or this.$store.state.posts -->
               	
                        <div class="card-body">
						    <i class='fas fa-cat' style='font-size:0.9em;padding-left:3%'></i>
                            <p class="card-text"><strong>{{ post.first_name }}</strong> <br>
                                {{ truncateText(post.last_name) }}
                            </p>
                        </div>
						
                        <button class="btn btn-success  z-overlay-fix-2" v-on:click="viewPost(i)">View   <i class="fa fa-crosshairs" style="font-size:14px"></i></button>
		                <button class="btn btn-info m-2 z-overlay-fix-2" @click="goTodetail(i)" > Router <i class="fa fa-tag" style="font-size:14px"></i></button>

						<hr>
					
                </div> <!-- end div v-for="(post, i)-->
	        </div>     <!-- end class="row"-->
	
	
	        <!-- Hidden modal window {Element Plus instead of ElementUI 'element-ui}(installed separately by npm) , will pop-up visible on click showing 1 full article -->
            <el-dialog v-if="currentPost"  v-model="postDialogVisible"  width="80%" class="z-overlay-3">
                <h3>{{ currentPost.first_name }} {{ currentPost.last_name }}</h3>
  
                <hr>
                <p>Owner: <b>{{ currentPost.first_name }} {{ currentPost.last_name }}</b></p>
  
                <!-- Venues hasMany -->
                <p>Owner has {{ currentPost.venues.length }} venues:</p>
                <div v-for="(venue, v) in currentPost.venues" :key="venue.id || v">
                     <p>Venue {{ v }}: {{ venue.venue_name }}, address: {{ venue.address }}</p>
    
                    <!-- Equipment hasMany -->
                    <ul>
                        <li>Venue has {{ venue.equipments.length }} equipments:</li>
                        <div v-for="(equipment, e) in venue.equipments" :key="equipment.id || e">
                            <li>Equipment {{ e }}: {{ equipment.trademark_name }} {{ equipment.model_name }}</li>
                        </div>
                    </ul>
                </div>
                <!-- End Venues hasMany -->
  
                <template #footer>
                    <el-button type="primary" @click="postDialogVisible = false">Okay</el-button>
                </template>
            </el-dialog>

            <!-- END Hidden modal window {Element Plus instead of ElementUI  'element-ui}(installed separately by npm) , will pop-up visible on click showing 1 full article -->

			
		
            <!-- GIF Loader (appears while ajax runs)  -->
           <div v-if="showLoader" class="col-sm-12 col-xs-12" style="position:absolute;top:-15%;left:-5%"> 
		       <img style="width: 25%;" src ="/public/img/loader-black.gif" alt="loader"/>
		   </div>
		   <!------------------ End GIF Loader --------->
		   		
			
	    </div>	   
    </div>
</template>

<script>
    //import { mapState } from 'vuex';
	//Use Options API only vs Composition API only
    import { useOwnerStore } from '@/store/index'; //Piania store, instead of Vuex 
    import axios from 'axios';
    export default {
	    data (){
			return{
				title:'Owners Vue component',
				postDialogVisible: false,
				//manualPosts: [], //not used 
                currentPost: '',
                ifMakeAjax: true,
    
			}
		},
		
        mounted() {
            //console.log('Component mounted.')
        },
		
		beforeMount() {
		    if(this.store.posts.length == 0){  //dont re-fetch if u come back from router, e.g /details-info
			     this.store.getAllPosts(); // fetch posts in Piania store
                //this.$store.dispatch('getAllPosts'); //trigger ajax function getAllPosts(), which is executed in Vuex store to REST Endpoint => /public/post/get_all
		    }
			//console.log('Mounted ' + this.$store.state.posts);
			//this.getAllPosts();
			//console.log('Mounted ' + this.$store.state.posts);
        },
		
		computed: {

            //get Piania store
			store() {
                 return useOwnerStore();
            },
            
			posts() {
                return this.store.posts; // get posts directly from Pinia store reactively
            },

            showLoader() {
               return this.store.showLoader;
            },
			

            sanctum_token() {
                return this.store.passport_api_tokenY; // get posts directly from Pinia store reactively
            },
		 
            //...mapState(['posts']), //is needed for Vuex store, after it u may address Vuex Store value as {posts} instead of {this.$store.state.posts}

			checkOwnerStore() { 
		      //console.log('CheckStore ' + JSON.stringify( this.$store.state.posts));
		      return this.store.posts;
		      //return [{"wpBlog_id":1,"wpBlog_title":"Article 1", "wpBlog_text":"Text 1"}, {"wpBlog_id":2,"wpBlog_title":"Article 2", "wpBlog_text":"Text 2"}]
            },
			
		},
			
			
	   /*	
	    |--------------------------------------------------------------------------
        | Methods
        |--------------------------------------------------------------------------
        */
		methods: {
		 
		    checkAlert() { alert(11); },
			
			truncateText(text) {
                if (text.length > 24) {
                    return `${text.substr(0, 24)}...`;
                }
                return text;
            },
			
		   /*	
	        |--------------------------------------------------------------------------
            | set currentPost for viewing one article (in modal pop-up)
            |--------------------------------------------------------------------------
            */
			viewPost(postIndex) {
			    //alert('view');
                const post = this.posts[postIndex];
                this.currentPost = post;
                this.postDialogVisible = true;
            },
			
			//open one owner details in newe link, uses Router
            goTodetail(prodId) {
                let proId = prodId+1;
                this.$router.push({name:'details-info',params:{Pidd:proId}}) //creates route like "/wpBlogVueFrameWork#/details/3"
            }, 
	    
		
			
        }
			
    }
</script>
