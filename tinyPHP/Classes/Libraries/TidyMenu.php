<?php namespace tinyPHP\Classes\Libraries;
/**
 *
 * TidyMenu Library
 *  
 * PHP 5
 *
 * tinyForum(tm) : Simple & Lightweight Forum (http://tinyforum.us/site/index)
 * Copyright 2012, 7 Media Web Solutions, LLC (http://www.7mediaws.org/)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, 7 Media Web Solutions, LLC (http://www.7mediaws.org/)
 * @link http://tinyforum.us/site/index tinyForum(tm) Project
 * @since tinyForum(tm) v 0.1
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
 
/**
 * Extends menu class and builds menu with readable HTML output.
 *
 * @author   Corey Worrell
 * @homepage http://coreyworrell.com
 * @version  1.0
 */

if ( ! defined('BASE_PATH') ) exit('No direct script access allowed');

class TidyMenu extends \tinyPHP\Classes\Libraries\Menu {

	public static function factory(Menu $menu = NULL)
	{
		return new \tinyPHP\Classes\Libraries\TidyMenu($menu);
	}
	
	public function __construct(Menu $menu = NULL)
	{
		if ( ! empty($menu))
		{
			$this->items = $menu->items;
			$this->current = $menu->current;
			$this->attrs = $menu->attrs;
		}
	}
	
	/**
	 * Renders the HTML output for the menu
	 *
	 * @param   array   Associative array of html attributes
	 * @param   array   Associative array containing the key and value of current url
	 * @param   array   The parent item's array, only used internally
	 * @return  string  HTML unordered list
	 */
	public function render(array $attrs = NULL, $current = NULL, array $items = NULL)
	{
		static $i;
		
		$items = empty($items) ? $this->items : $items;
		$current = empty($current) ? $this->current : $current;
		$attrs = empty($attrs) ? $this->attrs : $attrs;
		
		$i++;
		
		$menu = '<ul'.($i == 1 ? self::attributes($attrs) : NULL).'>'."\n".str_repeat("\t", $i - 1);
		
		foreach ($items as $key => $item)
		{
			$has_children = isset($item['children']);
			
			$class = array();
			
			$has_children ? $class[] = 'parent' : NULL;
			
			if ( ! empty($current))
			{
				if ($current_class = self::current($current, $item))
				{
					$class[] = $current_class;
				}
			}
			
			$classes = ! empty($class) ? self::attributes(array('class' => implode(' ', $class))) : NULL;
			
			$menu .= str_repeat("\t", $i).'<li'.$classes.'><a href="'.$item['url'].'">'.$item['title'].'</a>'.($has_children ? "\n".str_repeat("\t", $i + $i) : NULL);
			$menu .= $has_children ? $this->render(NULL, $current, $item['children']) : NULL;
			$menu .= ($has_children ? str_repeat("\t", $i) : NULL).'</li>'."\n".str_repeat("\t", $i - 1);
		}
		
		$menu .= str_repeat("\t", $i - 1).'</ul>'."\n".(($i - 2) >= 0 ? str_repeat("\t", $i - 2) : NULL);
		
		$i--;
		
		return $menu;
	}

}