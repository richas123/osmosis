<?php
/* SVN FILE: $Id$ */
/**
 * Ósmosis LMS: <http://www.osmosislms.org/>
 * Copyright 2008, Ósmosis LMS
 *
 * This file is part of Ósmosis LMS.
 * Ósmosis LMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Ósmosis LMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Ósmosis LMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @filesource
 * @copyright		Copyright 2008, Ósmosis LMS
 * @link			http://www.osmosislms.org/
 * @package			org.osmosislms
 * @subpackage		org.osmosislms.app
 * @since			Version 2.0 
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License Version 3
 */

class OsmosisPermissions extends Object {
	var $Courses = array(
			'index'	=> 'Member',
			'view'	=> 'Member',
			'enroll' => 'Member',
			'tools'	=> 'Professor'
		);
	var $Departments = array(
			'index'	=> 'Public',
			'view'	=> 'Public'
		);
	var $Dashboards = array();
	var $Members = array(
			'view'	=> 'Member',
			'edit'	=> 'Member',
			'online' => 'Member',
			'login'	=> 'Public',
			'logout' => 'Member',
			'recover' => 'Public',
			'security' => 'Member'
		);
}
?>