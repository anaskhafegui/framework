<?php

namespace tests;

use Core\FileSystem\FileSystem;
use Core\View;
use PHPUnit\Framework\TestCase;

final class ViewTest extends TestCase
{

    public function setUp()
    {
        $this->file = FileSystem::instance();
        $this->viewDir = __DIR__.'/../views';
    }

    /**
     * @test
     */
    public function render()
    {
        $data['name'] = 'Mohamed';

        $this->file->put($this->viewDir.'/view.php', '<p>Hello <?php echo $name; ?></p>');

        $this->assertSame("<p>Hello ". $data['name']. "</p>", View::render('view', $data)); 
    }
}