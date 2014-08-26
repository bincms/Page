<?php


namespace Extension\Page;


use BinCMS\ExtensionInfoInterface;

class Info implements ExtensionInfoInterface
{
    public function getVersion()
    {
        return version_compare(1, 0);
    }

    public function getTitle()
    {
        return 'Страницы';
    }

    public function getDependencies()
    {
        return [];
    }
}