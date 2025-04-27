<?php
/*
 *  Copyright 2025.  Baks.dev <admin@baks.dev>
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

namespace BaksDev\Article\Category\Entity\Info;


use BaksDev\Article\Category\Entity\Event\ArticleCategoryEvent;
use BaksDev\Article\Category\Type\Id\ArticleCategoryUid;
use BaksDev\Core\Entity\EntityReadonly;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

/* Модификаторы событий ArticleCategoryInfo */

#[ORM\Entity]
#[ORM\Table(name: 'article_category_info')]
#[ORM\Index(columns: ['active'])]
class ArticleCategoryInfo extends EntityReadonly
{
    /**
     * Идентификатор сущности
     */
    #[Assert\NotBlank]
    #[Assert\Uuid]
    #[ORM\Id]
    #[ORM\Column(type: ArticleCategoryUid::TYPE)]
    private ArticleCategoryUid $main;

    /** ID события */
    #[Assert\NotBlank]
    #[Assert\Uuid]
    #[ORM\OneToOne(targetEntity: ArticleCategoryEvent::class, inversedBy: 'modify')]
    #[ORM\JoinColumn(name: 'event', referencedColumnName: 'id')]
    private ArticleCategoryEvent $event;

    /** Семантическая ссылка на раздел */
    #[ORM\Column(type: Types::STRING, unique: true)]
    private string $url;

    /** Статус активности раздела */
    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $active = true;


    public function __construct(ArticleCategoryEvent $event)
    {
        $this->event = $event;
        $this->main = $event->getMain();
    }

    public function __toString(): string
    {
        return (string) $this->main;
    }

    public function getDto($dto): mixed
    {
        $dto = is_string($dto) && class_exists($dto) ? new $dto() : $dto;

        if($dto instanceof ArticleCategoryInfoInterface)
        {
            return parent::getDto($dto);
        }

        throw new InvalidArgumentException(sprintf('Class %s interface error', $dto::class));
    }


    public function setEntity($dto): mixed
    {
        if($dto instanceof ArticleCategoryInfoInterface || $dto instanceof self)
        {
            return parent::setEntity($dto);
        }

        throw new InvalidArgumentException(sprintf('Class %s interface error', $dto::class));
    }
}