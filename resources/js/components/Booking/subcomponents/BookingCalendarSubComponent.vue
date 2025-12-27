 <!-- Re-usable component for N room, fetches booking data onload and on calendar change, modal with form to add new booking, uses props from parent component -->
<template>
  <div class="container">

    <!-- Logged user -->
    <div class="col-12 text-center mb-2">
      Logged as: {{ userLogged?.data?.user?.name || 'no user name so far' }}
    </div>

    <!-- Error -->
    <div v-if="error" class="col-12 text-center text-danger">
      Error: {{ error }}
    </div>

    <!-- Create booking button -->
    <div class="col-12 text-center mb-2">
      <button class="btn btn-success" @click="showModal">Create new booking</button>
    </div>

    <!-- V-calendar -->
    <div class="col-12 text-center">
      <VCalendar v-model="selectedDate" :attributes="attrs" @dayclick="onDayClick" :min-date="todayLimit"/>
    </div>

    <!-- Hidden Booking modal window with form -->
    <transition name="fadeModal">
      <div v-if="isModalVisible" @click.self="hideModal" class="modal" tabindex="-1" style="display:block; position:absolute;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <h4 class="modal-title">Add new booking for {{this.roomId}} </h4>

               <!-- Show booked slots for selected date in form for better UI -->
                <div class="row border border-danger m-1 mb-5 p-1" v-if="bookingFetchedData.slots.some(s => s.status === 'booked')">
                  <p class="pull-right text-danger small ml-3"> See already booked </p>

                  <div v-for="(slot, index) in bookingFetchedData.slots.filter(s => s.status === 'booked')" :key="index" class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel-body text-danger">

                      <div class="panel-body small row ">
                      
                        <div class="col-5"> 
                            <strong>{{ formatTime(slot.start) }} - {{ formatTime(slot.end) }}</strong> 
                        </div>
                         <!--  <div class="col-3"> <span class="pull-right">({{ slot.status }})</span> </div> -->
                        <div class="col-3"> 
                          <span v-if="slot.user_name"> by {{ slot.user_name }} <i class="fa fa-trash text-danger pl-2" @click="deleteItem(slot.book_id)" style="cursor:pointer;"></i></span> 
                        </div>
                        
                      </div>
                    </div>
                 </div>
                </div>        
                <!-- End Show booked slots for selected date in form for better UI -->

              <!-- Save form -->
              <form @submit.prevent="saveNewBooking">

                <div class="form-group">
                  <label>Date</label>
                  <input type="date" v-model="booking_date" :min="this.setToday" @change="onFormDateChange" class="form-control" required>
                </div>

                <div class="form-group">
                  <label>Start time</label>
                  <select v-model="start_time" class="form-control" required>
                    <option value="" disabled>Select start hour</option>
                    <option v-for="hour in 23" :key="hour" :value="formatHour(hour)">
                      {{ formatHour(hour) }}
                    </option>
                  </select>
                </div>

                <div class="form-group">
                  <label>End time</label>
                  <select v-model="end_time" class="form-control" required>
                    <option value="" disabled>Select end hour</option>
                    <option v-for="hour in 24" :key="hour" :value="formatHour(hour)">
                      {{ formatHour(hour) }}
                    </option>
                  </select>
                </div>

                <div class="form-group">
                  <label>User name</label>
                  <input type="text" v-model="user_name" class="form-control" required>
                </div>

                <div class="form-group">
                  <label>Password</label>
                  <input type="text" v-model="booking_password" class="form-control" required>
                </div>
              </form>

              <div v-if="errors" :class="{'alert': true, 'alert-success': success, 'alert-danger': !success}" class="mt-3">
                    {{ errors }}
              </div>

              <div v-if="message" :class="{'alert': true, 'alert-success': success, 'alert-danger': !success}" class="mt-3">
                    {{ message }}
              </div>


            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="hideModal">Close</button>
              <button type="button" class="btn btn-primary" @click="saveNewBooking">
                <span v-if="showLoader">Loading...</span>
                <span v-else>Submit</span>
              </button>

            </div>
          </div>
        </div>
      </div>
    </transition>
    <!-- End Booking modal window with form -->


    <!-- Room name and selected date-->
    <h2 class="room-info">  {{ this.bookingFetchedData.room_name }} , room id: {{ this.bookingFetchedData.room_id }} ,  <span class="bold"> {{ this.bookingFetchedData.date }} </span> </h2>

    <!-- Booking slots -->
    <div class="row mt-3">
      <div v-for="(slot, index) in bookingFetchedData.slots" :key="index" class="col-12 col-md-3 mb-2">
        <div class="p-2 small text-center" :class="slot.status === 'free' ? 'slot-free' : 'slot-booked'">
          <strong>{{ formatTime(slot.start) }} - {{ formatTime(slot.end) }}</strong>
          <div v-if="slot.user_name">by {{ slot.user_name }} <i class="fa fa-trash text-danger" @click="deleteItem(slot.book_id)" style="cursor: pointer;"></i> <!-- Bootstrap delete icon --></div>  
        </div>
      </div>
    </div>


      <!--  -->
      <div class="col-12 text-center">
        <hr><br>

        <!-- Debugging chart data -->
        {{ this.selectedDate }}       <!-- Date selected in V calendar-->
        Selected {{ this.bookingFetchedData }} <!-- Fetched data from Api endpoint for selected date -->
      </div>

      <!-- GIF Loader -->
      <div v-if="showLoader" class="col-sm-12 col-xs-12" style="position:absolute;top:-15%;left:25%; z-index: 9999;">
        <img src="/public/img/loader-black.gif" alt="loader"/>
      </div>

  </div>
