<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
        $users = User::all();
        foreach($users as $user) {
            echo $user->name."<br>";
        }
    }
}
