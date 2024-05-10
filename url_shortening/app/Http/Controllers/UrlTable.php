<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
use Illuminate\Support\Facades\Auth;


class UrlTable extends Controller
{
    public function urlTable()
    {
        $userId = Auth::id();
        $urls = Url::where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->get();
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

    public function editUrlData(Request $request, $id)
    {
        $userId = Auth::id();
        $url = Url::where('user_id', $userId)->findOrFail($id);

        try {
            $request->validate([
                'short_url' => 'unique:url,short_url,' . $url->id,
            ]);

            $url->update([
                'short_url' => $request->short_url,
                'expiration_date' => $request->expiration_date . ' ' . $request->expiration_time,
            ]);

            return redirect()->back()->with('success', 'Lühendatud URL on edukalt uuendatud.');
        } catch (\Exception $e) {
            \Log::error('editUrlData function error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Viga lühendatud URL-i uuendamisel.');
        }
    }
}
