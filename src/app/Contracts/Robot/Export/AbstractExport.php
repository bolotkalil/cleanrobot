<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 4:47 PM
 */

namespace App\Contracts\Robot\Export;

use App\Contracts\Robot\Export\IExport;

abstract class AbstractExport
{
    protected $export;
    public abstract function getExport();
    public abstract function setExport(IExport $export);
}