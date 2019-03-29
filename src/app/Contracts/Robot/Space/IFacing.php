<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 3:52 PM
 */

namespace App\Contracts\Robot\Space;

interface IFacing
{
    public function getFacing();
    public function setFacing($facing);
}