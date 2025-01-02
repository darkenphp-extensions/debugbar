<?php 

namespace Darken\Debugbar;

use Darken\Events\AfterBuildEvent;
use Darken\Events\EventDispatchInterface;
use Darken\Events\EventInterface;
use DebugBar\StandardDebugBar;
use Yiisoft\Files\FileHelper;

class SaveAssetsAfterBuild implements EventInterface
{
    /**
     * @param AfterBuildEvent $event
     */
    public function __invoke(EventDispatchInterface $event): void
    {
        // how could we directly get acces to public folder?
        $assetsFolder = $event->app->config->getRootDirectoryPath() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets';

        //if (!file_exists($assetsFolder)) {
        //    return;
        //}

        $assetsVendor = $assetsFolder . DIRECTORY_SEPARATOR . 'debugbar';
        FileHelper::ensureDirectory($assetsVendor);

        $dbbar = new StandardDebugBar();
        $jsRenderer = $dbbar->getJavascriptRenderer();
        //$jsRenderer->setBasePath('/Resources/vendor/');
        
        $assets = $jsRenderer->getAssets();

        $count = 0;
        foreach ($assets as $types) {
            foreach ($types as $file) {
                $sourceFile = $file;

                $targetFile = str_replace($jsRenderer->getBasePath(), '', $sourceFile);
                
                //echo $sourceFile . ' -> ' . $targetFile . PHP_EOL;
                $count++;
                FileHelper::copyFile($sourceFile, $assetsVendor . DIRECTORY_SEPARATOR . $targetFile);
            }
        }

        $event->app->stdOut($event->app->stdTextYellow('⎀') . " Copied $count debugbar assets to $assetsVendor");
    }
}