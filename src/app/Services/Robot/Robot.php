<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 3:16 PM
 */

namespace App\Services\Robot;

use App\Contracts\Robot\AbstractRobot;
use App\Contracts\Robot\Source\AbstractSource;
use App\Contracts\Robot\State\AbstractState;
use App\Contracts\Robot\Command\IMotionCommand;
use App\Contracts\Robot\Source\ISource;
use App\Contracts\Robot\Iterator\AbstractAggregator;
use App\Services\Robot\Handler\HandlerContainer;
use App\Services\Robot\Iterator\CollectionAggregator;
use App\Services\Robot\State\LowBatteryState;
use App\Services\Robot\State\ReadyState;

class Robot extends AbstractRobot implements IMotionCommand
{
    private $battery;
    private $facing;
    private $coordinates;
    private $state;
    private $aggregates;
    private $status;

    public function init(AbstractSource $source)
    {
        $this->battery = null;
        $this->facing = null;
        $this->coordinates = null;
        $this->state = null;
        $this->aggregates = null;
        $this->status = null;
        app()->singleton(ReadyState::class, function ($app) {
            return new ReadyState($this);
        });
        app()->singleton(LowBatteryState::class, function ($app) {
            return new LowBatteryState($this);
        });
        $data = $source->getSource()->getData();
        $this->setAggregate('map')->getAggregate('map')->addItems($data['map']);
        $this->setCoordinates($data['start']['X'], $data['start']['Y']);
        $this->setFacing($data['start']['facing']);
        $this->setAggregate('commands')->getAggregate('commands')->addItems($data['commands']);
        $this->setBattery($data['battery']);

        $this->state = app(ReadyState::class);
    }

    public function setState(AbstractState $state)
    {
        $this->state = $state;
    }

    public function getState(): AbstractState
    {
        return $this->state;
    }

    public function getBattery()
    {
        return $this->battery;
    }

    public function setBattery($battery)
    {
        $this->battery = $battery;
        return $this;
    }

    public function launch()
    {
        $this->getAggregate('visited')->addItem(
            [
                'X'=>$this->getCoordinate('x'),
                'Y'=>$this->getCoordinate('y')
            ]
        );

        $commandsIterator = $this->getAggregate('commands')->getIterator();

        try {
            while($commandsIterator->valid()) {
                $cmd = strtoupper($commandsIterator->current());
                if (!defined('self::BOT_CMD_' . $cmd)) {
                    throw new Exception("Please check your commands, the: " . $cmd . " command does not exist");
                }
                call_user_func([$this->getState(), constant('self::BOT_CMD_' . $cmd)]);
                if ($cmd == 'A' && $this->getState()->robot->getStatus() == 'barrier') {
                    $this->getState()->onBackOff();
                }
                $commandsIterator->next();
            }
        } catch (Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }

        return [
            'visited' => $this->getAggregate('visited')->getItems(),
            'cleaned' => $this->getAggregate('cleaned')->getItems(),
            'final' => ['X' => $this->getCoordinate('x'), 'Y' => $this->getCoordinate('Y'), 'facing' => $this->getFacing()],
            'battery' => $this->getBattery()
        ];
    }

    public function getAggregate($name):AbstractAggregator
    {
        return (isset($this->aggregates[$name])?$this->aggregates[$name]:$this->setAggregate($name)->getAggregate($name));
    }

    public function getAggregates()
    {
        return $this->aggregates;
    }

    public function setAggregate($name)
    {
        if (!isset($this->aggregates[$name])) {
            $this->aggregates[$name] = app(CollectionAggregator::class);
        }
        return $this;
    }

    public function getFacing()
    {
        return $this->facing;
    }

    public function setFacing($facing)
    {
        $this->facing = $facing;
        return $this;
    }

    public function getCoordinate($coordinate)
    {
        return $this->coordinates[strtoupper($coordinate)];
    }

    public function getCoordinates()
    {
        return $this->coordinates;
    }

    public function setCoordinates($x, $y)
    {
        $this->coordinates = ['X'=>$x,'Y'=>$y];
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}