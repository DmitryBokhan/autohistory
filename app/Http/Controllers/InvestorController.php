<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function index()
    {
        $investors = User::role('investor')->get();

        return view('investors.index', compact(['investors']));
    }

    public function settings($user_id)
    {
        $user = User::find($user_id);

        return view('investors.profile_settings', compact(['user']));
    }

    public function update(Request $request)
    {
        //TODO сделать валидацию
        User::find($request->user_id)->update([
            'invest_percent' => $request->invest_percent,
            'is_active' => $request->has('is_active') ? true : false
        ]);

        return redirect()->route('investors.index');
    }
}
