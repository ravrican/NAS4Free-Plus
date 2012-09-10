#!/usr/local/bin/php
<?php
/*
	rv_mpd.php
	Copyright RV(rvm.my.home.s@gmail.com )
	All rights reserved.

	part of FreeNAS (http://www.freenas.org)
*/
require("auth.inc");
require("guiconfig.inc");
require("sajax/sajax.php");

function get_process_info() {
	exec("mpc", $result);
	return implode("\n", $result);
}

sajax_init();
sajax_export("get_process_info");
sajax_handle_client_request();

$pgtitle = array(gettext("Services"), gettext("MPD"));

if (!is_array($config['mpd']))
	$config['mpd'] = array();

$pconfig['enable'] = isset($config['mpd']['enable']);


if ($_POST) {
	unset($input_errors);

		if (stristr($_POST['Submit'], gettext("MPD start"))) {
			mwexec2(escapeshellcmd("/usr/local/etc/rc.d/musicpd start"), $output, $retval);
			if (0 == $retval) {
				$execmsg = gettext("The 'MPD start' has been executed successfully.");
				write_log("The 'musicpd start' has been executed successfully.");
			} else {
				$execfailmsg = gettext("Failed to execute 'MPD start'.");
				write_log("Failed to execute 'musicpd start'.");
			}
        }

      if (stristr($_POST['Submit'], gettext("MPD stop"))) {
    			mwexec2(escapeshellcmd("/usr/local/etc/rc.d/musicpd stop"), $output, $retval);
    			if (0 == $retval) {
    				$execmsg = gettext("The 'MPD stop' has been executed successfully.");
    				write_log("The 'musicpd stop' has been executed successfully.");
    			} else {
    				$execfailmsg = gettext("Failed to execute 'MPD stop'.");
    				write_log("Failed to execute 'musicpd stop'.");
    			}
      }

      if (stristr($_POST['Submit'], gettext("MPD restart"))) {
    			mwexec2(escapeshellcmd("/usr/local/etc/rc.d/musicpd restart"), $output, $retval);
    			if (0 == $retval) {
    				$execmsg = gettext("The 'MPD restart' has been executed successfully.");
    				write_log("The 'musicpd restart' has been executed successfully.");
    			} else {
    				$execfailmsg = gettext("Failed to execute 'MPD restart'.");
    				write_log("Failed to execute 'musicpd restart'.");
    			}
      }

      if (stristr($_POST['Submit'], gettext("Play"))) {
    			mwexec2(escapeshellcmd("/usr/local/bin/mpc play"), $output, $retval);
    			if (0 == $retval) {
    				$execmsg = gettext("The 'MPC play' has been executed successfully.");
    				write_log("The 'mpc play' has been executed successfully.");
    			} else {
    				$execfailmsg = gettext("Failed to execute 'MPC play'.");
    				write_log("Failed to execute 'mpc play'.");
    			}
     }

       if (stristr($_POST['Submit'], gettext("Next"))) {
    			mwexec2(escapeshellcmd("/usr/local/bin/mpc next"), $output, $retval);
    			if (0 == $retval) {
    				$execmsg = gettext("The 'MPC next' has been executed successfully.");
    				write_log("The 'mpc next' has been executed successfully.");
    			} else {
    				$execfailmsg = gettext("Failed to execute 'MPC next'.");
    				write_log("Failed to execute 'mpc next'.");
    			}
       }

      if (stristr($_POST['Submit'], gettext("Stop"))) {
    			mwexec2(escapeshellcmd("/usr/local/bin/mpc stop"), $output, $retval);
    			if (0 == $retval) {
    				$execmsg = gettext("The 'MPC stop' has been executed successfully.");
    				write_log("The 'mpc stop' has been executed successfully.");
    			} else {
    				$execfailmsg = gettext("Failed to execute 'MPC stop'.");
    				write_log("Failed to execute 'mpc stop'.");
    			}
       }


			header("Location: rv_mpd.php");
			exit;
}
?>


<?php
include("fbegin.inc");
?>

<script type="text/javascript">
<!--
function enable_change(enable_change) {
	var endis = !(document.iform.enable.checked || enable_change);
}
//-->
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    <td class="tabnavtbl">
      <ul id="tabnav">
         <li class="tabact"><a href="rv_mpd.php" title="<?=gettext("Reload page");?>"><span><?=gettext("MPD");?></span></a></li>
      </ul>
    </td>
  </tr>
  <tr>
    <td class="tabcont">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  	<?php html_titleline_checkbox("enable", gettext("MPD"), $pconfig['enable'] ? true : false, gettext("Enable"), "enable_change(false)");?>

			  <tr>
			    <td class="listt">
			    	<pre><textarea style="width: 98%;" id="procinfo" name="procinfo" class="listcontent" cols="95" rows="3" readonly="readonly"><?=htmlspecialchars(get_process_info());?></textarea></pre>
			    </td>
			  </tr>
			</table>

			<form action="rv_mpd.php" method="post" name="iform" id="iform">
				<div id="submit">
					<input name="Submit" id="mpd_start" type="submit" class="formbtn" value="<?=gettext("MPD start");?>" />
					<input name="Submit" id="mpd_stop" type="submit" class="formbtn" value="<?=gettext("MPD stop");?>" />
 					<input name="Submit" id="mpd_restart" type="submit" class="formbtn" value="<?=gettext("MPD restart");?>" />
                   <br><br>
					<input name="Submit" id="Play" type="submit" class="formbtn" value="<?=gettext("Play");?>" />
					<input name="Submit" id="Next" type="submit" class="formbtn" value="<?=gettext("Next");?>" />
					<input name="Submit" id="Stop" type="submit" class="formbtn" value="<?=gettext("Stop");?>" />
				</div>
				<?php include("formend.inc");?>
			</form>
    </td>
  </tr>
</table>

<?php include("fend.inc");?>
