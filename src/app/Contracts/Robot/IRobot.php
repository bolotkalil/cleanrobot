<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 3:52 PM
 */

namespace App\Contracts\Robot;

use App\Contracts\Robot\Space\IFacing;
use App\Contracts\Robot\Space\ICoordinates;
use App\Contracts\Robot\Iterator\IAggregate;
use App\Contracts\Robot\State\AbstractState;
use App\Contracts\Robot\Energy\IBattery;

interface IRobot extends IBattery, IAggregate, IFacing, ICoordinates
{
    public function setState(AbstractState $state);
    public function getState(): AbstractState;
    public function launch();
    public function getStatus();
    public function setStatus($status);
}