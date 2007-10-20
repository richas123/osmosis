<?php 

loadModel('Member');
loadModel('Role');

class MemberTestCase extends CakeTestCase {
	var $TestObject = null;
	var $fixtures = array('member','role');

	function setUp() {
		$this->TestObject = new Member();
		$this->TestObject->useDbConfig = 'test_suite';
		$this->TestObject->tablePrefix = 'test_suite_';
		$this->TestObject->Role->useDbConfig = 'test_suite';
		$this->TestObject->Role->tablePrefix = 'test_suite_';
	}

	function tearDown() {
		unset($this->TestObject);
	}

	
	function testParentNode() {
		$this->TestObject->id = 1;
		$result = $this->TestObject->parentNode();
		$expected = array('model'=>'Role','foreign_key'=>1);
		$this->assertEqual($result, $expected);
	}

}
?>