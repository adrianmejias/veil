<?php

declare(strict_types=1);

namespace AdrianMejias\Tests;

use PHPUnit\Framework\TestCase;
use AdrianMejias\Veil\Veil;
use AdrianMejias\Tests\Veils\FooVeil;
use Mockery;

class VeilsTest extends TestCase
{
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
        $mock = Mockery::mock(Veil::class);
        $mock->shouldReceive('all')->andReturn([]);
        $veil = new Veil;

        $this->assertSame($veil->all(), $mock->all());
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     */
    public function it_can_get_a_list_of_all_veils()
    {
        $mock = Mockery::mock(Veil::class);
        $mock->shouldReceive('add')->once()->with([
            'Foo' => FooVeil::class,
        ]);
        $mock->shouldReceive('all')->once()->andReturn([
            'Foo' => FooVeil::class,
        ]);
        $veil = new Veil;

        $veil->add(['Foo' => FooVeil::class]);
        $mock->add(['Foo' => FooVeil::class]);

        $this->assertSame($veil->all(), $mock->all());
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     */
    public function it_can_get_a_list_of_registered_veils()
    {
        $mock = Mockery::mock(Veil::class);
        $mock->shouldReceive('register')->once()->andReturn(true);
        $mock->shouldReceive('add')->once()->with([
            'Foo' => FooVeil::class,
        ]);
        $mock->shouldReceive('registered')->once()->andReturn([
            'Foo' => FooVeil::class,
        ]);
        $veil = new Veil;

        $this->assertSame($veil->register(), $mock->register());

        $veil->add(['Foo' => FooVeil::class]);
        $mock->add(['Foo' => FooVeil::class]);

        $this->assertSame(\Foo::bar(), FooVeil::getVeilInstance()->bar());

        $this->assertSame($veil->registered(), $mock->registered());
    }

    /**
     * @test
     * @covers \AdrianMejias\Veil\Veil
     * @covers \AdrianMejias\Veil\VeilAbstract
     */
    public function it_can_get_a_list_of_registered_veils_using_key_value_on_add_method()
    {
        $mock = Mockery::mock(Veil::class);
        $mock->shouldReceive('register')->once()->andReturn(true);
        $mock->shouldReceive('add')->once()->with('Foo', FooVeil::class);
        $mock->shouldReceive('registered')->once()->andReturn([
            'Foo' => FooVeil::class,
        ]);
        $veil = new Veil;

        $this->assertSame($veil->register(), $mock->register());

        $veil->add('Foo', FooVeil::class);
        $mock->add('Foo', FooVeil::class);

        $this->assertSame(\Foo::bar(), FooVeil::getVeilInstance()->bar());

        $this->assertSame($veil->registered(), $mock->registered());
    }
}
