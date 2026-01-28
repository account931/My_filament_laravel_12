<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Translate') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    Language switcher 

                     <!-- English -->
                     <a href="/translate/lang/en" class="btn btn-sm btn-outline-secondary me-2 {{ app()->getLocale() === 'en' ? 'btn-outline-danger ' : 'btn-outline-primary' }}">
                        <img src="https://flagcdn.com/w20/us.png" alt="EN" class="me-1">
                           EN
                    </a>

                    <!-- ESpainh -->
                    <a href="/translate/lang/es" class="btn btn-sm btn-outline-secondary {{ app()->getLocale() === 'es' ? 'btn-outline-danger' : 'btn-outline-primary' }}">
                       <img src="https://flagcdn.com/w20/es.png" alt="ES" class="me-1">
                         ES
                    </a>
                    
                    <!-- Arabic-->
                    <a href="{{ route('translate.changeLanguage', 'ar') }}" class="btn btn-sm  btn-outline-secondary {{ app()->getLocale() === 'ar' ? 'btn-outline-danger' : 'btn-outline-primary' }}">
                    <img src="https://flagcdn.com/w20/ar.png" alt="ES" class="me-1">
                    Ar
                    </a>



                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
 
                    <p> You selected <span class="bg-success m-2 p-1 rounded"> {{ session('locale') }} </span> language </p>
                     
                    <!--   Translatable text  -->
                    <p class="p-4 sm:p-8 bg-white shadow sm:rounded-lg"> {{ __('messages.welcome') }} </p>

                </div>
            </div>

         
        </div>
    </div>
</x-app-layout>
