<?php

declare(strict_types=1);

namespace AdrianMejias\Tests;

use AdrianMejias\Tests\Veils\FooVeil;
use AdrianMejias\Tests\Veils\MyTestClass;
use AdrianMejias\Veil\Exceptions\NoAccessorFoundException;
use AdrianMejias\Veil\Exceptions\NoInstanceFoundException;
use AdrianMejias\Veil\Exceptions\NoInstanceMethodFoundException;
use AdrianMejias\Veil\Veil;
use AdrianMejias\Veil\VeilAbstract;
use Mockery;
use PHPUnit\Framework\TestCase;

class MockVeilsTest extends TestCase
{
    public function setUp(): void
    {
        Mockery::globalHelpers();
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     */
    public function it_can_get_a_list_of_empty_veils()
    {
        $mock = mock(Veil::class);
        $mock->shouldReceive('all')->andReturn([]);

        $mock->all();
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     */
    public function it_can_get_a_list_of_all_veils()
    {
        $mock = mock(Veil::class);
        $mock->shouldReceive('add')->once()->with([
            'Foo' => FooVeil::class,
        ]);
        $mock->shouldReceive('all')->once()->andReturn([
            'Foo' => FooVeil::class,
        ]);

        $mock->add(['Foo' => FooVeil::class]);
        $mock->all();
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     */
    public function it_can_get_a_list_of_registered_veils_as_array()
    {
        $mock = mock(Veil::class);
        $mock->shouldReceive('register')->once()->andReturn(true);
        $mock->shouldReceive('add')->once()->with([
            'Foo' => FooVeil::class,
        ]);
        $mock->shouldReceive('registered')->once()->andReturn([
            'Foo' => FooVeil::class,
        ]);

        $mock->register();
        $mock->add(['Foo' => FooVeil::class]);
        $mock->registered();
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     */
    public function it_can_get_a_list_of_registered_veils_as_key_value()
    {
        $mock = mock(Veil::class);
        $mock->shouldReceive('register')->once()->andReturn(true);
        $mock->shouldReceive('add')->once()->with('Foo', FooVeil::class);
        $mock->shouldReceive('registered')->once()->andReturn([
            'Foo' => FooVeil::class,
        ]);

        $mock->register();
        $mock->add('Foo', FooVeil::class);
        $mock->registered();
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     * @covers \AdrianMejias\Veil\Exceptions\NoAccessorFoundException
     */
    public function it_can_throw_exception_for_accessor_not_found()
    {
        $mockClass = new class extends VeilAbstract {
            /** @inheritDoc */
            public static function getVeilInstance()
            {
                return new MyTestClass;
            }
        };
        $mock = Mockery::mock(Veil::class);
        $mock->shouldReceive('register')->once()->andReturn(true);
        $mock->shouldReceive('add')->once()->with('MockFoo', $mockClass::class);
        $mock->shouldReceive('registered')->once()->andReturn([
            'MockFoo' => $mockClass::class,
        ]);

        $mock->register();
        $mock->add('MockFoo', $mockClass::class);
        $registered = $mock->registered();

        $this->expectException(NoAccessorFoundException::class);
        $registered['MockFoo']::bar();
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     * @covers \AdrianMejias\Veil\Exceptions\NoInstanceFoundException
     */
    public function it_can_throw_exception_for_instance_not_found()
    {
        $mockClass = new class extends VeilAbstract {
            /** @inheritDoc */
            public static function getVeilAccessor()
            {
                return 'MockClass';
            }
        };
        $mock = Mockery::mock(Veil::class);
        $mock->shouldReceive('register')->once()->andReturn(true);
        $mock->shouldReceive('add')->once()->with('MockFoo', $mockClass::class);
        $mock->shouldReceive('registered')->once()->andReturn([
            'MockFoo' => $mockClass::class,
        ]);

        $mock->register();
        $mock->add('MockFoo', $mockClass::class);
        $registered = $mock->registered();

        $this->expectException(NoInstanceFoundException::class);
        $registered['MockFoo']::bar();
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     * @covers \AdrianMejias\Veil\Exceptions\NoInstanceMethodFoundException
     */
    public function it_can_throw_exception_for_instance_method_not_found()
    {
        $mock = Mockery::mock(Veil::class);
        $mock->shouldReceive('register')->once()->andReturn(true);
        $mock->shouldReceive('add')->once()->with('Foo', FooVeil::class);
        $mock->shouldReceive('registered')->once()->andReturn([
            'Foo' => FooVeil::class,
        ]);

        $mock->register();
        $mock->add('Foo', FooVeil::class);
        $registered = $mock->registered();

        $this->expectException(NoInstanceMethodFoundException::class);
        $registered['Foo']::noExist();
    }
}
