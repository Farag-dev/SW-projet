<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\CreatingService;
use App\Http\Controllers\Services\Helpers;
use App\Http\Controllers\Services\UpdatingService;
use App\Http\Controllers\Services\ValidationService;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Receptionist;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReceptionistContoller extends Controller
{
    use ValidationService, CreatingService, UpdatingService, Helpers;

    public function index()
    {
        if(Auth::user()->role != 'manager') return abort(404);
        return view('components.receptionist.list', [
            'receptionists' => Receptionist::with('employee')->get(),
            'title' => 'receptionists'
        ]);
    }


    public function create()
    {
        if(Auth::user()->role != 'manager') return abort(404);
        return view('components.receptionist.add');
    }


    public function store(Request $request)
    {
        if(Auth::user()->role != 'manager') return abort(404);
        $this->employeeCreateValidation($request);

        if($user = $this->userExists($request->email)) {
            if($user->role)
                return redirect(route('receptionists.create'))
                    ->with('err', 'This Email Has Been Already Used By Another Employee!!')
                    ->withInput();
        }

        $this->createStaff($request, $user, Receptionist::class, 'receptionist');

        return redirect(route('receptionists.index'))->with('done', 'Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        if(Auth::user()->role != 'manager') return abort(404);
        $user = User::with('employee')->where('username', $username)->get()->first();

        if(!$user || $user->role != 'receptionist') {
            return abort(404);
        }

        return view('components.receptionist.profile', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($username)
    {
        if(Auth::user()->role != 'manager' && Auth::user()->role != 'receptionist') return abort(404);
        $user = User::with('employee')->where('username', $username)->get()->first();

        if(!$user || $user->role != 'receptionist') {
            return abort(404);
        }

        return view('components.receptionist.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->role != 'manager' && Auth::user()->role != 'receptionist') return abort(404);
        $this->updateValidation($request);

        UpdatingService::update($request, $id, Employee::class);

        if(Auth::user()->role == 'receptionist') return redirect(route('profile'))->with('done', 'Updated!');
        return redirect(route('receptionists.show', User::select('username')->where('id', $id)->get()->first()->username))
            ->with('done', 'Updated!');
    }


    public function destroy($id)
    {
        if(Auth::user()->role != 'manager') return abort(404);
        $this->deleteEmployee( Receptionist::with('employee')->find($id) );

        return back()->with('done', 'Deleted!');
    }
}
