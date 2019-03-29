<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 3:46 PM
 */

namespace App\Services\Robot\State;

use App\Contracts\Robot\AbstractRobot;
use App\Contracts\Robot\State\AbstractState;

class LowBatteryState extends AbstractState
{

    public function __construct(AbstractRobot $robot)
    {
        parent::__construct($robot);
    }

    public function onAdvance()
    {
        // TODO: Implement onAdvance() method.
    }

    public function onBack()
    {
        // TODO: Implement onBack() method.
    }

    public function onTurnRight()
    {
        // TODO: Implement onTurnRight() method.
    }

    public function onTurnLeft()
    {
        // TODO: Implement onTurnLeft() method.
    }

    public function onClean()
    {
        // TODO: Implement onClean() method.
    }

    public function onBackOff()
    {
        // TODO: Implement onOvercome() method.
    }
}