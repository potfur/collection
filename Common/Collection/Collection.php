<?php

/*
* This file is part of the Storage package
*
* (c) Michal Wachowski <wachowski.michal@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Common\Collection;

/**
 * Collection
 *
 * @author  Michal Wachowski <wachowski.michal@gmail.com>
 * @package Common\Collection
 */
abstract class Collection implements CollectionInterface
{

    protected $collection = array();
    protected $instanceOf;

    /**
     * Adds value to the front of collection
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function prepend($value)
    {
        $this->assertInstanceOf($value);
        array_unshift($this->collection, $value);

        return $this;
    }

    /**
     * Adds value to the end of collection
     *
     * @param $value
     *
     * @return $this
     */
    public function append($value)
    {
        $this->assertInstanceOf($value);
        array_push($this->collection, $value);

        return $this;
    }

    /**
     * Adds value to collection at given offset or at end if shorter
     *
     * @param int   $offset
     * @param mixed $value
     *
     * @return $this
     */
    public function insert($offset, $value)
    {
        $this->assertInstanceOf($value);
        array_splice($this->collection, $offset, 0, array($value));

        return $this;
    }

    /**
     * Merges one or more collections together
     *
     * @param array|\ArrayObject|CollectionInterface $collection
     *
     * @return $this
     */
    public function merge($collection)
    {
        foreach (func_get_args() as $collection) {
            $collection = $this->getAsArray($collection);

            $this->assertInstanceOf($collection);

            $this->collection = array_merge($this->collection, $collection);
        }

        return $this;
    }

    /**
     * Splits collections into instances of set length
     *
     * @param int  $size
     * @param bool $preserveKeys
     *
     * @return array
     */
    public function split($size, $preserveKeys = false)
    {
        $result = array();
        foreach (array_chunk($this->collection, $size, $preserveKeys) as $collection) {
            $result[] = new static($collection);
        }

        return $result;
    }

    /**
     * Joins collection elements into string
     *
     * @param string $glue
     *
     * @return string
     */
    public function join($glue = null)
    {
        $collection = $this->collection;
        array_walk($collection, function ($node) { return (string) $node; });

        return implode($glue, $collection);
    }

    /**
     * Returns collection chunk from set offset and set length
     *
     * @param int      $offset
     * @param null|int $length
     * @param bool     $preserveKeys
     *
     * @return array
     */
    public function slice($offset, $length = null, $preserveKeys = false)
    {
        return array_slice($this->collection, $offset, $length, $preserveKeys);
    }

    /**
     * Exchanges current collection with new one
     * Returns old collection
     *
     * @param array|\ArrayObject|CollectionInterface $collection
     *
     * @return array
     */
    public function exchangeArray($collection)
    {
        $collection = $this->getAsArray($collection);

        $this->assertInstanceOf($collection);

        $old = $this->collection;
        $this->collection = $collection;

        return $old;
    }

    protected function getAsArray($collection)
    {
        if ($collection instanceof \ArrayObject) {
            $collection = $collection->getArrayCopy();
        }

        return $collection;
    }

    protected function assertInstanceOf($element)
    {
        $instanceOf = $this->instanceOf;

        if (!$instanceOf) {
            return;
        }

        if (is_array($element)) {
            foreach ($element as $e) {
                $this->assertInstanceOf($e);
            }

            return;
        }

        if ($element instanceof $instanceOf) {
            return;
        }

        throw new CollectionException(sprintf('Element in collection %s must be instance of %s', get_class($this), $instanceOf));
    }

    /**
     * Returns collection content as an array
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return $this->collection;
    }

    /**
     * Sorts collection preserving keys
     *
     * @return $this
     */
    public function asort()
    {
        asort($this->collection);

        return $this;
    }

    /**
     * Sorts collection preserving keys
     * Reversed
     *
     * @return $this
     */
    public function arsort()
    {
        arsort($this->collection);

        return $this;
    }

    /**
     * Sorts by keys
     */
    public function ksort()
    {
        ksort($this->collection);

        return $this;
    }

    /**
     * Sorts by keys
     * Reversed
     *
     * @return $this
     */
    public function krsort()
    {
        krsort($this->collection);

        return $this;
    }

    /**
     * Sorts array using callable
     *
     * @param callable $function
     *
     * @return $this
     */
    public function usort(callable $function)
    {
        usort($this->collection, $function);

        return $this;
    }

    /**
     * Sorts array using callable preserving keys
     *
     * @param callable $function
     *
     * @return $this
     */
    public function uasort(callable $function)
    {
        uasort($this->collection, $function);

        return $this;
    }

    /**
     * Sorts array by keys using callable
     *
     * @param callable $function
     *
     * @return $this
     */
    public function uksort(callable $function)
    {
        uksort($this->collection, $function);

        return $this;
    }

    // Countable

    /**
     * Returns number of elements in collection
     *
     * @return int
     */
    public function count()
    {
        return count($this->collection);
    }

    // ArrayAccess

    /**
     * Whether a offset exists
     *
     * @param mixed $offset
     *
     * @return bool true on success or false on failure.
     */
    public function offsetExists($offset)
    {
        return array_key_exists($this->collection, $offset);
    }

    /**
     * Offset to retrieve
     *
     * @param mixed $offset
     *
     * @return mixed
     * @throws CollectionException
     */
    public function & offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new CollectionException('Requested offset does not exists');
        }

        return $this->collection[$offset];
    }

    /**
     * Offset to set
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->assertInstanceOf($value);

        if ($offset === null) {
            $this->append($value);

            return;
        }

        $this->collection[$offset] = $value;

        return;
    }

    /**
     * Offset to unset
     *
     * @param mixed $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        if (!$this->offsetExists($offset)) {
            return;
        }

        unset($this->collection[$offset]);
    }

    // Iterator

    /**
     * Return the current element
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->collection);
    }

    /**
     * Move forward to next element
     */
    public function next()
    {
        next($this->collection);
    }

    /**
     * Return the key of the current element
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->collection);
    }

    /**
     * Checks if current position is valid
     *
     * @return bool
     */
    public function valid()
    {
        return $this->offsetExists(key($this->collection));
    }

    /**
     * Rewind the Iterator to the first element
     */
    public function rewind()
    {
        reset($this->collection);
    }

    // Serializable

    /**
     * Serializes to string representation of object
     *
     * @return string
     */
    public function serialize()
    {
        return serialize(array($this->collection, $this->instanceOf));
    }

    /**
     * Unserializes the object
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list($this->collection, $this->instanceOf) = unserialize($serialized);
    }
}