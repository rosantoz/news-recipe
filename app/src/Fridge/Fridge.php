<?php

namespace Fridge;

use Items;

class Fridge
{
    protected $items;

    public function __construct(Items $items)
    {
        $this->items = $items;
    }

    
} 