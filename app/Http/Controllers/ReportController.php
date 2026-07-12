<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        // eager load لعلاقة analyses (أحدث تحليل لكل مستند) عشان نتفادى N+1 queries
        // (كان قبل كده هيك: Auth::user()->documents()->latest()->paginate(10)
        //  يعني كل استدعاء لـ $doc->analyses->first() جوا الـ view كان يسوي query لحاله)
        $documents = Auth::user()
            ->documents()
            ->with(['analyses' => fn ($q) => $q->latest()])
            ->latest()
            ->paginate(10);

        return view('reports', compact('documents'));
    }
}