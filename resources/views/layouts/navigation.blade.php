<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-700">
    <x-slot name="content">
        <x-dropdown-link :href="route('profile.edit')">
            {{ __('Profile') }}
        </x-dropdown-link>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-dropdown-link :href="route('logout')"
                onclick="event.preventDefault();
                         this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-dropdown-link>
        </form>
    </x-slot>

   <x-responsive-nav-link :href="route('profile.show')">
    {{ __('Profile') }}
</x-responsive-nav-link>


        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')"
                onclick="event.preventDefault();
                         this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-responsive-nav-link>
        </form>
    </div>
</nav>
