<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Author;

class AuthorComposer
{

    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $author = Author::orderBy('author_lname','asc')->get();
        foreach ($author as $key => $value) {
            $this->author[$value->author_id] = $value->author_fname . ($value->author_lname ? $value->author_lname :'');
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
        $view->with('authorArr', $this->author);
    }
}
