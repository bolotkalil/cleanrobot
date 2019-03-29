<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 8:46 PM
 */

namespace App\Contracts\Robot\Iterator;

use App\Contracts\Robot\Iterator\AbstractAggregator;

interface IAggregate
{
    public function getAggregate($name):AbstractAggregator;
    public function getAggregates();
    public function setAggregate($name);
}