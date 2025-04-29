<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Deck;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeckController extends Controller
{
    public function get()
    {
        $user = Auth::user();
        $decks = $user->decks()->with('cards')->get();
        return response()->json($decks);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'public' => 'boolean',
            'cards' => 'array'
        ]);

        try {
            $deck = Deck::create([
                'name' => $request['name'],
                'user_id' => Auth::id(),
                'public' => $request['public']
            ]);
    
            if (!empty($validated['cards'])) {
                $deck->cards()->sync($validated['cards']);
            }
    
            return response()->json($deck->load('cards'), 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el mazo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getById($id)
    {
        $deck = Deck::with('cards')->findOrFail($id);
        
        if (!$deck->public && $deck->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($deck);
    }

    public function update(Request $request, $id)
    {
        $deck = Deck::findOrFail($id);

        if ($deck->user_id != Auth::id() && !Auth::user()->is_admin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'sometimes|required',
            'public' => 'sometimes|boolean',
            'cards' => 'sometimes|array'
        ]);

        $deck->update($request->only(['name', 'public']));

        if ($request->has('cards')) {
            $deck->cards()->sync($request->cards);
        }

        return response()->json($deck->load('cards'));
    }

    public function delete($id)
    {
        $deck = Deck::findOrFail($id);

        if ($deck->user_id != Auth::id() && !Auth::user()->is_admin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $deck->delete();
        return response()->json(null, 204);
    }

    public function addCard(Request $request, $deckId)
{
    $request->validate([
        'card_id' => 'required|integer|exists:cards,id'
    ]);

    $deck = Deck::where('id', $deckId)
              ->where('user_id', Auth::id())
              ->firstOrFail();

    $deck->cards()->syncWithoutDetaching([$request->card_id]);

    return response()->json([
        'message' => 'Carta añadida al mazo',
        'card' => $deck->cards()->find($request->card_id)
    ], 201);
}
}