<?php

namespace DynamicTerminal;
/**
 * 
 * @todo remover redundancia de codigo igual na funcao lines e columns
 * @todo Verificar o porque em um terminal bash só é retornado 3000 linhas
 * @todo separar execuçoes do console com o output (vamos manter o SOLID ne :D)
 */
class Console
{
    public function getCurrentUser(): string
    {
        return get_current_user();
    }

    public function getOption(string|array $option): array
    {
        if (is_array($option)) {
            $option = implode(":", $option);
        }

        return  getopt("$option:");
    }

    public function lines()
    {

        if ($this->commandExists("MODE")) {
            $info = $this->readFromProcess("MODE CON");
            if (null === $info || !preg_match('/--------+\r?\n.+?(\d+)\r?\n.+?(\d+)\r?\n/', $info, $matches)) {
                return null;
            }
            return $matches[1];
        }

        return $info = $this->readFromProcess("tput lines");
    }

    public function columns()
    {
       
        if ($this->commandExists("MODE")) {
            $info = $this->readFromProcess("MODE CON");
            if (null === $info || !preg_match('/--------+\r?\n.+?(\d+)\r?\n.+?(\d+)\r?\n/', $info, $matches)) {
                return null;
            }
            return $matches[2];
        }

        return $info = $this->readFromProcess("tput cols");
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

        return false;
    }

    private function commandExists(string $command)
    {

        $whereIsCommand = (PHP_OS == 'WINNT') ? 'where' : 'which';
        $return = shell_exec(sprintf("%s %s", $whereIsCommand, escapeshellarg($command)));
        return !empty($return);
    }

    public function isRuningFromTerminal()
    {
        return php_sapi_name() === "cli";
    }

    public function readFromProcess(string $command)
    {

        if (!\function_exists('proc_open')) {
            return null;
        }

        $descriptorspec = [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $process = proc_open($command, $descriptorspec, $pipes, null, null, ['suppress_errors' => true]);
        if (!\is_resource($process)) {
            return null;
        }

        $info = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);

        return $info;
    }
}
