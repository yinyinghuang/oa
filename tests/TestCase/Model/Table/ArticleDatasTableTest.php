<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ArticleDatasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ArticleDatasTable Test Case
 */
class ArticleDatasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ArticleDatasTable
     */
    public $ArticleDatas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.article_datas',
        'app.accounts',
        'app.follow_datas',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ArticleDatas') ? [] : ['className' => 'App\Model\Table\ArticleDatasTable'];
        $this->ArticleDatas = TableRegistry::get('ArticleDatas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ArticleDatas);

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
