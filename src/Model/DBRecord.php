<?php

namespace Lavi\Model;

use Lavi\Component\FlexibleObject;

class DBRecord extends FlexibleObject implements IDBRecord
{
    protected array $skipKeysInsert = [];
    protected array $skipKeysUpdate = [];

    public function __construct(array $data = array(), bool $isStrict = false)
    {
        parent::__construct($data);

        $this->initState();
    }
}