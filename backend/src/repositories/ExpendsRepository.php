<?php
/**
 * Created by PhpStorm.
 * User: Oleg0x57
 * Date: 23.06.2019
 * Time: 11:36
 */

namespace App\repositories;


use App\models\Expends;
use ParagonIE\EasyDB\EasyDB;

class ExpendsRepository
{
    /**
     * @var string
     */
    private $tableName = 'expenses';
    /**
     * @var EasyDB
     */
    private $db;

    public function __construct(EasyDB $db)
    {
        $this->db = $db;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     */
    public function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    public function getList()
    {
        return $this->db->run('SELECT * FROM ' . $this->tableName);
    }

    public function getById($id)
    {
        return $this->db->run('SELECT * FROM ' . $this->tableName . ' WHERE  id = ?', $id);
    }

    public function create(Expends $expends)
    {
        return $this->db->insert($this->tableName, [
            'type' => $expends->getType(),
            'contractor' => $expends->getContractor(),
            'details' => $expends->getDetails(),
            'date' => $expends->getDate(),
            'sum' => $expends->getSum(),
        ]);
    }

    public function update(Expends $expends)
    {
        return $this->db->update($this->tableName, [
            'type' => $expends->getType(),
            'contractor' => $expends->getContractor(),
            'details' => $expends->getDetails(),
            'date' => $expends->getDate(),
            'sum' => $expends->getSum(),
        ], [
            'id' => $expends->getId()
        ]);
    }

    public function delete(int $id)
    {
        return $this->db->delete($this->tableName, [
            'id' => $id
        ]);
    }
}