<?php

namespace tests;

use Core\Http\Request;
use Core\Http\Response;
use PHPUnit\Framework\TestCase;

final class HelpersTest extends TestCase
{
    /**
     * @test
     */
    public function app()
    {
        $this->assertInstanceOf(Request::class, app('request'));
        $this->assertInstanceOf(Response::class, app('response'));
    }

    /**
     * @test
     */
    public function pre()
    {
        $arr = [1, 2, 3];

        // getting content
        ob_start();
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
        $actual = ob_get_contents();
        ob_end_clean();

        ob_start();
        pre($arr);
        $expected = ob_get_contents();
        ob_end_clean();

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function flatten()
    {
        $arr = [
            'name'    => 'mohamed',
            'age'     => 27,
            'address' => [
                'city'    => 'giza',
                'country' => 'egypt',
            ],
        ];

        $flatten = ['mohamed', 27, 'giza', 'egypt'];

        $this->assertEquals($flatten, flatten($arr));

        $notFlatten = [
            'name'    => 'mohamed',
            'age'     => 27,
            'city'    => 'giza',
            'country' => 'egypt',
        ];

        $this->assertNotEquals($notFlatten, flatten($arr));
    }
}
