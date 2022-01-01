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

        $this->assertSame($veil->all(), []);
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

        $this->assertSame($veil->all(), ['Foo' => FooVeil::class]);
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     */
    public function it_can_get_a_list_of_registered_veils_as_array()
    {
        $veil = (new Veil)->register();
        $veil->add(['Foo' => FooVeil::class]);
        $registered = $veil->registered();

        $this->assertInstanceOf($veil::class, new Veil);
        $this->assertSame($registered, ['Foo' => FooVeil::class]);
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     */
    public function it_can_get_a_list_of_registered_veils_as_key_value()
    {
        $veil = (new Veil)->register();
        $veil->add('Foo', FooVeil::class);
        $registered = $veil->registered();

        $this->assertInstanceOf($veil::class, new Veil);
        $this->assertSame($registered, ['Foo' => FooVeil::class]);
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     */
    public function it_can_call_method()
    {
        (new Veil)->register()->add('Foo', FooVeil::class);

        $this->assertSame(\Foo::bar(), FooVeil::getVeilInstance()->bar());
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     * @covers \AdrianMejias\Veil\Exceptions\NoInstanceMethodFoundException
     */
    public function it_can_throw_exception_for_method_not_found()
    {
        (new Veil)->register()->add('Foo', FooVeil::class);

        $this->expectException(NoInstanceMethodFoundException::class);
        \Foo::noExist();
    }
}
