<?php 

loadModel('scorm.Rule');
loadModel('scorm.Rollup');
loadModel('scorm.Condition');

class RuleTestCase extends CakeTestCase {
	var $TestObject = null;
	var $fixtures = array('rule');
	
	function setUp() {
		$this->TestObject = new Rule();
		$this->TestObject->useDbConfig = 'test';
		$this->TestObject->tablePrefix = 'test_suite_';
	}

	function tearDown() {
		unset($this->TestObject);
	}

	function testValidation1() {
		$data = array();
		$this->TestObject->data = $data;
		$valid = $this->TestObject->validates();
		$expectedErrors = array (
			'type' => 'scorm.rule.type.allowedvalues',
			'action' => 'scorm.rule.action.allowedvalues'
		);
		$this->assertEqual($this->TestObject->validationErrors, $expectedErrors);
	}

	function testValidation2() {
		$data = array(
			'Rule' => array(
				'conditionCombination' => 'all',
			)
		);
		$this->TestObject->data = $data;
		$valid = $this->TestObject->validates();
		$expectedErrors = array (
			'type' => 'scorm.rule.type.allowedvalues',
			'action' => 'scorm.rule.action.allowedvalues'
		);
		$this->assertEqual($this->TestObject->validationErrors, $expectedErrors);
	}

	function testValidation3() {
		$allowedActions = array (
			'pre' => array('skip','disabled','hiddenFromChoice','stopForwardTraversal'),
			'post' => array('exitParent','exitAll','retry','retryAll','continue','previous'),
			'exit' => array('exit'),
			'rollup' => array('satisfied','notSatisfied','completed','incomplete')
		);
		foreach($allowedActions as $type => $actions) {
			foreach($actions as $action) {
				$data = array(
					'Rule' => array(
						'type' => $type,
						'conditionCombination' => 'any',
						'action' => $action
					)
				);
				$this->TestObject->create();
				$this->TestObject->data = $data;
				$valid = $this->TestObject->validates();
				$expectedErrors = array ();
				$this->assertEqual($this->TestObject->validationErrors, $expectedErrors);
			}
		}
	}

	function testValidation4() {
		$data = array(
			'Rule' => array (
				'type' => 'pre',
				'action' => 'skip',
				'minimumPercent' => '1',
				'minimumCount' => 'four'
			)
		);
		$this->TestObject->data = $data;
		$valid = $this->TestObject->validates();
		$expectedErrors = array (
			'minimumPercent' => 'scorm.rule.minimumpercent.decimal',
			'minimumCount' => 'scorm.rule.minimumcount.number'
		);
		$this->assertEqual($this->TestObject->validationErrors, $expectedErrors);
	}
	
	function testValidation5() {
		$data = array(
			'Rule' => array (
				'type' => 'pre',
				'action' => 'skip',
				'minimumPercent' => '-0.01',
				'minimumCount' => '-0.0000001'
			)
		);
		$this->TestObject->data = $data;
		$valid = $this->TestObject->validates();
		$expectedErrors = array (
			'minimumPercent' => 'scorm.rule.minimumpercent.range',
			'minimumCount' => 'scorm.rule.minimumcount.nonegative'
		);
		$this->assertEqual($this->TestObject->validationErrors, $expectedErrors);
	}
	
	function testValidation6() {
		$data = array(
			'Rule' => array (
				'type' => 'pre',
				'action' => 'skip',
				'minimumPercent' => '1.1',
				'minimumCount' => '1'
			)
		);
		$this->TestObject->data = $data;
		$valid = $this->TestObject->validates();
		$expectedErrors = array (
			'minimumPercent' => 'scorm.rule.minimumpercent.range'
		);
		$this->assertEqual($this->TestObject->validationErrors, $expectedErrors);
	}

	function testValidation7() {
		$data = array(
			'Rule' => array (
				'type' => 'pre',
				'action' => 'skip',
				'minimumPercent' => '0.11109',
			)
		);
		$this->TestObject->data = $data;
		$valid = $this->TestObject->validates();
		$expectedErrors = array ();
		$this->assertEqual($this->TestObject->validationErrors, $expectedErrors);
	}
	
	function testCRUD() {
		// Insert a new Condition
		$data = array (
			'type'				=> 'pre',
			'conditionCombination'	=> 'any',
			'action'				=> 'hiddenFromChoice',
			'minimumPercent'		=> '0.0000',
			'minimumCount'			=> '1'
		);
		
		$this->TestObject->save($data);
		$this->assertEqual(2, $this->TestObject->findCount());
		
		// Update the inserted Condition and Read
		$data = array (
			'type'				=> 'post',
			'conditionCombination'	=> 'any',
			'action'				=> 'exitAll',
			'minimumPercent'		=> '1.0000',
			'minimumCount'			=> '1'
		);
		$this->TestObject->save($data);
		$this->assertEqual(2, $this->TestObject->findCount());
		$last_id = $this->TestObject->getLastInsertID();
		$this->TestObject->id = $last_id;
		$expectedData = array(
			'Rule' => Set::merge(
				$data,
				array('id' => $last_id, 'rollup_id' => '') 
			),
			'Rollup' => array(),
			'Condition' => array()
		);
		$this->assertEqual($expectedData, $this->TestObject->read());
		
		// Delete
		$this->TestObject->delete();
		$this->assertEqual(1, $this->TestObject->findCount());
	}
}
?>
