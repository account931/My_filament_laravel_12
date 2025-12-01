<!-- Show BigQuery stats-->

<template>
    <div class="container">
        <div class="col-sm-12 col-xs-12">

            <!-- Debugging logged user -->
            Logged as : {{ this.userLogged && this.userLogged.data.user.name ? this.userLogged.data.user.name : 'no user name so far' }}
          
            <div v-if="this.error" class="error">
                Error here {{ error }}
            </div>

            <!-- Checking if user is logged. Route to BigQuery is Sanctum protected -->
            <div class="col-12 m-2 text-center">

                <!-- User is logged, show API query button -->
                <div v-if="userLogged" class="col-12 m-2 text-center">
                    <p class="col-12 m-2 text-center bg-info">Logged in as: {{ userLogged.name }} </p>

                    <!-- Log out button -->
                    <p class="text-center"> <button class="btn btn-danger" @click="logOutCSRF"> LogOut </button></p>

                    <!-- Button to make api call-->
                    <div class="col-12 m-2 text-center bg-info">
                        <button class="btn btn-info" @click="makeApiRequestToProtectedRoute">
                            MakeApiRequest to Sanctum protected route to get BigQuery stats 🔒
                        </button>
                    </div>
                </div>

                <!-- User not logged, show login form -->
                <div v-else class="col-12 m-2 text-center m-2">
                    <div class="login bg-danger m-2">Not logged. Login first to be able to make API request to Sanctum protected route.</div>
                
                <div class="login  m-2">
                    <h2>Login</h2>
                    <form @submit.prevent="loginSanctumCSRF">

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" v-model="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input  :type="showPassword ? 'text' : 'password'"  v-model="password" class="form-control">
 
                             <!-- Show/hide password -->
                            <button type="button" @click="showPassword = !showPassword">
                                 <span v-if="showPassword">👁️</span>
                                 <span v-else>🔒</span>
                            </button>
                        </div>


                     

                        <button class="btn btn-success" type="submit" :disabled="loading">
                            {{ loading ? "Logging in..." : "Login (API Token Authentication (Personal Access Tokens))" }}
                        </button>

                    </form>
                </div></div>
                <!-- End login form -->
            

            </div>
            <!-- End user check -->

            <!-- No BigQuery results -->
            <div class="col-12 m-2" v-if="bigQueryFetchedData.length == 0 && userLogged">
                <hr>
                <p class="text-center fw-bold text-danger">
                    No big query results found so far, click button to fetch
                </p>
                <br>
            </div>

            <!-- BigQuery Chart -->
            <div class="col-12 text-center">
                <hr><br>

                <div class="col-12">
                    <Bar :data="chartData" :options="chartOptions" />
                </div>

                <hr><br>

                <!-- Debugging chart data -->
                {{ this.chartData.labels }}
                {{ this.chartData.datasets[0].data }}

            </div>

            <!-- GIF Loader -->
            <div v-if="showLoader" class="col-sm-12 col-xs-12" style="position:absolute;top:-15%;left:20%">
                <img src="/public/img/loader-black.gif" alt="loader"/>
            </div>

        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import axios from 'axios';
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';

// Register chart.js modules
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

export default {
    components: {
        Bar
    },

    data() {
        return {
            title: 'Big Query stats',
            bigQueryFetchedData: [],
            userLogged: null,  //logged user data goes here
            error: '',
            email: '',
            password: '',
            showPassword: false, // <-- toggle flag

            postDialogVisible: false,
            visible: false,
            showLoader: false,

            // Chart.js data
            chartData: {
                labels: [],
                datasets: [
                    {
                        label: 'Product views',
                        backgroundColor: '#42b983',
                        data: []
                    }
                ]
            },
            chartOptions: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Products Views' }
                }
            }
        };
    },

    methods: {
        // Fetch BigQuery data
        async makeApiRequestToProtectedRoute() {  
            this.showLoader = true;
            //axios.defaults.withCredentials = true;

            try {
                // Step 1: Get CSRF cookie
                //await axios.get('/sanctum/csrf-cookie');  //we did already in async loginSanctumCSRF() 


                // Step 2: Login using CSRF    //we did already in async loginSanctumCSRF() 
                /*
                await axios.post('/loginApiCSRFSessionAuth', {
                    email: 'd**@gmail.com',
                    password: 'pas****'
                }, { withCredentials: true });
                */

                // Step 3: Call protected BigQuery API, Protected by Sanctum, API Token Authentication (Personal Access Tokens).
                 alert( 'access token '  + this.userLogged.data.access_token);
                const dataResponse = await axios.get('/api/bigquery/2topviewed', { 
                    withCredentials: true,
                    headers: {
                       'Content-Type': 'application/json',
                       'Authorization': 'Bearer ' + this.userLogged.data.access_token
                    }
                });

                if (dataResponse.data) {
                    this.bigQueryFetchedData = dataResponse.data;
                    this.prepareChartData();
                    Swal.fire("Done", "Response from Sanctum protected route is loaded (.", "success");
                }

            } catch (err) {
                if (err.response?.status === 401) {
                    Swal.fire("Unauthenticated", "Please log in again.", "error");
                } else {
                    Swal.fire("Error", JSON.stringify(err), "error");
                }
            } finally {
                this.showLoader = false;
            }
        },

        //updating states
        prepareChartData() {
            this.chartData = {
                labels: this.bigQueryFetchedData.map(p => `ProductVue ${p.product_id}`),
                datasets: [
                    {
                        label: 'Product views',
                        backgroundColor: '#42b983',
                        data: this.bigQueryFetchedData.map(p => p.total_views)
                    }
                ]
            };
        },

        //Login, API Token Authentication, NOT SPA Authentication (Session-Based / Cookie Authentication)
        async loginSanctumCSRF() {

            console.log(window.location.origin);  //check frontend port, it is  http://localhost:8000'

            //axios.defaults.withCredentials = true;
            //axios.defaults.baseURL = 'http://localhost:8000'  // comment since your backend and frontend on the same port 8000

            this.error = '';
            this.showLoader = true;

            try {
                // Get CSRF cookie
                //await axios.get('/sanctum/csrf-cookie'); //SPA Authentication (Session-Based / Cookie Authentication) attempt

                // Login
                const login = await axios.post('/api/login', {                    //API Token Authentication
                //const login = await axios.post('/loginApiCSRFSessionAuth', {  //SPA Authentication (Session-Based / Cookie Authentication)
                    email: this.email,
                    password: this.password
                });
                this.userLogged = login;  //API Token Authentication   //this.passport_api_tokenY = userLogged.access_token;
                alert('Login success: ' + JSON.stringify(login));

                // Get logged user, //SPA Authentication (Session-Based / Cookie Authentication) attempt
                //const res = await axios.get('/api/user', { withCredentials: true });
                //alert('User data: ' + JSON.stringify(res.data));
                //this.userLogged = res.data;
                

            } catch (e) {
                alert('Error: ' + JSON.stringify(e.response.data));
                
                if (e.response?.status === 422) {
                    this.error = "Invalid email or password.";
                } else if  (e.response?.status === 401) {
                    this.error = "Error 401.";
                }
                else {
                    this.error = "Login failed.";
                }
            } finally {
                this.showLoader = false;
                //alert('Error finally: ' );
            }
        },

        //log out
        logOutCSRF() {
            this.userLogged = null;
        },
    }
};
</script>
