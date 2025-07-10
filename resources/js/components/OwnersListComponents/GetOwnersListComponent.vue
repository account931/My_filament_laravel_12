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
			
		
            <!-- GIF Loader (appears while ajax runs  -->
           <div v-if="showLoader" class="col-sm-12 col-xs-12" style="position:absolute;top:-15%;left:20%"> 
		       <img src ="/public/img/loader-black.gif" alt="loader"/> <!-- Laravel 12 fix -->
		   </div>
		   <!------------------ End GIF Loader --------->
		   		
			
	    </div>	   
    </div>
</template>

<script>
//Use Options API only vs Composition API only
import { useOwnerStore } from '@/store/index';

export default {
  data() {
    return {
      //posts: [],             // local copy if needed
      postDialogVisible: false,
      currentPost: null,     // null, not ''
	  visible: false,
    };
  },

  computed: {
    store() {
      return useOwnerStore();
    },
    posts() {
      return this.store.posts; // get posts directly from Pinia store reactively
    },
    showLoader() {
      return this.store.showLoader;
    }
  },

  mounted() {
    this.store.getAllPosts(); // fetch posts in Piania store
  },

  methods: {

    viewPost(postIndex) { 
      this.currentPost = this.posts[postIndex];
      this.postDialogVisible = true;
    },

	truncateText(text) {
        if (text.length > 24) {
            return `${text.substr(0, 24)}...`;
        }
        return text;
    },

  }
};
</script>
