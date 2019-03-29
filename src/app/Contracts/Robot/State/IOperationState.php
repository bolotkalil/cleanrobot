<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 8:46 PM
 */

namespace App\Contracts\Robot\State;

interface IOperationState
{
    public function onClean();
    public function onBackOff();
}