<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 4:54 PM
 */

namespace App\Services\Robot\Source;

use App\Contracts\Robot\Source\AbstractSource;
use App\Contracts\Robot\Source\ISource;

class Source extends AbstractSource
{
    public function getSource()
    {
        return $this->source;
    }

    public function setSource(ISource $source)
    {
        $this->source = $source;
    }
}