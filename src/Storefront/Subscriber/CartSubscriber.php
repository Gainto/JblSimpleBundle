<?php

namespace JblSimpleBundle\Storefront\Subscriber;

use JblSimpleBundle\Core\Content\BundleProduct\BundleProductCollection;
use JblSimpleBundle\Core\Content\BundleProduct\BundleProductEntity;
use Shopware\Core\Checkout\Cart\Event\BeforeLineItemAddedEvent;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Content\Product\ProductCollection;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CartSubscriber implements EventSubscriberInterface
{
    public const SUPPORTED_BUNDLE_TYPES = [
        LineItem::PRODUCT_LINE_ITEM_TYPE
    ];

    /**
     * @param EntityRepository<ProductCollection> $productRepository
     */
    public function __construct(protected readonly EntityRepository $productRepository)
    {
    }


    public static function getSubscribedEvents(): array
    {
        return [
            BeforeLineItemAddedEvent::class => 'onBeforeLineItemAdded'
        ];
    }

    public function onBeforeLineItemAdded(BeforeLineItemAddedEvent $event): void
    {
        if (in_array($event->getLineItem()->getType(), self::SUPPORTED_BUNDLE_TYPES) === false) {
            return;
        }

        if ($event->getLineItem()->getReferencedId() === null) {
            return;
        }

        $criteria = new Criteria([$event->getLineItem()->getReferencedId()]);
        $criteria->addAssociation("bundleProducts");
        $product = $this->productRepository->search($criteria, $event->getContext())->first();

        if ($product === null) {
            return;
        }

        /** @var BundleProductCollection|null $bundleProducts */
        $bundleProducts = $product->getExtension("bundleProducts");

        if ($bundleProducts === null || $bundleProducts->count() === 0) {
            return;
        }

        /** @var BundleProductEntity $bundleProduct */
        foreach ($bundleProducts as $bundleProduct) {
            $event->getLineItem()->addChild(
                new LineItem(
                    Uuid::randomHex(),
                    "product",
                    $bundleProduct->getBundleProductId(),
                    $bundleProduct->getQuantity()
                )
            );
        }
    }
}
