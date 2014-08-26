<?php

namespace Extension\Page\Repository;

use BinCMS\RepositoryTrait\RepositoryExtendTrait;
use BinCMS\RepositoryTrait\RepositoryFilteredTrait;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Extension\Page\Repository\Interfaces\PageRepositoryInterface;

class PageRepository extends DocumentRepository implements PageRepositoryInterface
{
    use RepositoryExtendTrait;
    use RepositoryFilteredTrait;
}