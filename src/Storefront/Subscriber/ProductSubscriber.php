<?php

namespace JblSimpleBundle\Storefront\Subscriber;

use Shopware\Core\Content\Product\Events\ProductListingCriteriaEvent;
use Shopware\Core\Content\Product\ProductEvents;
use Shopware\Storefront\Page\Product\ProductPageCriteriaEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ProductPageCriteriaEvent::class => 'onBuildProductPageCriteria',
            ProductEvents::PRODUCT_LISTING_CRITERIA => 'onBuildProductListingCriteria',
        ];
    }

    /**
     * When loading the listing, we only need information whether the loaded products
     * are bundle products to display the respective badge in the storefront.
     * @param ProductListingCriteriaEvent $event
     * @return void
     */
    public function onBuildProductListingCriteria(ProductListingCriteriaEvent $event): void
    {
        $event->getCriteria()->addAssociation("bundleProducts");
    }

    /**
     * When creating detail page criteria, add bundleProduct with all needed information
     * @param ProductPageCriteriaEvent $event
     * @return void
     */
    public function onBuildProductPageCriteria(ProductPageCriteriaEvent $event): void
    {
        $event->getCriteria()->addAssociations([
            "bundleProducts",
            "bundleProducts.bundleProduct",
            "bundleProducts.bundleProduct.variation",
            "bundleProducts.bundleProduct.cover",
            "bundleProducts.bundleProduct.options",
            "bundleProducts.bundleProduct.options.group",
            "bundleProducts.bundleProduct.variantProduct",
            "bundleProducts.bundleProduct.variantProduct.options.group"
        ]);
    }
}
