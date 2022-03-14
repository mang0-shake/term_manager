<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class PrivilegeController extends Controller
{
    /**
     * @return Response
     */
    public function getPrivileges(): Response
    {
        $privileges = DB::select('select * from privileges');

        return response($privileges, 200);
    }
}
