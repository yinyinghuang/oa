<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FinanceReviewsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FinanceReviewsTable Test Case
 */
class FinanceReviewsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FinanceReviewsTable
     */
    public $FinanceReviews;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.finance_reviews',
        'app.finances',
        'app.users',
        'app.departments',
        'app.roles',
        'app.privileges',
        'app.article_datas',
        'app.accounts',
        'app.follow_datas',
        'app.customers',
        'app.customer_categories',
        'app.customer_businesses',
        'app.tasks',
        'app.cs',
        'app.project_issue_solutions',
        'app.project_issues',
        'app.project_schedules',
        'app.projects',
        'app.project_progresses',
        'app.dropboxes',
        'app.files'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('FinanceReviews') ? [] : ['className' => 'App\Model\Table\FinanceReviewsTable'];
        $this->FinanceReviews = TableRegistry::get('FinanceReviews', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FinanceReviews);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
