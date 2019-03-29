<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/17/18
 * Time: 9:51 AM
 */

namespace App\Services\Robot\Handler;

use App\Contracts\Robot\Handler\AbstractHandler;
use App\Contracts\Robot\State\AbstractState;

class HandlerContainer extends AbstractHandler
{
    public function handle(AbstractState $state)
    {
        foreach ($this->handlers as $handler) {
            $canNext = $handler->handle($state);
            if ($canNext == false || $canNext == null) break;
        }
    }
}