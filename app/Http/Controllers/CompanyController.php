<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CompanyRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

Validator::extend('is_image',function($attribute, $value, $params, $validator) {
    $image = base64_decode($value);
    $f = finfo_open();
    $result = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
    return $result == 'image/png' || $result == 'image/jpeg';
});

class CompanyController extends Controller
{
    private $repository;

    private $rules = [
        'name' => 'required|max:50',
        'email' => 'required|email|max:60|unique:companies',
        'website' => 'nullable|url',
        'logo' => 'nullable|is_image'
    ];

    public function __construct(CompanyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->apiResponse($this->repository->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            return $this->apiResponse([], false, $validator->messages());
        }

        // initial DTO
        $companyDTO = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'website' => $request->input('website'),
        ];

        // save logo if inject in request
        if ($request->input('logo')) {
            $image = base64_decode($request->input('logo'));

            $imageName = rand(111111111, 999999999) . '.jpg';

            if (env('USE_S3')) {
                // save in s3
                Storage::disk('s3')->put($imageName, $image, 'public');
            } else if ($value) {
                // save in local
                Storage::disk('public')->put($imageName, $image, 'public');
            }

            $companyDTO['logo'] = $imageName;
        }

        return $this->apiResponse($this->repository->create($companyDTO));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->apiResponse($this->repository->find($id));
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
