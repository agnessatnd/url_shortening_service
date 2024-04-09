<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Url;

class urlShortening extends Controller
{
    public function shorten(Request $request)
    {
        if ($request->has('shorten_button')) {

            $originalURL = $request->input('url');
            $shortenedCode = $this->generateShortUrl($originalURL);

            if (Auth::check()) {
                $userId = Auth::id(); // If user is logged in
            } else {
                $userId = null;
            }

            Url::create([
                'original_url' => $originalURL,
                'short_url' => $shortenedCode,
                'user_id' => $userId,
            ]);

            $shortenedURL = 'http://127.0.0.1:8000/' . $shortenedCode;
            $request->session()->flash('shortenedURL', $shortenedURL);

            return redirect()->back();
        }
    }

    public function redirectToOriginalUrl(Request $request, $shortCode)
    {
        $shortenedUrl = Url::where('short_url', $shortCode)->first();

        if ($shortenedUrl) {
            // Incrementing the number of clicks
            $shortenedUrl->increment('clicks');
            // Redirecting to the original URL
            return redirect()->away($shortenedUrl->original_url);
        } else {
            // If the original URL is not found
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
