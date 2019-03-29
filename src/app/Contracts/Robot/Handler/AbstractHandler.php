<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/17/18
 * Time: 10:22 AM
 */

namespace App\Contracts\Robot\Handler;


use App\Contracts\Robot\State\AbstractState;

abstract class AbstractHandler implements IHandler
{
    protected $handlers = [];

    public function addHandler(IHandler $handler)
    {
        $this->handlers[] = $handler;
    }

    public abstract function handle(AbstractState $state);
}