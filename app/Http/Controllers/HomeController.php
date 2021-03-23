<?php

namespace App\Http\Controllers;

use App\{Booking, Category, Customer, Room, User};

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'users' => User::count(),
            'rooms' => Room::count(),
            'bookings' => Booking::count(),
            'customers' => Customer::count(),
            'categories' => Category::orderBy('name', 'ASC')->get()
        ]);
    }
}
