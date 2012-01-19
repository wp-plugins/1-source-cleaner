<?php
/*
Plugin Name: 1 Source Cleaner
Plugin URI: http://slackline.snapmix.jp/2012/01/16195244/
Description: This plugin is very simple.Reduce the size of the source code by removing the line blake and white space. <strong>;Note: Don't use html tag &lt;pre&gt; , please use &lt;div&gt; and &lt;code&gt; and CSS.</strong>If the tag does not appear, and decoding is performed to update the entry.
Author:momizibafu
Version: 1.1.1
Tags: html, code, performance
Author URI: http://slackline.snapmix.jp/
License:GPL2
Copyright 2012 Gondu Seiki (http://slackline.snapmix.jp/)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/





class source_cleaner {
    function source_cleaner() {
        add_action('get_header', array(&$this, 'get_header'), 2);
        add_action('wp_footer', array(&$this, 'wp_footer'), 9999);
    }

    function replace_source_cleaner($str) {
	$str = str_replace(array("\r\n","\n","\t","   "), "", $str);
        return str_replace($search, $replace, $str);
    }
    function get_header(){
        ob_start(array(&$this, 'replace_source_cleaner'));
    }
    function wp_footer(){
        ob_end_flush();
    }
}
new source_cleaner();


include "2-source-cleaner-ad.php";

// Escape HTML License: Copyright 2010  Satya Prakash  (email : ws@satya-weblog.com)
function escapeHTML($arr) {
		// last params (double_encode) was added in 5.2.3
	if (version_compare(PHP_VERSION, '5.2.3') >= 0) {
	
		$output = htmlspecialchars($arr[2], ENT_NOQUOTES, get_bloginfo('charset'), false); 
	}
	else {
		$specialChars = array(
            '&' => '&amp;',
            '<' => '&lt;',
            '>' => '&gt;'
		);
		// decode already converted data
		$data = htmlspecialchars_decode($arr[2]);
		// escapse all data inside <pre>
		$output = strtr($data, $specialChars);
	}
	if (! empty($output)) {
		return  $arr[1] . $output . $arr[3];
	}
	else
	{
		return  $arr[1] . $arr[2] . $arr[3];
	}
	
}
function filterCode($data) {

	$modifiedData = preg_replace_callback('@(<pre.*>)(.*)(<\/pre>)@isU', 'escapeHTML', $data);
	$modifiedData = preg_replace_callback('@(<code.*>)(.*)(<\/code>)@isU', 'escapeHTML', $modifiedData);
	$modifiedData = preg_replace_callback('@(<tt.*>)(.*)(<\/tt>)@isU', 'escapeHTML', $modifiedData);
 	return $modifiedData;
}
add_filter( 'content_save_pre', 'filterCode', 8 );
add_filter( 'excerpt_save_pre', 'filterCode', 8 );
?>