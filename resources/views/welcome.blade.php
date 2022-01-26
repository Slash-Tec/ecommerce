<x-app-layout>
	<div class="container-menu py-8">
		<section>
		<h1 class="text-lg uppercase font-semibold text-gray-700">
			{{ $categories->first()->name }}
		</h1>
		
			@livewire('category-products', ['category' => $categories->first()])
		</section>
	</div>
	<script>
		new Glider(document.querySelector('.glider'), {
			slidesToShow: 5.5,
			slidesToScroll: 5,
			draggable: true,
			dots: '.dots',
			arrows: {
				prev: '.glider-prev',
				next: '.glider-next'
			}
		});
	</script>
</x-app-layout>
