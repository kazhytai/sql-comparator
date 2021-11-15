<?php
/**
 * @note         Тестирование валидации операторов
 * @copyright    Copyright © Real Time Engineering, LLP - All Rights Reserved
 * @license      Proprietary and confidential
 * Unauthorized copying or using of this file, via any medium is strictly prohibited.
 * Content can not be copied and/or distributed without the express permission of Real Time Engineering, LLP
 * @author       Written by Kuatbek Kazhytai <kkazhytai@mp.kz>, сентябрь 2021
 */

declare(strict_types=1);

namespace MP\Tests\ServicesTests\CommonService;

use DateInterval;
use DateTime;
use Kazhytai\SQLComparator\SqlComparator\ComparatorException;
use Kazhytai\SQLComparator\SqlComparator\Eq;
use Kazhytai\SQLComparator\SqlComparator\Ge;
use Kazhytai\SQLComparator\SqlComparator\Gt;
use Kazhytai\SQLComparator\SqlComparator\Is;
use Kazhytai\SQLComparator\SqlComparator\IsNot;
use Kazhytai\SQLComparator\SqlComparator\Le;
use Kazhytai\SQLComparator\SqlComparator\Lt;
use Kazhytai\SQLComparator\SqlComparator\Ne;
use SqlComparator\TestEntity;
use PHPUnit\Framework\TestCase;
use Throwable;
use TypeError;

class SqlOperatorsTest extends TestCase
{
    const VALUE_NUMERIC = "11111111.111111111";
    const VALUE_NUMERIC_2 = "2222222222222.222222222";
    const VALUE_INT = 10;
    const VALUE_INT_2 = 15;
    const VALUE_FLOAT = 1.1;
    const VALUE_FLOAT_2 = 125.2;
    const VALUE_STRING = "abc";
    const VALUE_STRING_2 = "cdf";
    /** @var DateTime */
    protected $dateTime;
    /** @var DateTime */
    protected $newDateTime;
    /** @var TestEntity объект который будем передавать в операторы */
    protected $entity;
    /** @var int[] массив который будем передавать в операторы */
    protected $array;


    /**
     * SqlOperatorsTest constructor.
     * @param string|null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->entity = new TestEntity();
        $this->dateTime = new DateTime("2019-12-12 10:48:33");
        $this->newDateTime = $this->dateTime->add(new DateInterval("P10D"));
        $this->array = [1, 2, 3];
    }

    /**
     * @throws ComparatorException
     */
    public function testEqOperator()
    {
        //integer
        $comparator = new Eq(self::VALUE_INT);
        self::assertEquals(self::VALUE_INT, $comparator->getValue());

        $comparator->setValue(self::VALUE_INT_2);
        self::assertEquals(self::VALUE_INT_2, $comparator->getValue());

        //float
        $comparator = new Eq(self::VALUE_FLOAT);
        self::assertEquals(self::VALUE_FLOAT, $comparator->getValue());

        $comparator->setValue(self::VALUE_FLOAT_2);
        self::assertEquals(self::VALUE_FLOAT_2, $comparator->getValue());

        //string
        $comparator = new Eq(self::VALUE_STRING);
        self::assertEquals(self::VALUE_STRING, $comparator->getValue());

        $comparator->setValue(self::VALUE_STRING_2);
        self::assertEquals(self::VALUE_STRING_2, $comparator->getValue());

        //numeric & set null
        $comparator = new Eq(self::VALUE_NUMERIC);
        self::assertEquals(self::VALUE_NUMERIC, $comparator->getValue());

        $comparator->setValue(self::VALUE_NUMERIC_2);
        self::assertEquals(self::VALUE_NUMERIC_2, $comparator->getValue());

        $comparator->setValue(null);
        self::assertEquals(null, $comparator->getValue());

        //dateTime
        $comparator = new Eq($this->dateTime);
        self::assertEquals($this->dateTime, $comparator->getValue());

        $comparator->setValue($this->newDateTime);
        self::assertEquals($this->newDateTime, $comparator->getValue());

        //null
        $comparator = new Eq(null);
        self::assertEquals(null, $comparator->getValue());

        //bool
        $this->assertException(ComparatorException::class,
            function () {
                new Eq(false);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue(true);
            }
        );

        // не dateTime объект
        $this->assertException(ComparatorException::class,
            function () {
                new Eq($this->entity);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue($this->entity);
            }
        );

        //array
        $this->assertException(ComparatorException::class,
            function () {
                new Eq($this->array);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue($this->array);
            }
        );
    }

