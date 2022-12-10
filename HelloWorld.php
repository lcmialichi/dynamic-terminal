<?php

require_once __DIR__ . "/vendor/autoload.php";

use DynamicTerminal\Displayer;
use DynamicTerminal\Chars;
use DynamicTerminal\Console;


/*
|--------------------------------------------------------------------------
| CONFINGS
|--------------------------------------------------------------------------
|
*/

$textColor = "black";
$bgColor = "white";
$successColor = "white";
$successBg = "cyan";
$fieldBg = "yellow";
$speed = 10000;
$defaultText = "Hello World!";
$uppercase = false;
$overwrite = true;
$positionX = 5;
$positionY = 7;

$console = new Console;

$target = str_split($console->argument(1) ?? $defaultText);
$targetLength = count($target);
$word = [];

/*
|--------------------------------------------------------------------------
| CHARS LIST
|--------------------------------------------------------------------------
|
*/

$chars = [
    ...range("A", "Z"),
    ...range("a", "z"),
    ...str_split("!@#$%^&*()_+{}|:<>?~`-=[]\;',./ "),
];

/*
|--------------------------------------------------------------------------
| EXECUTION PROGRESS BAR
|--------------------------------------------------------------------------
|
*/

$progressBar = new DynamicTerminal\Features\ProgressBar;
var_dump($progressBar->console()->getOption(["b","t"]));exit;
$progressBar->output("lets run progress bar? ",lineBreaker: false);
$progressBar->output("[yes/no] ", "yellow");
$response = $progressBar->waitForInteraction();

if ($response == "yes") {
    $progressBar->output("Starting progress bar demo...\n", "green");
    $progressBar->start(100);
    $progressBar->setBarScale(40);

    for ($i = 0; $i < 100; $i++) {
        $progressBar->increment(1);
        usleep(100000);
    }
}


$displayer = new Displayer();

/*
|--------------------------------------------------------------------------
| EXECUTION TEXT ROLET
|--------------------------------------------------------------------------
|
*/

$consoleY = floor($console->lines() / 2);
$consoleX = floor(($console->columns() - $targetLength) / 2);

$displayer->setOverwrite($overwrite);
$displayer->setOverwriteScale(
    line: ($line = $positionY ?? $consoleY) < 0 ? 0 : $line,
    column: ($column = $positionX ?? $consoleX) < 0 ? 0 : $column
);

$displayer->console()->removeLastLine();
$displayer->output(str_repeat(" ", $targetLength), $fieldBg, $fieldBg);

for ($index = 0; $index != $targetLength; $index++) {
    foreach (new Chars($chars, false) as $char) {
        if ($char == $target[$index]) {
            if ($index == $targetLength - 1) {
                $textColor = $successColor;
                $bgColor = $successBg;
            }

            $word[] = $uppercase ? strtoupper($char) : $char;
            $char = null;
        }

        $displayer->output(implode($word) . "{$char}", $textColor, $bgColor);
        usleep($speed);

        if (is_null($char)) {
            break;  
        }
    }
}
sleep(1);
$displayer->output("made by @lcmialichi\n", "blue");