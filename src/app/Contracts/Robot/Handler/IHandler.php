<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 8:46 PM
 */

namespace App\Contracts\Robot\Handler;

use App\Contracts\Robot\State\AbstractState;

interface IHandler
{
    public function handle(AbstractState $state);
}