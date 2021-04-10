<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Developer;
use App\Models\SpecialProperty;

class DeveloperComposer
{
    private $dev;
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->dev = Developer::orderBy('dev_name','asc')
        ->leftjoin('special_property','special_property.sprop_dev','=','developer.dev_id')
        ->select('developer.dev_id','developer.dev_name','developer.dev_slug','special_property.sprop_name','special_property.sprop_slug')
        ->get();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('devarr', $this->dev->groupBy('dev_name'));
        $view->with('comarr', $this->dev->groupBy('sprop_name'));
    }
}
