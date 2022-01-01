<?php

declare(strict_types=1);

namespace AdrianMejias\Tests;

use AdrianMejias\Tests\Veils\FooVeil;
use AdrianMejias\Tests\Veils\MyTestClass;
use AdrianMejias\Tests\Veils\NoAccessorVeil;
use AdrianMejias\Tests\Veils\NoInstanceVeil;
use AdrianMejias\Veil\Exceptions\NoAccessorFoundException;
use AdrianMejias\Veil\Exceptions\NoInstanceFoundException;
use AdrianMejias\Veil\Exceptions\NoInstanceMethodFoundException;
use AdrianMejias\Veil\Veil;
use Mockery;
use PHPUnit\Framework\TestCase;

class MockVeilsTest extends TestCase
{
    /** @inheritDoc */
    public function setUp(): void
    {
        Mockery::globalHelpers();
    }

    /** @inheritDoc */
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
        /** @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|\AdrianMejias\Veil\Veil */
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
        /** @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|\AdrianMejias\Veil\Veil */
        $mock = mock(Veil::class);
        $mock->shouldReceive('add')->once()->with([
            'Foo' => FooVeil::class,
        ])->andReturnSelf();
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
        /** @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|\AdrianMejias\Veil\Veil */
        $mock = mock(Veil::class);
        $mock->shouldReceive('register')->once()->andReturnSelf();
        $mock->shouldReceive('add')->once()->with([
            'Foo' => FooVeil::class,
        ])->andReturnSelf();
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
        /** @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|\AdrianMejias\Veil\Veil */
        $mock = mock(Veil::class);
        $mock->shouldReceive('register')->once()->andReturnSelf();
        $mock->shouldReceive('add')->once()
            ->with('Foo', FooVeil::class)->andReturnSelf();
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
     */
    public function it_can_call_method()
    {
        /** @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|\AdrianMejias\Tests\Veils\FooVeil */
        $mock = mock(FooVeil::class);
        $mock->shouldReceive([
            'getVeilInstance' => new MyTestClass,
            'bar' => 'hi',
        ]);
        $mock->getVeilInstance()->bar();
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     * @covers \AdrianMejias\Veil\Exceptions\NoAccessorFoundException
     */
    public function it_can_throw_exception_for_accessor_not_found()
    {
        /** @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|\AdrianMejias\Veil\Veil */
        $mock = mock(Veil::class);
        $mock->shouldReceive('register')->once()->andReturnSelf();
        $mock->shouldReceive('add')->once()
            ->with('NoAccessor', NoAccessorVeil::class)->andReturnSelf();
        $mock->shouldReceive('registered')->once()->andReturn([
            'NoAccessor' => NoAccessorVeil::class,
        ]);

        $mock->register();
        $mock->add('NoAccessor', NoAccessorVeil::class);
        $registered = $mock->registered();

        $this->expectException(NoAccessorFoundException::class);
        $registered['NoAccessor']::bar();
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     * @covers \AdrianMejias\Veil\Exceptions\NoInstanceFoundException
     */
    public function it_can_throw_exception_for_instance_not_found()
    {
        /** @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|\AdrianMejias\Veil\Veil */
        $mock = mock(Veil::class);
        $mock->shouldReceive('register')->once()->andReturnSelf();
        $mock->shouldReceive('add')->once()
            ->with('NoInstance', NoInstanceVeil::class)->andReturnSelf();
        $mock->shouldReceive('registered')->once()->andReturn([
            'NoInstance' => NoInstanceVeil::class,
        ]);

        $mock->register();
        $mock->add('NoInstance', NoInstanceVeil::class);
        $registered = $mock->registered();

        $this->expectException(NoInstanceFoundException::class);
        $registered['NoInstance']::bar();
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     * @covers \AdrianMejias\Veil\Exceptions\NoInstanceMethodFoundException
     */
    public function it_can_throw_exception_for_instance_method_not_found()
    {
        /** @var \Mockery\MockInterface|\Mockery\LegacyMockInterface|\AdrianMejias\Veil\Veil */
        $mock = mock(Veil::class);
        $mock->shouldReceive('register')->once()->andReturnSelf();
        $mock->shouldReceive('add')->once()
            ->with('Foo', FooVeil::class)->andReturnSelf();
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
