<?php
class ChoiceQuestionAnswer extends QuizAppModel {
	var $name = 'ChoiceQuestionAnswer';
	var $useTable = 'quiz_choice_questions_answers';
	
	var $belongsTo = array(
		'Member' => array(
			'className'		=> 'Member',
			'foreignKey'	=> 'member_id',
			'conditions'	=> '',
			'fields'		=> array('id','username', 'full_name'),
			'order'			=> ''
		),
		'ChoiceQuestion' => array(
			'className'		=> 'Quiz.ChoiceQuestion',
			'foreignKey'	=> 'choice_questions_quiz_id',
			'conditions'	=> '',
			'fields'		=> '',
			'order'			=> ''
		)
	);
	
	var $hasMany = array(
		'AnswerChoice' => array(
			'className'		=> 'Quiz.ChoiceAnswer',
			'foreignKey'	=> 'choice_questions_answer_id',
			'dependent'		=> true,
		),
	);
}
?>