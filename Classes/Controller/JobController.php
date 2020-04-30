<?php
namespace Pegasus\GoogleForJobs\Controller;

/***
 *
 * This file is part of the "Google for Jobs" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Michael Kunst <kunst@pega-sus.de>, PEGASUS Werbeagentur GmbH
 *
 ***/
/**
 * JobController
 */
class JobController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * jobRepository
     * 
     * @var \Pegasus\GoogleForJobs\Domain\Repository\JobRepository
     * @inject
     */
    protected $jobRepository = null;

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {   
        if ($this->settings['job']['renderType'] != 'list') {
            $this->redirect('noJobFound');
        }
        $jobs = $this->jobRepository->findAll();
        $this->view->assign('jobs', $jobs);
    }

    /**
     * action show
     * 
     * Renders the job detail template and renders the jobs
     * structured data script tag to the html head. 
     * 
     * @param \Pegasus\GoogleForJobs\Domain\Model\Job $job
     * @return void
     */
    public function showAction(\Pegasus\GoogleForJobs\Domain\Model\Job $job)
    {   
        $structuredData = $job->createStructuredData();
        /** @var \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer */
        $pageRenderer = $this->objectManager->get(\TYPO3\CMS\Core\Page\PageRenderer::class);
        $pageRenderer->addHeaderData($structuredData);

        if($this->settings['job']['renderDetailTemplate']) {
            $this->view->assign('job', $job);
        }
    }

    /**
     * Render no job found template
     * 
     * @return void 
     */
    protected function noJobFoundAction()
    {
    }
}
