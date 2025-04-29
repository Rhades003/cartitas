<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $query = Card::where('title', 'LIKE', '%' . $request->name . '%')
        ->orWhere('pasive', 'LIKE', '%' . $request->name . '%');

        $cards = $query->paginate(300);
        return response()->json($cards);
    }

    public function show($id)
    {
        $card = Card::with('offers')->findOrFail($id);
        return response()->json($card);
    }
}
