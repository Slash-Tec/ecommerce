<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\CreateData;

class UserOptionsTest extends DuskTestCase
{

     use RefreshDatabase;
     use DatabaseMigrations;
     use CreateData;

    /** @test */
    public function it_shows_the_login_and_register_options()
    {

        $this->createCategory();

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(100)
                ->click('.fa-circle-user')
                ->pause(100)
                ->assertSeeIn('.rounded-md .ring-1','Login')
                ->pause(500)
                ->assertSeeIn('.rounded-md .ring-1','Registro')
                ->screenshot('not-logged-test');
        });
    }

    /** @test */
    public function it_shows_the_logout_and_profile_options()
    {
        $this->createCategory();
        $user = $this->createUser();

        $this->browse(function (Browser $browser) use($user){
            $browser->loginAs($user->id)
                ->visit('/login')
                ->click('.rounded-full .object-cover')
                ->pause(100)
                ->assertSeeIn('.rounded-md .ring-1','Perfil')
                ->pause(100)
                ->assertSeeIn('.rounded-md .ring-1','Logout')
                ->screenshot('logged-test');
        });
    }

    /** @test */
    public function the_unauthenticated_user_cant_access_to_authenticate_necessary_routes()
    {

        $user = $this->createUser();
        $this->createOrder();

        $this->browse(function (Browser $browser) use ($user){
            $browser->visit('/orders')
                ->pause(100)
                ->assertPathIs('/login')
                ->loginAs($user->id)
                ->visit('/orders')
                ->pause(1000)
                ->assertPathIs('/orders')
                ->assertSee('Pedidos recientes')
                ->screenshot('needAuthentication-test');
        });
    }

    /** @test */
    public function an_authenticated_user_cant_access_other_authenticated_user_orders()
    {
        $this->createUser();
        $this->createOrder();

        $user = User::factory()->create([
            'name' => 'Pepe',
            'email' => 'pepe@test.com',
            'password' => bcrypt('123'),
        ]);

        $this->browse(function (Browser $browser) use ($user){
            $browser->loginAs($user->id)
                ->visit('/orders/1')
                ->pause(100)
                ->assertPathIs('/orders/1')
                ->assertTitle('Prohibido')
                ->assertSeeIn('div.px-4', '403')
                ->assertSeeIn('div.ml-4','ESTA ACCIÓN NO ESTÁ AUTORIZADA')
                ->screenshot('cannotAccessToOthersUsersOrders-test');
        });
    }

}
