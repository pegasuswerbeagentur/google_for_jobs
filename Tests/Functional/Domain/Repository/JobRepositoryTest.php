<?php

declare(strict_types=1);

namespace Pegasus\GoogleForJobs\Tests\Functional\Domain\Repository;

use Pegasus\GoogleForJobs\Domain\Model\Job;
use Pegasus\GoogleForJobs\Domain\Model\JobLocation;
use Pegasus\GoogleForJobs\Domain\Repository\JobRepository;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\TypoScript\AST\Node\RootNode;
use TYPO3\CMS\Core\TypoScript\FrontendTypoScript;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class JobRepositoryTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'pegasus/google-for-jobs',
    ];

    private JobRepository $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->importCSVDataSet(__DIR__ . '/Fixtures/Jobs.csv');
        $frontendTypoScript = new FrontendTypoScript(new RootNode(), [], [], []);
        $frontendTypoScript->setSetupArray([]);
        $GLOBALS['TYPO3_REQUEST'] = (new ServerRequest('https://example.com/'))
            ->withAttribute('applicationType', SystemEnvironmentBuilder::REQUESTTYPE_FE)
            ->withAttribute('frontend.typoscript', $frontendTypoScript);

        $this->subject = $this->get(JobRepository::class);
        $querySettings = $this->get(Typo3QuerySettings::class);
        $querySettings->setRespectStoragePage(false);
        $this->subject->setDefaultQuerySettings($querySettings);
    }

    /**
     * @param iterable<Job> $jobs
     * @return list<string>
     */
    private function titles(iterable $jobs): array
    {
        $titles = [];
        foreach ($jobs as $job) {
            $titles[] = $job->getTitle();
        }
        return $titles;
    }

    #[Test]
    public function expiredAndHiddenJobsAreNotListed(): void
    {
        $jobs = $this->subject->findForList(now: new \DateTimeImmutable('2026-11-03 15:00:00'));

        self::assertSame(['Alpha', 'Charlie', 'Echo'], $this->titles($jobs));
    }

    #[Test]
    public function expiredJobsAreListedIfConfigured(): void
    {
        $jobs = $this->subject->findForList(hideExpired: false);

        self::assertSame(['Alpha', 'Bravo', 'Charlie', 'Echo'], $this->titles($jobs));
    }

    public static function categoryFilterDataProvider(): \Generator
    {
        yield 'no filter' => [[1, 2], '', ['Alpha', 'Bravo', 'Charlie', 'Echo']];
        yield 'or' => [[1, 2], 'or', ['Alpha', 'Bravo', 'Charlie']];
        yield 'and' => [[1, 2], 'and', ['Bravo']];
        yield 'not or' => [[1, 2], 'notor', ['Echo']];
        yield 'not and' => [[1, 2], 'notand', ['Alpha', 'Charlie', 'Echo']];
        yield 'single category' => [[2], 'or', ['Bravo', 'Charlie']];
    }

    /**
     * @param list<int> $categories
     * @param list<string> $expected
     */
    #[Test]
    #[DataProvider('categoryFilterDataProvider')]
    public function jobsAreFilteredByCategories(array $categories, string $conjunction, array $expected): void
    {
        $jobs = $this->subject->findForList($categories, $conjunction, false);

        self::assertSame($expected, $this->titles($jobs));
    }

    public static function orderingDataProvider(): \Generator
    {
        yield 'default' => ['', '', ['Alpha', 'Bravo', 'Charlie', 'Echo']];
        yield 'title descending' => ['title', 'desc', ['Echo', 'Charlie', 'Bravo', 'Alpha']];
        yield 'date posted descending' => ['date_posted', 'desc', ['Echo', 'Charlie', 'Bravo', 'Alpha']];
        yield 'last change' => ['tstamp', 'asc', ['Echo', 'Charlie', 'Bravo', 'Alpha']];
        yield 'creation date' => ['crdate', 'asc', ['Alpha', 'Bravo', 'Charlie', 'Echo']];
        yield 'unknown field falls back to uid' => ['hidden; DROP TABLE pages', 'desc', ['Echo', 'Charlie', 'Bravo', 'Alpha']];
    }

    /**
     * @param list<string> $expected
     */
    #[Test]
    #[DataProvider('orderingDataProvider')]
    public function jobsAreOrderedByAllowedFieldsOnly(string $orderBy, string $direction, array $expected): void
    {
        $jobs = $this->subject->findForList([], '', false, $orderBy, $direction);

        self::assertSame($expected, $this->titles($jobs));
    }

    #[Test]
    public function selectedJobsKeepTheirOrderAndSkipUnavailableOnes(): void
    {
        $jobs = $this->subject->findByUids([3, 4, 99, 1]);

        self::assertSame(['Charlie', 'Alpha'], $this->titles($jobs));
    }

    #[Test]
    public function jobLocationsOfExistingDataAreResolvedInOrder(): void
    {
        $job = $this->subject->findByUid(1);
        self::assertInstanceOf(Job::class, $job);

        $cities = array_map(
            static fn(JobLocation $location): string => $location->getCity(),
            $job->getJobLocations()->toArray(),
        );

        self::assertSame(['Hamburg', 'Berlin'], $cities);
        self::assertSame('IT', $job->getFirstCategory()?->getTitle());
    }
}
