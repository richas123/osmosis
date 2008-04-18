<?php
/**
 * Helper class responsible for rendering placeholders
 *
 */

class PlaceholderHelper extends AppHelper {
	
	var $helpers = array('Html');
	
	/**
	 * Renders a type of placeholder
	 *
	 * @param string $type 
	 * @return string the rendered placeholder
	 */
	
	function render($type) {
		
		$view = ClassRegistry::getObject('view');
		$buffer = '';
		if(!isset( $view->data['placeholders'][$type])) {
			$this->_pullData($type);
		}
		$subscribers = $view->data['placeholders'][$type];
		
		if (empty($subscribers))
			return '';
			
		ob_start();
		foreach ($subscribers as $subscriber => $data) {
			$parts = explode('_',Inflector::underscore($subscriber));
			$plugin = $parts[0];
			echo $view->renderElement('placeholders/'.$type, array('plugin'=>$plugin,'cache'=>$data['cache'],'data' =>$data['data']));
		}
		return ob_get_clean();
	}
	
	/**
	 * Pulls data from the controller if not available in the view
	 *
	 * @param string $type 
	 * @return void
	 */
	
	private function _pullData($type) {
		
		$controller =& ClassRegistry::getObject('controller');
		if (!isset($controller->Placeholder))
			return;
		$controller->Placeholder->attach($type);
		$data = $controller->Placeholder->pullData($type);
		$view =& ClassRegistry::getObject('view');
		
		if (!isset($view->data['placeholders']) || !is_array($view->data['placeholders'])) {
			$view->data['placeholders'] = array();
		}
		
		if (!isset($view->data['placeholders'][$type]) || !is_array($view->data['placeholders'][$type])) {
			$view->data['placeholders'][$type] = array();
		}
		
		$view->data['placeholders'][$type] = am($view->data['placeholders'][$type],$data);
	}
}
?>