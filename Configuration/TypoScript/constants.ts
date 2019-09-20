
plugin.tx_googleforjobs_job {
    view {
        # cat=plugin.tx_googleforjobs_job/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:google_for_jobs/Resources/Private/Templates/
        # cat=plugin.tx_googleforjobs_job/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:google_for_jobs/Resources/Private/Partials/
        # cat=plugin.tx_googleforjobs_job/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:google_for_jobs/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_googleforjobs_job//a; type=string; label=Default storage PID
        storagePid =
    }
    settings {
        cssFile = EXT:google_for_jobs/Resources/Public/CSS/google_for_jobs-basic.css
    }
}
