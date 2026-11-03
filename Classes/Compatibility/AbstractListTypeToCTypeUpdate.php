<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Compatibility;

/*
 * Upgrade wizards moved from EXT:install (TYPO3 v13) to EXT:core (TYPO3 v14).
 * This alias lets the wizards of this extension support both versions.
 */
if (class_exists(\TYPO3\CMS\Core\Upgrades\AbstractListTypeToCTypeUpdate::class)) {
    class_alias(\TYPO3\CMS\Core\Upgrades\AbstractListTypeToCTypeUpdate::class, AbstractListTypeToCTypeUpdate::class);
} elseif (class_exists(\TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate::class)) {
    class_alias(\TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate::class, AbstractListTypeToCTypeUpdate::class);
}
