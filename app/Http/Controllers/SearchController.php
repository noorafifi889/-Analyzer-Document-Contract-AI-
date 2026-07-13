<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class SearchController extends Controller
{
    public function live(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (mb_strlen($query) < 2) {
            return response()->json([
                'documents' => [],
            ]);
        }

        $documents = Document::query()
            ->where('user_id', auth()->id()) // بس عقود المستخدم الحالي
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('original_name', 'like', "%{$query}%")
                  ->orWhere('extracted_text', 'like', "%{$query}%");
            })
            ->limit(8)
            ->get(['id', 'title', 'original_name', 'status']);

        return response()->json([
            'documents' => $documents,
        ]);
    }
}