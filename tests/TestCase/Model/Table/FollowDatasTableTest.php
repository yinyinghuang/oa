<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FollowDatasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FollowDatasTable Test Case
 */
class FollowDatasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FollowDatasTable
     */
    public $FollowDatas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.follow_datas',
        'app.accounts',
        'app.article_datas',
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
        $config = TableRegistry::exists('FollowDatas') ? [] : ['className' => 'App\Model\Table\FollowDatasTable'];
        $this->FollowDatas = TableRegistry::get('FollowDatas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FollowDatas);

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
