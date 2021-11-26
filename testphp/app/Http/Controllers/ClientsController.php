<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    //Get all Clients
    public function index(){
        $clients = Client::all();

        return view('clients.index', compact('clients'));
    }

    //Get a Client
    public function show($id){
        $client = Client::find($id);

        return response()->json([
            'item' => $client,
            'statusCode' => 200
        ]);
    }

    public function create(Request $request){

        $id = $request->input('id');
        $textResponse = 'Creado';
        if($id){
            $client = Client::find($id);
            $textResponse = 'Editado';
        }else
            $client = new Client();
        

        $client->name = $request->input('name');
        $client->last_name_p = $request->input('last_name_p');
        $client->last_name_m = $request->input('last_name_m');
        $client->address = $request->input('address');
        $client->email = $request->input('email');
        $client->save();

        $clients = Client::all();
        

        return response()->json([
            "msg" => "Usuario ". $textResponse ." correctamente",
            "items" => $clients,
            "statusCode" => 200
        ]);

    }

    public function delete(Request $request){

        Client::destroy($request->input('id'));


        $clients = Client::all();

        return response()->json([
            "msg" => "Usuario eliminado correctamente",
            "items" => $clients,
            "statusCode" => 200
        ]);
    }


}
