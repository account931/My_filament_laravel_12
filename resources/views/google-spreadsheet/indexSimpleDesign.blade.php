<!-- Read Google spreadsheet. Spreadsheet itself collects answers from Google form-->
<!-- Simple design version, if want to use it, rename it to index.blade.php -->

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
                        Read Google spreadsheet. Spreadsheet itself collects answers from Google form. Located at di***1.
                        <br> Uses Socialite login. </br> uses Google console project 'Laravel DB Backup' to login via Socialite
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

                                    <!------------ Read Google spreadsheet flow . Spreadsheet itself collects answers from Google form- --------->

                                    <!-- Show when user is logged to Google via Socialite -->
                                    @if (Auth::user()->google_refresh_token AND session('google_oauthed_user')) <!-- session('google_oauthed_user' is fix to work with Socialite login -->

                                        <div class=" alert alert-success">

                                            <div class="alert alert-success">
                                            <i class="fas fa-charging-station" style="font-size:21px"></i> &nbsp;User has google_refresh_token <br>
                                            </div>


                                            <!-- Button to read spreadsheet -->
                                             <div class="alert alert-success">
                                            <form method="POST" action="{{ route('google.spreadsheet.index') }}">
                                                @csrf
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-file-excel"></i> Load Google Spreadsheet</button>
                                            </form>
                                            </div>

                                            <!-- Log out Socialite Google form -->
                                            <div class="">
                                            <form action="{{ url('/auth/google/logout') }}" method="GET">
                                                <button type="submit" class="bg-red-500 border-2 border-black hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">Log Out of Google <i class='fa fa-arrow-right' style='font-size:26px'></i></button>
                                            </form>
                                            <br>
                                            </div>
                                            <!-- End Log out Socialite Google form -->

                                            <!-- if there are data from spreadsheet -->
                                            @if (count($values))

                                                <table class="table table-bordered">

                                                    @foreach ($values as $row)
                                                        <tr>
                                                            @foreach ($row as $cell)
                                                                <td>{{ $cell }}</td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </table>

                                            @else
                                                <div class="row  alert alert-info">
                                                    No data found.
                                                </div>
                                            @endif

                                        </div>

                                    <!-- Show when user has NOT logged to Google via Socialite -->
                                    @else

                                        <div class="row alert alert-danger">
                                            <i class="fas fa-charging-station" style="font-size:21px"></i> &nbsp;User does not have google_refresh_token. First go to Socialite, log in and come back manually
                                            <form action="{{ url('/auth/google') }}" method="GET">
                                                <button type="submit" class="bg-red-500 border border-black hover:bg-blue-700 text-black font-bold py-2 px-4 m-2 rounded">Log to Google via Socialite and come back here manually <i class='fas fa-project-diagram' style='font-size:26px'></i></button>
                                            </form>
                                        </div>

                                    @endif

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