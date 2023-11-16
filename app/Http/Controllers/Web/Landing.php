<?php

namespace App\Http\Controllers\Web;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class Landing extends Controller
{
    public function home(): Factory|View
    {
        return $this->getSimpleView('home');
    }

    private function getSimpleView(string $view): Factory|View
    {
        return view($view);
    }
}
