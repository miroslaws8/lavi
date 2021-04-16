<?php

namespace Lavi\Model\Extensions;

trait DBStatefulTrait
{
    private $state;

    public function initState()
    {
        $this->state = new DBRecordState();
        $this->state->setUninitialized();
    }

    public function getState(): DBRecordState
    {
        return $this->state;
    }
}