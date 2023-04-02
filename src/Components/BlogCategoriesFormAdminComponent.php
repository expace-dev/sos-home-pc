<?php

namespace App\Components;

use App\Entity\Categories;
use App\Form\Blog\Admin\CategoriesType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent('blog_categories_form_admin')]
class BlogCategoriesFormAdminComponent extends AbstractController {

    use LiveCollectionTrait;
    use DefaultActionTrait;

    #[LiveProp]
    public ?Categories $categorie = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(CategoriesType::class, $this->categorie);
    }
}