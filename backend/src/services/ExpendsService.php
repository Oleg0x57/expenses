<?php
/**
 * Created by PhpStorm.
 * User: Oleg0x57
 * Date: 23.06.2019
 * Time: 11:35
 */

namespace App\services;


use App\models\Expends;
use App\repositories\ExpendsRepository;

class ExpendsService
{
    /**
     * @var ExpendsRepository
     */
    private $repository;

    public function __construct(ExpendsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($data)
    {
        $expends = new Expends(null, $data['type'], $data['contractor'], $data['details'], $data['date'], $data['sum']);
        if ($this->repository->create($expends)) {
            $result = ['message' => 'success'];
        } else {
            $result = ['error' => true];
        }
        return $result;
    }

    public function update($data)
    {
        $expends = new Expends($data['id'], $data['type'], $data['contractor'], $data['details'], $data['date'], $data['sum']);
        if ($this->repository->update($expends)) {
            $result = ['message' => 'success'];
        } else {
            $result = ['error' => true];
        }
        return $result;
    }

    public function one(int $id)
    {
        return $this->repository->getById($id);
    }

    public function list()
    {
        return $this->repository->getList();
    }

    public function delete(int $id)
    {
        if ($this->repository->delete($id)) {
            $result = ['message' => 'success'];
        } else {
            $result = ['error' => true];
        }
        return $result;
    }
}