<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 4:47 PM
 */

namespace App\Contracts\Robot\Source;

abstract class AbstractSource
{
    protected $source;
    public abstract function getSource();
    public abstract function setSource(ISource $source);
}