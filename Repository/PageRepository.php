<?php

namespace Extension\Page\Repository;

use BinCMS\RepositoryTrait\ExtendRepositoryTrait;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Extension\Page\Repository\Interfaces\PageRepositoryInterface;
use Extension\Shop\Repository\Traits\DocumentRepositoryFindAllWithFilteredMethod;

class PageRepository extends DocumentRepository implements PageRepositoryInterface
{
    use ExtendRepositoryTrait;
    use DocumentRepositoryFindAllWithFilteredMethod;
}