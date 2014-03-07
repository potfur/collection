<?php
namespace Common\Collection;

interface ISample
{
}

class Sample implements iSample
{
}

class ExtSample extends Sample
{
}

class SampleCollection extends Collection
{
    public function __construct(array $collection = array(), $instanceOf = null)
    {
        $this->exchangeArray($collection);
        $this->instanceOf = $instanceOf;
    }
}

class CollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider elementProvider
     */
    public function testPrependUnrestricted($element)
    {
        $existing = new Sample();
        $collection = new SampleCollection(array($existing));
        $collection->prepend($element);
        $this->assertEquals(array($element, $existing), $collection->getArrayCopy());
    }

    /**
     * @dataProvider elementProvider
     */
    public function testPrepend($element)
    {
        $existing = new Sample();
        $collection = new SampleCollection(array($existing), '\Common\Collection\iSample');
        $collection->prepend($element);
        $this->assertEquals(array($element, $existing), $collection->getArrayCopy());
    }

    /**
     * @expectedException \Common\Collection\CollectionException
     * @expectedExceptionMessage Element in collection Common\Collection\SampleCollection must be instance of \ArrayAccess
     * @dataProvider elementProvider
     */
    public function testPrependInvalidInstance($element)
    {
        $existing = new Sample();
        $collection = new SampleCollection(array($existing), '\ArrayAccess');
        $collection->prepend($element);
    }

    /**
     * @dataProvider elementProvider
     */
    public function testAppendUnrestricted($element)
    {
        $existing = new Sample();
        $collection = new SampleCollection(array($existing));
        $collection->append($element);
        $this->assertEquals(array($existing, $element), $collection->getArrayCopy());
    }

    /**
     * @dataProvider elementProvider
     */
    public function testAppend($element)
    {
        $existing = new Sample();
        $collection = new SampleCollection(array($existing), '\Common\Collection\iSample');
        $collection->append($element);
        $this->assertEquals(array($existing, $element), $collection->getArrayCopy());
    }

    /**
     * @expectedException \Common\Collection\CollectionException
     * @expectedExceptionMessage Element in collection Common\Collection\SampleCollection must be instance of \ArrayAccess
     * @dataProvider elementProvider
     */
    public function testAppendInvalidInstance($element)
    {
        $existing = new Sample();
        $collection = new SampleCollection(array($existing), '\ArrayAccess');
        $collection->append($element);
    }

    /**
     * @dataProvider elementProvider
     */
    public function testInsertUnrestricted($element)
    {
        $existingA = new Sample();
        $existingB = new Sample();
        $collection = new SampleCollection(array($existingA, $existingB));
        $collection->insert(1, $element);
        $this->assertEquals(array($existingA, $element, $existingB), $collection->getArrayCopy());
    }

    /**
     * @dataProvider elementProvider
     */
    public function testInsert($element)
    {
        $existingA = new Sample();
        $existingB = new Sample();
        $collection = new SampleCollection(array($existingA, $existingB), '\Common\Collection\iSample');
        $collection->insert(1, $element);
        $this->assertEquals(array($existingA, $element, $existingB), $collection->getArrayCopy());
    }

    /**
     * @expectedException \Common\Collection\CollectionException
     * @expectedExceptionMessage Element in collection Common\Collection\SampleCollection must be instance of \ArrayAccess
     * @dataProvider elementProvider
     */
    public function testInsertInvalidInstance($element)
    {
        $existing = new Sample();
        $collection = new SampleCollection(array($existing), '\ArrayAccess');
        $collection->insert(1, $element);
    }

    public function elementProvider()
    {
        return array(
            array(new Sample()),
            array(new ExtSample()),
        );
    }

    public function testMerge()
    {
        $this->markTestIncomplete();
    }

    public function testMergeUnrestricted()
    {
        $this->markTestIncomplete();
    }

    /**
     * @expectedException \Common\Collection\CollectionException
     * @expectedExceptionMessage Element in collection Common\Collection\SampleCollection must be instance of \ArrayAccess
     * @dataProvider collectionProvider
     */
    public function testMergeInvalidInstance()
    {
        $this->markTestIncomplete();
    }

    public function testSplit()
    {
        $this->markTestIncomplete();
    }

    public function testSlice()
    {
        $this->markTestIncomplete();
    }

    public function collectionProvider()
    {
        return array(
            array(array(new Sample(), new Sample())),
            array(array(new Sample(), new ExtSample())),
            array(array(new ExtSample(), new Sample())),
            array(array(new ExtSample(), new ExtSample())),
        );
    }
}
 