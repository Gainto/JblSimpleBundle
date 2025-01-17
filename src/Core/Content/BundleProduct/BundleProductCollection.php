<?php

declare(strict_types=1);

namespace JblSimpleBundle\Core\Content\BundleProduct;

use Shopware\Core\Content\Product\ProductCollection;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;
use Shopware\Core\System\Tax\TaxCollection;

/**
 * @extends                  EntityCollection<BundleProductEntity>
 * @method void              add(BundleProductEntity $entity)
 * @method void              set(string $key, BundleProductEntity $entity)
 * @method BundleProductEntity[]    getIterator()
 * @method BundleProductEntity[]    getElements()
 * @method BundleProductEntity|null get(string $key)
 * @method BundleProductEntity|null first()
 * @method BundleProductEntity|null last()
 */
class BundleProductCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return BundleProductEntity::class;
    }
}
