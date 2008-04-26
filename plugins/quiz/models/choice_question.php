<?php
class ChoiceQuestion extends QuizAppModel {

	var $name = 'ChoiceQuestion';
	var $validate = array(
		'body' => array(
			'required' => array(
				'rule' => array('custom', '/.+/')
			)
		),
		'max_choices' => array(
			'positive' => array(
				'rule' => array('comparison', '>', 0),
				'allowEmpty' => true
			)
		),
		'min_choices' => array(
			'min_less_than_max' => array(
				'rule' => array('minLessThanMax'),
				'allowEmpty' => true
			),
			'positive' => array(
				'rule' => array('comparison', '>', 0)
			)
		),
		'num_correct' => array(
			'valid' => array(
				'rule' => array('numCorrectChoicesAvailable')
			)
		)
	);

	var $useTable = 'quiz_choice_questions';
	var $hasMany = array(
		'ChoiceChoice' => array(
			'className' => 'quiz.ChoiceChoice',
			'foreignKey' => 'choice_question_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'dependent' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'Quiz' => array(
			'className' => 'quiz.Quiz',
			'joinTable' => 'quiz_choice_questions_quizzes',
			'foreignKey' => 'choice_question_id',
			'associationForeignKey' => 'quiz_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'unique' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => '',
			'with' => 'QuizChoice'
		)
	);
	
	function __construct($id = false, $table = null, $ds = null) {
		$this->setErrorMessage(
			'body.required',
			__('This field is required',true)
		);
		$this->setErrorMessage(
			'max_choices.positive',
			__('Max Choices should be greater than zero',true)
		);
		$this->setErrorMessage(
			'min_choices.min_less_than_max',
			__('Min Choices should be less than Max Choices',true)
		);
		$this->setErrorMessage(
			'min_choices.positive',
			__('Min Choices should be greater than zero',true)
		);
		$this->setErrorMessage(
			'num_correct.valid',
			__('The number of correct answers is not enough compared to Min Choices',true)
		);
		parent::__construct($id, $table, $ds);
	}

	function beforeValidate() {
		parent::beforeValidate();
		$positions = array_filter(Set::extract($this->data, 'ChoiceChoice.{n}.position'));
		$repeated = Set::diff($positions, array_unique($positions));
		$done = $invalidChoiceChoices = array();
		$total = count($this->data['ChoiceChoice']);
		
		foreach ($this->data['ChoiceChoice'] as $i => $choice) {
			$choice['total'] = $total;
			$this->ChoiceChoice->set(array('ChoiceChoice' => $choice));
			$this->ChoiceChoice->validates();
			$valErrors = $this->ChoiceChoice->validationErrors;
			if (in_array($choice['position'], $repeated) && !in_array($choice['position'], $done)) {
				$invalidChoiceChoices[$i] = array('position' => __('This position is repeated', true));
				$done[] = $choice['position'];
				$invalidChoiceChoices[$i] = array_merge($invalidChoiceChoices[$i], $valErrors);
			} elseif (!empty($valErrors)) {
				$invalidChoiceChoices[$i] = $valErrors;
			}
		}
		if (!empty($invalidChoiceChoices)) {
			$this->ChoiceChoice->validationErrors = $invalidChoiceChoices;
			$this->validationErrors['ChoiceChoice'] = $invalidChoiceChoices;
		}
		return true;
	}
	
	function minLessThanMax() {
		if (empty($this->data['ChoiceQuestion']['max_choices'])) return true;
		return intval($this->data['ChoiceQuestion']['min_choices'])<=intval($this->data['ChoiceQuestion']['max_choices']);
	}
	
	function numCorrectChoicesAvailable() {
		if (empty($this->data['ChoiceQuestion']['min_choices'])) return true;
		return (intval($this->data['ChoiceQuestion']['num_correct']) >= intval($this->data['ChoiceQuestion']['min_choices']));
	}
}
?>