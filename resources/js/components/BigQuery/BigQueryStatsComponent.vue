<!-- Show BigQuery stats-->

<template>
    <div class="container">
        <div class="col-sm-12 col-xs-12">

            <!-- Debugging logged user -->
            Logged: {{ userLogged && userLogged.name ? userLogged.name : 'no user name so far' }}
          

            <!-- Checking if user is logged. Route to BigQuery is Sanctum protected -->
            <div class="col-12 m-2 text-center">

                <!-- User is logged, show API query button -->
                <div v-if="userLogged" class="col-12 m-2 text-center">
                    <p class="col-12 m-2 text-center bg-info">Logged in as: {{ userLogged.name }} </p>
                    <p class="text-center"> <button class="btn btn-danger" @click="logOutCSRF"> LogOut </button></p>
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


                        <div v-if="error" class="error">
                            {{ error }}
                        </div>

                        <button class="btn btn-success" type="submit" :disabled="loading">
                            {{ loading ? "Logging in..." : "Login (SPA Auth (Session-Based/Cookie Authentication))" }}
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
            userLogged: null,
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
            axios.defaults.withCredentials = true;

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

                // Step 3: Call protected BigQuery API
                const dataResponse = await axios.get('/api/bigquery/2topviewed', { withCredentials: true });

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

        //Login, SPA Authentication (Session-Based / Cookie Authentication
        async loginSanctumCSRF() {
            axios.defaults.withCredentials = true;
            axios.defaults.baseURL = 'http://localhost:8000'  // your backend URL

            this.error = '';
            this.showLoader = true;

            try {
                // Get CSRF cookie
                await axios.get('/sanctum/csrf-cookie');

                // Login
                await axios.post('/loginApiCSRFSessionAuth', {
                    email: this.email,
                    password: this.password
                });

                // Get logged user
                const res = await axios.get('/api/user');
                this.userLogged = res.data;

            } catch (e) {
                if (e.response?.status === 422) {
                    this.error = "Invalid email or password.";
                } else {
                    this.error = "Login failed.";
                }
            } finally {
                this.showLoader = false;
            }
        },

        //log out
        logOutCSRF() {
            this.userLogged = null;
        },
    }
};
</script>