</template>

<script>
//Vue Options API
import axios from 'axios';
import Swal from 'sweetalert2';
//import { onMounted } from 'vue';

//import BookingCalendarSubComponent from '@/components/Booking/subcomponents/BookingCalendarComponent.vue'; // import re-usable component


export default {
  name: 'BookingCalendar',
  props: {
    //used if u get id from props, like calling in parent <BookingCalendarSubComponent :roomId="1" />, but here we use router, so not needed
    /*roomId: {
      type: Number,
      required: true
    } */
  },
  data() {
    return {
 
      title: 'Booking system',
      bookingFetchedData: { slots: [] },  // data for selected data, e.g{"room_id":1,"room_name":"Room-officia","date":"2025-12-16","slots":[{"start":"2025-12-16 00:00","end":"2025-12-16 01:00","status":"free"},{"start":"2025-12-16 01:00","end":"2025-12-16 02:00","status":"free"},
      userLogged: window.authUser || null,  // Logged user data
      error: '',
      showLoader: false,
      isModalVisible: false,
      selectedDate: new Date().toISOString().split('T')[0], //seelcted day in v-calendar or form input date, set default to today
      todayLimit: new Date(), // can select today or future only
      attrs: [
        //auto highlight today
        {
          key: 'today',
          dates: new Date(),
          highlight: {
            backgroundColor: '#3b82f6', // blue
            color: 'white',
          },
        },
        //highlight booked
        {
          key: 'booked',
          dates: ['2025-12-2', '2025-12-3'], //['2025-12-2'],  //y-m-d
          dot: {color: 'red',}, //Better UX: red dot instead of full background
          //highlight: { backgroundColor: '#16d36bff' },
        },
      ],

      //form 
      roomId: null,  //since we use router now
      booking_date: new Date().toISOString().split('T')[0], //'',  //get today date on load
      start_time: '',
      end_time: '',
      user_name: window.authUser?.name || '',  //set in /views/booking/index.blade.php
      user_id: '',
      booking_password: '',
      loading: false,
      message: '',
      success: false,
      errors: {},
      setToday: new Date().toISOString().split('T')[0],  //to set in minimal date in modal form date input, so user cant select past


    };
  },
  computed: {
    today() {
      return new Date().toISOString().split('T')[0];
    },
    attrs() {
      return [
        { key: 'today', dates: new Date(), highlight: { backgroundColor: '#3b82f6', color: 'white' } }
      ];
    }
  },

  mounted() {
    this.roomId = this.$route.params.id;  //get id from router, prev used props from parents
    this.fetchBookingDataForSelectedDate(this.selectedDate);
  },

  //since use router, on router switch booking/1, booking/2 mounted method is not fired, have to watch it manually. I fuse props from parent, then not needed
   watch: {
    '$route'(to, from) {
      this.roomId = to.params.id;
      this.fetchBookingDataForSelectedDate(this.selectedDate);
    }
  },

  methods: {

    //get data from Api endpoint for selected date
    // **************************************************************************************
    // **************************************************************************************
    //                                                                                     **
    async fetchBookingDataForSelectedDate(dateSelected) {
      this.showLoader = true;
      this.error = '';
      await this.$nextTick(); // ensures DOM updates before API call
      
      //const today = new Date().toISOString().split('T')[0];
      //const roomId = 1; // Change if dynamic

      try {
        const response = await axios.get(`/api/rooms/${this.roomId}/calendar`, { //http://localhost:8000/api/rooms/1/calendar?date=2025-12-16
          params: { date: dateSelected },
          headers: { Accept: 'application/json' }   //to see validation error
        });
        this.bookingFetchedData = response.data;
      } catch (err) {
        console.error(err);
        this.error = err.response?.data?.message || 'Failed to fetch calendar';
      } finally {
        // delay hiding the loader by 2 seconds for better UI
        setTimeout(() => { this.showLoader = false;}, 500); // 2000ms = 2 seconds
      }
    },
    
    // **************************************************************************************
    // **************************************************************************************
    //                                                                                     **
    formatTime(datetime) {
      return new Date(datetime).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    },


    //watch clicks in form calendar  and update data from Api
    // **************************************************************************************
    // **************************************************************************************
    //                                                                                     **
    onDayClick(day) {
      console.log(day.date);        // Date object
      //console.log(day.id);          // YYYY-MM-DD
      //console.log(day.isToday);     // boolean
      //console.log(day.isDisabled);  // boolean

      //stop when past is selected
      const currentDate = new Date().setHours(0, 0, 0, 0);
      if (day.date < currentDate) {
         Swal.fire("False", "Past date selected", "error"); //alert('Past date selected');
         return; // stop further processing
      }

      this.booking_date = day.date.toLocaleDateString('en-CA'); //fix to return current dats // YYYY-MM-DD  //was returning prev day toISOString().split('T')[0];
      const roomId = 1; // Change if dynamic
      this.fetchBookingDataForSelectedDate(this.booking_date);  //fetch calendar for today
    },

    //show modal with new booking form
    // **************************************************************************************
    // **************************************************************************************
    //                                                                                     **
    showModal() {
      this.isModalVisible = true;
    },

    hideModal() {
      this.isModalVisible = false;
    },
    


    //save new booking
    // **************************************************************************************
    // **************************************************************************************
    //                                                                                     **
    async saveNewBooking() {

      //validation
      if (!this.validateForm()) {
        Swal.fire("Api", "Validation failed", "error"); 
            return;
      }
      
      this.showLoader = true;
      this.message = '';

      try {
        const response = await axios.post(`/api/rooms/${this.roomId}/bookings`, { 
          booking_date: this.booking_date,  
          start_time: this.start_time,
          end_time: this.end_time,
          user_name: this.user_name,
          booking_password: this.booking_password,
          
        });

        this.success = true;
        this.message = response.data.message;

        // Reset form
        this.start_time = '';
        this.end_time = '';
        this.user_name = '';

      } catch (error) {
        this.success = false;
        if (error.response && error.response.data && error.response.data.message) {
          this.message = error.response.data.message;
        } else {
          this.message = 'Something went wrong!';
        }
      } finally {
        //this.loading = false;
        setTimeout(() => { this.showLoader = false;}, 900); // 2000ms = 2 seconds
        this.fetchBookingDataForSelectedDate(this.booking_date);  //update calendar bookings

      }
    },

    //validate Add new bookingfrom
    // **************************************************************************************
    // **************************************************************************************
    //                                                                                     **
     validateForm() {
        this.errors = {};

  
        if (!this.booking_date) this.errors.booking_date = 'Booking_date is required';
        if (!this.start_time) this.errors.start_time = 'Start time is required';  
        if (!this.end_time) this.errors.end_time = 'End time is required'; 
        if (!this.user_name) this.errors.user_name = 'User_name is required'; 
        if (!this.booking_password) this.errors.booking_password = 'Booking_password is required';

        //password length check
        if (this.booking_password.length < 3) {
            this.errors.booking_password = 'Password must be at least 3 characters';
        }
  
        // Compare times
        if (this.start_time && this.end_time) {
            const start = this.start_time.split(':').map(Number);
            const end = this.end_time.split(':').map(Number);

            const startMinutes = start[0] * 60 + start[1];
            const endMinutes = end[0] * 60 + end[1];

            if (startMinutes >= endMinutes) {
                this.errors.start_time = 'Start time must be before end time';
            }
        }

        return Object.keys(this.errors).length === 0;
    },


    //Format date in form, hour must be with zero minutes, e.g 12:00, 13:00
    // **************************************************************************************
    // **************************************************************************************
    //                                                                                     **
    formatHour(hour) {
        if(hour == 24) { return String(23).padStart(2, '0') + ':59';}  //fix for 24 as Laravel validation will fail with 'The end time field must match the format H:i.'
        return String(hour).padStart(2, '0') + ':00';
    },

    // **************************************************************************************
    // **************************************************************************************
    //                                                                                     **
    deleteItem(id) {
    // Example: confirm first
    if (confirm('Are you sure you want to delete this booking ' +  id  +  ' ?')) {

      const pass = prompt('Provide password');
      if (!pass) {
        Swal.fire("False", "No password", "error"); //alert('Past date selected');
         return; // stop further processing
      }

      // Call API or remove from local array
      axios.delete(`/api/booking/${id}`)
        .then(response => {
          alert('Item deleted successfully');
          // Optional: remove from local list if you have one
          this.items = this.items.filter(item => item.id !== id);
        })
        .catch(error => {
          console.error(error);
          alert('Failed to delete item');
        });
    }
  },

  //when user changes date in form, update data from Api
  // **************************************************************************************
  // **************************************************************************************
  //                                                                                     **
  onFormDateChange(event) {
    this.selectedDate = this.booking_date;
    console.log('Selected date:', this.selectedDate);
    // Or do anything you want when the date changes
    //fetch new booking data for this date
    this.fetchBookingDataForSelectedDate(this.selectedDate);
  }
  
  }
};
</script>

<style scoped>
.slot-free { background-color: #d4edda; color: #155724; padding: 5px; border-radius: 4px; }
.slot-booked { background-color: #f8d7da; color: #721c24; padding: 5px; border-radius: 4px; }
.fadeModal-enter-active, .fadeModal-leave-active { transition: all 0.7s ease; }
.fadeModal-enter-from, .fadeModal-leave-to { opacity: 0; transform: translateY(20px); }
.fadeModal-enter-to, .fadeModal-leave-from { opacity: 1; transform: translateY(0); }
</style>