    /**
     * @throws ComparatorException
     */
    public function testNeOperator()
    {

        //integer
        $comparator = new Ne(self::VALUE_INT);
        self::assertEquals(self::VALUE_INT, $comparator->getValue());

        $comparator->setValue(self::VALUE_INT_2);
        self::assertEquals(self::VALUE_INT_2, $comparator->getValue());

        //float
        $comparator = new Ne(self::VALUE_FLOAT);
        self::assertEquals(self::VALUE_FLOAT, $comparator->getValue());

        $comparator->setValue(self::VALUE_FLOAT_2);
        self::assertEquals(self::VALUE_FLOAT_2, $comparator->getValue());

        //string
        $comparator = new Ne(self::VALUE_STRING);
        self::assertEquals(self::VALUE_STRING, $comparator->getValue());

        $comparator->setValue(self::VALUE_STRING_2);
        self::assertEquals(self::VALUE_STRING_2, $comparator->getValue());

        //numeric & null
        $comparator = new Ne(self::VALUE_NUMERIC);
        self::assertEquals(self::VALUE_NUMERIC, $comparator->getValue());

        $comparator->setValue(self::VALUE_NUMERIC_2);
        self::assertEquals(self::VALUE_NUMERIC_2, $comparator->getValue());

        $comparator->setValue(null);
        self::assertEquals(null, $comparator->getValue());

        //dateTime
        $comparator = new Ne($this->dateTime);
        self::assertEquals($this->dateTime, $comparator->getValue());

        $comparator->setValue($this->newDateTime);
        self::assertEquals($this->newDateTime, $comparator->getValue());

        //null
        $comparator = new Ne(null);
        self::assertEquals(null, $comparator->getValue());

        //bool
        $this->assertException(ComparatorException::class,
            function () {
                new Ne(false);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue(true);
            }
        );

        // не dateTime объект
        $this->assertException(ComparatorException::class,
            function () {
                new Ne($this->entity);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue($this->entity);
            }
        );

        //array
        $this->assertException(ComparatorException::class,
            function () {
                new Ne($this->array);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue($this->array);
            }
        );
    }

    public function testIsOperator()
    {
        //bool & null
        $comparator = new Is(null);
        self::assertNull($comparator->getValue());

        $comparator = new Is(true);
        self::assertTrue($comparator->getValue());

        $comparator->setValue(false);
        self::assertFalse($comparator->getValue());

        //null
        $comparator->setValue(null);
        self::assertNull($comparator->getValue());

        //int
        $this->assertException(TypeError::class,
            function () {
                new Is(self::VALUE_INT);
            }
        );
        $this->assertException(TypeError::class,
            function () use ($comparator) {
                $comparator->setValue(self::VALUE_INT);
            }
        );

        //float
        $this->assertException(TypeError::class,
            function () {
                new Is(self::VALUE_FLOAT);
            }
        );
        $this->assertException(TypeError::class,
            function () use ($comparator) {
                $comparator->setValue(self::VALUE_FLOAT);
            }
        );

        //string
        $this->assertException(TypeError::class,
            function () {
                new Is(self::VALUE_STRING);
            }
        );
        $this->assertException(TypeError::class,
            function () use ($comparator) {
                $comparator->setValue(self::VALUE_STRING);
            }
        );
        //numeric
        $this->assertException(TypeError::class,
            function () {
                new Is(self::VALUE_NUMERIC);
            }
        );
        $this->assertException(TypeError::class,
            function () use ($comparator) {
                $comparator->setValue(self::VALUE_NUMERIC);
            }
        );

        //object
        $this->assertException(TypeError::class,
            function () {
                new Is($this->dateTime);
            }
        );
        $this->assertException(TypeError::class,
            function () use ($comparator) {
                $comparator->setValue($this->dateTime);
            }
        );

        //array
        $this->assertException(TypeError::class,
            function () {
                new Is($this->array);
            }
        );
        $this->assertException(TypeError::class,
            function () use ($comparator) {
                $comparator->setValue($this->array);
            }
        );
    }

