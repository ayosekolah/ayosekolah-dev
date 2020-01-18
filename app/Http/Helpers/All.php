<?php

use App\Business;
use App\Clas;
use App\LessonBusines;
use App\Personal;
use App\PersonalBusiness;
use App\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Jenssegers\Agent\Agent;



if (!function_exists('countByBusiness')) {

    function countByBusiness()
    {
        if (Auth::guard('busines')->check()) {
            $data_static['class'] = Clas::where("busines_id", Auth::guard("busines")->user()->id)->count();
            $data_static['lesbi'] = LessonBusines::where("busines_id", Auth::guard("busines")->user()->id)->count();

            $data_static['teacher'] = PersonalBusiness::where("busines_id", Auth::guard("busines")->user()->id)
                ->where('type', 'teacher')
                ->where('is_approve', 1)
                ->count();
            $data_static['student'] = PersonalBusiness::where("busines_id", Auth::guard("busines")->user()->id)
                ->where('type', 'student')
                ->where('is_approve', 1)
                ->count();
        }

        $data_static['personal'] = Personal::count();
        $data_static['business'] = Business::count();
        $data_static['quiz'] = Quiz::where('busines_id', NULL)->count();

        return $data_static;
    }
}
if (!function_exists('uploadImage')) {
    function uploadImage($img)
    {
        try {
            $path = Storage::disk('local')->putFile(
                'public/v1/images/quiz_question_answer',
                $img
            );
            return $path;
        } catch (Exception $e) {
        }
    }
}
if (!function_exists('getImg')) {
    function getImg($filename)
    {
        if (!Storage::disk('local')->exists($filename)) {
            return  url("v1/images/defaults/placeholder.jpg");
        }


        return Storage::url($filename);
    }
}

if (!function_exists('sizeFont')) {
    function sizeFont($count)
    {

        $agent = new Agent();

        if ($agent->isMobile()) {
            if ($count > 30 && $count < 40) {
                return "font-size:14px;padding-top:7px;line-height: 1.4;";
            } else  if ($count > 40 && $count < 60) {
                return "font-size:16px;padding-top:7px;line-height: 1.4;";
            } else  if ($count > 60) {
                return "font-size:12px;padding-top:7px;line-height: 1.4;";
            }
        } else {
            if ($count > 50 && $count < 76) {
                return "font-size:16px;line-height: 1.4;";
            } else if ($count > 76) {
                return "font-size:14px;line-height: 1.4;";
            }
        }
    }
}
if (!function_exists('formatBytes')) {

    function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        // $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow)); 

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
if (!function_exists('random_color_part')) {
    function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }
}
if (!function_exists('random_color')) {
    function random_color()
    {
        return random_color_part() . random_color_part() . random_color_part();
    }
}
