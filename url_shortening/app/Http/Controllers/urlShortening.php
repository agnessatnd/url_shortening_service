<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Url;
use Illuminate\Support\Facades\Log;

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
            $shortenedUrl = Url::where('short_url', $shortenedCode)->first();
            $shortenedURL = $shortenedCode;
            $request->session()->flash('shortenedURL', $shortenedURL);
            $request->session()->flash('shortenedUrlId', $shortenedUrl->id);

            return redirect()->back();
        }
    }

    public function redirectToOriginalUrl(Request $request, $shortCode)
    {
        $shortenedUrl = Url::where('short_url', $shortCode)->first();

        if ($shortenedUrl) {

            if ($shortenedUrl->expiration_date && $shortenedUrl->expiration_date < now()) {
                return abort(404, 'Link on aegunud.');
            }

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
    public function saveShortenedUrl(Request $request)
    {
        try {
            $shortenedUrlId = $request->input('shortened_url_id');
            $shortenedUrl = Url::findOrFail($shortenedUrlId);

            $request->validate([
                'short_url' => 'unique:url,short_url,' . $shortenedUrl->id,
            ]);

            if ($request->filled('short_url')) {
                $customShortenedUrl = $request->input('short_url');
                $shortenedUrl->short_url = $customShortenedUrl;
            }

            if ($request->filled('expiration_date') && $request->filled('expiration_time')) {
                $expirationDateTime = $request->input('expiration_date') . ' ' . $request->input('expiration_time');
                $shortenedUrl->expiration_date = $expirationDateTime;
            }

            $shortenedUrl->save();

            return redirect()->back()->with('success', 'Lühendatud URL on edukalt salvestatud.');

        } catch (\Exception $e) {
            \Log::error('saveShortenedUrl function error: ' . $e->getMessage());
            return response('Lühendatud URL on juba kasutusel!', 500);

        }
    }
}
