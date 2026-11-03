<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Controller;

use Pegasus\GoogleForJobs\Domain\Model\Job;
use Pegasus\GoogleForJobs\Domain\Repository\JobRepository;
use Pegasus\GoogleForJobs\PageTitle\JobPageTitleProvider;
use Pegasus\GoogleForJobs\StructuredData\JobPostingBuilder;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\ErrorController;

/*
 * This file is part of the "Google for Jobs" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

class JobController extends ActionController
{
    private const RENDER_TYPES = ['list', 'show', 'listSelected'];

    public function __construct(
        protected readonly JobRepository $jobRepository,
        protected readonly JobPostingBuilder $jobPostingBuilder,
        protected readonly PageRenderer $pageRenderer,
        protected readonly JobPageTitleProvider $pageTitleProvider,
    ) {}

    /**
     * Dispatches to the view selected in the plugin settings without
     * a redirect, so no additional parameters end up in the URL.
     */
    public function indexAction(): ResponseInterface
    {
        $renderType = (string)($this->settings['job']['renderType'] ?? '');
        if (!in_array($renderType, self::RENDER_TYPES, true)) {
            $renderType = 'list';
        }
        return new ForwardResponse($renderType);
    }

    public function listAction(): ResponseInterface
    {
        $settings = $this->settings['job'] ?? [];
        $jobs = $this->jobRepository->findForList(
            GeneralUtility::intExplode(',', (string)($settings['categories'] ?? ''), true),
            (string)($settings['categoryConjunction'] ?? ''),
            (bool)($settings['hideExpired'] ?? true),
            (string)($settings['orderBy'] ?? ''),
            (string)($settings['orderDirection'] ?? ''),
        );
        $this->view->assign('jobs', $jobs);
        return $this->htmlResponse();
    }

    public function listSelectedAction(): ResponseInterface
    {
        $uids = GeneralUtility::intExplode(',', (string)($this->settings['job']['listSelected'] ?? ''), true);
        $this->view->assign('jobs', $this->jobRepository->findByUids($uids));
        return $this->htmlResponse();
    }

    public function initializeShowAction(): void
    {
        if (!$this->request->hasArgument('job')) {
            $this->throwPageNotFound('No job given');
        }
        $job = $this->request->getArgument('job');
        if (!is_scalar($job) || $this->jobRepository->findByUid((int)$job) === null) {
            $this->throwPageNotFound('Job not found');
        }
    }

    public function showAction(Job $job): ResponseInterface
    {
        $this->pageRenderer->addHeaderData(
            $this->jobPostingBuilder->render($this->jobPostingBuilder->build($job, $this->createUrlResolver())),
        );

        if ((bool)($this->settings['job']['setPageTitle'] ?? true)) {
            $this->pageTitleProvider->setTitle($job->getTitle());
        }

        if ((bool)($this->settings['job']['renderDetailTemplate'] ?? true)) {
            $this->view->assign('job', $job);
        }
        return $this->htmlResponse();
    }

    /**
     * @return (\Closure(string): string)|null
     */
    protected function createUrlResolver(): ?\Closure
    {
        $contentObject = $this->request->getAttribute('currentContentObject');
        if (!$contentObject instanceof ContentObjectRenderer) {
            return null;
        }
        return static fn(string $link): string => $contentObject->createUrl([
            'parameter' => $link,
            'forceAbsoluteUrl' => true,
        ]);
    }

    /**
     * @throws PropagateResponseException
     */
    protected function throwPageNotFound(string $reason): never
    {
        $response = GeneralUtility::makeInstance(ErrorController::class)
            ->pageNotFoundAction($this->request, $reason);
        throw new PropagateResponseException($response, 1730714400);
    }
}
