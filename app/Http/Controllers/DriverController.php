<?php namespace App\Http\Controllers;

use App\DataTables\DriversDataTable;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('driver.dashboard');
    }

    public function shift(Request $request)
    {
        if ((integer) auth()->user()->isDriver()) {

            if ((int) $request->in_shift == 1) {
                auth()->user()->shifts()
                    ->create(['start_date' => Carbon::now()]);

                return json_encode('Shift is opened.');
            }
            if ((int) $request->in_shift == 0) {
                auth()->user()->shifts()
                    ->latest()->first()->update(['end_date' => Carbon::now()]);

                return json_encode('Shift is closed.');
            }
        }
    }
}
