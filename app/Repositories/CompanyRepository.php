<?php

namespace App\Repositories;

use App\Models\Company;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompanyRepository implements CompanyRepositoryInterface
{
    protected $model;

    /**
     * CompanyRepository constructor.
     *
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        $this->model = $company;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->where('id', $id)
            ->update($data);
    }

    public function delete($id)
    {
        // delete all employees by company
        $this->model->find($id)->employees()->delete();
        // delete company
        return $this->model->destroy($id);
    }

    public function find($id)
    {
        if (null == $company = $this->model->find($id)) {
            throw new ModelNotFoundException("Company not found");
        }

        return $company;
    }
}
