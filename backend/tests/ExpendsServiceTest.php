<?php
/**
 * Created by PhpStorm.
 * User: Oleg0x57
 * Date: 23.06.2019
 * Time: 16:04
 */

use App\services\ExpendsService;

class ExpendsServiceTest extends \PHPUnit\Framework\TestCase
{
    private $db;
    private $repository;
    /**
     * @var ExpendsService
     */
    private $service;
    private $data;

    public function setUp()
    {
        $this->data = require __DIR__ . '/fixtures/expends.php';
        $this->db = \ParagonIE\EasyDB\Factory::fromArray([
            'pgsql:host=localhost;port=5433;dbname=personal',
            'postgres',
            '123456'
        ]);
        $this->repository = new \App\repositories\ExpendsRepository($this->db);
        $this->repository->setTableName('expenses_test');
        $this->service = new \App\services\ExpendsService($this->repository);
        $this->db->run('CREATE TABLE IF NOT EXISTS expenses_test AS SELECT * FROM expenses;');
        $this->db->run('TRUNCATE expenses_test;');
        $this->db->run('ALTER TABLE public.expenses_test ADD CONSTRAINT expenses_test_pkey PRIMARY KEY(id);');
        $this->db->run('INSERT INTO expenses_test (id, type, contractor, details, date, sum) VALUES (' . implode('),(', array_map(function ($item) {
                return '\'' . implode('\',\'', $item) . '\'';
            }, $this->data)) . ');');
    }

    public function tearDown()
    {
        $this->repository = null;
        $this->service = null;
        $this->db->run('ALTER TABLE public.expenses_test DROP CONSTRAINT expenses_test_pkey;');
        $this->db->run('DROP TABLE public.expenses_test;');
        $this->db = null;
    }

    public function testOne()
    {
        $result = $this->service->one(12);
        $this->assertEquals([$this->data[2]], $result);
    }

    public function testDelete()
    {
        $result = $this->service->delete(12);
        $this->assertEquals(['message' => 'success'], $result);
    }

    public function testCreate()
    {
        $data = [
            'type' => 'расход',
            'contractor' => 'себе',
            'details' => 'обед',
            'date' => '2019-06-23',
            'sum' => '100.00',
        ];
        $result = $this->service->create($data);
        $this->assertEquals(['message' => 'success'], $result);
        $lastId = $this->db->run('SELECT MAX(id) FROM expenses_test');
        $lastItem = $this->service->one($lastId);
        $this->assertEquals([$data], $lastItem);
    }

    public function testList()
    {
        $result = $this->service->list();
        $this->assertEquals($this->data, $result);
    }

    public function testUpdate()
    {
        $data = [
            'id' => '12',
            'type' => 'расход',
            'contractor' => 'себе',
            'details' => 'обед',
            'date' => '2019-06-23',
            'sum' => '100.00',
        ];
        $result = $this->service->update($data);
        $this->assertEquals(['message' => 'success'], $result);
        $result = $this->service->one(12);
        $this->assertEquals([$data], $result);
    }
}
