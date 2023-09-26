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
    }
}
