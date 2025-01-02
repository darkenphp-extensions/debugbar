<?php

namespace Darken\Debugbar\Build;

class Extension extends \Darken\Service\Extension
{
    public function __construct(\Darken\Debugbar\DebugBarConfig $debugBarConfig) {
            $this->registerDefinition('Darken\Debugbar\DebugBarConfig', $debugBarConfig);
        }

    public function getClassMap(): array
    {
        return array (
);
    }

    public function getSerializedEvents(): string
    {
        return 'YToxOntzOjI5OiJEYXJrZW5cRXZlbnRzXEFmdGVyQnVpbGRFdmVudCI7YToxOntpOjA7czozNjoiRGFya2VuXERlYnVnYmFyXFNhdmVBc3NldHNBZnRlckJ1aWxkIjt9fQ==';
    }

    public function getSerializedMiddlewares(): string
    {
        return 'YToxOntpOjA7YToyOntzOjk6ImNvbnRhaW5lciI7czozNDoiRGFya2VuXERlYnVnYmFyXERlYnVnQmFyTWlkZGxld2FyZSI7czo4OiJwb3NpdGlvbiI7RTozNjoiRGFya2VuXEVudW1cTWlkZGxld2FyZVBvc2l0aW9uOkFGVEVSIjt9fQ==';
    }
}