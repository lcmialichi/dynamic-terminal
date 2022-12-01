# dynamic-terminal

A simple way to output messages on terminal using PHP

### ProgressBar | Output | Interaction 
---

When a progress bar is initialized you can set the start position and range on start method, when you try to increment to a position that is out of the pre setted range, it will finish the progressbar and fresh it
 ```php

$progressBar = new DynamicTerminal\Features\ProgressBar;

// Normal Output but you can choose the bg color, fg color and if it will break line
$progressBar->output("lets run progress bar? ",lineBreaker: false);
$progressBar->output("[yes/no] ", "yellow");

// Waits for the user to interact with terminal and return the responses
$response = $progressBar->waitForInteraction();
$progressBar->output("Starting progress bar demo...\n", "green");

if ($response == "yes") {

    // Start a progressBar with 100 of range
    $progressBar->start(100);

    // Set Bar scale in terminal columns
    $progressBar->setBarScale(40);

    for ($i = 0; $i < 100; $i++) {

        // Increments bar count ( the percent and position will be automatically calculated)
        $progressBar->increment(1);
        usleep(100000);
    }
}

```

You can also overwrite content in terminal using `overwrite` method availible on `Displayer` class, passing $line and $column parameters witch refers to line and column on terminal it self.

### Different way to output Hello World!

runnig `HelloWorld.php` script...

![](https://i.ibb.co/W5yGY0N/Captura-de-tela-2022-12-01-012002.png)
