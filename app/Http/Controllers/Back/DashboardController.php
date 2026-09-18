<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Menu;
use App\Models\Reservation;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        $total_artikel    = Article::count();
        $total_menu       = Menu::count();
        $total_reservasi  = Reservation::count();
        $total_testimoni  = Testimonial::count();

        $menus = Menu::latest()->take(5)->get();

        return view('back.dashboard.index', compact(
            'total_artikel',
            'total_menu',
            'total_reservasi',
            'total_testimoni',
            'menus',
        ));

    }
}
