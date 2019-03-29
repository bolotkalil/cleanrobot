<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/17/18
 * Time: 9:51 AM
 */

namespace App\Services\Robot\Iterator;

use App\Contracts\Robot\Iterator\AbstractAggregator;

class CollectionIterator implements \Iterator
{
    private $collection;
    private $position = 0;

    public function __construct(AbstractAggregator $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->collection->getItems()[$this->position];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return int
     * @since 5.0.0
     */
    public function next()
    {
        return $this->position++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->collection->getItems()[$this->position]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->position = 0;
    }
}