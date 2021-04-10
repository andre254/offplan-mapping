<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Location;

class LocationComposer
{

    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $location = Location::orderBy('loc_name','asc')->get();
        foreach ($location as $key => $value) {
            $this->location[$value->loc_id] = $value->loc_name;
        };
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('locarr', $this->location);
    }
}
