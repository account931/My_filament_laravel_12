<?php
// my custom error page when there is no Internet
?>
<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('No Internet') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
				<br>
                <h1 class="text-danger border p-3 m-1">503</h1>
				<h1>No Internet Connection or cURL error</h1>
				<p>Please check your internet connection and try again.</p>

				<p class="text-danger border p-3 m-1"> Error message:
				@if(app()->environment('local') && isset($exception))
                {{ $exception->getMessage() }}
                @endif
				</p>


				<small style="font-size: 0.7rem; color: #6c757d;">
					it is my custom 503 from /views/errors/no-internet, activated in /bootstrap/app in ->withExceptions(function (Exceptions $exceptions): void {
				</small>
			</div>
		</div>
	</div>
</x-app-layout>
