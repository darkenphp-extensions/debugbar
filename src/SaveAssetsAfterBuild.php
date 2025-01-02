<?php 

namespace Darken\Debugbar;

use Darken\Events\AfterBuildEvent;
use DebugBar\StandardDebugBar;
use Yiisoft\Files\FileHelper;

class SaveAssetsAfterBuild
{
    public static function handle (AfterBuildEvent $event) {
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

        foreach ($assets as $types) {
            foreach ($types as $file) {
                $sourceFile = $file;

                $targetFile = str_replace($jsRenderer->getBasePath(), '', $sourceFile);
                
                echo $sourceFile . ' -> ' . $targetFile . PHP_EOL;

                FileHelper::copyFile($sourceFile, $assetsVendor . DIRECTORY_SEPARATOR . $targetFile);
            }
        }
    }
}