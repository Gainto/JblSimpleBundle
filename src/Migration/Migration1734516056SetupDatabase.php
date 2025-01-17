<?php

declare(strict_types=1);

namespace JblSimpleBundle\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

/**
 * @codingStandardsIgnoreFile
 */
class Migration1734516056SetupDatabase extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1734516056;
    }

    public function update(Connection $connection): void
    {
        $this->createBundleProductTable($connection);
    }

    public function createBundleProductTable(Connection $connection): void{
        $query = <<<SQL
            CREATE TABLE IF NOT EXISTS `jbl_bundle_product` (
              `id` binary(16) NOT NULL,
              `product_id` binary(16) NOT NULL,
              `bundle_product_id` binary(16) NOT NULL,
              `active` tinyint(1) NOT NULL,
              `quantity` int(4) DEFAULT 1 NOT NULL,
              `created_at` datetime(3) NOT NULL,
              `updated_at` datetime(3) DEFAULT NULL,
              PRIMARY KEY (`id`),
              CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `fk_bundle_product_id` FOREIGN KEY (`bundle_product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              UNIQUE KEY `unique_product_bundle` (`product_id`, `bundle_product_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        SQL;

        $connection->executeStatement($query);
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}