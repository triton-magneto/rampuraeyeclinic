<?php
/**
 * @Copyright
 * @package     TM Wrapper
 * @author      TemplateMonster
 * @link        http://www.templatemonster.com/
 *
 * @license     GNU/GPL
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Restricted access');

class PlgSystemTmWrapper extends JPlugin
{

    /**
     * Trigger onAfterRender executes the main plugin procedure
     */
    public function onAfterRender()
    {
        $app = JFactory::getApplication();
        if( !$app->isAdmin() )
        {
            $body = JFactory::getApplication()->getBody(false);
            preg_match_all('|<h[1-6][^>]*>(.*)</h[1-6]+>|iUs', $body, $matches);
            if(!empty($matches[0])){
                foreach($matches[1] as $k => $match){
                    preg_match('/<a\s+.*?href=".*"[^>]*>([^<]+)<\/a>/iUs', $match, $link);
                    if(!empty($link)){
                        $words = explode(' ', trim(strip_tags($link[1])));
                    }
                    else{
                        $words = explode(' ', trim(strip_tags($match)));
                    }
                    $string = "";
                    $string_length = count($words);
                    foreach($words as $key => $word){
                        $class= "item_title_part_" . $key;
                        if($key % 2){
                            $class.=" item_title_part_even";
                        }
                        else{
                            $class.=" item_title_part_odd";
                        }
                        if ($key*2<$string_length){
                            $class.=" item_title_part_first_half";
                        }
                        else{
                            $class.=" item_title_part_second_half";
                        }
                        if($key == 0){
                            $class.=" item_title_part_first";
                        }
                        if($key == $string_length-1){
                            $class.=" item_title_part_last";
                        }
                        $string .= '<span class="' . $class . '">'.$word.'</span> ';
                    }
                    $string = trim($string);
                    if(!empty($link)){
                        $string = str_replace($link[1], $string, $link[0]);
                    }
                    $match = str_replace($matches[1][$k], $string, $matches[0][$k]);
                    $body = str_replace($matches[0][$k], $match, $body);
                }
            }
            JFactory::getApplication()->setBody($body);
        }
    }
}