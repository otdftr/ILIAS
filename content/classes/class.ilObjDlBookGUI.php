<?php
/*
	+-----------------------------------------------------------------------------+
	| ILIAS open source                                                           |
	+-----------------------------------------------------------------------------+
	| Copyright (c) 1998-2001 ILIAS open source, University of Cologne            |
	|                                                                             |
	| This program is free software; you can redistribute it and/or               |
	| modify it under the terms of the GNU General Public License                 |
	| as published by the Free Software Foundation; either version 2              |
	| of the License, or (at your option) any later version.                      |
	|                                                                             |
	| This program is distributed in the hope that it will be useful,             |
	| but WITHOUT ANY WARRANTY; without even the implied warranty of              |
	| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the               |
	| GNU General Public License for more details.                                |
	|                                                                             |
	| You should have received a copy of the GNU General Public License           |
	| along with this program; if not, write to the Free Software                 |
	| Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA. |
	+-----------------------------------------------------------------------------+
*/

/**
* Class ilObjDlBookGUI
*
* @author Databay AG <ay@databay.de>
* @version $Id$
*
* @package content
*/

require_once "classes/class.ilObjectGUI.php";
require_once "content/classes/class.ilObjContentObjectGUI.php";

class ilObjDlBookGUI extends ilObjContentObjectGUI
{
	/**
	* Constructor
	*
	* @access	public
	*/
	function ilObjDlBookGUI($a_data,$a_id = 0,$a_call_by_reference = true, $a_prepare_output = true)
	{
        $this->type = "dbk";
		parent::ilObjContentObjectGUI($a_data,$a_id,$a_call_by_reference,$a_prepare_output);

	}

    
}
?>
