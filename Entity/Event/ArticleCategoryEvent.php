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

namespace BaksDev\Article\Category\Entity\Event;

use BaksDev\Article\Category\Entity\ArticleCategory;
use BaksDev\Article\Category\Entity\Modify\ArticleCategoryModify;
use BaksDev\Article\Category\Type\Event\ArticleCategoryEventUid;
use BaksDev\Article\Category\Type\Id\ArticleCategoryUid;
use BaksDev\Core\Entity\EntityEvent;
use BaksDev\Core\Entity\EntityState;
use BaksDev\Core\Type\Locale\Locale;
use BaksDev\Core\Type\Modify\ModifyAction;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;


/* ArticleCategoryEvent */

#[ORM\Entity]
#[ORM\Table(name: 'article_category_event')]
class ArticleCategoryEvent extends EntityState
{
    /**
     * Идентификатор События
     */
    #[Assert\NotBlank]
    #[Assert\Uuid]
    #[ORM\Id]
    #[ORM\Column(type: ArticleCategoryEventUid::TYPE)]
    private ArticleCategoryEventUid $id;

    /**
     * Идентификатор ArticleCategory
     */
    #[Assert\NotBlank]
    #[Assert\Uuid]
    #[ORM\Column(type: ArticleCategoryUid::TYPE, nullable: false)]
    private ?ArticleCategoryUid $main = null;

    /**
     * Модификатор
     */
    #[ORM\OneToOne(targetEntity: ArticleCategoryModify::class, mappedBy: 'event', cascade: ['all'], fetch: 'EAGER')]
    private ArticleCategoryModify $modify;



    public function __construct()
    {
        $this->id = new ArticleCategoryEventUid();
        $this->modify = new ArticleCategoryModify($this);

    }

    /**
     * Идентификатор События
     */

    public function __clone()
    {
        $this->id = new ArticleCategoryEventUid();
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public function getId(): ArticleCategoryEventUid
    {
        return $this->id;
    }

    /**
     * Идентификатор ArticleCategory
     */
    public function setMain(ArticleCategoryUid|ArticleCategory $main): void
    {
        $this->main = $main instanceof ArticleCategory ? $main->getId() : $main;
    }


    public function getMain(): ?ArticleCategoryUid
    {
        return $this->main;
    }

    public function getDto($dto): mixed
    {
        if($dto instanceof ArticleCategoryEventInterface)
        {
            return parent::getDto($dto);
        }

        throw new InvalidArgumentException(sprintf('Class %s interface error', $dto::class));
    }

    public function setEntity($dto): mixed
    {
        if($dto instanceof ArticleCategoryEventInterface)
        {
            return parent::setEntity($dto);
        }

        throw new InvalidArgumentException(sprintf('Class %s interface error', $dto::class));
    }


    //	public function isModifyActionEquals(ModifyActionEnum $action) : bool
    //	{
    //		return $this->modify->equals($action);
    //	}

    //	public function getUploadClass() : ArticleCategoryImage
    //	{
    //		return $this->image ?: $this->image = new ArticleCategoryImage($this);
    //	}

    //	public function getNameByLocale(Locale $locale) : ?string
    //	{
    //		$name = null;
    //		
    //		/** @var ArticleCategoryTrans $trans */
    //		foreach($this->translate as $trans)
    //		{
    //			if($name = $trans->name($locale))
    //			{
    //				break;
    //			}
    //		}
    //		
    //		return $name;
    //	}
}