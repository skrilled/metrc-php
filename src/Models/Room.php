<?php

namespace MetrcApi\Models;

class Room extends ApiObject
{
    /**
     * @var int
     */
    public $id = null;

    /**
     * @var string
     */
    public $name;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'Id' => $this->id,
            'Name' => $this->name
        ];
    }
}