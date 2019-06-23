<?php
/**
 * Created by PhpStorm.
 * User: Oleg0x57
 * Date: 23.06.2019
 * Time: 13:06
 */

namespace App\models;


class Expends
{
    private $id;
    private $type;
    private $contractor;
    private $details;
    private $date;
    private $sum;

    public function __construct($id, $type, $contractor, $details, $date, $sum)
    {
        $this->id = $id;
        $this->type = $type;
        $this->contractor = $contractor;
        $this->details = $details;
        $this->date = $date;
        $this->sum = $sum;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getContractor()
    {
        return $this->contractor;
    }

    /**
     * @param mixed $contractor
     */
    public function setContractor($contractor): void
    {
        $this->contractor = $contractor;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     */
    public function setDetails($details): void
    {
        $this->details = $details;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param mixed $sum
     */
    public function setSum($sum): void
    {
        $this->sum = $sum;
    }
}