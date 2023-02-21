<x-app-layout>
    {{--<x-alert type="success" position="top-right">Esta es mi alerta</x-alert>--}}
    <div class="container-menu py-8">
        @foreach($categories as $category)
            <section class="mb-6">
                <div class="flex items-center mb-2">
                    <h1 class="text-lg uppercase font-semibold text-gray-700">
                        {{ $category->name }}
                    </h1>
                    <a href="{{ route('categories.show', $category) }}" class="text-orange-500 hover:text-orange-400 hover:underline ml-2 font-semibold">Ver más</a>
                </div>
                @livewire('category-products', ['category' => $category])
            </section>
        @endforeach
    </div>
    @push('scripts')
    <script>
        Livewire.on('glider', function (id) {
            new Glider(document.querySelector('.glider-' + id), {
                slidesToShow: 1,
                slidesToScroll: 1,
                draggable: true,
                dots: '.glider-' + id + '~.dots',
                arrows: {
                    prev: '.glider-' + id + '~.glider-prev',
                    next: '.glider-' + id + '~.glider-next'
                },
                responsive: [
                    {
                        breakpoint: 640,
                        settings: {
                            slidesToShow: 2.5,
                            slidesToScroll: 2,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3.5,
                            slidesToScroll: 3,
                        }
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4.5,
                            slidesToScroll: 4,
                        }
                    },
                    {
                        breakpoint: 1280,
                        settings: {
                            slidesToShow: 5.5,
                            slidesToScroll: 5,
                        }
                    }
                    ]
            });
        });
    </script>
    @endpush
</x-app-layout>
