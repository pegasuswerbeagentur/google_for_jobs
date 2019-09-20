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
        $jobs = $this->jobRepository->findAll();
        $this->view->assign('jobs', $jobs);
    }

    /**
     * action show
     * 
     * @param \Pegasus\GoogleForJobs\Domain\Model\Job $job
     * @return void
     */
    public function showAction(\Pegasus\GoogleForJobs\Domain\Model\Job $job)
    {
        $this->view->assign('job', $job);
    }
}
