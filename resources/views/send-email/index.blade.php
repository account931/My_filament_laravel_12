<x-app-layout>
    {{-- Header Slot --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Send pure email') }}
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
                        Send emails (it sends usual Facade Mail in queued job)  <i class="fa fa-envelope"></i><br>
                        See messages at Mailtrap.io in sandbox, log there as acc***1@ukr.net <i class="fa fa-home"></i>
                    </div>

                    <div class="card-body">
                        {{-- Session status --}}
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="alert alert-success">
                            <p>
                                <i class="fas fa-user-circle"></i> Hello, <strong>{{ Auth::user()->name }}</strong> 
                            </p>

                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    {{-- Placeholder for additional content --}}
                                </div>

                                {{-- Flash messages --}}
                                @if(session()->has('flashSuccess'))
                                    <div class="alert alert-info">
                                        <i class="fas fa-charging-station" style="font-size:21px"></i> &nbsp;
                                        {{ session('flashSuccess') }}
                                    </div>
                                @endif

                                @if(session()->has('flashFailure'))
                                    <div class="alert alert-danger">
                                        {{ session('flashFailure') }}
                                    </div>
                                @endif
                            </div>

                            <div class="send-notification">
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

                                    {{-- Email form --}}
                                    <form action="{{ route('send.email.send') }}" method="POST" class="my-form">
                                        @csrf

                                        <div class="form-group">
                                            <label class="form-label" for="email"><i class="fa fa-envelope"></i> Recipient"s email: <br></label>
                                            <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="message" class="form-label"><i class="fa fa-envelope"></i> Your Message:</label>
                                            <textarea name="message" id="message" rows="4" class="form-control" placeholder="Enter your message here...">{{ old('message') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit"><i class="fa fa-envelope"></i> Send </button>
                                        </div>
                                    </form>
                                    {{-- End form --}}
                                </div>
                            </div> {{-- End send-notification --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
