<?php

#####################################################
#  Buddyfriends 2.3 pour Xoops 2
#
#  Original version byTim Cook tim@boinng.com and p4@directfriends.com
#  Adaptation a Xoops et modification Pascal Le Boustouller - http://www.e-xoopsfr.com
#  et P4 - http://www.directfriends.com
#
#  Licence : GPL
#  Merci de laisser ce copyright en place...
#####################################################
include 'functions.php';
include 'xoops_version.php';
global $xoopsUser;

include 'header.php';
if ('buddyfriends' == $xoopsConfig['startpage']) {
    $xoopsOption['show_rblock'] = 1;

    require XOOPS_ROOT_PATH . '/header.php';

    make_cblock();

    echo '<br>';
} else {
    $xoopsOption['show_rblock'] = 0;

    require XOOPS_ROOT_PATH . '/header.php';
}

$ModName = 'Messenger';

OpenTable();
echo '<table width=100%><tr><td>';
echo '<p class=pn-title><b>' . $xoopsConfig['sitename'] . " - $ModName</b></p>";
echo "<p class=pn-normal>$ModName " . _ALLOWSYOUTO . " $ModName " . _MSGSYOURCV . '.</p>';
if ($xoopsUser) {
    echo '<p class=pn-normal>' . _TOLAUNCH . " $ModName, " . _CLICKBUTTONRIGHT . '.</p>';
} else {
    echo '<p class=pn-normal>' . _TOUSE . " $ModName " . _YOUMUSTFIRST . ' ' . $xoopsConfig['sitename'] . '. ' . _TODOTHIS . " <a href='" . XOOPS_URL . "/register.php'>" . _HERE . '</a>.';
}
echo "</td><td valign='middle'><center>";
if ($xoopsUser) {
    echo "<a href=# ONCLICK=window.open('buddy.php','$email$ModName','width=450,height=370,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,copyhistory=0')><img src=buddyfriends_logo.png alt=\"Launch $ModName\" border=0></a>";
}
echo '<br></center></td></tr></table>';
CloseTable();
echo '<P>';

OpenTable();
echo '<DIV ALIGN="right">Buddyfriends v ' . $modversion['version'] . ' <br>';
echo '' . _POWERED . ' <a href=http://www.boinng.com target=_blank>Boinng</a> <br>';
echo '' . _ADAPTED . ' <a href=http://www.e-xoopsfr.com target=_blank>Pascal Le Boustouller</a> et <a href=http://www.directfriends.com>P4</a> </DIV>';
CloseTable();

require XOOPS_ROOT_PATH . '/footer.php';