    /**
     *
     */
    public function testIsNotOperator()
    {
        //bool & null
        $comparator = new IsNot(null);
        self::assertNull($comparator->getValue());

        $comparator = new IsNot(true);
        self::assertTrue($comparator->getValue());

        $comparator->setValue(false);
        self::assertFalse($comparator->getValue());

        //null
        $comparator->setValue(null);
        self::assertNull($comparator->getValue());

        //int
        $this->assertException(TypeError::class,
            function () {
                new IsNot(self::VALUE_INT);
            }
        );
        $this->assertException(TypeError::class,
            function () use ($comparator) {
                $comparator->setValue(self::VALUE_INT);
            }
        );

        //float
        $this->assertException(TypeError::class,
            function () {
                new IsNot(self::VALUE_FLOAT);
            }
        );
        $this->assertException(TypeError::class,
            function () use ($comparator) {
                $comparator->setValue(self::VALUE_FLOAT);
            }
        );

        //string
        $this->assertException(TypeError::class,
            function () {
                new IsNot(self::VALUE_STRING);
            }
        );
        $this->assertException(TypeError::class,
            function () use ($comparator) {
                $comparator->setValue(self::VALUE_STRING);
            }
        );
        //numeric
        $this->assertException(TypeError::class,
            function () {
                new IsNot(self::VALUE_NUMERIC);
            }
        );
        $this->assertException(TypeError::class,
            function () use ($comparator) {
                $comparator->setValue(self::VALUE_NUMERIC);
            }
        );

        //object
        $this->assertException(TypeError::class,
            function () {
                new IsNot($this->dateTime);
            }
        );
        $this->assertException(TypeError::class,
            function () use ($comparator) {
                $comparator->setValue($this->dateTime);
            }
        );

        //array
        $this->assertException(TypeError::class,
            function () {
                new IsNot($this->array);
            }
        );
        $this->assertException(TypeError::class,
            function () use ($comparator) {
                $comparator->setValue($this->array);
            }
        );
    }

