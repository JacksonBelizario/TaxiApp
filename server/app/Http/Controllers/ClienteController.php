<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Firebase\JWT\JWT;

class ClienteController extends Controller
{
	const MODEL = "App\Models\Cliente";
    protected $modelClass = Cliente::class;
    private $request;
    
    
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cliente $clientes)
    {
        return $clientes->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Create a new token.
     */
    protected function jwt(Cliente $user)
    {
        $payload = [
            'iss' => "cliente", // Issuer of the token
            'id' => $user->id_cliente, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60 * 60 * 8, // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     */
    public function auth(Cliente $cliente)
    {
        $this->validate($this->request, [
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        // Find the user by email
        $user = $cliente->where('email', $this->request->input('email'))->first();

        if (!$user) {
            return response()->json([
                'error' => 'Email incorreto.',
            ], 400);
        }

        // Verify the password and generate the token
        if ($this->request->input('senha') === $user->senha) {
            return response()->json([
                'token' => $this->jwt($user),
                'me' => $user,
            ], 200);
        }

        // Bad Request response
        return response()->json([
            'error' => 'Email ou senha incorreto.',
        ], 400);
    }
}
