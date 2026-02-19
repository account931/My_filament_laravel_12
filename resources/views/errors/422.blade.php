

<?php
//my custom error page for 422, for example when uses fake price in shop

?>
<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Something wrong. Unprocessable Request') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
				<br>
                <h1>422 </h1>
				<h1>Something wrong</h1>
				<br>
                <p class="text-danger">
                    <i class="fa fa-building"></i> 
                   {{ $exception->getMessage() ?: __('Something wrong. Unprocessable Request') }}
                   <br>
                </p>

				<small style="font-size: 0.7rem; color: #6c757d;">
					it is my custom 422  from /views/errors/422
				</small>
			</div>
		</div>
	</div>
</x-app-layout>