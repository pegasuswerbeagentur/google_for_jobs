<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Updates;

use Pegasus\GoogleForJobs\Compatibility\AbstractListTypeToCTypeUpdate;

/**
 * Migrates existing "Insert plugin" content elements of this extension
 * (CType "list", list_type "googleforjobs_job") to the dedicated content
 * element type "googleforjobs_job". Plugin settings stay untouched.
 */
final class PluginListTypeToCTypeUpdate extends AbstractListTypeToCTypeUpdate
{
    public const IDENTIFIER = 'googleForJobs_pluginListTypeToCType';

    public function getTitle(): string
    {
        return 'Google for Jobs: Migrate plugin to content element';
    }

    public function getDescription(): string
    {
        return 'Migrates content elements of type "Insert plugin" with the Google for Jobs plugin to the dedicated content element type and adjusts backend user group permissions accordingly.';
    }

    protected function getListTypeToCTypeMapping(): array
    {
        return [
            'googleforjobs_job' => 'googleforjobs_job',
        ];
    }
}
