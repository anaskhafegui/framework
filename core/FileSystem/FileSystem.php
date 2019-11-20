<?php

namespace Core\FileSystem;

use Core\Interfaces\FileSystemInterface;
use RecursiveIteratorIterator;

class FileSystem implements FileSystemInterface
{
    /**
     * Check if the given path exists
     * 
     * @param string $path
     * @return bool 
     */
    public function exists(string $path): bool
    {
        return file_exists($path);
    }
    
    /**
     * Check if the given path is a file
     * 
     * @param string $path
     * @return bool 
     */
    public function isFile(string $path): bool
    {
        return is_file($path);
    }
    
    /**
     * Check if the given path is a directory
     * 
     * @param string $path
     * @return bool 
     */
    public function isDirectory(string $path): bool
    {
        return is_dir($path);
    }
    
    /**
     * Create a directory.
     *
     * @param  string  $path
     * @param  int     $mode
     * @param  bool    $recursive
     * @param  bool    $force
     * @return bool
     */
    public function makeDirectory(string $path, int $mode, bool $recursive, bool $force): bool
    {
        return mkdir($path, $mode, $recursive);
    }

    /**
     * Remove all contents of the given directory path and keep the directory
     * 
     * @param  string $path
     * @return bool
     */
    public function cleanDirectory(string $path): bool
    {
        array_map( 'unlink', array_filter((array) glob($path) ) );

        return glob($path . "*") == 0;
    }

    /**
     * Get the content of the given file path
     * 
     * @param string $path
     * @param bool   $lock
     * @return string
     * @throws FileNotFoundException
     */
    public function get(string $path, bool $lock): string
    {
        return file_get_contents($path);
    }
    
    /**
     * Get the content of the given json file 
     * 
     * @param string $path
     * @return array
     * @throws FileNotFoundException
     */
    public function getJson(string $path, bool $assoc): array
    {
        $json = $this->get($path, false);

        return json_decode($json, $assoc);
    }
    
    /**
     * Require the given file path 
     * 
     * @param string $file
     * @return mixed
     */
    public function require(string $file)
    {
        require $file;
    }
    
    /**
     * Require the given file path once 
     * 
     * @param string $file
     * @return mixed
     */
    public function requireOnce(string $file)
    {
        require_once $file;
    }
    
    /**
     * Put the given content to the given file path
     * 
     * @param string $path
     * @param string $content
     * @param int $flags
     * @return int|false 
     */
    public function put(string $path, string $content, int $flags)
    {
        file_put_contents($path, $content, $flags);
    }
    
    /**
     * Put the given content to the given json file path
     * 
     * @param string $path
     * @param array $data
     * @param int $flags
     * @return int|false 
     */
    public function putJson(string $path, array $data, int $flags)
    {
        $json = json_encode($data);

        $this->put($path, $json, $flags);
    }
    
    /**
     * Add content to the beginning of the given file path
     * 
     * @param string $path
     * @param string $content
     * @return int|false 
     */
    public function prepend(string $path, string $content)
    {
        $prependContent = $content;
        $prependContent .= $this->get($path, false);

        $this->put($path, $prependContent, 0);
    }
    
    /**
     * Add content to the end of the given file path
     * 
     * @param string $path
     * @param string $content
     * @return int|false 
     */
    public function append(string $path, string $content)
    {
        $appendContent = $this->get($path, false);
        $appendContent .= $content;

        $this->put($path, $appendContent, 0);
    }
    
    /**
     * Delete the given path
     * This works with files and directories as well
     * 
     * @param string $path
     * @return bool 
     */
    public function delete(string $path): bool
    {
        if ($this->isDirectory($path)) 
        {
            return rmdir($path);
        }

        return unlink($path);
    }
    
    /**
     * Rename the given path to the new path
     * 
     * @param string $oldPath
     * @param string $newPath
     * @return bool 
     */
    public function rename(string $oldPath, string $newPath): bool
    {
        return rename($oldPath, $newPath);
    }
    
    /**
     * Copy the given path to the new pat
     * This works with files and directories as well
     * 
     * @param string $target
     * @param string $destination
     * @return bool 
     */
    public function copy(string $target, string $destination): bool
    {
        return copy($target, $destination);
    }

    /**
     * Move the given path to the new path
     * This works with files and directories as well
     * 
     * @param string $target
     * @param string $destination
     * @return bool 
     */
    public function move(string $target, string $destination): bool
    {
        return $this->rename($target, $destination);
    }

    /**
     * Get the MD5 hash of the file at the given path.
     *
     * @param  string  $path
     * @return string
     */
    public function hash(string $path): string
    {
        return md5_file($path);
    }

    /**
     * Get the file|directory size.
     * If the unit parameter is passed then convert the size to its corresponding unit accordingly
     * Available units: kb|mb|gb
     *  
     * @param  string  $path
     * @param  string  $unit
     * @return float
     */
    public function size(string $path, string $unit): float
    {
        return 1.5;
    }
    
