<?php
class ChoiceQuestionsController extends AppController {

	var $name = 'ChoiceQuestions';
	var $helpers = array('Html', 'Form' );

	function index() {
		$this->ChoiceQuestion->recursive = 0;
		$this->set('choiceQuestions', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid Choice Question.');
			$this->redirect(array('action'=>'index'), null, true);
		}
		$this->set('choiceQuestion', $this->ChoiceQuestion->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->cleanUpFields();
			$this->ChoiceQuestion->create();
			if ($this->ChoiceQuestion->save($this->data)) {
				$this->Session->setFlash('The Choice Question has been saved');
				$this->redirect(array('action'=>'index'), null, true);
			} else {
				$this->Session->setFlash('The Choice Question could not be saved. Please, try again.');
			}
		}
		$quizzes = $this->ChoiceQuestion->Quiz->generateList();
		$this->set(compact('quizzes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid Choice Question');
			$this->redirect(array('action'=>'index'), null, true);
		}
		if (!empty($this->data)) {
			$this->cleanUpFields();
			if ($this->ChoiceQuestion->save($this->data)) {
				$this->Session->setFlash('The Choice Question has been saved');
				$this->redirect(array('action'=>'index'), null, true);
			} else {
				$this->Session->setFlash('The Choice Question could not be saved. Please, try again.');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ChoiceQuestion->read(null, $id);
		}
		$quizzes = $this->ChoiceQuestion->Quiz->generateList();
		$this->set(compact('quizzes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for Choice Question');
			$this->redirect(array('action'=>'index'), null, true);
		}
		if ($this->ChoiceQuestion->del($id)) {
			$this->Session->setFlash('Choice Question #'.$id.' deleted');
			$this->redirect(array('action'=>'index'), null, true);
		}
	}

}
?>