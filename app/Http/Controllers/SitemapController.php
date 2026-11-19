<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $beritas = Berita::where('status', 'published')->latest('tanggal_publish')->get();

        $content = view('sitemap', compact('beritas'))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/xml');
    }
}
