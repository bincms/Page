<?php

namespace Extension\Page\Converter;

use BinCMS\Converter\ConverterEventInterface;
use BinCMS\Converter\ConverterInterface;
use BinCMS\Converter\ConverterService;
use Extension\Page\Document\PageMetadata;

class PageMetadataConverter implements ConverterInterface
{
    public function convert($value, ConverterService $converterService, ConverterEventInterface $event)
    {
        return $this->convertValue($value, $converterService, $event);
    }

    private function convertValue(PageMetadata $pageMetadata, ConverterService $converterService, ConverterEventInterface $event)
    {
        return [
            'created' => $pageMetadata->getCreated()->format('c'),
            'updated' => $pageMetadata->getUpdated()->format('c')
        ];
    }
}