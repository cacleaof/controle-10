<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Perfil;
use Illuminate\Auth\Access\HandlesAuthorization;

class admin
{
    use HandlesAuthorization;
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function administrador($user)
    {

        $perf = Perfil::where('user_id', $user->id)->wherein('perfil', ['X'])->get();
        $perf = $perf->implode('perfil', ', ');
        if($perf == 'X' || $user->id == '1') {
            return true;
        }
         return false;
    }
}
