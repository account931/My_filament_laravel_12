<!-- NOT USED, BookingCalendarComponent example before implementing re-usable components, i.e BookingCalendarSubComponent :roomId="1" -->
<!-- This one works for one room only, KEEP IN MIND this one got much outdated vs BookingCalendarSubComponent -->

<!-- Show Booking calendar, uses package v-calendar Vue 3) -->
<template>

  <div class="container">
    <div class="col-sm-12 col-xs-12 ">
      
      <!--  Re-usable components -->
      <!-- <BookingCalendarSubComponent :roomId="1" />  -->
      <!-- <BookingCalendarSubComponent :roomId="2" />  -->

      
      <!-- Debugging logged user -->
      <div  class="col-sm-12 col-xs-12 text-center">
         Logged as: {{ userLogged?.data?.user?.name || 'no user name so far' }}
      </div>
      
      <div v-if="error" class="error col-sm-12 col-xs-12 text-center">
        Error here: {{ error }}
      </div>

      <!-- Button: Create new booking -> opens modal window -->
      <div class="col-sm-12 col-xs-12 text-center m-2">
        <button class="btn btn-success" @click="showModal" > Create new booking </button>  
      </div>
   
      <!-- V-calendar package, :attributes="attrs" to customize calendar -->
      <div class="col-sm-12 col-xs-12 text-center">
          <VCalendar v-model="selectedDate" :attributes="attrs" @dayclick="onDayClick"   :min-date="todayLimit"/>
      </div>
      <!-- End V-calendar package -->

      
      <!-- Hidden modal window with form to add new booking -->
      <transition name="fadeModal">
      <div v-if="isModalVisible" @click.self="hideModal" class="modal" tabindex="-1" style="display:block; position:absolute;">
      <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Body -->
            <div class="modal-body">
                <h4 class="modal-title">Add new booking</h4>
                <!--<h3>Book a Slot</h3> ->

                <!-- Show booked slots for selected date in form for better UI -->
                <div class="row border border-danger m-1 mb-5" v-if="bookingFetchedData.slots.some(s => s.status === 'booked')">
                  <p class="pull-right text-danger small ml-3"> See already booked </p>
                  <div v-for="(slot, index) in bookingFetchedData.slots.filter(s => s.status === 'booked')" :key="index" class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel-body text-danger">
                      <div class="panel-body small">
                        <strong>{{ formatTime(slot.start) }} - {{ formatTime(slot.end) }}</strong>
                        <span class="pull-right">({{ slot.status }})</span>
                        <span v-if="slot.user_name"> by {{ slot.user_name }} <i class="fa fa-trash text-danger pl-2" @click="deleteItem(slot.book_id)" style="cursor:pointer;"></i></span>
                      </div>
                    </div>
                 </div>
                </div>        
                <!-- End Show booked slots for selected date in form for better UI -->



                <!-- Save form -->
                <form @submit.prevent="saveNewBooking">
                    
                    <!-- Date form input -->
                    <div class="form-group"> 
                        <label for="booking_date">Date</label>
                        <input type="date"  v-model="booking_date" @change="onFormDateChange" id="booking_date" :min="this.setToday" class="form-control" required>
                    </div>

                    <!-- Start time form input -->
                    <label for="start_time"> Start time </label>
                    <select v-model="start_time" class="form-control" required>
                      <option value="" disabled>Select start hour</option>
                      <option v-for="hour in 23" :key="hour" :value="formatHour(hour)">
                      {{ formatHour(hour) }}
                      </option>
                    </select>

                    <!-- End time form input -->
                    <label for="end_time"> End time </label>
                    <select v-model="end_time" class="form-control" required>
                      <option value="" disabled>Select end hour</option>
                      <option v-for="hour in 24" :key="hour" :value="formatHour(hour)">
                      {{ formatHour(hour) }}
                      </option>
                    </select>

                    <!-- Usere name form input, auto set in data if user is logged -->
                    <div class="form-group">
                        <label for="user_name">User name</label>
                        <input type="text" v-model="user_name" id="user_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="user_id">User ID</label>
                        <input type="number" v-model="user_id" id="user_id" class="form-control" placeholder="optional" >
                    </div>

                    <div class="form-group">
                        <label for="booking_password">Password</label>
                        <input type="text" v-model="booking_password" id="booking_password" class="form-control" required>
                    </div>

                    <!-- <button type="submit" class="btn btn-primary" :disabled="loading">
                        {{ loading ? 'Saving...' : 'Save Booking' }}
                    </button> -->
                </form>

                <div v-if="errors" :class="{'alert': true, 'alert-success': success, 'alert-danger': !success}" class="mt-3">
                    {{ errors }}
                </div>

                <div v-if="message" :class="{'alert': true, 'alert-success': success, 'alert-danger': !success}" class="mt-3">
                    {{ message }}
                </div>
                <!-- End save form -->
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button @click="hideModal" type="button" class="btn btn-default">Close</button>
                <button @click="saveNewBooking" type="button" class="btn btn-primary">
                  <span v-if="showLoader">Loading...</span>
                  <span v-else>Submit</span>
                </button>
            </div>

        </div>
    </div>
    </div>
    </transition>
    <!-- End Hidden modal window with form to add new booking -->


      
    


      <!-- Show Booking slot lists -->
      <div class="col-12 m-2" v-if="bookingFetchedData.length === 0">
        <hr>
        <p class="text-center fw-bold text-danger">
          No booking results found so far, reload page
        </p>
        <br>
      </div>

      <!-- Room name and selected date-->
      <h2 class="room-info">  {{ this.bookingFetchedData.room_name }} <!--, room id: {{ this.bookingFetchedData.room_id }} -->,  <span class="bold"> {{ this.bookingFetchedData.date }} </span> </h2>

      <!-- Show Booking free/booked slot lists -->
      <div class="row">
        <div v-for="(slot, index) in bookingFetchedData.slots" :key="index" class="col-xs-12 col-sm-6 col-md-3">
           <div class="panel-body" :class="slot.status === 'free' ? 'slot-free' : 'slot-booked'">
             <div class="panel-body small">
               <strong>{{ formatTime(slot.start) }} - {{ formatTime(slot.end) }}</strong>
               <span class="pull-right">({{ slot.status }})</span>
               <!-- User who booked, if aplicable -->
               <span v-if="slot.user_name"> 
                   by {{ slot.user_name }}   <i class="fa fa-trash text-danger" @click="deleteItem(slot.book_id)" style="cursor: pointer;"></i> <!-- Bootstrap delete icon -->

               </span>
             </div>
          </div>
       </div>
      </div>
      <!-- End Show Booking free/booked slot lists -->






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
  </div>
