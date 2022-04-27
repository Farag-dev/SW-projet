<?php

namespace App\Http\Controllers\Services;

use App\Models\Doctor;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

trait UpdatingService {
    public static function update(Request $request, $id, $model) {
        static::updateUser($request, $id);

        $model::where('user_id', $id)->update([
            'national_id' => $request->national_id
        ]);
    }

    public static function updateUser(Request $request, $id) {
        return User::where('id', $id)->update([
            'fname' => ucwords($request->fname),
            'lname' => ucwords($request->lname),
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);
    }

    public static function updatePatient(Request $request, $id) {
        User::where('id', $id)->update([
            'fname' => ucwords($request->fname),
            'lname' => ucwords($request->lname),
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        Patient::where('user_id', $id)->update([
            'doctor_id' => Doctor::inRandomOrder()->where('clinic_id', $request->clinic)->first()->id
        ]);
    }

    protected function setUserData(Request $request, User $user) {
        $user->fname = ucwords($request->fname);
        $user->lname = ucwords($request->lname);
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->address = $request->address;

        if($user->role == 'manager') {
            $user->manager->update([
                'national_id' => $request->national_id,
            ]);
        } else {
            $user->employee->update([
                'national_id' => $request->national_id,
            ]);
        }

        $user->save();

        return $user;
    }
}
