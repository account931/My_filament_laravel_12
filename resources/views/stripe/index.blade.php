<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stripe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                Cashier provides an expressive, fluent interface to Stripe's subscription billing services.
                Laravel Cashier is mainly designed for subscriptions and recurring billing, but you can absolutely use it for one-time payments with Stripe too.</br>
                 For Stripe you can use 2 variants:</br>
                 Stripe JS  or Stripe Checkout (redirecting to Stripe page)
            </div> 
            
            <div id="stripeJs" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                Stripe JS form 
                <form id="payment-form">
                    <div id="card-element"></div> <!-- Stripe card input -->
                    </br>
                    <button type="submit" class="mb-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Pay $10</button>
                    <div id="card-errors" role="alert"></div>
                </form>
 

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg text-xs">
                    4242 4242 4242 4242	Basic Visa test card	Successful payment   </br>
                    4000 0000 0000 0002	Card declined   </br>
                    4000 0000 0000 0127	Incorrect CVC   </br>
                    use any MM/YY, CVV, Zip    
                </div> 

            </div>  <!-- end id="stripeJs" -->  
            
            <div id="checkout" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            Stripe Checkout form, redirects to Stripe page
                <form id="checkout-form" action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="price" step="0.01" min="0" value="2000">  <!-- $20.00 -->
                    </br>
                    <button type="submit" class="mb-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Pay $20</button>
                </form>
            </div><!-- end id="checkout" -->             


        </div>
    </div>

    <div id="loader"  style="display:none;font-size:3em; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); z-index:9999;color:red;">
         Loading...
    </div>






@push('scripts')
<script src="https://js.stripe.com/v3/"></script>  <!-- Stripe card JS-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Sweet alert -->

<script>
     //Script if use Stripe JS, then Stripe will create card input itself

    //alert("{{ env('STRIPE_PUBLIC') }}");  //working
    //alert("{{ config('services.stripe.public') }}"); //working

    // Initialize Stripe with your public key, set in config/services
    //const stripe = Stripe("{{ env('STRIPE_PUBLIC') }}");
    const stripe = Stripe("{{ config('services.stripe.public') }}");

// Create an instance of Elements
const elements = stripe.elements();
const cardElement = elements.create("card");

// Mount card input to div
cardElement.mount("#card-element");

// Handle real-time validation errors
cardElement.on('change', function(event) {
  const displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle form submission
const form = document.getElementById('payment-form');

form.addEventListener('submit', async (event) => {
  event.preventDefault();

  const { paymentMethod, error } = await stripe.createPaymentMethod({
  //const {error, paymentIntent} = await stripe.confirmCardPayment(clientSecret, {
    type: 'card',
    card: cardElement,
  });

  if (error) {
    // Show error in the UI
    document.getElementById('card-errors').textContent = error.message;

  } else {
    // Send paymentMethod.id to your backend for charging
    document.getElementById('loader').style.display = 'block';

    fetch('/charge', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}', // if using Blade templates
      },
      body: JSON.stringify({
        payment_method: paymentMethod.id,
        amount: 1000 // $10.00 in cents, change as needed
      }),
    })
    .then(response => response.json())
    .then(data => {

      //if(data.success){
      if(data.status == 'succeeded'){
        Swal.fire('Success!', 'Payment successful!', 'success');
        //alert('Payment successful!');
        document.getElementById('payment-form').reset(); //reset form inputs
        cardElement.clear(); //Clear the Stripe card element input

      } else {
        //alert('Payment failed: ' + (data.error || 'Unknown error'));
        Swal.fire('Failed!', (data.error || 'Unknown error'), 'error');
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });

    //hide loader
    setTimeout(function() {
        document.getElementById('loader').style.display = 'none';
    }, 1000);
  }
});

</script>
@endpush




</x-app-layout>