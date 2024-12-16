<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class Landing extends Controller
{

    public function home(): Factory|View
    {
        return view('home');
    }
}
