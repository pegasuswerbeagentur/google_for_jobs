
plugin.tx_googleforjobs_job {
    view {
        templateRootPaths.0 = EXT:{extension.extensionKey}/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_googleforjobs_job.view.templateRootPath}
        partialRootPaths.0 = EXT:google_for_jobs/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_googleforjobs_job.view.partialRootPath}
        layoutRootPaths.0 = EXT:google_for_jobs/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_googleforjobs_job.view.layoutRootPath}
    }
    features {
        #skipDefaultArguments = 1
        # if set to 1, the enable fields are ignored in BE context
        ignoreAllEnableFieldsInBe = 0
        # Should be on by default, but can be disabled if all action in the plugin are uncached
        requireCHashArgumentForActionArguments = 1
    }
    settings {
        job {
            renderDetailTemplate = 1
        }
    }
}