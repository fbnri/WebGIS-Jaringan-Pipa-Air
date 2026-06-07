<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pipe;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? date('Y');
        $pipes = Pipe::where(function ($q) use ($year) {
            $q->whereYear('planned_at', '<=', $year)
            ->where(function ($q2) use ($year) {
                $q2->whereNull('installed_at')
                    ->orWhereYear('installed_at', '<=', $year);
            });
        })->get();

        $terpasang = $pipes->filter(function ($p) use ($year) {
            return $p->installed_at && date('Y', strtotime($p->installed_at)) <= $year;
        })->count();

        $rencana = $pipes->filter(function ($p) use ($year) {
            return !$p->installed_at || date('Y', strtotime($p->installed_at)) > $year;
        })->count();

        return view('dashboard', compact('terpasang','rencana','year'));
    }
}