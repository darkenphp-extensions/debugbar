<?php

namespace MyExtension\Build;

class Darken extends \Darken\Service\Extension
{
    public function getClassMap(): array
    {
        return array (
  'MyExtension\\Build\\Components\\ExampleComponent' => '/Components/ExampleComponent.php',
);
    }

    public function getSerializedEvents(): string
    {
        return 'YTowOnt9';
    }
}