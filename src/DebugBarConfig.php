<?php

namespace Darken\Debugbar;

use Darken\Config\ConfigInterface;
use DebugBar\DataCollector\ConfigCollector;
use DebugBar\StandardDebugBar;

class DebugBarConfig extends StandardDebugBar
{
    public function __construct(public bool $isActive = false)
    {
        parent::__construct();
    }

    public function start($name, $label = null) : self
    {
        $this['time']->startMeasure($name, $label);

        return $this;
    }

    public function stop($name) : self
    {
        $this['time']->stopMeasure($name);

        return $this;
    }

    public function config(ConfigInterface $config) : self
    {
        $data = [
            'getDebugMode' => $config->getDebugMode(),
            'getRootDirectoryPath' => $config->getRootDirectoryPath(),
            'getBuildOutputFolder' => $config->getBuildOutputFolder(),
            'getBuildOutputNamespace' => $config->getBuildOutputNamespace(),
            'getBuildingFolders' => $config->getBuildingFolders(),
        ];

        $this->addCollector(new ConfigCollector($data));

        return $this;
    }
    

    public function message($message, $label = 'info') : self
    {
        $this['messages']->addMessage($message, $label);

        return $this;
    }
}