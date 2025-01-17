<?php

declare(strict_types=1);

namespace JblSimpleBundle\Core\Content\BundleProduct;

use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class BundleProductEntity extends Entity
{
    use EntityIdTrait;

    protected string $productId;
    protected ?ProductEntity $product;
    protected string $bundleProductId;
    protected ProductEntity $bundleProduct;
    protected bool $active;
    protected int $quantity = 1;

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }

    public function getProduct(): ?ProductEntity
    {
        return $this->product;
    }

    public function setProduct(?ProductEntity $product): void
    {
        $this->product = $product;
    }

    public function getBundleProductId(): string
    {
        return $this->bundleProductId;
    }

    public function setBundleProductId(string $bundleProductId): void
    {
        $this->bundleProductId = $bundleProductId;
    }

    public function getBundleProduct(): ProductEntity
    {
        return $this->bundleProduct;
    }

    public function setBundleProduct(ProductEntity $bundleProduct): void
    {
        $this->bundleProduct = $bundleProduct;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}
