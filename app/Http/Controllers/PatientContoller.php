<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\CreatingService;
use App\Http\Controllers\Services\Helpers;
use App\Http\Controllers\Services\UpdatingService;
use App\Http\Controllers\Services\ValidationService;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;

class PatientContoller extends Controller
{
    use ValidationService, CreatingService, UpdatingService, Helpers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('components.patient.list', [
            'patients' => Patient::with('user')->limit(10)->get(),
            'title' => 'patients'
        ]);
    }


    public function create()
    {
        return view('components.patient.add');
    }


    public function store(Request $request)
    {
        $this->patientCreateValidation($request);

        if($user = $this->userExists($request->email)) {
            if($user->role) {
                if($user->role == 'patient') {
                    if($user->patient->doctor->clinic->id == $request->clinic) {
                        return redirect(route('patients.create'))
                            ->with('err', 'This Patient Has Been Already In This Clinic!!')
                            ->withInput();
                    }
                } else {
                    return redirect(route('patients.create'))
                        ->with('err', 'This Email Has Been Already Used By Another Account!!')
                        ->withInput();
                }
            } else {
                $this->setRole($user, 'patient');
            }
        }

        return $this->createPatient($request, $user) ? redirect(route('patients.index'))->with('done', 'Added!')
            : redirect(route('patients.create'))
                ->with('err', 'The Selected Clinic Does NOT Open Yet!!')
                ->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $user = User::with('patient')->where('username', $username)->get()->first();

        if(!$user || $user->role != 'patient') {
            return abort(404);
        }

        return view('components.patient.profile', [
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
        $user = User::with('patient')->where('username', $username)->get()->first();

        if(!$user || $user->role != 'patient') {
            return abort(404);
        }

        return view('components.patient.edit', [
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
        $this->patientUpdateValidation($request);

        UpdatingService::updatePatient($request, $id);

        return redirect(route('patients.show', User::select('username')->where('id', $id)->get()->first()->username))
            ->with('done', 'Updated!');
    }


    public function destroy($id)
    {
        $this->deletePatient( User::with('patient')->find($id) );

        return back()->with('done', 'Deleted!');
    }
}
