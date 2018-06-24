<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\S3Helper;
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
        $credentials = [
            'email' => $payload['email'],
            'password' => $payload['password']
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized user'
            ]);   
        }
        $user = Auth::user();
        return response()->json([
            'code' => 200,
            'user' => $user
        ]);
    }

    private function handleGoogleLogin($payload)
    {
        $credentials = [
            'email' => $payload['email'],
            'googleToken' => $payload['token']
        ];
        $user = User::where('email', $credentials['email'])
                    ->where('googleToken', $credentials['googleToken'])
                    ->first();
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
        try
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
                $user->googleToken = $request->googleToken;
                $user->fbToken = $request->fbToken;
                //$user->rememberToken();
                $user->save();
                if ($request->image)
                {
                $ruta = $this->uploadFileTest($request->image,$user->id);
                $user->pictureUrl = $ruta;
                $user->save();
                }
                return response()->json([
                    'code' => 200,
                    'message' => 'user registrado',
                    'user' => $user
                ]);
            }
        
            return response()->json([
                'code' => 401,
                'message' => 'ya existe una cuenta con ese correo'
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'code' => 500,
                'message'=> 'Hubo un error',
                'data' => $e->getMessage()
            ]);
        }
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

    private function uploadFileTest($image,$owner) {
        //return $image;
        $data = base64_decode($image);
        $my_file = 'user' . $owner . '.jpg';
        //$my_file = 'files2.txt';
        //return $my_file;
        $filename = $this->createTestFile($my_file,$data);
        $disk = Storage::disk('s3');
        $added = $this->uploadTestFileToDisk($disk, $filename);
        if ($added) {
            // return $disk->temporaryUrl($filename, now()->addYears(1));
            return S3Helper::getFileUrl($disk->url($filename));
        }
        return "File not added";
    }

    private function uploadTestFileToDisk($disk, $my_file) {
        $handle = fopen($my_file, 'r') or die('Cannot open file:  ' . $my_file);
        $added = $disk->put($my_file, $handle, 'public');
        fclose($handle);
        return $added;
    }

    private function createTestFile($my_file,$data) {
        $handle = fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
        //$data = 'Test data to see if this works!';
        fwrite($handle, $data);
        fclose($handle);
        return $my_file;
    }
}
