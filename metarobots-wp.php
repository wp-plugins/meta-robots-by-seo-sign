<?php
/*
Plugin Name: MetaRobots by SEO-Sign
Plugin URI: http://www.seo-sign.com/p/simple-ways-to-manage-meta-robots-tag.html
Description: The easiest way to manage meta robots tag.
Version: 1.0.0
Author: Artem Pilipec
Author URI: https://profiles.wordpress.org/artem-pilipets/
*/
/*  Copyright 2015  Artem Pilipec  (email: artem.shatamba@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
define('MRS_PATH', plugin_dir_path(__FILE__));
include_once MRS_PATH . 'settings.php';
function mrs_create_metaRobotsTxt() {
    $metaRobotsFile = fopen("metarobots.txt", "w+") or die("Unable to open file!");
    $txt = "Allow: *\n";
    fwrite($metaRobotsFile, $txt);
    fclose($metaRobotsFile);
}
function metarobots_mrs() {
    $lines = file('metarobots.txt');
    $setMetaRobots = false;
    foreach($lines as $line_num => $line) {
        $lines[$line_num] = str_replace(' ', '', trim($lines[$line_num]));
        if ($lines[$line_num] != '') {
            $arr = explode(':', trim($lines[$line_num]));
            $instruction = $arr[0];
            $metaRobotsRule = $arr[1];
            if (isset($arr[2])) {
                $canonicalurl = $arr[2];
            } else {
                $canonicalurl = '';
            }
            if ((($instruction) and ($metaRobotsRule)) != '') {
                $metaRobotsRule = str_replace(array(',','.','*','/','?'), array('\,','\.','.*','\/','\?'), $metaRobotsRule);
                $instruction = strtolower($instruction);
                if ($metaRobotsRule != '') {
                    if (preg_match('/^' . $metaRobotsRule . '.*$/', $_SERVER['REQUEST_URI'])) {
                        if ('disallow' == $instruction) {
                            echo '<meta name="robots" content="noindex, nofollow">' . "\n";
                            $setMetaRobots = true;
                            break;
                        }
                        if ('follow' == $instruction) {
                            echo '<meta name="robots" content="noindex, follow">' . "\n";
                            $setMetaRobots = true;
                            break;
                        }
                        if ('index' == $instruction) {
                            echo '<meta name="robots" content="index, nofollow">' . "\n";
                            $setMetaRobots = true;
                            break;
                        }
                        if ('noarchive' == $instruction) {
                            echo '<meta name="robots" content="noarchive">' . "\n";
                            $setMetaRobots = true;
                            break;
                        }
                        if ('nosnippet' == $instruction) {
                            echo '<meta name="robots" content="nosnippet">' . "\n";
                            $setMetaRobots = true;
                            break;
                        }
                        if ('noodp' == $instruction) {
                            echo '<meta name="robots" content="noodp">' . "\n";
                            $setMetaRobots = true;
                            break;
                        }
                        if ('notranslate' == $instruction) {
                            echo '<meta name="robots" content="notranslate">' . "\n";
                            $setMetaRobots = true;
                            break;
                        }
                        if ('noimageindex' == $instruction) {
                            echo '<meta name="robots" content="noimageindex">' . "\n";
                            $setMetaRobots = true;
                            break;
                        }
                        if ('canonical' == $instruction) { 
                            if (preg_match('/\+/', $canonicalurl)) { 
                                $canonicalurl = str_replace('+', '', $canonicalurl);
                                list($baseurl) = explode($canonicalurl, trim($_SERVER['REQUEST_URI'])); 
                                $canonicalurl = $_SERVER['HTTP_HOST'] . $baseurl . $canonicalurl; 
                                if ($canonicalurl == '/') {
                                    $canonicalurl = $_SERVER['HTTP_HOST'];
                                } 
                                
                            }
                            if (preg_match('/\-/', $canonicalurl)) { 
                                $canonicalurl = str_replace('-', '', $canonicalurl); 
                                list($baseurl) = explode($canonicalurl, trim($_SERVER['REQUEST_URI'])); 
                                $canonicalurl = $_SERVER['HTTP_HOST'] . $baseurl; 
                                if ($canonicalurl == '/') {
                                    $canonicalurl = $_SERVER['HTTP_HOST'];
                                } 
                                
                            }
                            echo '<link rel="canonical" href="http://' . $canonicalurl . '">' . "\n";
                            break;
                        }
                    }
                }
            }
        }
    }
    if (TRUE != $setMetaRobots) {
        if ('yes'  ==  get_option('makeIndexFollow')) {
            echo '<meta name="robots" content="index, follow">' . "\n";
        }
    }
}
if (file_exists('metarobots.txt')) {
    add_action('wp_head', 'metarobots_mrs');
} else {
    mrs_create_metaRobotsTxt();
}
?>