<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    public function login(Request $request) {
        $method = $request->method;
        if (!$method) {
            return response()->json([
                "code" => 400,
                "message" => "Malformed request",
            ]);
        }

        $response = null;
        $payload = $request->payload;
        if (!$payload) {
            return response()->json([
                "code" => 400,
                "message" => "Malformed request",
            ]);
        }
        switch ($method) {
            case "email": {
                $response = $this->handleEmailLogin($payload);
                break;
            }
            case "google": {
                $response = $this->handleGoogleLogin($payload);
                break;
            }
            case "fb": {
                $response = $this->handleFbLogin($payload);
                break;
            }
            default: {
                $response = reponse()->json([
                    "code" => 400,
                    "message" => "Login method not recognized",
                ]);
            }
        }
        return $response;
    }

    private function handleEmailLogin($payload)
    {
        $email = $payload['email'];
        $password = $payload['password'];

        $user = User::where('email', $email)
                ->where('password', Hash::make($password))->get();

        if (!$user) {
            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized user'
            ]);
        }
        return response()->json([
            'code' => 200,
            'user' => $user
        ]);
    }

    private function handleGoogleLogin($payload)
    {
        $user = User::where('googleToken', $payload['token'])->get();
        if (!$user) {
            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized user'
            ]);
        }
        return response()->json([
            'code' => 200,
            'user' => $user
        ]);
    }

    private function handleFbLogin($payload)
    {
        $user = User::where('fbToken', $payload['token'])->get();
        if (!$user) {
            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized user'
            ]);
        }
        return response()->json([
            'code' => 200,
            'user' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // retgistro normal 
        
        $email = User::where('email', $request['email'])->get();
        //return count($email);
        if (!count($email)) {
            $user = new User();
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->birthday = $request->birthday;
            $user->address = $request->address;
            //$user->sellerDescription = $request->sellerDescription;
            $user->pictureUrl = 'http://200.16.7.152/img/Usuarios/flashapp.jpg';
            //$user->sellerRating = 0;
            //$user->customerRating = 0;
            $user->email = $request->email;
            //password debe ser con hash
            $user->password = Hash::make($request->password);
            //$user->rememberToken();
            $user->save();
            return response()->json([
                'code' => 200,
                'message' => 'user registrado'
            ]);
        }
        
        return response()->json([
            'code' => 401,
            'user' => 'ya existe una cuenta con ese correo'
        ]);

        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
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
}
