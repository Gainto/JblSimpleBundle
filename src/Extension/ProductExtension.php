<?php

namespace JblSimpleBundle\Extension;

use JblSimpleBundle\Core\Content\BundleProduct\BundleProductDefinition;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class ProductExtension extends EntityExtension
{
    /**
     * @return string
     */
    public function getDefinitionClass(): string
    {
        return ProductDefinition::class;
    }

    /**
     * @param FieldCollection $collection
     * @return void
     */
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField('bundleProducts', BundleProductDefinition::class, 'product_id', 'id')
        );
    }
}
