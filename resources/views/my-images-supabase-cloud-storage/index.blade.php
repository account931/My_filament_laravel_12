<x-app-layout>

    @push('styles')
    <style>
 /* -----------Gallary images CSS, hover and open in modal ---------*/
 

 .thumbnail-lightbox {
        /* Set initial size or ensure it's not expanding beyond its natural size unnecessarily */
        max-width: 70%; /* Ensures the image scales down if its container is smaller */
        height: auto; /* Maintains aspect ratio */

    /* Add a smooth transition for the transform property */
    /* This makes the scaling smooth instead of instantaneous */
    transition: transform 0.3s ease-in-out; /* 0.3 seconds, ease-in-out timing function */
}



.thumbnail-lightbox:hover {
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



/* ----------- Some color change css, e.g submit button--------*/
 .change-color {
        /* Set initial size or ensure it's not expanding beyond its natural size unnecessarily */
        max-width: 100%; /* Ensures the image scales down if its container is smaller */
        height: auto; /* Maintains aspect ratio */

    /* Add a smooth transition for the transform property */
    /* This makes the scaling smooth instead of instantaneous */
        transition: transform 0.7s ease-in-out, background-color 0.7s ease-in-out, box-shadow 1.7s ease-in-out;

}
.change-color:hover {
    /* Scale the image up by a certain factor (e.g., 1.1 means 110%) */
    transform: scale(1.1);
    background-color: blue;
    /* Optional: Add a subtle shadow for a more pronounced effect */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.delete-btn-text {font-size: 0.7rem !important;}
.descr-text {font-size: 0.8rem !important;}

/* Applies to screens smaller than 768px */ /* Small devices (phones) */
@media (max-width: 576px) {
    .delete-btn-text {font-size: 0.2rem !important;}
    .descr-text {font-size: 0.4rem !important; line-height: 0.4 !important;}
    .descr-supa-text {font-size: 0.5rem !important; }
    .my-flash-success {font-size: 0.5rem !important; }
    .my-fixed-mobile {
        position: relative;      /* stays in normal flow */
        width: 100vw !important;            /* full viewport width */
        left: 0 !important;                /* align to left edge */
        margin-left: calc(-1 * var(--tw-space-x)) !important; /* remove parent padding if needed */
        border-radius: 0;        /* optional: remove rounding on mobile */
        padding-left: 0.5rem !important;    /* optional padding for text */
        padding-right: 0.5rem !important; 
    }
     .modal-content {
        max-width: 95%;
        max-height: 90%;
        border-radius: 5px;
    }

    .close {
        top: 10px;
        right: 15px;
        font-size: 30px;
    }
}

    </style>
@endpush

@push('scripts')
<script>  
$(document).ready(function () {


//Modal Lightbox style window with image
$('.thumbnail-lightbox').click(function() {
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
            {{ __('Supabase Cloud Storage') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Just Info box -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                Supabase Cloud Storage. 
                <span style="font-size: smaller;color:red;">Supabse bucket is registered to acc***1@ukr.net </span>
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
                    <div  style="word-wrap: break-word;" class="mb-4 p-4 border border-success  text-success rounded my-flash-success"><!-- Usese Bootstrap class as Tailwinf fails fo no reason -->
                        {{ session('success') }}
                    </div>
                @endif
                <!-- End Flash for success -->

                <!-- Flash for failure -->
                @if (session('error'))
                    <div class="mb-4 p-4 border border-red-500 bg-red-100 text-red-700 rounded my-flash-success"><!-- Uses tailwind-->
                        {{ session('error') }}
                    </div>
                @endif
                <!-- End Flash for failure -->
            </div>

            <!-- Upload image to Google Cloud Storage -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="alert alert-success alert-dismissible fade show" role="alert">

                    <!-- Upload Form -->
                    <div>
                        <p class="change-color bg-red-500 border-2 border-black  text-black font-bold py-2 px-4 rounded w-screen my-fixed-mobile">
                            Upload your images to SupaBase Cloud Storage, <br>
                            <span class="descr-text">it saves the user_id and path to local DB as well, but in Supabase Cloud it does not matter who you are (no Socialite login needed), it just saves to common Supabse bucket registered to acc***1@ukr.net</span>
                        </p>
                        <br>

                        <form action="{{ route('supabase.storage.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Image Input -->
                            <div>
                                <label for="image">Choose File:</label>
                                <input type="file" name="image" id="image" required accept="image/*">
                                @error('image')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                             <!-- Public or private bucket checkbox Input -->
                            <div>
                              <label>
                              <input type="checkbox" name="is_private" value="1">
                              Save to private bucket <span class="text-red-500 small">(see private bucket name in .env)</span><i class="fa fa-lock"></i>
                              </label>
                            <div>

                            <!-- Submit Button -->
                            <button type="submit" class="change-color bg-red-500 border-2 border-black  text-black font-bold py-2 px-4 rounded">
                                Upload
                            </button>
                        </form>
                    </div>
                    <!-- End Upload Form -->

                </div>
            </div>
            <!-- End Upload image to Supabase Cloud Storage -->

            <!-- Display Supabase Cloud Storage images -->
            <div>
                <br><p class="mb-4 p-4 border border-success  text-success rounded descr-supa-text"> Supabase Storage images for {{ Auth::user()->name }},  <span style="font-size: 0.5em;"> uses Relations\HasMany (user()->google_storage_images)</span></p>

                @if (count($mySupabaseImages) == 0)
                    <span style="color:red;">You have uploaded zero images so far</span>
                @else
                    <div class="container"><!-- Bootstrap CSS class- not Tailwind -->
                    <div class="row"> <!-- Bootstrap CSS class-->
                    @foreach($mySupabaseImages as $item)
                        @php
                            //Extract the object path from the full URL, since we save in 'path' the full public URL instead of just the relative path
                            /*
                            $bucketName = config('filesystems.disks.supabase.bucket') ; //'my-laravel-gcs-bucket';
                            $folder = 'images';
                            $relativePath = str_replace("https://storage.googleapis.com/{$bucketName}/{$folder}", '', $item->path); //$item->path is full path, i.e https://storage.googleapis.com/{$bucketName}/{$folder}
                            $relativePath = 'images/' . ltrim($relativePath, '/');
                            $relativePath = trim($relativePath);   //images/OYJncp.jpg" 
                            */
                        @endphp
                        
                      
                        <div class="col-4"> <!-- Bootstrap CSS class-->
                           <p><span style="font-size: 0.5em;">Relative Path:<br> "{{ $item->path}}"</span></p> <!-- $relativePath = "images/OYJncp.jpg" -->
                           
                           <!-- Delete button from  -->
                            <form action="{{ route('supabase.storage.delete',  $item->id ) }}" method="POST" >
                               @csrf
                               @method('DELETE')
                               <!--<input type="hidden" name="id" value="{{ $item->id }}" />-->
                               <button type="submit" class="btn btn-danger rounded delete-btn-text" onclick="return confirm('Are you sure you want to hard delete image (NOT SOFT DELETE) ID: {{ $item->id }} ?')"> <i class="fa fa-trash"></i> Delete ID {{ $item->id }} from both Supabase cloud and local DB</button> 
                           </form>



                            <!-- Display images itself, below we have Lightbox-style modal for the image -->
                            <!-- Fix to avoid crash when GCS not available, lets say free tier is off-->
                            @php
                            // Select the correct disk based on "is_private_bucket" db field, config/filesystems has 2 supabase disks: public and private
                            $disk = $item->is_private_bucket
                                ? Storage::disk('supabase_private')
                                : Storage::disk('supabase_public');

                            try {
                                $exists = $disk->exists($item->path);
                            } catch (\Exception $e) {
                                $exists = false;
                            }

                            // manually generate correct URL for public bucket
                            // get bucket name from config
                            $bucket = $item->is_private_bucket
                                ? config('filesystems.disks.supabase_private.bucket')
                                : config('filesystems.disks.supabase_public.bucket');

                            // generate URL for public or private image
                            $url = $exists
                                ? ($item->is_private_bucket
                                    ? $disk->temporaryUrl($item->path, now()->addMinutes(5))  //signed route
                                    : "https://drgudgvxqszdwxxfmieb.supabase.co/storage/v1/object/{$bucket}/{$item->path}"
                                  )
                                : null;

                            @endphp


                            <!-- If bucket is public -->                           
                            <!-- <img src="https://drgudgvxqszdwxxfmieb.supabase.co/storage/v1/object/laravel_12_bucket/{{ $item->path }}"> --> 

                            @if($exists)
                                <!-- Show public/private badge --> 
                                <span class="badge {{ $item->is_private_bucket ? 'bg-danger' : 'bg-success' }}">
                                   {{ (bool)$item->is_private_bucket ? 'Private. Signed' : 'Public' }}
                                </span>

                                <!-- Image --> 
                                <img src="{{ $url }}" class="thumbnail-lightbox" alt="User Image">
                            @else
                                <p class="text-white rounded  bg-danger m-2 p-2">
                                     <span class="me-2">&#9888;</span> <!-- ⚠️ Unicode warning/exclamation icon -->
                                     Image not available, Supabase free tier is off
                                </p>
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
