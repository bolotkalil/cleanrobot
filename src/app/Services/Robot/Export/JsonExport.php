<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 4:54 PM
 */

namespace App\Services\Robot\Export;

use App\Contracts\Robot\Export\IExport;

class JsonExport implements IExport
{
    private $data;

    public function setData($data)
    {
        $this->data = json_encode($data);
        if (!$this->data) {
            throw new Exception("Oops the source file cannot be parsed");
        }
    }

    public function exportData()
    {
        return $this->data;
    }
}