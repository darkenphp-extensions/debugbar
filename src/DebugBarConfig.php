<?php

namespace Darken\Debugbar;

use DebugBar\StandardDebugBar;

class DebugBarConfig extends StandardDebugBar
{
    public function start($name, $label = null)
    {
        $this['time']->startMeasure($name, $label);
    }

    public function stop($name)
    {
        $this['time']->stopMeasure($name);
    }

    public function message($message)
    {
        $this['messages']->addMessage($message);
    }
}