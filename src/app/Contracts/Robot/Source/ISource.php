<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 4:47 PM
 */

namespace App\Contracts\Robot\Source;

interface ISource
{
    public function getData():array;
    public function setData($data);
    public function isValid();
}