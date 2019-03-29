<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 3:52 PM
 */

namespace App\Contracts\Robot\Space;

interface ICoordinates
{
    public function getCoordinate($coordinate);
    public function getCoordinates();
    public function setCoordinates($x, $y);
}