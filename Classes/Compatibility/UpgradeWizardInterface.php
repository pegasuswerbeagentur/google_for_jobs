<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Compatibility;

/*
 * Upgrade wizards moved from EXT:install (TYPO3 v13) to EXT:core (TYPO3 v14).
 * This alias lets the wizards of this extension support both versions.
 */
if (interface_exists(\TYPO3\CMS\Core\Upgrades\UpgradeWizardInterface::class)) {
    class_alias(\TYPO3\CMS\Core\Upgrades\UpgradeWizardInterface::class, UpgradeWizardInterface::class);
} elseif (interface_exists(\TYPO3\CMS\Install\Updates\UpgradeWizardInterface::class)) {
    class_alias(\TYPO3\CMS\Install\Updates\UpgradeWizardInterface::class, UpgradeWizardInterface::class);
}
