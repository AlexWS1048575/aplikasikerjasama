<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Corporation;
use App\Models\Wish;
use App\Models\User;
use App\Models\Role;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewUserNotification;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalOrganizations = Organization::count();
        $totalCorporations = Corporation::count();
        $totalWishes = Wish::count();
        $totalUsers = User::count();
        $totalRoles = Role::count();
        $user = Auth::user();
        $notifications = Auth::user()->unReadNotifications;
        $pengguna = User::find(1);
        // grafik pie chart bedasarkan tipe kerjasama
        $test = DB::table('corporations')->select(DB::raw("COUNT(*) as count"))
                    ->LeftJoin('types', 'types.id', '=', 'corporations.type_id')
                    ->groupBy('types.id')
                    ->orderBy('corporations.id','DESC')
                    ->pluck('count');
        $corporations = DB::table('corporations')->select(DB::raw("COUNT(*) as count"), DB::raw("types.name as typename"))
                    ->LeftJoin('types', 'types.id', '=', 'corporations.type_id')
                    ->groupBy('types.name')
                    ->orderBy('corporations.id','DESC')
                    ->pluck('count', 'typename');
        // $corporations = DB::statement("SELECT b.name AS typename, count(a.id) AS count, 
        //                 (SELECT count(a.id) AS total FROM corporations a) AS totaldata, 
        //                 (count(a.id) / (SELECT count(a.id) AS total FROM corporations a)) AS persentase 
        //                 FROM corporations a LEFT JOIN types b ON b.id = a.type_id GROUP BY b.name")
        //                 ->pluck('typename', 'count', 'totaldata', 'persentase');
        // grafik pie chart bedasarkan jenis kerjasama
        $corporations2 = Corporation::select(DB::raw("COUNT(*) as count"), DB::raw("corporation_types.name as corporationtypename"))
                    ->LeftJoin('corporation_types', 'corporation_types.id', '=', 'corporations.corporationtype_id')
                    ->groupBy('corporation_types.name')
                    ->orderBy('corporations.id','DESC')
                    ->pluck('count', 'corporationtypename');
 
        $labels = $corporations->keys();
        $data = $corporations->values();

        $labels2 = $corporations2->keys();
        $data2 = $corporations2->values();

        return view('backend.layouts.app', compact('totalOrganizations', 'totalCorporations', 'totalWishes', 'totalUsers', 
                    'totalRoles', 'labels', 'data', 'labels2', 'data2', 'notifications', 'pengguna'))->with(['user' => $user]);
    }

    public function pages()
    {
        return view('admin.pages');
    }

    public function pages2()
    {
        return view('admin.pages2');
    }

    public function changePassword()
    {
        return view('change-password');
    }

    public function changeProfile()
    {
        $user = Auth::user();
        return view('change-profile', ['user' => $user]);
        // return view('change-profile');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'password_confirmation' => 'required|same:new_password',
        ]);
        $auth = Auth::user();
 
        // Cek apakah password lama sesuai atau tidak
        if (!Hash::check($request->get('old_password'), $auth->password)) 
        {
            return back()->with('error_message', "Current Password is Invalid!");
        }
 
        // Jika password lama dan baru adalah sama
        if (strcmp($request->get('old_password'), $request->new_password) == 0) 
        {
            return redirect()->back()->with('error_message', "New Password cannot be same as your current password!");
        }
 
        $user =  User::find($auth->id);
        $user->password =  Hash::make($request->new_password);
        $user->save();
        return back()->with('success_message', "Password berhasil diubah!");
    }

    public function markNotification(Request $request)
    {
        Auth::user()->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
        // $user = User::find($auth->id);

        // foreach ($user->unreadNotifications as $notification) {
        //     $notification->markAsRead();
        // }
        // return redirect()->back();

    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
        ]);
        $auth = Auth::user();
        $user = User::find($auth->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->affiliation = $request->affiliation;
        $user->save();
        return redirect()->route('home')->with('success_message', "Profil berhasil diubah!");
    }
}
