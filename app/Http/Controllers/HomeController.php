<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $user = auth()->user();

        if ($user->isAdmin()) {

            return redirect()->action('UserController@index');
        }

        if ($user->isDispatcher()) {

            return redirect()->action('OrderController@index');
        }

        if ($user->isDriver()) {

            return redirect()->route('driver.index');
        }
    }
}
