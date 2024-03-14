<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class urlShortening extends Controller
{
    public function shorten(Request $request)
    {
        $originalURL = $request->input('url');
        $shortenedCode = $this->generateShortUrl($originalURL);

        // Salvestan andmed andmebaasi
       DB::table('url')->insert([
            'original_url' => $originalURL,
            'short_url' => $shortenedCode,
            'user_id' => null,
        ]);


        $shortenedURL = 'http://127.0.0.1:8000/' . $shortenedCode;
        $request->session()->flash('shortenedURL', $shortenedURL);

        return redirect()->back();
    }



   public function redirectToOriginalUrl(Request $request, $shortCode)
    {
        $shortenedUrl = DB::table('url')->where('short_url', $shortCode)->first();

        if ($shortenedUrl) {
            // Suuname kasutaja originaalsele URL-ile
            return redirect()->away($shortenedUrl->original_url);
        } else {
            // Kui originaal URL-i ei leitud, siis kuvatakse 404 viga
            abort(404);
        }
    }

    private function generateShortUrl($url) {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $code = '';
        $length = strlen($characters);

        for ($i = 0; $i < 6; $i++) {
            $code .= $characters[rand(0, $length - 1)];
        }

        return $code;
    }
}


