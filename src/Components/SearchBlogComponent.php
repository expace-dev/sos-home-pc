<?php

namespace App\Components;

use App\Repository\ArticlesRepository;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('search_blog')]
class SearchBlogComponent {

    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';



    public function __construct(private ArticlesRepository $articlesRepository)
    {
    }

    public function getBlogpost(): array {

        return $this->articlesRepository->findByQuery($this->query);

    }
    
}