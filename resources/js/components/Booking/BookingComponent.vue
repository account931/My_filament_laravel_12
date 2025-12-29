<!-- Show Booking calendar, uses package v-calendar Vue 3) -->
<template>

  <div class="container">
    <div class="col-sm-12 col-xs-12 ">
      
      <!--- Router Menu Variant 3 --->
        <nav class="navbar navbar-expand-lg navbar-light bg-light" > <!-- fix for BS 4+--> <!-- .fix-for-non-working-click-in-mobile is a fix for non-working click in mobile -->
            <ul class="nav navbar-nav">
				
              <!--- Link: Room 1 -->
				      <li class="nav-item">
                  <router-link class="nav-link" to="/booking/1"> Room 1 </router-link> 
                  <!--- <router-link class="nav-link" to="{ name: '/booking', params: { id: 1}}"> Room 1</router-link> -->
              </li>

              <!--- Link: Room 2  -->
              <li class="nav-item">
                  <router-link class="nav-link" to="/booking/2"> Room 2</router-link> 
              </li>

              <!--- Add other rooms links if needed, make sure other rooms exist in DB booking_rooms.....  -->
				
            </ul>
        </nav>
	    <!--- End Router Menu Variant 3 --->


      <!------ Shows the rendered page (room 1, room 2, etc) based on selected menu item. Uses animation ------>
      <div class="col-sm-12 col-12 container">
            <transition name="fadeModal">
                <router-view/> <!-- built-in Vue component -->
            </transition>
      </div>
	    <!------ End Shows the rendered page (home, services, etc) based on selected menu item ------>


      <!-- <BookingCalendarSubComponent :roomId="1" /> -->  <!-- Prev variant based on props (Before router variant)  -->
      <!-- <BookingCalendarSubComponent :roomId="2" /> -->

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
        Swal.fire("Api", "Vildation failed", "error"); 
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


/* Custom style for active  link in router-link */
.navbar .nav-link.router-link-exact-active {
    color: #fff !important;          /* White text */
    background-color: #007bff;       /* Bootstrap primary blue background */
    border-radius: 4px;              /* Rounded corners */
    font-weight: bold;               /* Bold text */
}

/* Optional: hover effect for all links */
.navbar .nav-link:hover {
    background-color: #e2e6ea;
    color: #007bff;
}

</style>
