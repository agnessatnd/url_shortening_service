<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class UrlTable extends Controller
{
    public function urlTable()
    {
        $userId = Auth::id();

        $urls = Url::where('user_id', $userId)->get();
        return view('url_table', ['urls' => $urls]);
    }
    public function deleteUrl($id)
    {
        $userId = Auth::id();
        $url = Url::where('user_id', $userId)->findOrFail($id);
        $url->delete();
        return response()->json(['message' => 'URL kustutatud edukalt']);
    }

    public function deleteSelectedRows(Request $request)
    {
        $selectedIds = json_decode($request->input('selectedIds'));

        Url::whereIn('id', $selectedIds)->delete();

        return response()->json(['message' => 'Valitud read kustutatud edukalt!']);
    }

    public function updateCustomLink(Request $request, $id)
    {
        $userId = Auth::id();
        $url = Url::where('user_id', $userId)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'custom_link' => 'required|unique:url,short_url,' . $url->id,
            'expires_at' => 'nullable|date|after:now',
        ], [
            'custom_link.unique' => 'Selline lühendatud link on juba olemas.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $url->short_url = $request->custom_link;
            $url->save();
            return response()->json([]);
        }
    }
}

