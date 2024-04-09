<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UrlTableController extends Controller
{
    public function urlTable()
    {
        $userId = Auth::id();

        $urls = Url::where('user_id', $userId)->get();
        return view('url_table', ['url' => $urls]);
    }
    public function deleteUrl($id)
    {
        $userId = Auth::id();
        $url = Url::where('user_id', $userId)->findOrFail($id);
        $url->delete();
        return response()->json(['message' => 'URL kustutatud edukalt']);
    }
}
