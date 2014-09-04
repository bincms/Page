<?php

namespace Extension\Page\Document;

use BinCMS\Document\Image;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * @MongoDB\Document(repositoryClass="Extension\Page\Repository\PageRepository")
 */
class Page implements Translatable
{

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @Gedmo\Translatable
     * @MongoDB\String
     */
    protected $title;

    /**
     * @MongoDB\EmbedOne(targetDocument="PageMetadata")
     */
    protected $metadata;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @MongoDB\String
     */
    protected $slug;

    /**
     * @Gedmo\Translatable
     * @MongoDB\String
     */
    protected $content;

    /**
     * @Gedmo\Locale
     */
    protected $locale;

    /**
     * @MongoDB\ReferenceOne(targetDocument="BinCMS\Document\User")
     */
    protected $author;

    /**
     * @MongoDB\Collection
     */
    protected $tags;

    /**
     * @MongoDB\ReferenceOne(targetDocument="BinCMS\Document\Image")
     */
    protected $image;

    public function __construct()
    {
        $this->setTags(new ArrayCollection());
        $this->setMetadata(new PageMetadata());
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param mixed $metadata
     */
    public function setMetadata(PageMetadata $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    public function addTag($tag)
    {
        $this->tags[] = $tag;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage(Image $image)
    {
        $this->image = $image;
    }
}