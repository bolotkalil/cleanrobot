<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/17/18
 * Time: 9:51 AM
 */

namespace App\Services\Robot\Handler;

use App\Contracts\Robot\Handler\AbstractHandler;
use App\Contracts\Robot\Handler\IHandler;
use App\Contracts\Robot\State\AbstractState;

class TL_B_TR_A_Handler implements IHandler
{
    public function handle(AbstractState $state)
    {
        $state->robot->getState()->onTurnLeft();
        $state->robot->getState()->onBack();
        $state->robot->getState()->onTurnRight();
        $state->robot->getState()->onAdvance();
        if ($state->robot->getStatus() == 'barrier') return true;
    }
}