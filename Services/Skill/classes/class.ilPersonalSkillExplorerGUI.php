<?php
/* Copyright (c) 1998-2013 ILIAS open source, Extended GPL, see docs/LICENSE */

include_once("./Services/UIComponent/Explorer2/classes/class.ilTreeExplorerGUI.php");
include_once("./Services/Skill/classes/class.ilSkillTreeNode.php");

/**
 * Explorer for selecting a personal skill
 *
 * @author	Alex Killing <alex.killing@gmx.de>
 * @version	$Id$
 *
 * @ingroup ServicesUIComponent
 */
class ilPersonalSkillExplorerGUI extends ilTreeExplorerGUI
{
	/**
	 * Constructor
	 */
	public function __construct($a_parent_obj, $a_parent_cmd)
	{
		include_once("./Services/Skill/classes/class.ilSkillTree.php");
		$this->tree = new ilSkillTree();
		$this->root_id = $this->tree->readRootId();
		
		parent::__construct("pskill_sel", $a_parent_obj, $a_parent_cmd, $this->tree);
		$this->setSkipRootNode(true);
		
		$this->all_nodes = $this->tree->getSubTree($this->tree->getNodeData($this->root_id));
		foreach ($this->all_nodes as $n)
		{
			$this->node[$n["child"]] = $n;
			$this->child_nodes[$n["parent"]][] = $n;
			$this->parent[$n["child"]] = $n["parent"];
//echo "-$k-"; var_dump($n);
		}

		
//		$this->setTypeWhiteList(array("skrt", "skll", "scat", "sktr"));
		$this->buildSelectableTree($this->tree->readRootId());
	}

	/**
	 * Build selectable tree
	 *
	 * @param
	 * @return
	 */
	function buildSelectableTree($a_node_id)
	{
//echo "<br>-$a_node_id-";
		if (ilSkillTreeNode::_lookupSelfEvaluation($a_node_id))
		{
			$this->selectable[$a_node_id] = true;
			$this->selectable[$this->parent[$a_node_id]] = true;
		}
		foreach ($this->getOriginalChildsOfNode($a_node_id) as $n)
		{
//echo "+".$n["child"]."+";
			$this->buildSelectableTree($n["child"]);
		}
		if ($this->selectable[$a_node_id] &&
			!ilSkillTreeNode::_lookupDraft($a_node_id))
		{
			$this->selectable_child_nodes[$this->node[$a_node_id]["parent"]][] =
				$this->node[$a_node_id];
		}
	}

	/**
	 * Get childs of node (selectable tree)
	 *
	 * @param int $a_parent_id parent id
	 * @return array childs
	 */
	function getChildsOfNode($a_parent_id)
	{
		if (is_array($this->selectable_child_nodes[$a_parent_id]))
		{
			$childs =  $this->selectable_child_nodes[$a_parent_id];
			$childs = ilUtil::sortArray($childs, "order_nr", "asc", true);
			return $childs;
		}
		return array();
	}

	/**
	 * Get original childs of node (whole tree)
	 *
	 * @param int $a_parent_id parent id
	 * @return array childs
	 */
	function getOriginalChildsOfNode($a_parent_id)
	{
		if (is_array($this->child_nodes[$a_parent_id]))
		{
			return $this->child_nodes[$a_parent_id];
		}
		return array();
	}

	/**
	 * Get href for node
	 *
	 * @param mixed $a_node node object/array
	 * @return string href attribute
	 */
	function getNodeHref($a_node)
	{
		global $ilCtrl;
		
		$skill_id = $a_node["child"];
		
		$ilCtrl->setParameterByClass("ilpersonalskillsgui", "obj_id", $skill_id);
		$ret = $ilCtrl->getLinkTargetByClass("ilpersonalskillsgui", "addSkill");
		$ilCtrl->setParameterByClass("ilpersonalskillsgui", "obj_id", "");
		
		return $ret;
	}

	/**
	 * Get node content
	 *
	 * @param array 
	 * @return
	 */
	function getNodeContent($a_node)
	{
		global $lng;

		// title
		$title = $a_node["title"];

		return $title;
	}
	
	/**
	 * Is clickable
	 *
	 * @param
	 * @return
	 */
	function isNodeClickable($a_node)
	{
		if (!ilSkillTreeNode::_lookupSelfEvaluation($a_node["child"]))
		{
			return false;
		}
		return true;
	}
	
	/**
	 * get image path (may be overwritten by derived classes)
	 */
	function getNodeIcon($a_node)
	{
		$t = $a_node["type"];
		if (in_array($t, array("sktr")))
		{
			return ilUtil::getImagePath("icon_skll_s.png");
		}
		return ilUtil::getImagePath("icon_".$t."_s.png");
	}

}

?>
