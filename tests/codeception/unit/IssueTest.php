<?php
namespace tests\codeception\unit;
use app\models\Issue;
use yii\db\ActiveQuery;
use yii\codeception\DbTestCase;
use tests\codeception\fixtures\ProjectFixture;
use tests\codeception\fixtures\IssueFixture;
class IssueTest extends DbTestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }
	
	public function fixtures()
    {
        return [
			'projects' => [
				'class' => ProjectFixture::className(),
                'dataFile' => '@tests/codeception/unit/fixtures/data/tbl_project.php'
			],
            'issues' => [
				'class' => IssueFixture::className(),
                'dataFile' => '@tests/codeception/unit/fixtures/data/tbl_issue.php'
			],
        ];
    }

    // tests
    public function testMe()
    {
    }
	
	// 测试获取issue的所有类型方法
    public function testGetTypes()
    {
		$issue = new Issue();
		$options = $issue->typeOptions;
		$this->assertTrue(is_array($options));
		$this-> assertTrue (3 ==  count ($options));
		$this-> assertTrue ( in_array ('Bug', $options));
		$this-> assertTrue ( in_array ('Feature', $options));
		$this-> assertTrue ( in_array ('Task', $options));
    }
	
	/* 测试获取issue的状态方法 */
	public function testGetStatus()
	{
		$issueBug = $this->issues('issueBug');
		//$this-> assertTrue ('进行中' === $issueBug->status);
		
	}

}