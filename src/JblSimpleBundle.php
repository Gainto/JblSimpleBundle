<?php

declare(strict_types=1);

namespace JblSimpleBundle;

use Doctrine\DBAL\Connection;
use JblSimpleBundle\Core\Content\BundleProduct\BundleProductDefinition;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;

class JblSimpleBundle extends Plugin
{

    public function install(InstallContext $installContext): void
    {
        parent::install($installContext);
    }

    public function uninstall(UninstallContext $uninstallContext): void
    {
        if ($uninstallContext->keepUserData() || $this->container === null) {
            return;
        }

        $connection = $this->container->get(Connection::class);
        if (!$connection instanceof Connection) {
            return;
        }

        $tables = [
          BundleProductDefinition::ENTITY_NAME
        ];

        foreach ($tables as $table) {
            $connection->executeStatement(sprintf('DROP TABLE IF EXISTS %s', $table));
        }
    }
}
