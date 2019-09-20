
plugin.tx_googleforjobs_job {
    view {
        templateRootPaths.0 = EXT:{extension.extensionKey}/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_googleforjobs_job.view.templateRootPath}
        partialRootPaths.0 = EXT:google_for_jobs/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_googleforjobs_job.view.partialRootPath}
        layoutRootPaths.0 = EXT:google_for_jobs/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_googleforjobs_job.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_googleforjobs_job.persistence.storagePid}
        #recursive = 1
    }
    features {
        #skipDefaultArguments = 1
        # if set to 1, the enable fields are ignored in BE context
        ignoreAllEnableFieldsInBe = 0
        # Should be on by default, but can be disabled if all action in the plugin are uncached
        requireCHashArgumentForActionArguments = 1
    }
    mvc {
        #callDefaultActionIfActionCantBeResolved = 1
    }
}

# these classes are only used in auto-generated templates
plugin.tx_googleforjobs._CSS_DEFAULT_STYLE (
    textarea.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    input.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    .tx-google-for-jobs table {
        border-collapse:separate;
        border-spacing:10px;
    }

    .tx-google-for-jobs table th {
        font-weight:bold;
    }

    .tx-google-for-jobs table td {
        vertical-align:top;
    }

    .typo3-messages .message-error {
        color:red;
    }

    .typo3-messages .message-ok {
        color:green;
    }
)
