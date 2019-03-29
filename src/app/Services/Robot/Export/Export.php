<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 4:54 PM
 */

namespace App\Services\Robot\Export;

use App\Contracts\Robot\Export\AbstractExport;
use App\Contracts\Robot\Export\IExport;

class Export extends AbstractExport
{
    public function getExport()
    {
        return $this->export;
    }

    public function setExport(IExport $export)
    {
        $this->export = $export;
    }
}