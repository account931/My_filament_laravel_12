<x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('dashboard')">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Dashboard') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('filament.1.pages.dashboard')">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Filament') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('test-filament')">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Test film view') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('api.owners.index')">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Api endpoint /api/owners') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('owners.list')">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Owners Controller (regular web)') }}
                        </x-dropdown-link>
                        
                        <x-dropdown-link :href="route('vue.start.page')">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Vue page') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('vue.pages-with-router')">
                            <i class="fas fa-radiation-alt" style="font-size:14px"></i>
                            {{ __('Vue with router') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('venue-locator')">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Vue Geo Locator') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('send-notification')" :class="request()->routeIs('send-notification') ? 'bg-gray-300 text-gray-900 font-semibold' : ''">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Send-notification and mail') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('stripe.main')" :class="request()->routeIs('stripe.main') ? 'bg-gray-300 text-gray-900 font-semibold' : ''">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Stripe 2 var payments') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('shop.main')" :class="request()->routeIs('shop.main') ? 'bg-gray-300 text-gray-900 font-semibold' : ''">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Shop') }}
                        </x-dropdown-link>

                        <x-dropdown-link href="/metrics">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Prometheus metrics') }}
                        </x-dropdown-link>

                        <x-dropdown-link href="/docs/api">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Scrambled docs') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('onetime.link')" :class="request()->routeIs('onetime.link') ? 'bg-gray-300 text-gray-900 font-semibold' : ''">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('One-time signed link to Scramble') }}
                        </x-dropdown-link>
                        
                        <x-dropdown-link :href="route('socialite.start')"  :class="request()->routeIs('socialite.start') ? 'bg-gray-300 text-gray-900 font-semibold' : ''">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Socialite Google login') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('sql-dump.save-to-gdive')"  :class="request()->routeIs('sql-dump.save-to-gdive') ? 'bg-gray-300 text-gray-900 font-semibold' : ''">
                            {{ __('Back-up SQL DB to GDrive') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('my.google.drive.start')"  :class="request()->routeIs('my.google.drive.start') ? 'bg-gray-300 text-gray-900 font-semibold' : ''">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('My Google Drive') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('my.google-cloud-storage.images')"  :class="request()->routeIs('my.google-cloud-storage.images') ? 'bg-gray-300 text-gray-900 font-semibold' : ''">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Google Cloud Storage Images') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('send.email.index')"  :class="request()->routeIs('send.email.index') ? 'bg-gray-300 text-gray-900 font-semibold' : ''">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Send email') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('bigQuery.index')"  :class="request()->routeIs('bigQuery.index') ? 'bg-gray-300 text-gray-900 font-semibold' : ''">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Google BigQuery') }}
                        </x-dropdown-link>

                        <!-- Booking Vue -->
                        <x-dropdown-link :href="route('booking.index')"  :class="request()->routeIs('booking.index') ? 'bg-gray-300 text-gray-900 font-semibold' : ''">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Booking Vue') }}
                        </x-dropdown-link>

                         <!-- Transalte -->
                        <x-dropdown-link :href="route('translate.index')"  :class="request()->routeIs('translate.index') ? 'bg-gray-300 text-gray-900 font-semibold' : ''">
                            <i class="fas fa-cloud-sun" style="font-size:12px"></i>
                            {{ __('Translate') }}
                        </x-dropdown-link>