    /**
     * Get or set UNIX mode of a file or directory.
     * If second parameter is passed, then set the mode otherwise return it.
     *
     * @param  string  $path
     * @param  int  $mode
     * @return mixed
     */
    public function chmod(string $path, int $mode)
    {
        return chmod($path, $mode);
    }

    /**
     * Extract the file name from a file path.
     *
     * @param  string  $path
     * @return string
     */
    public function name(string $path): string
    {
        return basename($path);
    }

    /**
     * Extract the trailing name component from a file path.
     *
     * @param  string  $path
     * @return string
     */
    public function basename(string $path): string
    {
        return '';
    }

    /**
     * Extract the parent directory from a file path.
     *
     * @param  string  $path
     * @return string
     */
    public function dirname(string $path):? string
    {
        return dirname($path);
    }

    /**
     * Extract the file extension from a file path.
     *
     * @param  string  $path
     * @return string
     */
    public function extension(string $path):? string
    {
        $info = phpinfo($path);
        return $info['extension'];
    }

    /**
     * Get the file type of a given file.
     *
     * @param  string  $path
     * @return string
     */
    public function type(string $path):? string
    {
        return filetype($path);
    }

    /**
     * Get the mime-type of a given file.
     *
     * @param  string  $path
     * @return string|null
     */
    public function mimeType(string $path):? string
    {
        return mime_content_type($path);
    }

    /**
     * Get the file's last modification time.
     *
     * @param  string  $path
     * @return int
     */
    public function lastModified(string $path): int
    {
        return filemtime($path);
    }

    /**
     * Determine if the given path is readable.
     *
     * @param  string  $path
     * @return bool
     */
    public function isReadable(string $path): bool
    {
        return is_readable($path);
    }
    
    /**
     * Determine if the given path is writable.
     *
     * @param  string  $path
     * @return bool
     */
    public function isWritable(string $path): bool
    {
        return is_writable($path);
    }
    
    /**
     * Get an array of all files in a directory.
     *
     * @param  string  $directory
     * @param  bool  $hidden
     */
    public function files(string $directory, bool $hidden = false): iterable
    {        
        // exclude hidden files
        if (! $hidden) return preg_grep('/^([^.])/', scandir($directory));
        
        return scandir($directory);   
    }
    
    /**
     * Get an array of all files in a directory recursively.
     *
     * @param  string  $directory
     * @param  bool  $hidden
     */
    public function allFiles(string $directory, bool $hidden = false): iterable
    {
        $files = [];
        $tree = $this->glob(rtrim($directory, '/') . '/*', 0);

        if (is_array($tree)) {
            foreach($tree as $file) {
                // Recursively get files in directory
                if ($this->isDirectory($file)) {
                    $files = $this->allFiles($file);
                }
            }
        }

        return $files;
    }
    
    /**
     * Get an array of all directories in a directory.
     *
     * @param  string  $directory
     * @param  bool  $hidden
     */
    public function directories(string $directory, bool $hidden = false): iterable
    {
        $directories = [];
        foreach (scandir($directory) as $directory) {
            if ($this->isDirectory($directory)) {
                $directories[] = $directory;
            }
        }

        return $directories;
    }
    
    /**
     * Get an array of all directories in a directory recursively.
     *
     * @param  string  $directory
     * @param  bool  $hidden
     */
    public function allDirectories(string $directory, bool $hidden = false): iterable
    {
        $directories = [];
        $tree = $this->glob(rtrim($directory, '/') . '/*', 0);

        if (is_array($tree)) {
            foreach($tree as $file) {
                // Recursively get files in directory
                if ($this->isDirectory($file)) {
                    $directories[] = $file; 
                }
            }
        }

        return $directories;
    }
    
    /**
     * Get an array of all directories and files in a directory.
     *
     * @param  string  $directory
     * @param  bool  $hidden
     */
    public function list(string $directory, bool $hidden = false): iterable
    {
        // exclude hidden files
        if (! $hidden) return preg_grep('/^([^.])/', scandir($directory));
        
        return scandir($directory);   
    }
    
    /**
     * Get an array of all directories and files in a directory recursively.
     *
     * @param  string  $directory
     * @param  bool  $hidden
     */
    public function listAll(string $directory, bool $hidden = false): iterable
    {
        $files = [];
        $tree = $this->glob(rtrim($directory, '/') . '/*', 0);

        if (is_array($tree)) {
            foreach($tree as $file) {
                if ($this->isDirectory($file)) {
                    $files[] = $this->allFiles($file);
                } else {
                    $files[] = $file;
                }
            }
        }

        return $files;
    }
    
    /**
     * Find path names matching a given pattern.
     *
     * @param  string  $pattern
     * @param  int     $flags
     * @return array
     */
    public function glob(string $pattern, int $flags): iterable
    {
        return glob($pattern, $flags);
    }
}