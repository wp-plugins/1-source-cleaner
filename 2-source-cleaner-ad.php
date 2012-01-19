<?php
class source_cleaner_ad {
    function source_cleaner_ad() {
        add_action('get_header', array(&$this, 'get_header'), 1);
        add_action('shutdown', array(&$this, 'shutdown'), 1);
    }
    function replace_source_cleaner_ad($str) {
	$str = str_replace(array("google_ad_client"), "\r\ngoogle_ad_client", $str);
        return str_replace($search, $replace, $str);
    }
    function get_header(){
        ob_start(array(&$this, 'replace_source_cleaner_ad'));
    }
    function shutdown(){
        ob_end_flush();
    }
}
new source_cleaner_ad()
?>