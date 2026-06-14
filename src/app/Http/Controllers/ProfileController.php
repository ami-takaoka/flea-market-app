<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        $action = request('action', 'setup');

        return view('mypage.profile', compact('user', 'action'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('image')) {

            $path = $request->file('image')
                ->store('profile_images', 'public');

            $user->update([
                'image' => $path,
                'name' => $request->name,
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ]);

        } else {

            $user->update([
                'name' => $request->name,
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ]);
        }

        if ($request->action === 'edit') {
            return redirect()->route('mypage');
        }

        return redirect()->route('items.index');
    }
}