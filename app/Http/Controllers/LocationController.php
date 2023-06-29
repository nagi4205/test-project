<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        // 現在の緯度経度を取得
    $currentLatitude = $request->input('latitude');
    $currentLongitude = $request->input('longitude');
    // 一定の距離内の投稿を取得
    $distance = 3; // キロメートル単位の距離

    $posts = DB::table('posts')
        ->select('id', 'title', 'content', 'image', 'latitude', 'longitude')
        ->selectRaw(
            "(6371 * acos(cos(radians($currentLatitude)) 
                * cos(radians(latitude)) 
                * cos(radians(longitude) 
                - radians($currentLongitude)) 
                + sin(radians($currentLatitude)) 
                * sin(radians(latitude)))) 
                AS distance"
        )
        ->having('distance', '<=', $distance)
        ->orderBy('distance', 'ASC')
        ->get();

    // setLocation.jsファイルにjson形式でresponseを渡す
    // return response()->json($posts);
    // return response()->json(['apple' => 'red', 'peach' => 'pink']);
    return view('post.index', compact($posts));
    }
}
