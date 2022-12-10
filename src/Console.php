<?php

namespace DynamicTerminal;

class Console
{
    public function getCurrentUser() : string
    {
        return get_current_user();
    }

    public function getOption(string|array $option) : array
    {
        if (is_array($option)) {
            $option = implode(":", $option);
        }

        return  getopt("$option:");
    }

    public function lines()
    {
        $info = shell_exec('MODE 2> NUL') ?? shell_exec('tput lines');
        if (strlen($info) > 7) {
            preg_match('/CON.*:(\n[^|]+?){2}(?<lines>\d+)/', $info, $match);
            $info = $match['lines'] ?? 80;
        }
        return $info;
    }

    public function columns()
    {
        $info = shell_exec('MODE 2> NUL') ?? shell_exec('tput cols');
        if (strlen($info) > 7) {
            preg_match('/CON.*:(\n[^|]+?){3}(?<cols>\d+)/', $info, $match);
            $info = $match['cols'] ?? 80;
        }
        return $info;
    }

    public function removeLastLine()
    {
        echo "\r\x1b[K";
        echo "\033[1A\033[K";
    }

    public function output(string $output): void
    {
        print($output);
    }

    public function overwrite(int $line = 0, int $column = 0)
    {
        printf("\x1b[%d;%dH", $line, $column);
    }

    public static function argument(string|int $arg)
    {

        if (is_int($arg)) {
            return $_SERVER['argv'][$arg] ?? null;
        }

        $input =  array_values(array_filter(
            array_values($_SERVER['argv']),
            function ($item) use ($arg) {
                return beginsWith($arg . "=", $item);
            }
        ));

        if (!empty($input)) {
            return ltrim($input[0], "{$arg}=");
        }

        return null;
    }
}
