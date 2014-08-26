<?php

namespace Extension\Page\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @MongoDB\EmbeddedDocument
 */
class PageMetadata
{
    /**
     * @Gedmo\Timestampable(on="create")
     * @MongoDB\Date
     */
    protected $created;

    /**
     * @Gedmo\Timestampable
     * @MongoDB\Date
     */
    protected $updated;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreated($createdAt)
    {
        $this->created = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdated($updatedAt)
    {
        $this->updated = $updatedAt;
    }

} 