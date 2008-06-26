<?php
class MatchingQuestionAnswer extends AppModel {
	var $name = 'MatchingQuestionAnswer';
	var $useTable = 'quiz_matching_questions_answers';
	
	var $belongsTo = array(
		'Member' => array(
			'className'		=> 'Member',
			'foreignKey'	=> 'member_id',
			'conditions'	=> '',
			'fields'		=> array('id','username', 'full_name'),
			'order'			=> ''
		),
		'MatchingQuestionQuestion' => array(
			'className'		=> 'Quiz.MatchingQuestion',
			'foreignKey'	=> 'matching_questions_quiz_id',
			'conditions'	=> '',
			'fields'		=> '',
			'order'			=> ''
		)
	);
	
	var $hasMany = array(
			'AnswerMatching' => array(
				'className'		=> 'Quiz.MatchingAnswer',
				'foreignKey'	=> 'matching_questions_answer_id',
				'dependent'		=> true,
			),
	);
}
?>