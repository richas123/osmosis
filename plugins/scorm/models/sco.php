<?php
class Sco extends ScormAppModel {

	var $name = 'Sco';
	var $validate = null;
	var $hasMany = array(
			'SubItem' => array('className' => 'Sco',
								'foreignKey' => 'parent_id',
								'dependent' => true),
			'Objective' => array('className' => 'Objective',
								'foreignKey' => 'sco_id',
								'dependent' => true),
	);
	var $actsAs = array('transaction');
	function __construct() {
		parent::__construct();
		$this->validate = array(
			'manifest' => array(
				'required' =>  array(
					'rule' => VALID_NOT_EMPTY,
					'message' => __('scormplugin.sco.manifest.empty', true),
					'required' => true
				)
			),
			'organization' => array(
				'required' =>  array(
					'rule' => VALID_NOT_EMPTY,
					'message' => __('scormplugin.sco.organization.empty', true),
					'required' => true
				)
			),
			'identifier' => array(
				'required' =>  array(
					'rule' => VALID_NOT_EMPTY,
					'message' => __('scormplugin.sco.identifier.empty', true),
					'required' => true)
				),
			'title' => array(
				'required' =>  array(
					'rule' => VALID_NOT_EMPTY,
					'message' => __('scormplugin.sco.title.empty', true),
					'required' => true
					)
				),
			'href' => array(
				'required' =>  array(
					'rule' => VALID_NOT_EMPTY,
					'message' => __('scormplugin.sco.href.empty', true),
					'required' => false
					)
				),
			'completionThreshold' => array(
				'required' =>  array(
					'rule' => 'decimal',
					'message' => __('scormplugin.sco.completionthreshold.decimal', true),
					'required' => false
					)
				),
			'isvisible' => array(
				'required' =>  array(
					'rule' => IS_BOOLEAN,
					'message' => __('scormplugin.sco.isvisible.boolean', true),
					'required' => false
					)
				),
			'attemptLimit' => array(
				'required' =>  array(
					'rule' => 'numeric',
					'message' => __('scormplugin.sco.attemptlimit.integer', true),
					'required' => false
					)
				),
			'attemptAbsoluteDurationLimit' => array(
				'required' =>  array(
					'rule' => VALID_NOT_EMPTY,
					'message' => __('scormplugin.sco.attemptabsolutedurationlimit.empty', true),
					'required' => false
					)
				),
			'dataFromLMS' => array(
				'required' =>  array(
					'rule' => VALID_NOT_EMPTY,
					'message' => __('scormplugin.sco.datafromlms.empty', true),
					'required' => false
					)
				),
			'scormType' => array(
				'required' =>  array(
					'rule' => '/(sco|asset)/',
					'message' => __('scormplugin.sco.scormtype.token', true),
					'required' => true
					)
				),
			'parameters' => array(
				'required' =>  array(
					'rule' => VALID_NOT_EMPTY,
					'message' => __('scormplugin.sco.parameters.empty', true),
					'required' => false
					)
				)
		);
	}
	
	function save($data=null,$validate=true,$fields=array()) {
		$this->begin();
		$saved = parent::save($data,$validate,$fields);
		if($saved && isset($data['SubItem'])) {
			foreach($data['SubItem'] as $sco){
				$sco['parent_id'] = $this->getLastInsertId();
				$this->SubItem->create();
				$saved = $this->SubItem->save($sco);
				if(!$saved)
					break;
			}
		}
		if($saved && isset($data['Objective'])) {
			foreach($data['Objective'] as $objective){
				$objective['sco_id'] = $this->getLastInsertId();
				$this->Objective->create();
				$saved = $this->Objective->save($objective);
				if(!$saved)
					break;
			}
		}
		if($saved) {
			$this->commit();
		} else {
			$this->rollback();
		}
		return $saved;
	}
	
}
?>