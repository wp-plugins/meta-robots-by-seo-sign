<?php
add_action('admin_menu', 'mrs_plugin_menu');

function mrs_plugin_menu() {
    add_options_page('Meta Robots by SEO Sign', 'Meta Robots by SEO Sign', 'manage_options', 'meta-robots-settings.php', 'mrs_settings_page');
    add_action('admin_init', 'mrs_register_settings');
}
function mrs_check_files() {
    $wp_root_path = get_home_path();
    if (FALSE == file_exists($wp_root_path . "metarobots.txt")) {
        $metaRobotsFile = fopen($wp_root_path . "metarobots.txt", "w+") or die("Unable to open file!");
        $txt = "Allow: *\n";
        fwrite($metaRobotsFile, $txt);
        fclose($metaRobotsFile);
    }
    if (FALSE == file_exists($wp_root_path . "robots.txt")) {
        $robotsFile = fopen($wp_root_path . "robots.txt", "w+") or die("Unable to open file!");
        $txt = "User-Agent: *\nAllow: *\n";
        fwrite($robotsFile, $txt);
        fclose($robotsFile);
    }
}
function mrs_register_settings() {
    register_setting('mrs-settings-group', 'makeIndexFollow');
    register_setting('mrs-settings-group', 'rewriteRobots');
}
function mrs_files_rewrite() {
    $wp_root_path = get_home_path();
    $formMetaRobotsTxt = filter_input( INPUT_POST, 'formMetaRobotsTxt', FILTER_SANITIZE_STRING);
    $formRobotsTxt = filter_input( INPUT_POST, 'formRobotsTxt', FILTER_SANITIZE_STRING);
    if ('yes' == get_option('rewriteRobots')) {
        $metaRobotsStrings = explode("\n", $formMetaRobotsTxt);
        $robotsStrings = explode("\n", $formRobotsTxt);
        foreach($robotsStrings as $key => $value) {
            $value = mb_strtolower($value);
            if (FALCE  == strpos($value, 'disallow')) {
                array_push($metaRobotsStrings, $value);
                $robotsStrings[$key] = "Allow: *";
            }
        }
        $metaRobotsStrings = array_map("mb_strtolower", $metaRobotsStrings);
        $metaRobotsStrings = array_unique($metaRobotsStrings);
        $robotsStrings = array_unique($robotsStrings);
        $formMetaRobotsTxt = implode("\n", $metaRobotsStrings);
        $formRobotsTxt = implode("\n", $robotsStrings);
    }
    $value = $formMetaRobotsTxt;
    $metaRobotsFileWrite = fopen($wp_root_path . "metarobots.txt", "w+");
    fwrite($metaRobotsFileWrite, $value);
    fclose($metaRobotsFileWrite);
    $value = $formRobotsTxt;
    $robotsFileWrite = fopen($wp_root_path . "robots.txt", "w+");
    fwrite($robotsFileWrite, $value);
    fclose($robotsFileWrite);
}
function mrs_settings_page() {
    $wp_root_path = get_home_path();
    mrs_check_files();
    if (FALSE == get_option('makeIndexFollow')) {
        update_option('makeIndexFollow', 'no');
    }
    if (isset($_POST['formRobotsTxt'])) {
        update_option('rewriteRobots', sanitize_option( "rewriteRobots", $_POST['rewriteRobots'] ));
        update_option('makeIndexFollow', sanitize_option( "makeIndexFollow", $_POST['makeIndexFollow'] ));
        mrs_files_rewrite();
    }  
?> 

<div class="wrap"> 
<h2>MetaRobots by Seo-Sign</h2> 

<form method="post" action=""> 
         
    <br /> 
<p><b>Placing a tag on pages open to index</b><br /> 
    <input type="radio" name="makeIndexFollow" value="no"   <?php
    if (get_option('makeIndexFollow') === 'no') {
        echo 'checked="checked"';
    }
?> >Do not place meta robots tag<br /> 
    <input type="radio" name="makeIndexFollow" value="yes"<?php
    if (get_option('makeIndexFollow') === 'yes') {
        echo 'checked="checked"';
    }
?> >Set robots tag with values "index,follow"<br /> 
  </p> 
  <p><input type="checkbox" name="rewriteRobots" value="yes"<?php
    if (get_option('rewriteRobots') === 'yes') {
        echo 'checked="checked"';
    }
?> >Rewrite robots.txt rules to metarobots rules</p> 
     
    <h2>MetaRobots rules</h2> 
    <p>Edit meta robots rules</p> 
    <p>Use robots.txt syntax for meta robots tags</p> 
    <textarea name="formMetaRobotsTxt" cols="40" rows="7"><?php 
    $metaRobotsFile = file($wp_root_path . 'metarobots.txt');
    foreach($metaRobotsFile as $value) {
        echo $value;
    }
?></textarea> 
     
    <h2>Robots.txt rules</h2> 
    <p>Edit robots.txt rules</p> 
    <textarea name="formRobotsTxt" cols="40" rows="7"><?php
    $robotsFile = file($wp_root_path . 'robots.txt');
    foreach($robotsFile as $value) {
        echo $value;
    }
?></textarea> 
    <p><input type="submit" class="button button-primary" value="Submit"></p> 
</form>

                <p>Manage prohibitions meta robots and robots.txt<br />
                   file from the control panel using the commands in the format of robots.txt</p>
                <p><b>MetaRobots rules listing:</b></p>
                <table>
                <tr><td>Command</td><td>META ROBOTS value</td></tr>
                <tr><td>Disallow:</td><td>"noindex, nofollow"</td></tr>
                <tr><td>Index:</td><td>"index, nofollow"</td></tr>
                <tr><td>Follow:</td><td>"noindex, follow"</td></tr>
                <tr><td>Noarchiv:</td><td>"noarchive"</td></tr>
                <tr><td>Nosnippet:</td><td>"nosnippet"</td></tr>
                <tr><td>Noodp:</td><td>"noodp"</td></tr>
                <tr><td>Notranslate:</td><td>"notranslate"</td></tr>
                <tr><td>Noimageindex:</td><td>"noimageindex"</td></tr>
</table>

</div> 

<?php
}