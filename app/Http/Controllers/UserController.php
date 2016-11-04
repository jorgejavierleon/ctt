<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Jleon\LaravelPnotify\Notify;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show', compact($user));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if($user->update($request->only(['name', 'email']))){
            Notify::success('se actualizaron los datos');
            return redirect()->back();
        }

        Notify::error('No se pudo actualizar');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->delete()){
            Notify::success('Se eliminó la cuenta');
            return redirect('/');
        };

        Notify::success('No se pudo eliminar la cuenta');
        return redirect()->back();
    }

    /**
     * @param Request $request
     */
    public function avatar(Request $request)
    {
        $user = Auth::user();

       if($request->hasFile('croppedImage')){
           $image = $request->file('croppedImage');
           $file_name = $user->id . '_avatar' . '.' . $image->guessExtension();
           $destination = public_path('img/avatars');
           $image->move($destination, $file_name);

           $avatar = url('img/avatars/' . $file_name);
           $user->update(['avatar' => $avatar]);
       }
    }
}
