<?php

namespace App\Http\Controllers;

use App\Pet;
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
    public function index()
    {
        return $this->uploadFileTest();
    }

    private function uploadFileTest() {
        $my_file = 'files2.txt';
        $filename = $this->createTestFile($my_file);
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

    private function createTestFile($my_file) {
        $handle = fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
        $data = 'Test data to see if this works!';
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
