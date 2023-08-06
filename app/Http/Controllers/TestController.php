<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Exception;

class TestController extends Controller
{
    public function test() {
        function func($arg) {
            echo "func start.<br>";
            try {
                // $argが0だったら例外を投げる
                if ($arg == 0) {
                    throw new Exception();
                }
         
                // $argの値を表示
                echo "arg=".$arg;
                echo "<br>";
            } catch(Exception $e) {
                echo "catch Exception.<br>";
            }
            echo "func end.<br>";
        }

        func(10);
        echo "<br>";
        func(0);
        // func(0);
    }

    public function test2() {

        $date1 = Carbon::parse('2023-09-30');
        $date2 = Carbon::parse('2023-10-31');

        $time = $date1->diffInMonths($date2);

        echo $date1;

        if ($time < 1) {
            echo "１ヶ月以内です。";
        } else {
            echo "一ヶ月以上です。";
        }

        echo $time."<br>";
        
        echo $date2."<br>";

        $users = User::all();
        foreach($users as $user) {
            echo $user->name."<br>";
        }
    }
}
