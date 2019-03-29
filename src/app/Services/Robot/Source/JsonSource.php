<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/16/18
 * Time: 4:54 PM
 */

namespace App\Services\Robot\Source;

use App\Contracts\Robot\Source\ISource;
use Exception;

class JsonSource implements ISource
{
    private $data;

    public function getData():array
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = json_decode($data, true);
        if (!$this->data) {
            throw new Exception("Oops the source file cannot be parsed");
        }
    }

    public function isValid()
    {
        //todo::it written fast(there is no time) need improve validation code without too many conditions
        if (!isset($this->data['map'])) {
            throw new Exception("Please provide map section");
        }

        if (!isset($this->data['start']) ||
            !isset($this->data['start']['X']) ||
            !isset($this->data['start']['Y']) ||
            !isset($this->data['start']['facing'])
        ) {
            throw new Exception("Please provide start section with subsections");
        }

        if (!isset($this->data['commands'])) {
            throw new Exception("Please provide commands section");
        }

        if (!isset($this->data['battery'])) {
            throw new Exception("Please provide battery section");
        }
    }
}