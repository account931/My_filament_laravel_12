<x-app-layout>

    @push('styles')
    <style>
        /* -----------Gallary images CSS, hover and open in modal ---------*/
        .resizable-image {
        /* Set initial size or ensure it's not expanding beyond its natural size unnecessarily */
        max-width: 100%; /* Ensures the image scales down if its container is smaller */
        height: auto; /* Maintains aspect ratio */

    /* Add a smooth transition for the transform property */
    /* This makes the scaling smooth instead of instantaneous */
    transition: transform 0.3s ease-in-out; /* 0.3 seconds, ease-in-out timing function */
}

.resizable-image:hover {
    /* Scale the image up by a certain factor (e.g., 1.1 means 110%) */
    transform: scale(1.2);

    /* Optional: Add a subtle shadow for a more pronounced effect */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* ----------- Modal Lightbox style window with image ---------*/
	/* The Modal (background) */
    .modal {
    display: none;
    position: fixed;
    z-index: 999;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.8);
    }

    /* Modal Image */
    .modal-content {
    margin: auto;
    display: block;
    max-width: 70%;
    max-height: 80%;
    border-radius: 10px;
    }

    /* Close Button */
   .close {
    position: absolute;
    top: 20px;
    right: 35px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    }

/* ----------- End Modal window with image---------*/
    </style>
@endpush

@push('scripts')
<script>  
$(document).ready(function () {


//Modal Lightbox style window with image
$('.thumbnail').click(function() {
        var src = $(this).attr('src');
        $('#modalImage').attr('src', src);
        $('#imageModal').fadeIn();
    });

    $('.close, #imageModal').click(function(e) {
        if (e.target !== $('#modalImage')[0]) {
            $('#imageModal').fadeOut();
        }
    });
// End Modal Lightbox style window with image

});
</script>
@endpush



    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Images Google Cloud Storage') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Just Info box -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                Images Google Cloud Storage, do NOT require login via Socialite to get access_token or refresh_token, as it loads to a predefined bucket.
                <br>
                <span style="font-size: smaller;color:red;">As it uses Google bucket with billing, it works as long trial period is valid (till 5 January 2026) </span>
                <br>
                <i class='fas fa-unlock' style='font-size:24px'></i>

                <!-- Validation errors -->
                @if ($errors->any())
                    <div class="mb-4 p-4 border border-red-500 bg-red-100 text-red-700 rounded">
                        <strong>There are some validation problems with your input:</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- End Validation errors -->

                <!-- Flash for success -->
                @if (session('success'))
                    <div class="mb-4 p-4 border border-success  text-success rounded"><!-- Usese Bootstrap class as Tailwinf fails fo no reason -->
                        {{ session('success') }}
                    </div>
                @endif
                <!-- End Flash for success -->

                <!-- Flash for failure -->
                @if (session('failed'))
                    <div class="mb-4 p-4 border border-red-500 bg-red-100 text-red-700 rounded"><!-- Uses tailwind-->
                        {{ session('failed') }}
                    </div>
                @endif
                <!-- End Flash for failure -->
            </div>

            <!-- Upload image to Google Cloud Storage -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="alert alert-info alert-dismissible fade show" role="alert">

                    <!-- Upload Form -->
                    <div>
                        <p class="bg-red-500 border-2 border-black hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                            Upload your images to Google Cloud Storage, <br>
                            <span style="font-size: smaller;">it saves the user_id and path to local DB, but in Google Cloud it does not matter who you are (no Socialite login needed), it just saves to common bucket registered to di***1@gmail.com</span>
                        </p>
                        <br>

                        <form action="{{ route('my-google-cloud-storage.image.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Image Input -->
                            <div>
                                <label for="image">Choose File:</label>
                                <input type="file" name="image" id="image" required accept="image/*">
                                @error('image')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="bg-red-500 border-2 border-black hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                                Upload
                            </button>
                        </form>
                    </div>
                    <!-- End Upload Form -->

                </div>
            </div>
            <!-- End Upload image to Google Cloud Storage -->

            <!-- Display Google Cloud Storage images -->
            <div>
                <p class="mb-4 p-4 border border-success  text-success rounded"> Google Storage images for {{ Auth::user()->name }}, <br> <span style="font-size: 0.5em;"> uses Relations\HasMany (user()->google_storage_images)</span></p>

                @if (count($myGoogleImages) == 0)
                    <span style="color:red;">You have uploaded zero images so far</span>
                @else
                    <div class="container"><!-- Bootstrap CSS class- not Tailwind -->
                    <div class="row"> <!-- Bootstrap CSS class-->
                    @foreach($myGoogleImages as $item)
                        @php
                            //Extract the object path from the full URL, since we save in 'path' the full public URL instead of just the relative path
                            $bucketName = config('filesystems.disks.gcs.bucket') ; //'my-laravel-gcs-bucket';
                            $folder = 'images';
                            $relativePath = str_replace("https://storage.googleapis.com/{$bucketName}/{$folder}", '', $item->path); //$item->path is full path, i.e https://storage.googleapis.com/{$bucketName}/{$folder}
                            $relativePath = 'images/' . ltrim($relativePath, '/');
                            $relativePath = trim($relativePath);   //images/OYJncp.jpg" 
                        @endphp
                        
                      
                        <div class="col-4"> <!-- Bootstrap CSS class-->
                           <p><span style="font-size: 0.5em;">Relative Path:<br> "{{ $relativePath }}"</span></p> <!-- $relativePath = "images/OYJncp.jpg" -->
                           
                           <!-- Delete button from  -->
                            <form action="{{ route('my-google-cloud-storage.image.delete',  $item->id ) }}" method="POST" >
                               @csrf
                               @method('DELETE')
                               <!--<input type="hidden" name="id" value="{{ $item->id }}" />-->
                               <button type="submit" class="btn btn-danger rounded" onclick="return confirm('Are you sure you want to hard delete image (NOT SOFT DELETE) ID: {{ $item->id }} ?')"> Delete ID {{ $item->id }}</button> 
                           </form>

                            <!-- Display image itself, below we have Lightbox-style modal for the image -->
                            @if(\Illuminate\Support\Facades\Storage::disk('gcs')->exists($relativePath))
                                <img src="{{ Storage::disk('gcs')->url($relativePath) }}" class="resizable-image thumbnail" alt="Image" style="width:33%;"> <!-- "/my-laravel-gcs-bucket/images/OYJnc9m.jpg" --> 
                            @else
                                <br><span style="color:red;">No image available</span> <i class="fas fa-times-circle" style="font-size:14px; color:red;"></i>
                            @endif
                            

                        </div> <!-- End  class="col-4 -->
                        

                    @endforeach
                    </div> <!--  End  class="row" -->
                    </div> <!--  End  class="container" -->

                    <!-- Lightbox-style modal, should be out of the loop -->
                        <div id="imageModal" class="modal">
                           <span class="close">&times;</span>
                           <img class="modal-content" id="modalImage">
                        </div>
                    <!-- Lightbox-style modal -->

                @endif
            </div>
            <!-- End Display Google Cloud Storage images -->

        </div>
    </div>

    @push('scripts')
        <script>
            // Add JS here if needed
        </script>
    @endpush

</x-app-layout>