    /**
     * @throws ComparatorException
     */
    public function testGtOperator()
    {
        //integer
        $comparator = new Gt(self::VALUE_INT);
        self::assertEquals(self::VALUE_INT, $comparator->getValue());

        $comparator->setValue(self::VALUE_INT_2);
        self::assertEquals(self::VALUE_INT_2, $comparator->getValue());

        //float
        $comparator = new Gt(self::VALUE_FLOAT);
        self::assertEquals(self::VALUE_FLOAT, $comparator->getValue());

        $comparator->setValue(self::VALUE_FLOAT_2);
        self::assertEquals(self::VALUE_FLOAT_2, $comparator->getValue());

        //numeric
        $comparator = new Gt(self::VALUE_NUMERIC);
        self::assertEquals(self::VALUE_NUMERIC, $comparator->getValue());

        $comparator->setValue(self::VALUE_NUMERIC_2);
        self::assertEquals(self::VALUE_NUMERIC_2, $comparator->getValue());

        //dateTime
        $comparator = new Gt($this->dateTime);
        self::assertEquals($this->dateTime, $comparator->getValue());

        $comparator->setValue($this->newDateTime);
        self::assertEquals($this->newDateTime, $comparator->getValue());

        //string
        $this->assertException(ComparatorException::class,
            function () {
                new Gt(self::VALUE_STRING);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue(self::VALUE_STRING);
            }
        );

        //bool
        $this->assertException(ComparatorException::class,
            function () {
                new Gt(false);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue(true);
            }
        );

        // не dateTime объект
        $this->assertException(ComparatorException::class,
            function () {
                new Gt($this->entity);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue($this->entity);
            }
        );

        //array
        $this->assertException(ComparatorException::class,
            function () {
                new Gt($this->array);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue($this->array);
            }
        );

        //null
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue(null);
            }
        );

        $this->assertException(ComparatorException::class,
            function () {
                new Gt(null);
            }
        );
    }

    /**
     * @throws ComparatorException
     */
    public function testGeOperator()
    {
        //integer
        $comparator = new Ge(self::VALUE_INT);
        self::assertEquals(self::VALUE_INT, $comparator->getValue());

        $comparator->setValue(self::VALUE_INT_2);
        self::assertEquals(self::VALUE_INT_2, $comparator->getValue());

        //float
        $comparator = new Ge(self::VALUE_FLOAT);
        self::assertEquals(self::VALUE_FLOAT, $comparator->getValue());

        $comparator->setValue(self::VALUE_FLOAT_2);
        self::assertEquals(self::VALUE_FLOAT_2, $comparator->getValue());

        //numeric
        $comparator = new Ge(self::VALUE_NUMERIC);
        self::assertEquals(self::VALUE_NUMERIC, $comparator->getValue());

        $comparator->setValue(self::VALUE_NUMERIC_2);
        self::assertEquals(self::VALUE_NUMERIC_2, $comparator->getValue());

        //dateTime
        $comparator = new Ge($this->dateTime);
        self::assertEquals($this->dateTime, $comparator->getValue());

        $comparator->setValue($this->newDateTime);
        self::assertEquals($this->newDateTime, $comparator->getValue());

        //string
        $this->assertException(ComparatorException::class,
            function () {
                new Ge(self::VALUE_STRING);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue(self::VALUE_STRING);
            }
        );

        //bool
        $this->assertException(ComparatorException::class,
            function () {
                new Ge(false);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue(true);
            }
        );

        // не dateTime объект
        $this->assertException(ComparatorException::class,
            function () {
                new Ge($this->entity);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue($this->entity);
            }
        );

        //array
        $this->assertException(ComparatorException::class,
            function () {
                new Ge($this->array);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue($this->array);
            }
        );

        //null
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue(null);
            }
        );

        $this->assertException(ComparatorException::class,
            function () {
                new Ge(null);
            }
        );
    }

    /**
     * @throws ComparatorException
     */
    public function testLtOperator()
    {
        //integer
        $comparator = new Lt(self::VALUE_INT);
        self::assertEquals(self::VALUE_INT, $comparator->getValue());

        $comparator->setValue(self::VALUE_INT_2);
        self::assertEquals(self::VALUE_INT_2, $comparator->getValue());

        //float
        $comparator = new Lt(self::VALUE_FLOAT);
        self::assertEquals(self::VALUE_FLOAT, $comparator->getValue());

        $comparator->setValue(self::VALUE_FLOAT_2);
        self::assertEquals(self::VALUE_FLOAT_2, $comparator->getValue());

        //numeric
        $comparator = new Lt(self::VALUE_NUMERIC);
        self::assertEquals(self::VALUE_NUMERIC, $comparator->getValue());

        $comparator->setValue(self::VALUE_NUMERIC_2);
        self::assertEquals(self::VALUE_NUMERIC_2, $comparator->getValue());

        //dateTime
        $comparator = new Lt($this->dateTime);
        self::assertEquals($this->dateTime, $comparator->getValue());

        $comparator->setValue($this->newDateTime);
        self::assertEquals($this->newDateTime, $comparator->getValue());

        //string
        $this->assertException(ComparatorException::class,
            function () {
                new Lt(self::VALUE_STRING);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue(self::VALUE_STRING);
            }
        );

        //bool
        $this->assertException(ComparatorException::class,
            function () {
                new Lt(false);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue(true);
            }
        );

        // не dateTime объект
        $this->assertException(ComparatorException::class,
            function () {
                new Lt($this->entity);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue($this->entity);
            }
        );

        //array
        $this->assertException(ComparatorException::class,
            function () {
                new Lt($this->array);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue($this->array);
            }
        );

        //null
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue(null);
            }
        );

        $this->assertException(ComparatorException::class,
            function () {
                new Lt(null);
            }
        );
    }

    /**
     * @throws ComparatorException
     */
    public function testLeOperator()
    {
        //integer
        $comparator = new Le(self::VALUE_INT);
        self::assertEquals(self::VALUE_INT, $comparator->getValue());

        $comparator->setValue(self::VALUE_INT_2);
        self::assertEquals(self::VALUE_INT_2, $comparator->getValue());

        //float
        $comparator = new Le(self::VALUE_FLOAT);
        self::assertEquals(self::VALUE_FLOAT, $comparator->getValue());

        $comparator->setValue(self::VALUE_FLOAT_2);
        self::assertEquals(self::VALUE_FLOAT_2, $comparator->getValue());

        //numeric
        $comparator = new Le(self::VALUE_NUMERIC);
        self::assertEquals(self::VALUE_NUMERIC, $comparator->getValue());

        $comparator->setValue(self::VALUE_NUMERIC_2);
        self::assertEquals(self::VALUE_NUMERIC_2, $comparator->getValue());

        //dateTime
        $comparator = new Le($this->dateTime);
        self::assertEquals($this->dateTime, $comparator->getValue());

        $comparator->setValue($this->newDateTime);
        self::assertEquals($this->newDateTime, $comparator->getValue());

        //string
        $this->assertException(ComparatorException::class,
            function () {
                new Le(self::VALUE_STRING);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue(self::VALUE_STRING);
            }
        );

        //bool
        $this->assertException(ComparatorException::class,
            function () {
                new Le(false);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue(true);
            }
        );

        // не dateTime объект
        $this->assertException(ComparatorException::class,
            function () {
                new Le($this->entity);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue($this->entity);
            }
        );

        //array
        $this->assertException(ComparatorException::class,
            function () {
                new Le($this->array);
            }
        );
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue($this->array);
            }
        );

        //null
        $this->assertException(ComparatorException::class,
            function () use ($comparator) {
                $comparator->setValue(null);
            }
        );

        $this->assertException(ComparatorException::class,
            function () {
                new Le(null);
            }
        );
    }

    /**
     * Asserts that the given callback throws the given exception.
     *
     * @param string $expectClass
     * @param callable $callback
     * @param string|null $expectMessage
     */
    protected function assertException(string $expectClass, callable $callback, string $expectMessage = null)
    {
        try {
            $callback();
        } catch (Throwable $exception) {
            self::assertInstanceOf($expectClass, $exception, 'An invalid exception was thrown');
            if (!is_null($expectMessage))
                self::assertSame($expectMessage, $exception->getMessage());

            return;
        }

        $this->fail('No exception was thrown');
    }
}
