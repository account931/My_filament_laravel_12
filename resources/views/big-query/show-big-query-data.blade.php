{{-- @extends('layouts.app') --}}   {{-- Laravel 12 fix --}}
{{-- @section('content') --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product track') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Recent Product Views BigData 
                         <button class="btn btn-info btn-sm w-100"> <a href="{{ route('bigQuery.index') }}">
                            <i class='fas fa-sign-in-alt'></i> Go back to List
                        </a> </button>
                    </div>

                    <div class="card-body">

                        {{-- Session status --}}
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{-- Flash message: success --}}
                        @if(session()->has('flashSuccess'))
                            <div class="row alert alert-success">
                                <i class='fas fa-charging-station' style='font-size:21px'></i> &nbsp;
                                {{ session()->get('flashSuccess') }}
                            </div>
                        @endif

                        {{-- Flash message: failure --}}
                        @if(session()->has('flashFailure'))
                            <div class="row alert alert-danger">
                                {{ session()->get('flashFailure') }}
                            </div>
                        @endif

                        <div class="alert alert-success">
                            <p>
                                <i class="fas fa-user-circle"></i>
                                Hello, <strong>{{ Auth::user()->name }}</strong>
                            </p>

                            {{-- BigData display --}}
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Product name</th>
                                        <th>User ID</th>
                                        <th>Viewed At</th>
                                        <th>IP Address</th>
                                        <th>User Agent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($views as $view)
                                        <tr>
                                            <td>{{ $view['product_id'] }}</td>
                                            <td>{{ $view['product']['name'] ?? 'Unknown Product' }}</td>
                                            <td>{{ $view['user_id'] }}</td>
                                            <td>
                                                {{ $view['viewed_at'] instanceof \DateTimeInterface 
                                                    ? $view['viewed_at']->format('Y-m-d H:i:s') 
                                                    : $view['viewed_at'] }}
                                            </td>
                                            <td>{{ $view['ip_address'] }}</td>
                                            <td>{{ Str::limit($view['user_agent'], 40) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- End BigData display --}}

                            <br>
                            <a href="{{ route('bigQuery.index') }}">
                                <i class='fas fa-sign-in-alt'></i> Go back to List
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- @endsection --}}   {{-- Laravel 12 fix --}}
