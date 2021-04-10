<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class ProptypeComposer
{

    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->proptype = ['Apartment'=>'Apartment','Villa'=>'Villa','Plot'=>'Plot'];

    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('proptype', $this->proptype);
    }
}
