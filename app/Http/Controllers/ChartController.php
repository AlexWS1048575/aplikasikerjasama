<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Corporation;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    public function index() {

        // $users = User::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
        //             ->whereYear('created_at', date('Y'))
        //             ->groupBy(DB::raw("month_name"))
        //             ->orderBy('id','ASC')
        //             ->pluck('count', 'month_name');

        // $users = User::select(DB::raw("COUNT(*) as count"), DB::raw("DAY(created_at) as day"))
        //             ->whereYear('created_at', date('Y'))
        //             ->groupBy(DB::raw("day"))
        //             ->orderBy('id','ASC')
        //             ->pluck('count', 'day');

        // $corporations = Corporation::select(DB::raw("COUNT(*) as count"), DB::raw("status_id as status"))
        //             ->LeftJoin('statuses', 'statuses.id', '=', 'corporations.status_id')
        //             ->groupBy('corporations.status_id')
        //             ->orderBy('corporations.id','DESC')
        //             ->pluck('count', 'status');

        $corporations = Corporation::select(DB::raw("COUNT(*) as count"), DB::raw("types.name as typename"))
                    ->LeftJoin('types', 'types.id', '=', 'corporations.type_id')
                    ->groupBy('types.name')
                    ->orderBy('corporations.id','DESC')
                    ->pluck('count', 'typename');
 
        $labels = $corporations->keys();
        $data = $corporations->values();

        $corporations2 = Corporation::select(DB::raw("COUNT(*) as count"), DB::raw("corporation_types.name as corporationtypename"))
                    ->LeftJoin('corporation_types', 'corporation_types.id', '=', 'corporations.corporationtype_id')
                    ->groupBy('corporation_types.name')
                    ->orderBy('corporations.id','DESC')
                    ->pluck('count', 'corporationtypename');
 
        $labels2 = $corporations2->keys();
        $data2 = $corporations2->values();
        
        return view('chart.pie', compact('labels', 'data', 'labels2', 'data2'));

        // $corporations = DB::table('corporations')
        //     ->leftJoin('statuses', 'corporations.status_id', '=', 'statuses.id')
        //     ->get();
        // return view('chart.pie', compact('corporations'));
    }
}
