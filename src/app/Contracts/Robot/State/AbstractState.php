<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 3:24 PM
 */

namespace App\Contracts\Robot\State;

use App\Contracts\Robot\AbstractRobot;
use App\Contracts\Robot\State\IOperationState;

abstract class AbstractState implements IOperationState
{
    public $robot;
    public function __construct(AbstractRobot $robot)
    {
        $this->robot = $robot;
    }

    public abstract function onAdvance();
    public abstract function onBack();
    public abstract function onTurnRight();
    public abstract function onTurnLeft();
}