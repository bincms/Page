<?php

namespace Extension\Page\Controller;

use BinCMS\Application;
use BinCMS\Converter\ConverterService;
use BinCMS\FilterBuilder\FilterBuilder;
use BinCMS\FilterBuilder\FilterType\ODM\InFilterType;
use BinCMS\FilterBuilder\FilterType\ODM\StringFilterType;
use BinCMS\Pagination\PaginationODM;
use BinCMS\Repository\Interfaces\ImageRepositoryInterface;
use Extension\Page\Document\Page;
use Extension\Page\Document\PageMetadata;
use Extension\Page\Form\PageForm;
use Extension\Page\Repository\Interfaces\PageRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator;

class PageController
{
    /**
     * @var \Extension\Page\Repository\Interfaces\PageRepositoryInterface
     */
    private $pageRepository;
    /**
     * @var \BinCMS\Converter\ConverterService
     */
    private $converterService;
    /**
     * @var \Symfony\Component\Validator\Validator
     */
    private $validator;
    /**
     * @var \BinCMS\Repository\Interfaces\ImageRepositoryInterface
     */
    private $imageRepository;

    public function __construct(PageRepositoryInterface $pageRepository, ImageRepositoryInterface $imageRepository, ConverterService $converterService,
                                Validator $validator)
    {
        $this->pageRepository = $pageRepository;
        $this->converterService = $converterService;
        $this->validator = $validator;
        $this->imageRepository = $imageRepository;
    }


    /**
     * @Route(pattern="/", method="GET")
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function mainAction(Application $app, Request $request)
    {
        $single = filter_var($request->get('single', false), \FILTER_VALIDATE_BOOLEAN);
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', null);

        $pagination = null;
        if(null !== $perPage) {
            $pagination = new PaginationODM($page, $perPage);
        }

        $filterBuilder = new FilterBuilder();
        $filterBuilder->add('slug', 'slug', new StringFilterType());
        $filterBuilder->add('tags', 'tags', new InFilterType());

        $filterBuilder->bindRequest($request);

        $result = $this->pageRepository->findAllWithFiltered($filterBuilder, $pagination, $single);

        if(null === $result) {
            $app->abort(404);
        }

        return $app->json($this->converterService->convert($result));
    }

    /**
     * @Route(pattern="/{id}", method="GET")
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAction(Application $app, $id)
    {
        $page = $this->pageRepository->find($id);

        if(null == $page) {
            return $app->abort(404);
        }

        return $app->json(
            $this->converterService->convert($page)
        );
    }

    /**
     * @Route(pattern="/", method="POST")
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createAction(Application $app, Request $request)
    {
        $pageForm = new PageForm();
        $pageForm->bindRequest($request);

        $errors = $this->validator->validate($pageForm);

        if (sizeof($errors) > 0) {
            return $app->json($this->converterService->convert($errors), 400);
        }

        $page = new Page();

        if(null !== $pageForm->imageId) {
            $image = $this->imageRepository->find($pageForm->imageId);
            if(null !== $image) {
                $page->setImage($image);
            }
        }

        if(mb_detect_encoding($pageForm->content) == 'ASCII') {
            $pageForm->content = mb_convert_encoding($pageForm->content, 'UTF-8', 'HTML-ENTITIES');
        }

        $page->setTitle($pageForm->title);
        $page->setContent($pageForm->content);
        $page->setTags($pageForm->tags);

        if($pageForm->slug === '') {
            $page->setSlug(null);
        } else {
            $page->setSlug($pageForm->slug);
        }

        $this->pageRepository->saveEntity($page);

        return $app->json(
            $this->converterService->convert($page)
        );
    }

    /**
     * @Route(pattern="/{id}", method="PUT")
     * @param Application $app
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateAction(Application $app, Request $request, $id)
    {
        $pageForm = new PageForm();
        $pageForm->bindRequest($request);

        $errors = $this->validator->validate($pageForm);

        if (sizeof($errors) > 0) {
            return $app->json($this->converterService->convert($errors), 400);
        }

        $page = $this->pageRepository->find($id);

        if(null === $page) {
            throw new \RuntimeException('Page not found');
        }

        if(mb_detect_encoding($pageForm->content) == 'ASCII') {
            $pageForm->content = mb_convert_encoding($pageForm->content, 'UTF-8', 'HTML-ENTITIES');
        }

        $page->setMetadata(new PageMetadata());
        $page->setTitle($pageForm->title);
        $page->setContent($pageForm->content);
        $page->setTags($pageForm->tags);

        if(null !== $pageForm->imageId) {
            $image = $this->imageRepository->find($pageForm->imageId);
            if(null !== $image) {
                $page->setImage($image);
            }
        }

        if($pageForm->slug === '') {
            $page->setSlug(null);
        } else {
            $page->setSlug($pageForm->slug);
        }

        $this->pageRepository->saveEntity($page);

        return $app->json(
            $this->converterService->convert($page)
        );
    }

    /**
     * @Route(pattern="/{id}", method="DELETE")
     * @param Application $app
     * @param $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function removeAction(Application $app, $id)
    {
        $page = $this->pageRepository->find($id);

        if(null === $page) {
            throw new \RuntimeException('Page not found');
        }

        $this->pageRepository->removeAndFlushEntity($page);

        return $app->json([
            'success' => true
        ]);
    }
}