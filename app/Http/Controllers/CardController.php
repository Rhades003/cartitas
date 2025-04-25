<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $query = Card::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%'.$request->title.'%');
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('pasive')) {
            $query->where('pasive', 'like', '%'.$request->pasive.'%');
        }

        $cards = $query->paginate(150);
        return response()->json($cards);
    }

    public function show($id)
    {
        $card = Card::with('offers')->findOrFail($id);
        return response()->json($card);
    }
}
