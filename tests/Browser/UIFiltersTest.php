<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\CreateData;

class UIFiltersTest extends DuskTestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use CreateData;

    /** @test */
    public function it_hides_the_unchecked_columns()
    {
        $admin = $this->createAdmin();

        $this->browse(function (Browser $browser) use ($admin){
            $browser
                ->loginAs($admin)
                ->visit('/admin/products2')
                ->pause(1000)
                ->press('Mostrar/Ocultar columnas')
                ->pause(100)
                ->check('#Nombre')
                ->pause(100)
                ->assertDontSeeIn('table','Nombre')
                ->pause(100)
                ->screenshot('hideColumns-test');
        });
    }

    /** @test */
    public function it_shows_the_filters()
    {
        $this->createProduct();
        $this->createProducts(3);
        $admin = $this->createAdmin();

        $this->browse(function (Browser $browser) use ($admin){
            $browser
                ->loginAs($admin)
                ->visit('/admin/products2')
                ->pause(1000)
                ->press('Filtros')
                ->pause(100)
                ->assertSee('Limpiar filtros')
                ->pause(100)
                ->screenshot('showFilters-test');
        });
    }

    /** @test */
    public function it_hides_the_filters()
    {
        $this->createProduct();
        $this->createProducts(3);
        $admin = $this->createAdmin();

        $this->browse(function (Browser $browser) use ($admin){
            $browser
                ->loginAs($admin)
                ->visit('/admin/products2')
                ->pause(1000)
                ->press('Filtros')
                ->pause(100)
                ->press('Filtros')
                ->assertDontSee('Limpiar filtros')
                ->pause(100)
                ->screenshot('hideFilters-test');
        });
    }

    /** @test */
    public function it_cleans_the_filters()
    {
        $this->createProduct();
        $this->createProducts(3);
        $admin = $this->createAdmin();

        $this->browse(function (Browser $browser) use ($admin){
            $browser
                ->loginAs($admin)
                ->visit('/admin/products2')
                ->pause(1000)
                ->press('Filtros')
                ->pause(100)
                ->type('div.pl-2 > input', 'Ta')
                ->pause(100)
                ->clickLink('Limpiar filtros')
                ->pause(100)
                ->assertInputValue('div.pl-2 > input', '')
                ->pause(100)
                ->screenshot('cleanFilter-test');
        });
    }

    /** @test */
    public function it_cleans_the_date_inputs()
    {
        $this->createProduct();
        $this->createProducts(3);
        $admin = $this->createAdmin();

        $this->browse(function (Browser $browser) use ($admin){
            $browser
                ->loginAs($admin)
                ->visit('/admin/products2')
                ->pause(1000)
                ->press('Filtros')
                ->pause(100)
                ->value('input.dateFlatpicker', '16/02/2022')
                ->pause(100)
                ->press('Limpiar')
                ->pause(100)
                ->assertInputValue('.dateFlatpicker', '')
                ->pause(100)
                ->screenshot('cleanDateInput-test');
        });
    }

    /** @test */
    public function it_is_possible_to_select_the_shown_products_per_page()
    {
        $this->createProduct();
        $this->createProducts(10);
        $admin = $this->createAdmin();

        $this->browse(function (Browser $browser) use ($admin){
            $browser
                ->loginAs($admin)
                ->visit('/admin/products2')
                ->pause(1000)
                ->select('paginate', '10')
                ->pause(100)
                ->assertSee( 'Mostrando 1 al 10 de 11 resultados')
                ->pause(100)
                ->screenshot('paginate-test');
        });
    }
}
