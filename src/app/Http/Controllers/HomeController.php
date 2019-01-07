<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pickup;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user                   = Auth::user();
        $data['title']          = 'Dashboard - PUDEMAS';
        $data['page']           = 'Dashboard';
        $data['job_pickup']     = Pickup::select([
            'pick_up.id as id_pickup',
            'pick_up.type',
            'pick_up.is_send_to_customer',
            'pick_up.status',
        ])
        ->where('pick_up.status', '3')
        ->where('pick_up.is_send_to_customer', '0')
        ->where('pick_up.courier', $user->id)
        ->get();

        return view('home')->with($data);
    }
}
