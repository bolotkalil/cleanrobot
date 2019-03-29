<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/17/18
 * Time: 4:12 PM
 */

namespace App\Contracts\Robot\Command;


interface IMotionCommand
{
    const BOT_CMD_TR = 'onTurnRight';
    const BOT_CMD_TL = 'onTurnLeft';
    const BOT_CMD_A  = 'onAdvance';
    const BOT_CMD_C  = 'onClean';
}