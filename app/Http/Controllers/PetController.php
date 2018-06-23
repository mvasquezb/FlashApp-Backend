<?php

namespace App\Http\Controllers;

use App\Pet;
use App\AnimalType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\S3Helper;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMascotas($userid){
        $mascotas = Pet::where('owner_id',$userid)->get();
        foreach ($mascotas as &$m) {
            $m->animalType;
        }
        return response()->json([
                'code' => 200,
                'message' => 'mascota encontradas',
                'data' => $mascotas
            ]);
    }

    public function actualizar(Request $request)
    {
        $pet = Pet::where('id',$request->id)->first();
        $pet->owner;
        //return $pet;
        $ruta = $this->uploadFileTest($request->image,$pet->owner->id,$request->id);
        //return $ruta;        
        $pet->name = $request['name'];
        $pet->gender = $request['gender'];
        $pet->breed = $request['breed'];
        $animal_type_id = AnimalType::where('description',$request->tipo)->first();

        //$file = base64_decode($request->image);
        //$filename = $file->getClientOriginalName();
        //$bitmap = BitmapFactory.decodeByteArray(decodedString,0,decodedString.length);
        //return $bitmap;
        
        if ($animal_type_id)
        {
            // si el tipo ya exite
            $pet->animal_type_id = $animal_type_id->id;
        }
        else 
        {
            // si el tipo no exite
            $type = new AnimalType();
            $type->description = $request->tipo;
            $type->save();
            $pet->animal_type_id = $type->id;
        }

        // por ahora todos la misma imagen
        //$ruta = $this->uploadFileTest($request->image,$pet->owner->id,$request->id);
        //return $ruta;
        $pet->pictureUrl = $ruta;
        $pet->save();
        return response()->json([
                'code' => 200,
                'message' => 'mascota actualizada',
                'data' => $pet
            ]);

    }

    public function delete($petid){
        $pet = Pet::where('id',$petid)->delete();
        return response()->json([
                'code' => 200,
                'message' => 'mascotas borrada'
            ]);
    }

    public function index()
    {
        return $this->uploadFileTest();
    }

    private function uploadFileTest($image,$owner,$pet) {
        //return $image;
        $data = base64_decode($image);
        $my_file = 'pet' . $owner . $pet . '.jpg';
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
        //
        try
        {
            $pet = new Pet();
            $pet->name = $request['name'];
            $pet->gender = $request['gender'];
            $pet->breed = $request['breed'];
            $animal_type_id = AnimalType::where('description',$request->tipo)->first();
            
            if ($animal_type_id)
            {
                // si el tipo ya exite
                $pet->animal_type_id = $animal_type_id->id;
            }
            else 
            {
                // si el tipo no exite
                $type = new AnimalType();
                $type->description = $request->tipo;
                $type->save();
                $pet->animal_type_id = $type->id;
            }

            //los 2 son lo same creo
            $pet->owner_id = $request['user_id'];

            // por ahora todos la misma imagen
            $pet->pictureUrl = "http://200.16.7.152/img/Usuarios/flashapp.jpg";
            $pet->save();
            return response()->json([
                'code' => 200,
                'message' => 'mascota registrada',
                'data' => $pet
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json(['code' => 500,
                'message'=> 'Hubo un error',
                'data' => $e->getMessage()
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function show(Pet $pet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function edit(Pet $pet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pet $pet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pet  $pet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pet $pet)
    {
        //
    }

}
