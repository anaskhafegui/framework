<?php

namespace tests;

use Core\FileSystem\FileSystem;
use PHPUnit\Framework\TestCase;

class FileSystemTest extends TestCase
{
    public function setUp()
    {
        $this->file = FileSystem::instance();
        $this->tempDir = __DIR__.'/tmp';
        $this->file->makeDirectory($this->tempDir, 0777, true, true);
    }

    public function tearDown()
    {
        $this->file->delete($this->tempDir);
    }


    /**
     * @test
     */
    public function files()
    {
        $this->file->put($this->tempDir.'/file1.txt', 'Hello World from file1');
        $this->file->put($this->tempDir.'/file2.txt', 'Hello World from file2');

        $this->assertCount(2, $this->file->files($this->tempDir));
    }

    /**
     * @test
     */
    public function allFiles()
    {
        $this->file->put($this->tempDir.'/file1.txt', 'Hello World from file1');
        $this->file->put($this->tempDir.'/file2.txt', 'Hello World from file2');
        $this->file->makeDirectory($this->tempDir.'/sub_dir1', 0777, true, true);
        $this->file->put($this->tempDir.'/sub_dir1/file3.txt', 'Hello World from file3');
        $this->file->put($this->tempDir.'/sub_dir1/file4.txt', 'Hello World from file4');

        $this->assertCount(4, $this->file->allFiles($this->tempDir));
    }

    /**
     * @test
     */
    public function directories()
    {
        $this->file->put($this->tempDir.'/file1.txt', 'Hello World from file1');
        $this->file->put($this->tempDir.'/file2.txt', 'Hello World from file2');
        $this->file->makeDirectory($this->tempDir.'/sub_dir1', 0777, true, true);
        $this->file->put($this->tempDir.'/sub_dir1/file3.txt', 'Hello World from file3');
        $this->file->put($this->tempDir.'/sub_dir1/file4.txt', 'Hello World from file4');

        $this->file->makeDirectory($this->tempDir.'/sub_dir2', 0777, true, true);
        $this->file->put($this->tempDir.'/sub_dir2/file5.txt', 'Hello World from file5');
        $this->file->put($this->tempDir.'/sub_dir2/file6.txt', 'Hello World from file6');

        $this->assertCount(2, $this->file->directories($this->tempDir));
    }

    /**
     * @test
     */
    public function allDirectories()
    {
        
        $this->file->makeDirectory($this->tempDir.'/sub_dir1', 0777, true, true);
        $this->file->put($this->tempDir.'/sub_dir1/file3.txt', 'Hello World from file3');
        $this->file->put($this->tempDir.'/sub_dir1/file4.txt', 'Hello World from file4');

        $this->file->makeDirectory($this->tempDir.'/sub_dir2', 0777, true, true);
        $this->file->put($this->tempDir.'/sub_dir2/file5.txt', 'Hello World from file5');
        $this->file->put($this->tempDir.'/sub_dir2/file6.txt', 'Hello World from file6');

        $this->file->makeDirectory($this->tempDir.'/sub_dir2/sub_dir3', 0777, true, true);
        
        $this->assertCount(3, $this->file->allDirectories($this->tempDir));   
    }

    /**
     * @test
     */
    public function list()
    {
        $this->file->put($this->tempDir.'/file1.txt', 'Hello World from file1');
        $this->file->put($this->tempDir.'/file2.txt', 'Hello World from file2');

        $this->file->makeDirectory($this->tempDir.'/sub_dir1', 0777, true, true);
        $this->file->put($this->tempDir.'/sub_dir1/file3.txt', 'Hello World from file3');
        $this->file->put($this->tempDir.'/sub_dir1/file4.txt', 'Hello World from file4');

        $this->file->makeDirectory($this->tempDir.'/sub_dir2', 0777, true, true);
        $this->file->put($this->tempDir.'/sub_dir2/file5.txt', 'Hello World from file5');
        $this->file->put($this->tempDir.'/sub_dir2/file6.txt', 'Hello World from file6');

        $this->file->makeDirectory($this->tempDir.'/sub_dir2/sub_dir3', 0777, true, true);

        $this->assertCount(2, $this->file->list($this->tempDir)['directories']);  
        $this->assertCount(2, $this->file->list($this->tempDir)['files']);  
    }


    /**
     * @test
     */
    public function listAll()
    {
        $this->file->put($this->tempDir.'/file1.txt', 'Hello World from file1');
        $this->file->put($this->tempDir.'/file2.txt', 'Hello World from file2');

        $this->file->makeDirectory($this->tempDir.'/sub_dir1', 0777, true, true);
        $this->file->put($this->tempDir.'/sub_dir1/file3.txt', 'Hello World from file3');
        $this->file->put($this->tempDir.'/sub_dir1/file4.txt', 'Hello World from file4');

        $this->file->makeDirectory($this->tempDir.'/sub_dir2', 0777, true, true);
        $this->file->put($this->tempDir.'/sub_dir2/file5.txt', 'Hello World from file5');
        $this->file->put($this->tempDir.'/sub_dir2/file6.txt', 'Hello World from file6');

        $this->file->makeDirectory($this->tempDir.'/sub_dir2/sub_dir3', 0777, true, true);

        $this->assertCount(3, $this->file->listAll($this->tempDir)['directories']);  
        $this->assertCount(6, $this->file->listAll($this->tempDir)['files']); 
    }

    /**
     * @test
     */
    public function cleanDirectory()
    {
        $this->file->put($this->tempDir.'/file1.txt', 'Hello World from file1');
        $this->file->put($this->tempDir.'/file2.txt', 'Hello World from file2');

        $this->file->makeDirectory($this->tempDir.'/sub_dir1', 0777, true, true);
        $this->file->put($this->tempDir.'/sub_dir1/file3.txt', 'Hello World from file3');
        $this->file->put($this->tempDir.'/sub_dir1/file4.txt', 'Hello World from file4');

        $this->file->makeDirectory($this->tempDir.'/sub_dir2', 0777, true, true);
        $this->file->put($this->tempDir.'/sub_dir2/file5.txt', 'Hello World from file5');
        $this->file->put($this->tempDir.'/sub_dir2/file6.txt', 'Hello World from file6');

        $this->file->makeDirectory($this->tempDir.'/sub_dir2/sub_dir3', 0777, true, true);

        $file = FileSystem::instance();
        $this->assertTrue($file->cleanDirectory($this->tempDir.'/sub_dir1'));  

        $this->assertEmpty($this->file->listAll($this->tempDir.'/sub_dir1')['files']);  
        $this->assertEmpty($this->file->listAll($this->tempDir.'/sub_dir1')['directories']);  
    }

    /**
     * @test
     */
    public function append()
    {
        $filePath = $this->tempDir.'/file1.txt';
        $this->file->put($filePath , 'Hello');

        $this->file->append($filePath, ' World');

        $this->assertStringEqualsFile($filePath, 'Hello World');
    }

    /**
     * @test
     */
    public function prepend()
    {
        $filePath = $this->tempDir.'/file1.txt';
        $this->file->put($filePath , 'World');

        $this->file->prepend($filePath, 'Hello ');

        $this->assertStringEqualsFile($filePath, 'Hello World');
    }
}