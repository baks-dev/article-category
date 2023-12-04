<?php
/*
 *  Copyright 2023.  Baks.dev <admin@baks.dev>
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is furnished
 *  to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 */

declare(strict_types=1);

namespace BaksDev\Article\Category\Entity;

use BaksDev\Article\Category\Entity\Event\ArticleCategoryEvent;
use BaksDev\Article\Category\Type\Event\ArticleCategoryEventUid;
use BaksDev\Article\Category\Type\Id\ArticleCategoryUid;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;


/* ArticleCategory */

#[ORM\Entity]
#[ORM\Table(name: 'article_category')]
class ArticleCategory
{
    public const TABLE = 'article_category';

    /**
     * Идентификатор сущности
     */
    #[Assert\NotBlank]
    #[Assert\Uuid]
    #[ORM\Id]
    #[ORM\Column(type: ArticleCategoryUid::TYPE)]
    private ArticleCategoryUid $id;

    /**
     * Идентификатор События
     */
    #[Assert\NotBlank]
    #[Assert\Uuid]
    #[ORM\Column(type: ArticleCategoryEventUid::TYPE, unique: true)]
    private ArticleCategoryEventUid $event;

    public function __construct()
    {
        $this->id = new ArticleCategoryUid();
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    /**
     * Идентификатор
     */
    public function getId(): ArticleCategoryUid
    {
        return $this->id;
    }

    /**
     * Идентификатор События
     */
    public function getEvent(): ArticleCategoryEventUid
    {
        return $this->event;
    }

    public function setEvent(ArticleCategoryEventUid|ArticleCategoryEvent $event): void
    {
        $this->event = $event instanceof ArticleCategoryEvent ? $event->getId() : $event;
    }
}