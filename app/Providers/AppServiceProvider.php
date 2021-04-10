<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use Propaganistas\LaravelIntl\Facades\Country;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public $quarters;
    public $price;
    public $country;
    public function __construct(){
        $carb = new Carbon();
        $i = 1;
        $this->country = Country::all();
        $this->price['price']['any'] = 'Any';
        $this->price['price']['pa'] = 'Price on Application';
        $this->price['price']['200k'] = '200,000';
        $this->price['price']['500k'] = '500,000';
        while ($i <= 100) {
            if ($i < 6) {
                $this->price['price'][$i.'m'] = preg_replace('/\B(?=(\d{3})+(?!\d))/', ",", ($i * 1000000));
            }else{
                $this->price['price'][$i.'m'] = $i.',000,000';
            }
            if ($i < 6) {
                $i += 0.5;
            }else if ($i < 15 && $i > 5) {
                $i++;
            }else if ($i < 30) {
                $i += 5;
            }else{
                $i += 10;
            }
        }
        $this->quarters['date']['any'] = 'Any';
        for ($i=0; $i < 7; $i++) { 
            for ($ii=1; $ii < 5; $ii++) { 
                    $supkey = $carb->now()->addYear($i)->year;
                    $key = $carb->now()->addYear($i)->year . '-' .(3*$ii). '-30 00:00:00';
                    $this->quarters['date'][$supkey][$key] = 'Quarter ' . $ii . ' of ' . $supkey;
            }
               
        }

    }

    public function boot()
    {
        View::share(['date'=>$this->quarters,'price'=>$this->price,'country'=>$this->country]);
        View::composer('*', 'App\Http\ViewComposers\LocationComposer');
        View::composer('*', 'App\Http\ViewComposers\ProptypeComposer');
        View::composer(['admin.blog_add', 'admin.blog'], 'App\Http\ViewComposers\AuthorComposer');
        View::composer('*', 'App\Http\ViewComposers\DeveloperComposer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
