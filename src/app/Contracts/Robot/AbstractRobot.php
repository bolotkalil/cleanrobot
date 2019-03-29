<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 3:24 PM
 */

namespace App\Contracts\Robot;

use App\Contracts\Robot\Source\AbstractSource;

abstract class AbstractRobot implements IRobot
{
    public $directions = ['N', 'E', 'S', 'W'];
    public abstract function init(AbstractSource $source);
}