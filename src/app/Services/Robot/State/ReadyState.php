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
use App\Services\Robot\Handler;

class ReadyState extends AbstractState
{
    private $cleaned;
    private $map;
    private $visited;
    private $backOffHandlerContainer;

    public function __construct(AbstractRobot $robot)
    {
        parent::__construct($robot);
        $this->cleaned = $this->robot->getAggregate('cleaned');
        $this->map = $this->robot->getAggregate('map');
        $this->visited = $this->robot->getAggregate('visited');
    }

    public function onAdvance()
    {
        $batteryLoss = 2;
        if($this->robot->getBattery() < $batteryLoss) {
            return $this->robot->setState(app(LowBatteryState::class));
        }
        $this->robot->setBattery($this->robot->getBattery() - $batteryLoss);
        $x = $this->robot->getCoordinate('X');
        $y = $this->robot->getCoordinate('Y');
        switch ($this->robot->getFacing()) {
            case 'N':
                $y--;
                break;
            case 'E':
                $x++;
                break;
            case 'S':
                $y++;
                break;
            case 'W':
                $x--;
                break;
        }
        $this->setVisitedPlace($x, $y);
    }

    public function onBack()
    {
        $batteryLoss = 3;
        if($this->robot->getBattery() < $batteryLoss) {
            return $this->robot->setState(app(LowBatteryState::class));
        }
        $this->robot->setBattery($this->robot->getBattery() - $batteryLoss);
        $x = $this->robot->getCoordinate('X');
        $y = $this->robot->getCoordinate('Y');
        switch ($this->robot->getFacing()) {
            case 'N':
                $y++;
                break;
            case 'E':
                $x--;
                break;
            case 'S':
                $y--;
                break;
            case 'W':
                $x++;
                break;
        }
        $this->setVisitedPlace($x, $y);
    }

    public function onTurnRight()
    {
        $batteryLoss = 1;
        if($this->robot->getBattery() < $batteryLoss) {
            return $this->robot->setState(app(LowBatteryState::class));
        }
        $this->robot->setBattery($this->robot->getBattery() - $batteryLoss);
        $index = array_flip($this->robot->directions)[$this->robot->getFacing()] + 1;
        $this->robot->setFacing($this->robot->directions[$index % count($this->robot->directions)]);
    }

    public function onTurnLeft()
    {
        $batteryLoss = 1;

        if($this->robot->getBattery() < $batteryLoss) {
            return $this->robot->setState(app(LowBatteryState::class));
        }

        $this->robot->setBattery($this->robot->getBattery() - $batteryLoss);

        $index = array_flip($this->robot->directions)[$this->robot->getFacing()] + (count($this->robot->directions) - 1);
        $this->robot->setFacing($this->robot->directions[$index % count($this->robot->directions)]);
    }

    public function onClean()
    {
        $batteryLoss = 5;
        if($this->robot->getBattery() < $batteryLoss) {
            return $this->robot->setState(app(LowBatteryState::class));
        }

        $this->robot->setBattery($this->robot->getBattery() - $batteryLoss);
        $exist = false;
        $cleanedIterator = $this->cleaned->getIterator();
        while ($cleanedIterator->valid()) {
            if ($this->robot->getCoordinate('X') == $cleanedIterator->current()['X']
                && $this->robot->getCoordinate('Y') == $cleanedIterator->current()['Y']
            ) {
                $exist = true;
                break;
            }
            $cleanedIterator->next();
        }
        if (! $exist) $this->cleaned->addItem(
            [
                'X'=>$this->robot->getCoordinate('x'),
                'Y'=>$this->robot->getCoordinate('y')
            ]
        );
    }

    private function setVisitedPlace($x, $y)
    {
        if( $y >= 0 &&
            $y < count($this->map->getItems()) &&
            $x >= 0 &&
            $x < count($this->map->getValueByIndex($y)) &&
            $this->map->getValueByIndex($y)[$x] == 'S'
        ) {
            $this->robot->setStatus('ok');
            $this->robot->setCoordinates($x, $y);
            $exist = false;
            $visitedIterator = $this->visited->getIterator();
            while ($visitedIterator->valid()) {
                if ($visitedIterator->current()['X'] == $x && $visitedIterator->current()['Y'] == $y) {
                    $exist = true;
                }
                $visitedIterator->next();
            }
            if (!$exist) $this->visited->addItem(
                [
                    'X'=>$this->robot->getCoordinate('X'),
                    'Y'=>$this->robot->getCoordinate('Y')
                ]
            );
        } else {
            $this->robot->setStatus('barrier');
        }
    }

    public function onBackOff()
    {
        $this->backOffHandlerContainer = app(Handler\HandlerContainer::class);
        $this->backOffHandlerContainer->addHandler(app(Handler\TR_A_Handler::class));
        $this->backOffHandlerContainer->addHandler(app(Handler\TL_B_TR_A_Handler::class));
        $this->backOffHandlerContainer->addHandler(app(Handler\TL_TL_A_Handler::class));
        $this->backOffHandlerContainer->addHandler(app(Handler\TR_B_TR_A_Handler::class));
        $this->backOffHandlerContainer->addHandler(app(Handler\TL_TL_A_Handler::class));
        $this->backOffHandlerContainer->handle($this);
    }
}
