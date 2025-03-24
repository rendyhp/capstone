<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogActivity as LogActivityModel;

class LogActivity
{
    public static function addToLog($subject)
    {
        $log = [];
        $log['subject'] = $subject;
        $log['url'] = request()->fullUrl(); // Menggunakan request() untuk membuat instance dari Request
        $log['method'] = request()->method(); // Menggunakan request() untuk membuat instance dari Request
        $log['ip'] = request()->ip(); // Menggunakan request() untuk membuat instance dari Request
        $log['agent'] = request()->header('user-agent'); // Menggunakan request() untuk membuat instance dari Request
        $log['user_id'] = Auth::user()->id;
        LogActivityModel::create($log);
    }

    public static function logActivityLists()
    {
        return LogActivityModel::latest('updated_at')
            ->join('users', 'log_activities.user_id', '=', 'users.id')
            ->select('log_activities.*', 'users.name')
            ->get();;
    }
}
