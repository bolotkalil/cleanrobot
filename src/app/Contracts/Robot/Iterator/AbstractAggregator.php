<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/17/18
 * Time: 10:22 AM
 */

namespace App\Contracts\Robot\Iterator;

use Iterator;
use IteratorAggregate;

abstract class AbstractAggregator implements IteratorAggregate
{
    private $items = [];

    public function getItems()
    {
        return $this->items;
    }

    public function addItem($item)
    {
        $this->items[] = $item;
    }

    public function addItems($items)
    {
        $this->items = $items;
    }

    public function getValueByIndex($index)
    {
        return (isset($this->items[$index])?$this->items[$index]:null);
    }

    public function getIndexByValue($value)
    {
        return array_search(strtoupper($value), $this->items);
    }
}