<?php
/**
 * Created by PhpStorm.
 * User: Oleg0x57
 * Date: 23.06.2019
 * Time: 11:34
 */

namespace App\api;


use App\services\ExpendsService;

class ExpendsApiController
{
    /**
     * @var ExpendsService
     */
    protected $service;

    public function __construct(ExpendsService $service)
    {
        $this->service = $service;
    }

    public function respond($method, $id, $params)
    {
        if (isset($id)) {
            switch ($method) {
                case 'GET':
                    $result = $this->service->one($id);
                    break;
                case'PUT':
                    if (empty($params['id'])) {
                        $params['id'] = $id;
                    }
                    $result = $this->service->update($params);
                    break;
                case 'DELETE':
                    $result = $this->service->delete($id);
                    break;
                default:
                    $result = null;
                    break;
            }
        } else {
            switch ($method) {
                case 'GET':
                    $result = $this->service->list();
                    break;
                case'POST':
                    $result = $this->service->create($params);
                    break;
                default:
                    $result = null;
                    break;
            }
        }
        return $result;
    }
}