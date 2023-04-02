<?php

namespace App\Components;

use App\Entity\Articles;
use App\Form\Blog\Admin\ArticleType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent('blog_articles_edit')]
class BlogArticlesEditComponent extends AbstractController {

    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(fieldName: 'data')]
    public ?Articles $article = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(ArticleType::class, $this->article);
    }
}