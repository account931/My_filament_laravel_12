<!-- Read Google spreadsheet. Spreadsheet itself collects answers from Google form-->
<x-app-layout>

    {{-- Header Slot --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Read Google spreadsheet. Spreadsheet itself collects answers from Google form') }}
        </h2>
    </x-slot>

    {{-- Styles Slot (optional extra CSS/JS) --}}
    <x-slot name="styles">
        <!-- Bootstrap Select JS -->
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>-->
    </x-slot>

    {{-- Page Content --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        Read Google spreadsheet. Spreadsheet itself collects answers from Google form
                        <br>
                        <br>
                        <br>
                    </div>

                    <div class="card-body">

                        {{-- Session status --}}
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                        @endif

                        <div class="alert alert-success">

                            <p><i class="fas fa-user-circle"></i> Hello, <strong>{{ Auth::user()->name }}</strong></p>

                            <div class="row">

                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    {{-- Placeholder for additional content --}}
                                </div>

                                {{-- Flash messages --}}
                                @if (session()->has('flashSuccess'))
                                    <div class="row alert alert-success"><i class="fas fa-charging-station" style="font-size:21px"></i> &nbsp; {{ session('flashSuccess') }}</div>
                                @endif

                                @if (session()->has('flashFailure'))
                                    <div class="row alert alert-danger">{{ session('flashFailure') }}</div>
                                @endif

                            </div>

                                <div class="col-sm-12 col-xs-12">

                                    {{-- Display validation errors --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif


                                    <div class="g-spreadsheet-row">

                                        <!------------ Read Google spreadsheet. Spreadsheet itself collects answers from Google form- --------->
                                 

                                        
                                    </div>
                                    {{-- End .g-spreadsheet-row --}}

                                </div>

                           

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <style>
        /* No internet error image */
    </style>

</x-app-layout>