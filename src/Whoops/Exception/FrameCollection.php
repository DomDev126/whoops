<?php
/**
 * Whoops - php errors for cool kids
 * @author Filipe Dobreira <http://github.com/filp>
 */

namespace Whoops\Exception;
use Whoops\Exception\Frame;
use InvalidArgumentException;
use IteratorAggregate;
use ArrayIterator;
use Serializable;
use Countable;

/**
 * Mostly just implements iterator methods, the only
 * notable aspects is that it is read-only, and instantiates
 * Frame objects on demand.
 */
class FrameCollection implements IteratorAggregate, Serializable, Countable
{
    /**
     * @var array[]
     */
    private $frames;

    /**
     * @param array $frames
     */
    public function __construct(array $frames)
    {
        $this->frames = array_map(function($frame) {
            return new Frame($frame);
        }, $frames);
    }

    /**
     * Filters frames using a callable, returns the same FrameCollection
     * 
     * @param  callable $callable
     * @return Whoops\Exception\FrameCollection
     */
    public function filter($callable)
    {
        if(!is_callable($callable)) {
            throw new InvalidArgumentException(
                __METHOD__ . " expects a callable, like function($frame) { return bool; }"
            );
        }

        $this->frames = array_filter($this->frames, $callable);
        return $this;        
    }

    /**
     * @see IteratorAggregate::getIterator
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->frames);
    }

    /**
     * @see Countable::count
     * @return int
     */
    public function count()
    {
        return count($this->frames);
    }

    /**
     * @see Serializable::serialize
     * @return string
     */
    public function serialize()
    {
        return serialize($this->frames);
    }

    /**
     * @see Serializable::unserialize
     * @param string $serializedFrames
     */
    public function unserialize($serializedFrames)
    {
        $this->frames = unserialize($serializedFrames);
    }
}
