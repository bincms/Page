<?php

namespace Extension\Page\Converter;

use BinCMS\Converter\ConverterEventInterface;
use BinCMS\Converter\ConverterInterface;
use BinCMS\Converter\ConverterService;
use BinCMS\Util\StringUtils;
use Extension\Page\Document\Page;

class PageConverter implements ConverterInterface
{
    public function convert($value, ConverterService $converterService, ConverterEventInterface $event)
    {
        return $this->convertValue($value, $converterService, $event);
    }

    private function convertValue(Page $page, ConverterService $converterService, ConverterEventInterface $event)
    {

        $content = htmlspecialchars_decode($page->getContent());

        return [
            'id' => $page->getId(),
            'title' => $page->getTitle(),
            'content' =>  $page->getContent(),
            'announcement' => StringUtils::truncate(strip_tags($content), 100),
            'slug' => $page->getSlug(),
            'image' => $converterService->convert($page->getImage()),
            'metadata' => $converterService->convert($page->getMetadata()),
            'tags' => $page->getTags()

        ];
    }

    private function  cutString($string, $length)
    {
        if (mb_strlen($string) > $length) {
            $substring = mb_substr($string, 0, $length);
            if (strrpos($substring, ' ')) {
                return substr($substring, 0, strrpos($substring, ' ')) . '...';
            } else {
                return $substring;
            }
        } else {
            return $string;
        }
    }
}