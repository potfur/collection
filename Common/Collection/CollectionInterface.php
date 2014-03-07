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
 * Collection interface
 *
 * @author  Michal Wachowski <wachowski.michal@gmail.com>
 * @package Common\Collection
 */
interface CollectionInterface extends \ArrayAccess, \Iterator, \Countable, \Serializable
{

    /**
     * Adds value to the front of collection
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function prepend($value);

    /**
     * Adds value to the end of collection
     *
     * @param $value
     *
     * @return $this
     */
    public function append($value);

    /**
     * Adds value to collection at given offset or at end if shorter
     *
     * @param int   $offset
     * @param mixed $value
     *
     * @return $this
     */
    public function insert($offset, $value);

    /**
     * Merges one or more collections together
     *
     * @param array|\ArrayObject|CollectionInterface $collection
     *
     * @return $this
     */
    public function merge($collection);

    /**
     * Splits collections into instances of set length
     *
     * @param int  $size
     * @param bool $preserveKeys
     *
     * @return array
     */
    public function split($size, $preserveKeys = false);

    /**
     * Returns collection chunk from set offset and set length
     *
     * @param int      $offset
     * @param null|int $length
     * @param bool     $preserveKeys
     *
     * @return array
     */
    public function slice($offset, $length = null, $preserveKeys = false);

    /**
     * Exchanges current collection with new one
     * Returns old collection
     *
     * @param array|\ArrayObject|CollectionInterface $collection
     *
     * @return array
     */
    public function exchangeArray($collection);

    /**
     * Returns collection content as an array
     *
     * @return array
     */
    public function getArrayCopy();

    /**
     * Returns number of elements in collection
     *
     * @return int
     */
    public function count();

    /**
     * Sorts collection preserving keys
     *
     * @return $this
     */
    public function asort();

    /**
     * Sorts collection preserving keys
     * Reversed
     *
     * @return $this
     */
    public function arsort();

    /**
     * Sorts by keys
     */
    public function ksort();

    /**
     * Sorts by keys
     * Reversed
     *
     * @return $this
     */
    public function krsort();

    /**
     * Sorts array using callable
     *
     * @param callable $function
     *
     * @return $this
     */
    public function usort(callable $function);

    /**
     * Sorts array using callable preserving keys
     *
     * @param callable $function
     *
     * @return $this
     */
    public function uasort(callable $function);

    /**
     * Sorts array by keys using callable
     *
     * @param callable $function
     *
     * @return $this
     */
    public function uksort(callable $function);
}
