<?php

namespace DynamicConsole\Features;

use DynamicConsole\Displayer;

class ProgressBar extends Displayer
{
    /**
     * @var int
     */
    private int $progress = 0;
    /**
     * @var int
     */
    private int $total = 0;
    /**
     * @var int
     */
    private int $position = 0;
    /**
     * @var int
     */
    private string $bar = "";
    /**
     * @var int
     */
    private int $barSize = 50;
    /**
     * @var string
     */
    private string $lefEdge = "[";
    /**
     * @var string
     */
    private string $rightEdge = "]";
    /**
     * @var string
     */
    private string $content = "=";

    public function start(int $length = 100, int $start = 0)
    {
        $this->total = $length;
        $this->bar = str_repeat(" ", $this->barSize);
        $this->position = $start;

        $this->output($this->getBar());
    }

    public function finish()
    {
        $this->position = $this->total;
        $this->updateBar();
        $this->output($this->getBar());
        $this->fresh();
    }

    public function fresh()
    {
        $this->position = 0;
        $this->progress = 0;
        $this->bar = str_repeat(" ", $this->barSize);
    }

    public function increment(int $count = 1): void
    {
        $this->console->removeLastLine();
        $this->incrementProgress($count);
        if ($this->position >= $this->total) {
            $this->finish();
            return;
        }

        $this->updateBar();
        $this->output($this->getBar());
    }

    public function getBar()
    {
        return "{$this->lefEdge}{$this->bar}{$this->rightEdge} {$this->currentPercent()}% ({$this->position}/{$this->total})";
    }

    private function updateBar()
    {
        $currentBar = $this->currentBarPosition();
        $this->bar = str_repeat($this->content, $currentBar) . str_repeat(" ", $this->barSize - $currentBar);
    }

    private function incrementProgress(int $count)
    {
        $this->position = $this->position + $count;
        $this->progress = floor($this->progress + ($this->currentPercent() * $count / 100));
    }

    private function currentPercent()
    {
        return floor($this->position / $this->total * 100);
    }

    public function currentBarPosition()
    {
        return floor(($this->currentPercent() * $this->barSize()) / 100);
    }

    public function barSize()
    {
        return $this->barSize;
    }

    public function setBarScale(int $size)
    {
        $this->barSize = $size;
    }

    public function style(string $content = "=", string $leftEdge = "{", string $rightEdge = "}")
    {
        if(strlen($content) > 1) {
            $content = substr($content, 0, 1);
        }
        $this->content = $content;
        $this->lefEdge = $leftEdge;
        $this->rightEdge = $rightEdge;
    }
}
