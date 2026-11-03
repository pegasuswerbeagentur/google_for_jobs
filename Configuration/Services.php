<?php

declare(strict_types=1);

use Pegasus\GoogleForJobs\Updates\PluginListTypeToCTypeUpdate;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator): void {
    $upgradeWizardsAvailable = interface_exists(\TYPO3\CMS\Core\Upgrades\UpgradeWizardInterface::class)
        || interface_exists(\TYPO3\CMS\Install\Updates\UpgradeWizardInterface::class);
    if (!$upgradeWizardsAvailable) {
        return;
    }

    $services = $configurator->services();
    $services->set(PluginListTypeToCTypeUpdate::class)
        ->autowire()
        ->public()
        ->tag('install.upgradewizard', ['identifier' => PluginListTypeToCTypeUpdate::IDENTIFIER]);
};
