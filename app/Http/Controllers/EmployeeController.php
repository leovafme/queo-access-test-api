<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EmployeeRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    private $repository;

    private $rules = [
        'first_name' => 'required|max:60',
        'last_name' => 'required|max:60',
        'email' => 'required|email|max:60|unique:employees',
        'phone' => 'nullable|max:60',
        'company_id' => 'required|exists:companies,id',
    ];

    public function __construct(EmployeeRepositoryInterface $repository)
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

        $inputDTO = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'company_id' => $request->input('company_id'),
        ];

        return $this->apiResponse($this->repository->create($inputDTO));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->apiResponse($this->repository->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->apiResponse($this->repository->delete($id));
    }
}
