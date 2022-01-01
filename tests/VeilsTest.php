<?php

declare(strict_types=1);

namespace AdrianMejias\Tests;

use AdrianMejias\Tests\Veils\FooVeil;
use AdrianMejias\Veil\Exceptions\NoInstanceMethodFoundException;
use AdrianMejias\Veil\Veil;
use PHPUnit\Framework\TestCase;

class VeilsTest extends TestCase
{
    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     */
    public function it_can_get_a_list_of_empty_veils()
    {
        $veil = new Veil;

        $expected = [];
        $actual = $veil->all();
        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     */
    public function it_can_get_a_list_of_all_veils()
    {
        $veil = new Veil;
        $veil->add(['Foo' => FooVeil::class]);

        $expected = ['Foo' => FooVeil::class];
        $actual = $veil->all();
        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     */
    public function it_can_get_a_list_of_registered_veils_as_array()
    {
        $instance = new Veil;

        $veil = $instance->register()->add(['Foo' => FooVeil::class]);

        $this->assertInstanceOf($veil::class, $instance);

        $expected = ['Foo' => FooVeil::class];
        $actual = $veil->registered();
        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     */
    public function it_can_get_a_list_of_registered_veils_as_key_value()
    {
        $instance = new Veil;

        $veil = $instance->register()->add('Foo', FooVeil::class);

        $this->assertInstanceOf($veil::class, $instance);

        $expected = ['Foo' => FooVeil::class];
        $actual = $veil->registered();
        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     */
    public function it_can_call_method()
    {
        (new Veil)->register()->add('Foo', FooVeil::class);

        $expected = \Foo::bar();
        $actual = FooVeil::getVeilInstance()->bar();

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     * @covers \AdrianMejias\Veil\Exceptions\NoInstanceMethodFoundException
     */
    public function it_can_throw_exception_for_instance_method_not_found()
    {
        (new Veil)->register()->add('Foo', FooVeil::class);

        $this->expectException(NoInstanceMethodFoundException::class);
        \Foo::noExist();
    }
}
