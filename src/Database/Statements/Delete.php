<?php

namespace Core\Database\Statements;

class Delete
{
    public static function generate($table)
    {
        return 'DELETE FROM '.$table;
    }
}
