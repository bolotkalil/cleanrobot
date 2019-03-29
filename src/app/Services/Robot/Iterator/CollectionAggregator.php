<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/17/18
 * Time: 9:51 AM
 */

namespace App\Services\Robot\Iterator;


use App\Contracts\Robot\Iterator\AbstractAggregator;
use Iterator;
use Traversable;

class CollectionAggregator extends AbstractAggregator
{
    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator(): Iterator
    {
        return app()->instance(CollectionIterator::class, new CollectionIterator($this));
    }
}