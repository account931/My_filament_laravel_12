<!-- This is a Sub-component of Registration_component.vue, used in \resources\assets\js\Wp_Login_Register_Rest\components -->
<!-- Uses Vuex store: this.store.passport_api_tokenY -->

<template>

    <div class="col-sm-12 col-xs-12 alert alert-info borderX">
        <center>
		    <p> Registration Vue </p>
        </center>
        
        <!-- Display Validation errors if any come from Controller Request Php validator -->
        <div v-for="(error, i) in this.errorGet " :key="i" class="alert alert-danger"> 
            Error: {{ error }} 
        </div>
        
        <div class="form-group">
         <center>
            <div v-if="status_msg" class="alert-danger alert" role="alert">
                {{ status_msg }}
            </div>
            
            <!-- Register Form -->
            <form class="login" @submit.prevent="registerSubmit">
                <h1>Register</h1>
                <p><i class="fa fa-credit-card" style="font-size:36px"></i></p>
                
                <!-- Login: email -->
                <div class="col-md-6 form-group">
                    <label for="email" class="col-md-6 control-label">E-Mail Address</label>
                    <input required v-model="email" type="email" placeholder="Email"  class="form-control"/>
                </div>
                
                <!-- Name -->
                <div class="col-md-6 form-group">
                    <label for="name" class="col-md-6 control-label"> Name </label>
                    <input required v-model="name" type="text" placeholder="Name"  class="form-control"/>
                </div>
               
                <!-- Password -->
                <div class="col-md-6 form-group">
                    <label for="password" class="col-md-6 control-label">Password</label>
                    <input v-model="password" type="password" placeholder="Password" id="passwordd"  class="form-control" required/>
                    <i class="fa fa-eye" id="passEye1" @click="togglePasswordReg1" style="cursor:pointer;"></i>
                </div>
                
                <!-- Password Confirmation -->
                <div class="col-md-6 form-group">
                    <label for="passworddConfirm" class="col-md-6 control-label">Confirm Password</label>
                    <input required v-model="password_confirm" type="password" placeholder="Confirm Password" id="passworddConfirm"  class="form-control"/>
                    <i class="fa fa-eye" id="passEye2" @click="togglePasswordReg2" style="cursor:pointer;"></i>
                </div>
                
                <hr><br><br>
                <button type="submit" class="btn btn-info"> Register <i class="	fa fa-folder-open-o" style="font-size:12px"></i></button>
            </form>
            </center>
        </div>
    </div>

</template>

<script>
//Use Options API only vs Composition API only
import { useOwnerStore } from '@/store/index'; //Piania store, instead of Vuex
import $ from 'jquery';  //jquery
import Swal from 'sweetalert2';
export default {
    name: 'all-posts',
    data() {
        return {
            email           : "",  //form email
            password        : "",  //form password
            password_confirm: "",  //form password confirm
            name            : "",  //form name
            status_msg      : "",  //validate error message
            status          : "",
            errorList: [],         //list of validations errors of server-side validator
        };
    },
  
    computed: { 
        errorGet () { //compute Back-end validation errors
            return this.errorList;
        }      
    },
    beforeMount() {},
    methods: {
    
        /*
        |--------------------------------------------------------------------------
        |Rest Api Registration submit
        |--------------------------------------------------------------------------
        |
        |
        */
        registerSubmit (e) {
            e.preventDefault();
            if (!this.validateForm()) {
                return false;
            }
            
            let emailX    = this.email; 
            let passwordX = this.password;
            
            //Use Formdata to bind inpts 
            var thatX = this; //Fix for ajax 
            var formData = new FormData(); 
            formData.append('email',                  this.email);
            formData.append('name',                   this.name);
            formData.append('password',               this.password);
            formData.append('password_confirmation',  this.password_confirm); //must be named 'password_confirmation', i.e 'firstINPUT_confirmation' to be automatically validate in back-end via ('password' => 'required|confirmed',)
            
            $.ajax({
		        url: 'api/register', 
                type: 'POST', 
                cache : false,
                dataType    : 'json',
                processData : false,
                contentType: false,
			    //passing the data
                data: formData, 
                success: function(data) {
                    console.log(data);
                    if(data.error_message){
                        Swal.fire("Failed", data.error_message, "error");
                        thatX.status_msg = data.error_message;
                        
                        //setting the list of validations errors of server-side validator
                        var tempoArray = []; //temporary array
                        for (var key in data.validateErrors) { //Object iterate
                            var t = data.validateErrors[key][0]; //gets validation err message, e.g validateErrors.title[0]
                            tempoArray.push(t);
                        }
                        that.errorList = tempoArray; 
                        
                    } else {
                        Swal.fire("OK", "Reg is OK, login now", "success");
                        var tempoArray = []; 
                        thatX.errorList = tempoArray; //clears validation server-side errors if any. Simple that.errorList = [] won't work
                    }
                },  
			    error: function (errorData) {
                    alert("error " +  JSON.stringify(errorData, null, 4));  
                    //alert("error " +  JSON.stringify(errorData.responseJSON, null, 4));  
                    //alert(errorData.responseJSON.errors.name); 
                    //add error disaply here 
                    //thatX.status_msg = errorData.error.responseText;

                    //Laravel 12 fix 
                    //setting the list of validations errors of server-side validator
                    if (errorData.responseJSON) {
                        const tempoArray = [];

                        for (var key in errorData.responseJSON.errors) {
                            if (errorData.responseJSON.errors.hasOwnProperty(key)) {
                                const t = errorData.responseJSON.errors[key][0]; // Get first validation error message
                                //alert(errorData.responseJSON.errors[key][0]);
                                tempoArray.push(t);
                            }
                        }

                        thatX.errorList = tempoArray;                   
		        } 
            }
         });                           
            
        },
        
        
        /*
        |--------------------------------------------------------------------------
        |Client-side form validation
        |--------------------------------------------------------------------------
        |
        |
        */
        validateForm() {
            if (!this.email) {
                this.status = false;
                this.showNotification('Email title cannot be empty');
                return false;
            }
            
             if (!this.name) {
                this.status = false;
                this.showNotification('Name cannot be empty');
                return false;
            }
            
            if (!this.password) {
                this.status = false;
                this.showNotification('Password cannot be empty');
                return false;
            }
            
            if (!this.password_confirm) {
                this.status = false;
                this.showNotification('Password confirm cannot be empty');
                return false;
            }
            
            //client-side password match check
            if (this.password != this.password_confirm) {
                this.status = false;
                this.showNotification('Passwords do not match');
                return false;
            }
      
            this.showNotification(''); //clears error messages if any prev
            return true;
        },
        
        showNotification (message) {
            this.status_msg = message;
            setTimeout(() => {  //clears message in n seconds
                this.status_msg = ''
            }, 3000 * 155)
        },
        
         
        /*
        |--------------------------------------------------------------------------
        |Toggles Password Visibility //eye icon in Password input 
        |--------------------------------------------------------------------------
        |
        |
        */
        togglePasswordReg1(){
            const password = document.querySelector('#passwordd');
            const type     = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            document.getElementById("passEye1").classList.toggle('fa-eye-slash');//HTML DOM property element.classList 
        },
        
        togglePasswordReg2(){
            const password = document.querySelector('#passworddConfirm');
            const type     = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            document.getElementById("passEye2").classList.toggle('fa-eye-slash');//HTML DOM property element.classList 
        },
    },
}
</script>