<style>
#navigation-menu{
height: calc(100vh - 4rem);
}
.navigation-link:hover .navigation-submenu{
display: block !important;
}
</style>
<header class="bg-trueGray-700 sticky z-50 top-0" x-data="dropdown()">
    <div class="container-menu flex items-center h-16 justify-between md:justify-start">
        <a :class="{'bg-opacity-100 text-orange-500': open}" x-on:click="show()" class="flex flex-col items-center justify-center order-last md:order-first px-6 sm:px-4 bg-white bg-opacity-25 text-white cursor-pointer font-semibold h-full">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path  class="inline-flex"  stroke-linecap="round"  stroke-linejoin="round"  stroke-width="2"  d="M4  6h16M4 12h16M4 18h16" />
            </svg>
            <span class="text-sm hidden sm:block">
                Categorías
            </span>
        </a>
        <a href="/" class="mx-6">
        <x-jet-application-mark class="block h-9 w-auto"></x-jet-application-mark>
        </a>
        <div class="flex-1 hidden md:block">
            @livewire('search')
        </div>
        <div class="mx-6 relative hidden md:block">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                    @else
                        <x-jet-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <i class="fas fa-user-circle text-white text-3xl cursor-pointer"></i>
                            </x-slot>
                            <x-slot name="content">
                                <x-jet-dropdown-link href="{{ route('login') }}">{{ __('Login') }}</x-jet-dropdown-link>
                                <x-jet-dropdown-link href="{{ route('register') }}">{{ __('Register') }}</x-jet-dropdown-link>
                            </x-slot>
                        </x-jet-dropdown>
                    @endauth
                </div>
            @endif
        </div>
        <div class="hidden md:block">
            @livewire('dropdown-cart')
        </div>
    </div>
    <nav id="navigation-menu" x-show="open" :class="{'block': open, 'hidden': !open}" class="bg-trueGray-700 bg-opacity-25 w-full absolute hidden">
        <div class="container-menu h-full hidden sm:block">
            <div x-on:click.away="close()" class="grid grid-cols-4 h-full relative">
                <ul class="bg-white">
                    @foreach($categories as $category)
                    <li class="navigation-link text-trueGray-500 hover:bg-orange-500 hover:text-white">
                        <a href="" class="py-2 px-4 text-sm flex items-center">
                        <span class="flex justify-center w-9">
                        {!! $category->icon !!}
                        </span>
                        {{ $category->name }}
                        </a>
                        <div class="navigation-submenu bg-gray-100 absolute w-3/4 h-full top-0 right-0 hidden">
                            <x-navigation-subcategories :category="$category" />
                            <div class="grid grid-cols-4 py-4 px-4">
                                <div>
                                <p class="text-lg font-bold text-center text-trueGray-500 mb-3">Subcategorías</p>
                                <ul>
                                @foreach($category->subcategories as $subcategory)
                                <li>
                                <a href="" class="text-trueGray-500 inline-block font-semibold py-1 px-4 hover:text-orange-500">
                                {{ $subcategory->name }}
                                </a>
                                </li>
                                @endforeach
                                </ul>
                                </div>
                            <div class="col-span-3">
                            <img class="h-64 w-full object-cover object-center" src="{{ Storage::url($category->image) }}" alt="">
                            </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div class="col-span-3 bg-gray-100">
                    <x-navigation-subcategories :category="$categories->first()" />
                    <div class="grid grid-cols-4 py-4 px-4">
                        <div>
                        <p class="text-lg font-bold text-center text-trueGray-500 mb-3">Subcategorías</p>
                        <ul>
                        @foreach($categories->first()->subcategories as $subcategory)
                            <li>
                            <a href="" class="text-trueGray-500 inline-block font-semibold py-1 px-4 hover:text-orange-500">
                            {{ $subcategory->name }}
                            </a>
                            </li>
                        @endforeach
                        </ul>
                        </div>
                        <div class="col-span-3">
                            <img class="h-64 w-full object-cover object-center" src="{{ Storage::url($categories->first()->image) }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white h-full overflow-y-auto">
        <div class="container-menu bg-gray-200 py-3 mb-2">
            @livewire('search')
        </div>
            <ul class="bg-white">
                @foreach($categories as $category)
            <li class="text-trueGray-500 hover:bg-orange-500 hover:text-white">
                <a href="" class="py-2 px-4 text-sm flex items-center">
                <span class="flex justify-center w-9">
                {!! $category->icon !!}
                </span>
                {{ $category->name }}
                </a>
            </li>
            @endforeach
            </ul>
            <p class="text-trueGray-500 px-6 my-2">USUARIOS</p>

                @livewire('cart-movil')

                @auth
            <a href="{{ route('profile.show') }}" class="py-2 px-4 text-sm flex items-center text-trueGray-500 hover:bg-orange-500
            hover:text-white">
                <span class="flex justify-center w-9">
                <i class="far fa-address-card"></i>
                </span>
            Perfil
            </a>
            <a href=""
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit()"
            class="py-2 px-4 text-sm flex items-center text-trueGray-500 hover:bg-orange-500 hover:text-white">
                <span class="flex justify-center w-9">
                <i class="fas fa-sign-out-alt"></i>
                </span>
            Cerrar sesión
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
                @else
            <a href="{{ route('login') }}" class="py-2 px-4 text-sm flex items-center text-trueGray-500 hover:bg-orange-500
            hover:text-white">
                <span class="flex justify-center w-9">
                <i class="fas fa-user-circle"></i>
                </span>
            Iniciar sesión
            </a>
            <a href="{{ route('register') }}" class="py-2 px-4 text-sm flex items-center text-trueGray-500 hover:bg-orange-500
            hover:text-white">
                <span class="flex justify-center w-9">
                <i class="fas fa-fingerprint"></i>
                </span>
            Registrar
            </a>
                @endauth
        </div>
    </nav>
</header>
<script>
function dropdown(){
return {
open: false,
show(){
if(this.open){
this.open = false;
document.getElementsByTagName('html')[0].style.overflow = 'auto'
}else{
this.open = true;
document.getElementsByTagName('html')[0].style.overflow = 'hidden'
}
},
close(){
this.open = false;
document.getElementsByTagName('html')[0].style.overflow = 'auto'
}
}
}
</script>
