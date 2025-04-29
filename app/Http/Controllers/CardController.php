<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function index(Request $request)
    {
        //return $request->searchOnlyhForName;
        if($request->searchOnlyhForName == "true"){
        $query = Card::where('title', 'LIKE', '%' . $request->name . '%');    
    }
        else {
            $query = Card::where('title', 'LIKE', '%' . $request->name . '%')
            ->orWhere('pasive', 'LIKE', '%' . $request->name . '%');
        }
        $cards = $query->paginate(300);
        return response()->json($cards);
    }

    public function show($id)
    {
        $card = Card::with('offers')->findOrFail($id);
        
        try {
            $user = Auth::user();
        
        }catch(Exception $e) {
            $user = [
                "admin" => false
            ];
        }

        $data = [
            "card"=> $card,
            "admin"=>$user->admin,
        ];
            

            return response()->json($data);
        }


}
