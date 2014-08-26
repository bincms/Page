<?php

namespace Extension\Page\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Document\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @MongoDB\Document
 */
class PageTranslation extends AbstractPersonalTranslation
{

} 