</template>

<script>
//Vue Options API
import BookingCalendarSubComponent from '@/components/Booking/subcomponents/BookingCalendarSubComponent.vue'; // import re-usable component
import Swal from 'sweetalert2';
import axios from 'axios';
import { onMounted } from 'vue';

export default {
  name: 'Booking',

  components: {
      BookingCalendarSubComponent, // Register the imported component
  },

  data() {
    return {
      title: 'Booking system',
      bookingFetchedData: [],  //{"room_id":1,"room_name":"Room-officia","date":"2025-12-16","slots":[{"start":"2025-12-16 00:00","end":"2025-12-16 01:00","status":"free"},{"start":"2025-12-16 01:00","end":"2025-12-16 02:00","status":"free"},
      userLogged: null,  // Logged user data
      error: '',
      showLoader: false,
      isModalVisible: false,
      selectedDate: null, //v calendar
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
      roomId: 1,
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
      setToday: new Date().toISOString().split('T')[0],  //to set in modal form date input, so user cant select past
    };
  },

  setup() {
    // If using Composition API
  },

  mounted() {
    // Call fetch on component mount
    const today = new Date().toISOString().split('T')[0];
    const roomId = 1; // Change if dynamic

    this.fetchBookingDataForSelectedDate(today, roomId);  //fetch calendar  data from APi for today
  },



  methods: {

    //get data from Api endpoint for selected date
    // **************************************************************************************
    // **************************************************************************************
    //                                                                                     **
    async fetchBookingDataForSelectedDate(dateSelected, roomId) {
      this.showLoader = true;
      this.error = '';
      await this.$nextTick(); // ensures DOM updates before API call
      
      //const today = new Date().toISOString().split('T')[0];
      //const roomId = 1; // Change if dynamic

      try {
        const response = await axios.get(`/api/rooms/${roomId}/calendar`, { //http://localhost:8000/api/rooms/1/calendar?date=2025-12-16
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


    //watch calendar clicks and update data from Api
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

      this.booking_date = day.date.toLocaleDateString('en-CA'); //to return current dats // YYYY-MM-DD  //was returning prev day toISOString().split('T')[0];
      const roomId = 1; // Change if dynamic
      this.fetchBookingDataForSelectedDate(this.booking_date, roomId);  //fetch calendar for today
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
      
      this.loading = true;
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
        setTimeout(() => { this.showLoader = false;}, 500); // 2000ms = 2 seconds
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

    //Format date in form, hour must be with zero minutes
    // **************************************************************************************
    // **************************************************************************************
    //                                                                                     **
    formatHour(hour) {
        return String(hour).padStart(2, '0') + ':00';
    },

    // **************************************************************************************
    // **************************************************************************************
    //                                                                                     **
    deleteItem(id) {
    // Example: confirm first
    if (confirm('Are you sure you want to delete this booking ' +  id  +  ' ?')) {
      // Call API or remove from local array
      axios.delete(`/api/items/${id}`)
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
    console.log('Selected date:', this.booking_date);
    // Or do anything you want when the date changes
    //fetch new booking data for this date
    this.fetchBookingDataForSelectedDate(this.booking_date, this.roomId);
  }

    

  },
};
</script>

<style>
.error {
  color: red;
  font-weight: bold;
}

/* Slot colors */
.slot-free {
  background-color: #d4edda; /* light green */
  color: #155724; border: 2px solid white;margin-bottom: 5px;
}

.slot-booked {
  background-color: #f8d7da; /* light red */
  color: #721c24; border: 2px solid white;margin-bottom: 3px;
}

.room-info {
  background-color: #f8d7da; /* light red */
  color: #721c24; border: 2px solid black;margin-bottom: 2em;margin-top: 2em;padding: 5px;
}

/* Form animation */
.fadeModal-enter-active, .fadeModal-leave-active{
  transition: all 0.7s ease;
}
.fadeModal-enter-from, .fadeModal-leave-to {
  opacity: 0;
  transform: translateY(20px);
}
.fadeModal-enter-to, .fadeModal-leave-from{
  opacity: 1; transform: translateY(0);
}

</style>
