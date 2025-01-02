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

    public function start($name, $label = null)
    {
        $this['time']->startMeasure($name, $label);
    }

    public function stop($name)
    {
        $this['time']->stopMeasure($name);
    }

    public function config(ConfigInterface $config)
    {
        $data = [
            'getDebugMode' => $config->getDebugMode(),
            'getRootDirectoryPath' => $config->getRootDirectoryPath(),
            'getBuildOutputFolder' => $config->getBuildOutputFolder(),
            'getBuildOutputNamespace' => $config->getBuildOutputNamespace(),
            'getBuildingFolders' => $config->getBuildingFolders(),
        ];
        
        $this->addCollector(new ConfigCollector($data));
    }
    

    public function message($message, $label = 'info')
    {
        $this['messages']->addMessage($message, $label);
    }
}