<?php

if (!function_exists('beginsWith')) {
    /**
     *
     * @return bool
     */
    function beginsWith(string $search, string $string): mixed
    {
        return 0 === strncmp($search, $string, \strlen($search));
    }
}