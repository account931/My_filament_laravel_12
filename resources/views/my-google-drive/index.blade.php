<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('My Google drive, requires login via Socialite') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
				Your Google drive, requires login via Socialite to get access_token and refresh_token
				<br> 
				<i class='fas fa-certificate' style='font-size:24px'></i>

				<!-- Validation errors  --> 
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
				<!-- End Validation errors  --> 
        

        <!-- Flash for success  --> 
        @if (session('success'))
        <div class="mb-4 p-4 border border-green-500 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
        </div>
        @endif
        <!-- End Flash for success  --> 

			</div> 

			<!-- Socialite content part --> 
			<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
				<!-- Show user has logged to Google --> 
				@if (Auth::user()->google_user_email)
					<div class="alert alert-info alert-dismissible fade show" role="alert">
						Logged as: {{ Auth::user()->google_user_email }}  
						<br>

						{{--
						Name: {{ session('google_oauthed_user')->name ?? 'No name found' }} <br>
						@if (session('google_oauthed_user') && session('google_oauthed_user')->avatar)
							<img src="{{ session('google_oauthed_user')->avatar }}" alt="Avatar" class="w-10 h-10 border-2 border-black">
						@else
							<p>No avatar found</p>
						@endif
						--}}
						
						<!-- Log out Socialite Google form --> 
						<form action="{{ url('/auth/google/logout') }}" method="GET">
							<br>
							<button type="submit" class="bg-red-500 border-2 border-black hover:bg-blue-700 text-black font-bold py-2 px-4 rounded"> 
								Log Out of Google <i class='fa fa-arrow-right' style='font-size:26px'></i>
							</button>
						</form>
						<br>
						<!-- End Log out Socialite Google form --> 

						<p>Your folders list</p>
						@foreach ($folders as $folder)
							Folder Name: <strong>{{ $folder->getName() }}</strong> | ID: <code>{{ $folder->getId() }}</code> 
						@endforeach
						<br>

						<!-- Form to upload file to G Drive --> 
						<div>
              <br><br>
              <p class="bg-red-500 border-2 border-black hover:bg-blue-700 text-black font-bold py-2 px-4 rounded"> Upload your new files to Google Drive </p>
              <br>
							<form action="{{ route('my.google.drive.process.upload') }}" method="POST" enctype="multipart/form-data">
								@csrf

								<!-- File Input -->
								<div>
									<label for="file">Choose File:</label>
									<input type="file" name="file" id="file" required accept="image/*">
									<!-- Show validation error -->
									@error('file')
										<div class="text-red-500 text-sm mt-1">{{ $message }}</div>
									@enderror
								</div>

								<!-- Dynamic Select -->
								<div>
									<label for="folder">Choose Folder:</label>
									<select name="folder" id="folder" required>
										<option value="">-- Select Folder --</option>
										@foreach ($folders as $folder)
											<option value="{{ $folder->getId() }}">{{ $folder->getName() }}</option>
										@endforeach
									</select>
									<!-- Show validation error for 'folder' -->
									@error('folder')
										<div class="text-red-500 text-sm mt-1">{{ $message }}</div>
									@enderror
								</div>

								<button type="submit" class="bg-red-500 border-2 border-black hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">Upload</button>
							</form>
						</div>
						<!-- End form to upload file to G Drive --> 
					</div>
				@else
					<!-- Show user has not logged to Google --> 
					<form action="{{ url('/auth/google') }}" method="GET">
						<button type="submit" class="bg-red-500 border border-black hover:bg-blue-700 text-black font-bold py-2 px-4 rounded"> 
							Log to Google via Socialite and come back here manually <i class='fas fa-project-diagram' style='font-size:26px'></i>
						</button>
					</form>
				@endif
			</div> <!-- end -->
			<!-- End Socialite -->    
		</div>
	</div>

	@push('scripts')
	<script>
	</script>
	@endpush

</x-app-layout>
