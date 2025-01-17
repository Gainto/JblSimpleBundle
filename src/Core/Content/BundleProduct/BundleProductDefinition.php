<?php

declare(strict_types=1);

namespace JblSimpleBundle\Core\Content\BundleProduct;

use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CreatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IntField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\UpdatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class BundleProductDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'jbl_bundle_product';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return BundleProductEntity::class;
    }

    public function getCollectionClass(): string
    {
        return BundleProductCollection::class;
    }

    /**
     * @return FieldCollection
     */
    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new FkField('product_id', 'productId', ProductDefinition::class))->addFlags(new Required()),
            (new FkField('bundle_product_id', 'bundleProductId', ProductDefinition::class))->addFlags(new Required()),
            (new BoolField("active", "active"))->addFlags(new Required()),
            (new IntField("quantity", "quantity"))->addFlags(new Required()),
            (new CreatedAtField())->addFlags(new Required()),
            (new UpdatedAtField()),

            new ManyToOneAssociationField('product', 'product_id', ProductDefinition::class, 'id', false),
            new ManyToOneAssociationField('bundleProduct', 'bundle_product_id', ProductDefinition::class, 'id', true),
        ]);
    }
}
