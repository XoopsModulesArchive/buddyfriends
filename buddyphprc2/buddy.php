<?php

#####################################################
#  Buddyfriends 2.0 pour Xoops 2
#
#  Original version byTim Cook tim@boinng.com and p4@directfriends.com
#  Adaptation a Xoops et modification Pascal Le Boustouller - http://www.e-xoopsfr.com
#  et P4 - http://www.directfriends.com
#
#  Licence : GPL
#  Merci de laisser ce copyright en place...
#####################################################
require __DIR__ . '/functions.php';
require __DIR__ . '/xoops_version.php';
include 'header.php';
$ModName = 'Messenger';

global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF;
$currenttheme = getTheme();
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
if ($xoopsUser) {
    echo "<html>\n<head>";

    echo "<LINK REL=\"StyleSheet\" HREF=\"../../cache/style.css\" TYPE=\"text/css\">\n";
} else {
    echo "<html>\n<head>\n";

    echo "<LINK REL=\"StyleSheet\" HREF=\"../../cache/style.css\" TYPE=\"text/css\">\n";

    move();

    echo "<body LEFTMARGIN=3 MARGINWIDTH=3 TOPMARGIN=3 MARGINHEIGHT=3>\n";

    echo '<table height=100% width=100%><tr><td>';

    OpenTable();

    echo '<p align=center class=pn-title>' . _PLEASE . " $ModName<br><a href='javascript:window.opener.location=\"../../register.php\";window.close();'>" . _REGIN . '</a><br><br>' . _IFMEMBER . ' ' . $xoopsConfig['sitename'] . "<br><a href='javascript:window.opener.location=\"../../user.php\";window.close();'>" . _ORLOGIN . "</a></p>\n";

    CloseTable();

    echo "</td></tr></table></body></html>\n";

    exit;
}

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////

function buddygo()
{
    header('Location: buddy.php');
}

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
$task = isset($_GET['task']) ? trim($_GET['task']) : '';
$task = isset($_POST['task']) ? trim($_POST['task']) : $task;
$type = isset($_GET['type']) ? trim($_GET['type']) : '';
$type = isset($_POST['type']) ? trim($_POST['type']) : $type;
function buddylist()
{
    global $ModName, $modversion, $xoopsUser, $xoopsConfig, $xoopsTheme, $xoopsDB, $xoopsLogger, $xoopsMF, $HTTP_COOKIE_VARS;

    $idd = $xoopsUser->getVar('uid', 'E');

    $sql = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('priv_msgs') . " WHERE to_userid = '$idd' AND read_msg='0'");

    if ($row = $xoopsDB->getRowsNum($sql)) {
        while (false !== ($msgs = $xoopsDB->fetchArray($sql))) {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">\n
var telwin = null;\n
telwin = window.open(\"buddy.php?task=buddyread&msg_id=$msgs[msg_id]\", \"$priv_msg[msg_time]\", \"width=450,height=370,toolbar=no,location=no,menubar=no,scrollbars=yes,resizeable=no,status=no\");\n
</SCRIPT>\n\n";
        }
    }

    move();

    $isadmin = 0;

    echo '<title>' . $xoopsConfig['sitename'] . " - $ModName</title><LINK REL=\"StyleSheet\" HREF=\"../../cache/style.css\" TYPE=\"text/css\">
<script language=\"javascript\">\nfunction IM(IM) { var MainWindow = window.open (IM, \"_blank\",\"width=450,height=370,toolbar=no,location=no,menubar=no,scrollbars=no,resizeable=no,status=no\");}\n</script>
</head><body onload=setInterval('self.location.reload()',20000)>";

    echo "<center><table class='outer'><tr class='odd'><td>";

    echo '<p class=normal><a href=buddy.php><font size=2>' . _WHOISONLINE . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';

    echo '<a href=buddy.php?task=allusers>' . _LIST . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';

    echo '<a href=buddy.php?task=buddyfriend>' . _MF_TITLE . '</a></font></td></tr></table><br>';

    echo '<table width="100%" cellspacing="1" class="outer"><tr><th colspan="4"><font size=2>' . _WHOISONLINE . '</font></th></tr>';

    $result = $xoopsDB->query('SELECT online_uid, online_uname, online_module FROM ' . $xoopsDB->prefix('online') . '');

    while (list($online_uid, $online_uname, $online_module) = $xoopsDB->fetchRow($result)) {
        if (0 != $online_uid) {
            echo '<tr valign="middle" align="center" class="odd"><td>';

            $result2 = $xoopsDB->query('SELECT user_avatar FROM ' . $xoopsDB->prefix('users') . " where uid=$online_uid");

            $result3 = $xoopsDB->fetchArray($result2);

            echo "<img src='../../uploads/$result3[user_avatar]'>";

            echo "</td><td><a href=\"javascript:window.opener.location='../../userinfo.php?uid=$online_uid';javascript:window.location='buddy.php';\"><font size=2>$online_uname</font></a>";

            $result4 = $xoopsDB->query('SELECT name FROM ' . $xoopsDB->prefix('modules') . " where mid=$online_module");

            $result5 = $xoopsDB->fetchArray($result4);

            echo "</td><td><font size=2>$result5[name]</font></td><td>";

            echo "<a href=\"javascript:IM('../../pmlite.php?send2=1&to_userid=$online_uid','pmlite',450,370);\">
<img src=\"" . XOOPS_URL . '/images/icons/pm_small.gif" border="0" width="27" height="17" alt=""></a>
</td></tr>';
        } else {
            echo '<tr valign="middle" align="center" class="odd"><td>';

            echo '</td><td><font size=2>' . VISITER . '</font></a>';

            $result4 = $xoopsDB->query('SELECT name FROM ' . $xoopsDB->prefix('modules') . " where mid=$online_module");

            $result5 = $xoopsDB->fetchArray($result4);

            echo "</td><td><font size=2>$result5[name]</font></td><td>";

            echo '</td></tr>';
        }
    }

    echo '</table><br>';

    echo '</center></body></html>';

    exit;
}

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////

function allusers($alpha)
{
    global $ModName, $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF;

    if (!$alpha) {
        $alpha = 'A';
    }

    $iddds = $xoopsUser->getVar('uid', 'E');

    $sql = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('priv_msgs') . " WHERE to_userid = '$iddds' AND read_msg='0'");

    echo '<title>' . $xoopsConfig['sitename'] . " - $ModName</title><LINK REL=\"StyleSheet\" HREF=\"../../cache/style.css\" TYPE=\"text/css\">";

    if ($row = $xoopsDB->getRowsNum($sql)) {
        while (false !== ($msgs = $xoopsDB->fetchArray($sql))) {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">\n
var telwin = null;\n
telwin = window.open(\"buddy.php?task=buddyread&msg_id=$msgs[msg_id]\", \"$priv_msg[msg_time]\", \"width=450,height=370,toolbar=no,location=no,menubar=no,scrollbars=yes,resizeable=no,status=no\");\n
</SCRIPT>\n\n";
        }
    }

    move();

    echo "<script language=\"javascript\">\nfunction IM(IM) { var MainWindow = window.open (IM, \"_blank\",\"width=450,height=370,toolbar=no,location=no,menubar=no,scrollbars=no,resizeable=no,status=no\");}\n</script></head>
<body onload=setInterval('self.location.reload()',20000) LEFTMARGIN=3 MARGINWIDTH=3 TOPMARGIN=3 MARGINHEIGHT=3>";

    echo "<center><table class='outer'><tr class='odd'><td>";

    echo '<p class=normal><a href=buddy.php><font size=2>' . _WHOISONLINE . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';

    echo '<a href=buddy.php?task=allusers>' . _LIST . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';

    echo '<a href=buddy.php?task=buddyfriend>' . _MF_TITLE . '</a></font></td></tr></table><br>';

    echo "<table width='100%' cellspacing='1' class='outer'><tr><th colspan='3'><form task=\"buddy.php\" method=\"get\">\n";

    echo '<p class=normal><font size=2>' . _MEMBERSFOR . '</font> ';

    echo "<select name=\"alpha\"onChange='submit()'>";

    echo "<option value=\"$alpha\">$alpha</option>\n";

    echo "<option value=\"A\">A</option>\n";

    echo "<option value=\"B\">B</option>\n";

    echo "<option value=\"C\">C</option>\n";

    echo "<option value=\"D\">D</option>\n";

    echo "<option value=\"E\">E</option>\n";

    echo "<option value=\"F\">F</option>\n";

    echo "<option value=\"G\">G</option>\n";

    echo "<option value=\"H\">H</option>\n";

    echo "<option value=\"I\">I</option>\n";

    echo "<option value=\"J\">J</option>\n";

    echo "<option value=\"K\">K</option>\n";

    echo "<option value=\"L\">L</option>\n";

    echo "<option value=\"M\">M</option>\n";

    echo "<option value=\"N\">N</option>\n";

    echo "<option value=\"O\">O</option>\n";

    echo "<option value=\"P\">P</option>\n";

    echo "<option value=\"Q\">Q</option>\n";

    echo "<option value=\"R\">R</option>\n";

    echo "<option value=\"S\">S</option>\n";

    echo "<option value=\"T\">T</option>\n";

    echo "<option value=\"U\">U</option>\n";

    echo "<option value=\"V\">V</option>\n";

    echo "<option value=\"W\">W</option>\n";

    echo "<option value=\"X\">X</option>\n";

    echo "<option value=\"Y\">Y</option>\n";

    echo "<option value=\"Z\">Z</option>\n";

    echo "<option value=\"*\">*</option>\n";

    echo "</select>\n";

    echo '<INPUT TYPE="HIDDEN" NAME="task" VALUE="allusers">';

    echo '</p></form></th></tr>';

    if ('*' == $alpha) {
        $sql = $xoopsDB->query('SELECT uid, uname, user_avatar FROM ' . $xoopsDB->prefix('users') . " where uname REGEXP \"^\[1-9]\" AND (uid>0 AND level>0) order by uname");
    } else {
        $sql = $xoopsDB->query('SELECT uid, uname, user_avatar FROM ' . $xoopsDB->prefix('users') . " where uname like '" . $alpha . "%' AND (uid>0 AND level>0) order by uname");
    }

    $member_num = $xoopsDB->getRowsNum($sql);

    $i = 1;

    while (false !== ($userlist = $xoopsDB->fetchArray($sql))) {
        if ($i == $member_num) {
            $who .= "<tr class='odd'><td width='50' align='center'><img src=\"../../uploads/$userlist[user_avatar]\" alt=\"\" height='20'></td><td width'100%' align='center'><a href='javascript:window.opener.location=\"../../userinfo.php?uid=$userlist[uid]\";javascript:window.location=\"buddy.php?alpha=" . $alpha . "&task=allusers\";'><font size=2>$userlist[uname]</font></a></td><td width='50' align='center'><a href=\"javascript:IM('../../pmlite.php?send2=1&to_userid=$userlist[uid]','pmlite',450,370);\"><img src=\"" . XOOPS_URL . '/images/icons/pm_small.gif" border="0" width="27" height="17" alt=""></a></td></tr>';
        } else {
            $who .= "<tr class='odd'><td width='50' align='center'><img src=\"../../uploads/$userlist[user_avatar]\" alt=\"\" height='20'></td><td width'100%' align='center'><a href='javascript:window.opener.location=\"../../userinfo.php?uid=$userlist[uid]\";javascript:window.location=\"buddy.php?alpha=" . $alpha . "&task=allusers\";'><font size=2>$userlist[uname]</font></a></td><td width='50' align='center'><a href=\"javascript:IM('../../pmlite.php?send2=1&to_userid=$userlist[uid]','pmlite',450,370);\"><img src=\"" . XOOPS_URL . '/images/icons/pm_small.gif" border="0" width="27" height="17" alt=""></a></td></tr>';
        }
    }

    $i++;

    echo "<p align=left class=tiny>$who</p></table><br>";

    exit;
}

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////

function buddycompose($to, $subject, $delete, $prev_msg)
{
    echo '<SCRIPT LANGUAGE="JavaScript">
document.location.href="../../pmlite.php?reply=1&amp;msg_id=' . $prev_msg . '"
</SCRIPT>';

    exit;
}

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////

function buddyread($msg_id)
{
    global $ModName, $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF;

    $idd = $xoopsUser->getVar('uid', 'E');

    $sql = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('priv_msgs') . " WHERE msg_id=$msg_id AND to_userid='$idd' AND read_msg='0'");

    $priv_msg = $xoopsDB->fetchArray($sql);

    $from_userid = $priv_msg[from_userid];

    $fromuser = $xoopsDB->query('select uname from ' . $xoopsDB->prefix('users') . " where uid = '$from_userid'");

    $fname = $xoopsDB->fetchArray($fromuser);

    $from_user = $fname[uname];

    $subject = stripslashes($priv_msg[subject]);

    $msg_image = stripslashes($priv_msg[msg_image]);

    $message = stripslashes($priv_msg[msg_text]);

    $msgtime = formatTimestamp($priv_msg['msg_time']);

    $GLOBALS['xoopsDB']->queryF('UPDATE ' . $xoopsDB->prefix('priv_msgs') . " SET read_msg='1' WHERE msg_id='$priv_msg[msg_id]'");

    echo '<title>' . _INCOMINGFROM . " $from_user !</title><LINK REL=\"StyleSheet\" HREF=\"../../cache/style.css\" TYPE=\"text/css\">\n";

    move();

    echo "</head>\n";

    echo '<body LEFTMARGIN=3 MARGINWIDTH=3 TOPMARGIN=3 MARGINHEIGHT=3>';

    echo "<table width=100% cellspacing=1 cellpadding=3 class='outer'><tr><td>";

    $result = $xoopsDB->query('SELECT uid, user_avatar FROM ' . $xoopsDB->prefix('users') . " WHERE uname='$from_user'");

    $result2 = $xoopsDB->fetchArray($result);

    echo "<tr><th colspan='2' align='left'><font size=2>" . _INCOMINGFROM . "</font></td></tr><tr class='odd'><td valign='top'>";

    echo "<a href=\"../../userinfo.php?uid=$result2[uid]\" target=\"_blank\"><font size=2>$from_user</font></a><br><img src=\"../../uploads/$result2[user_avatar]\" alt=\"\"><br><br>";

    echo "</td><td><img src='../../images/subject/$msg_image' alt=''>&nbsp;<font size=2>" . _SENTAT . " $msgtime</font>";

    echo "<hr><b><font size=2>$subject</font></b><br><br><font size=2>\n";

    $myts = MyTextSanitizer::getInstance();

    $message = htmlspecialchars($message, ENT_QUOTES | ENT_HTML5);

    echo (string)$message;

    echo '</font><br><br></td></tr></table><br>';

    echo "<FORM METHOD=POST task=\"buddy.php\" TARGET=_self>
<input type=HIDDEN name=\"to\" value=\"$from_user\">
<input type=HIDDEN name=\"subject\" value=\"$subject\">
<input type=HIDDEN name=\"prev_msg\" value=\"" . $priv_msg[msg_id] . '">';

    echo '<CENTER><TABLE WIDTH=100% BORDER=0>
    <TR>
      <TD COLSPAN=2 ALIGN="CENTER"><input type=CHECKBOX name="delete" CHECKED><font size=2>' . _DELETEON . '</font><br><SELECT NAME="task">
	<OPTION VALUE="buddycompose"> ' . _REPLY . '
	<OPTION VALUE="buddel"> ' . _CLOSEF . '
</SELECT>
</TD>
    </TR>
    <TR>
      <TD VALIGN="TOP"  ALIGN="CENTER"><INPUT TYPE="submit" VALUE="' . _CONTINU . '"></TD>
      <TD VALIGN="TOP"  ALIGN="CENTER"></FORM></TD>
    </TR>
</TABLE></CENTER>
<embed src="newmessage.wav" autostart="true" hidden="true" loop="false">
</body>
</html>';

    exit;
}

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////

function buddel($prev_msg, $delete)
{
    global $ModName, $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF;

    if ($delete) {
        $idd = $xoopsUser->getVar('uid', 'E');

        $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('priv_msgs') . " WHERE msg_id='$prev_msg' AND to_userid ='$idd'");
    }

    echo '<script language=JavaScript>
<!--
self.name="wname";window.close();
//-->
</script>';

    exit;
}

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////

function friendExists()
{
    echo '<br>' . _MF_EXISTS . '<br><br>';

    echo "<a href='buddy.php?task=buddyfriend'>" . _MF_BACKTOLIST . '</a>';
}

//########################################----------------------------------###################################

function displayFriendsList($beg_in)
{
    global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF;

    $ModName = 'Messenger';

    $idd = $xoopsUser->getVar('uid', 'E');

    $sql = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('priv_msgs') . " WHERE to_userid = '$idd' AND read_msg='0'");

    if ($row = $xoopsDB->getRowsNum($sql)) {
        while (false !== ($msgs = $xoopsDB->fetchArray($sql))) {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">\n
var telwin = null;\n
telwin = window.open(\"buddy.php?task=buddyread&msg_id=$msgs[msg_id]\", \"$priv_msg[msg_time]\", \"width=450,height=370,toolbar=no,location=no,menubar=no,scrollbars=yes,resizeable=no,status=no\");\n
</SCRIPT>\n\n";
        }
    }

    move();

    $isadmin = 0;

    echo '<title>' . $xoopsConfig['sitename'] . " - $ModName</title><LINK REL=\"StyleSheet\" HREF=\"../../cache/style.css\" TYPE=\"text/css\">
<script language=\"javascript\">\nfunction IM(IM) { var MainWindow = window.open (IM, \"_blank\",\"width=450,height=370,toolbar=no,location=no,menubar=no,scrollbars=no,resizeable=no,status=no\");}\n</script>
</head><body onload=setInterval('self.location.reload()',20000)>";

    echo "<center><table class='outer'><tr class='odd'><td>";

    echo '<p class=normal><a href=buddy.php><font size=2>' . _WHOISONLINE . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';

    echo '<a href=buddy.php?task=allusers>' . _LIST . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';

    echo '<a href=buddy.php?task=buddyfriend>' . _MF_TITLE . '</a></font></td></tr></table><br>';

    $myid = $xoopsUser->uid();

    if (false == is_numeric($beg_in)) {
        $beg_in = 0;
    } else {
        if ($beg_in < 1) {
            $beg_in = 0;
        }
    }

    //##

    $sqlstr = 'SELECT fuid FROM ' . $xoopsDB->prefix('buddyfriends') . " WHERE uid=$myid";

    //count my friends

    $sqlstr2 = 'SELECT Count(*) FROM ' . $xoopsDB->prefix('buddyfriends') . " WHERE uid=$myid";

    $result2 = $xoopsDB->query($sqlstr2) || die($xoopsDB->error());

    while (list($rep) = $xoopsDB->fetchRow($result2)) {
        $numfriends = $rep;
    }

    $resultzz = $xoopsDB->query($sqlstr) || die($xoopsDB->error());

    //begin of html

    echo '<br><center>';

    echo "[ <a href='buddy.php?task=mod'>" . _MF_FRIENDSLIST_MOD . '</a> ]';

    echo '<br>';

    echo '</center><table width="100%" cellspacing="1" class="outer"><tr><th colspan="4">
<font size=2>' . _MF_FRIENDSLIST_HAVE . "<b>$numfriends</b>" . _MF_FRIENDSLIST_ACTUAL . '</font></th></tr>';

    while ($userinfo = $xoopsDB->fetchArray($resultzz)) {
        $userinfo = new XoopsUser($userinfo['fuid']);

        $zuid = $userinfo->uid();

        $zuname = $userinfo->uname();

        $zavatar = $userinfo->user_avatar();

        echo "<tr class='odd'><td align='center'>";

        echo '<img src="' . $xoopsConfig['xoops_url'] . '/uploads/' . $zavatar . "\" name=\"avatar\" id=\"avatar\" height='20'>";

        echo '</td><td align=center>';

        echo "<a href='../../userinfo.php?uid=$zuid' target=new><font size=2>" . ucfirst($zuname) . '</font></a>';

        echo '</td><td align=center>';

        echo "<a href='javascript:IM(\"" . $xoopsConfig['xoops_url'] . '/pmlite.php?send2=1&amp;to_userid=' . $zuid . "\",\"pmlite\",450,370);'><img src=\"" . XOOPS_URL . '/images/icons/pm_small.gif" border="0" width="27" height="17" alt=""></a>';

        echo '</td><td align=center>';

        echo "<a href=\"buddy.php?task=retirer&uid=$zuid\"><font size=2>Retirer</font></a>";

        echo '</td></tr>';
    }

    echo '</table>';

    echo '<br>';

    echo '</center>';
}

//########################################----------------------------------###################################

function displayUsersList($beg_in, $let_in)
{
    global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF;

    $ModName = 'Messenger';

    $idd = $xoopsUser->getVar('uid', 'E');

    $sql = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('priv_msgs') . " WHERE to_userid = '$idd' AND read_msg='0'");

    if ($row = $xoopsDB->getRowsNum($sql)) {
        while (false !== ($msgs = $xoopsDB->fetchArray($sql))) {
            echo "<SCRIPT LANGUAGE=\"JavaScript\">\n
var telwin = null;\n
telwin = window.open(\"buddy.php?task=buddyread&msg_id=$msgs[msg_id]\", \"$priv_msg[msg_time]\", \"width=450,height=370,toolbar=no,location=no,menubar=no,scrollbars=yes,resizeable=no,status=no\");\n
</SCRIPT>\n\n";
        }
    }

    move();

    $isadmin = 0;

    echo '<title>' . $xoopsConfig['sitename'] . " - $ModName</title><LINK REL=\"StyleSheet\" HREF=\"../../cache/style.css\" TYPE=\"text/css\">
<script language=\"javascript\">\nfunction IM(IM) { var MainWindow = window.open (IM, \"_blank\",\"width=450,height=370,toolbar=no,location=no,menubar=no,scrollbars=no,resizeable=no,status=no\");}\n</script>
</head><body onload=setInterval('self.location.reload()',20000)>";

    echo "<center><table class='outer'><tr class='odd'><td>";

    echo '<p class=normal><a href=buddy.php><font size=2>' . _WHOISONLINE . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';

    echo '<a href=buddy.php?task=allusers>' . _LIST . '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';

    echo '<a href=buddy.php?task=buddyfriend>' . _MF_TITLE . '</a></font></td></tr></table><br>';

    $myid = $xoopsUser->uid();

    $p = $xoopsConfig['prefix'];

    //##

    if (false == is_numeric($beg_in)) {
        $beg_in = 0;
    } else {
        if ($beg_in < 1) {
            $beg_in = 0;
        }
    }

    if ($let_in) {
        $let_in = strip_tags($let_in);
    }

    //##

    $tranche = 20;

    $inf = $beg_in;

    $sup = $beg_in + $tranche;

    //select users

    $sqlstr = 'SELECT uid, uname, level FROM ' . $xoopsDB->prefix('users') . " WHERE level>0 AND uid!=$myid LIMIT $inf, $tranche";

    //select my friends

    $sqlstr1 = 'SELECT uid, fuid FROM ' . $xoopsDB->prefix('buddyfriends') . " WHERE uid=$myid ORDER BY fuid ASC";

    $result1 = $xoopsDB->query($sqlstr1) || die($xoopsDB->error());

    //count my friends

    $sqlstr2 = 'SELECT Count(*) from ' . $xoopsDB->prefix('users') . " WHERE level>0 AND uid!=$myid";

    $result2 = $xoopsDB->query($sqlstr2) || die($xoopsDB->error());

    while (list($rep) = $xoopsDB->fetchRow($result2)) {
        $numusers = $rep;
    }

    $ismyfriend = [];

    while (list($uid, $fuid) = $xoopsDB->fetchRow($result1)) {
        $ismyfriend[$fuid] = 1;
    }

    //letters

    if ($let_in) {
        $let_in1 = mb_strtoupper($let_in);

        $let_in2 = mb_strtolower($let_in);

        $sqlstr = 'SELECT uid, uname, level FROM ' . $xoopsDB->prefix('users') . " WHERE (((uname LIKE '$let_in1%') OR (uname LIKE '$let_in2%')) AND level>0 AND uid!=$myid)";
    }

    $result = $xoopsDB->query($sqlstr) || die($xoopsDB->error());

    //##links for next/previous pages

    $prevlink = '';

    $nextlink = '';

    if ($sup < $numusers) {
        $nextlink = "<a href='buddy.php?task=mod&beg=$sup'>" . _MF_NEXT . '</a>';

        $aff_sup = $sup;
    } else {
        $aff_sup = $numusers;
    }

    $prevn = $inf - $tranche;

    if ($prevn >= 0) {
        $prevlink = "<a href='buddy.php?task=mod&beg=$prevn'>" . _MF_PREVIOUS . '</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

        $aff_inf = $inf + 1;
    } else {
        $aff_inf = 1;
    }

    //num pages

    $numz = 0;

    $numpage = 1;

    $pagesLinks = '';

    while ($numz < $numusers) {
        $pagesLinks .= "<a href='buddy.php?task=mod&beg=$numz'>$numpage</a>&nbsp;&nbsp;";

        $numz += $tranche;

        $numpage++;
    }

    //##

    //begin of html

    echo '<center>';

    echo "[ <a href='buddy.php?task=buddyfriend'>" . _MF_BACKTOLIST . '</a> ]';

    echo '</center>';

    echo '<table width="100%" cellspacing="1" class="outer"><tr><th colspan="4">';

    echo "<font size=2><a href='buddy.php?task=mod'>" . _MF_ALL . '</a>&nbsp;&nbsp;';

    echo "<a href='buddy.php?task=mod&letter=A'>A</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=B'>B</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=C'>C</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=D'>D</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=E'>E</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=F'>F</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=G'>G</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=H'>H</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=I'>I</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=J'>J</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=K'>K</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=L'>L</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=M'>M</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=N'>N</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=O'>O</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=P'>P</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=Q'>Q</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=R'>R</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=S'>S</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=T'>T</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=U'>U</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=V'>V</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=W'>W</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=X'>X</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=Y'>Y</a>&nbsp;";

    echo "<a href='buddy.php?task=mod&letter=Z'>Z</a></font>";

    echo '</th></tr>';

    while ($userinfo = $xoopsDB->fetchArray($result)) {
        $userinfo = new XoopsUser($userinfo['uid']);

        $zuid = $userinfo->uid();

        $zuname = $userinfo->uname();

        $zavatar = $userinfo->user_avatar();

        echo "<tr class='odd'><td align='center'>";

        echo '<img src="' . $xoopsConfig['xoops_url'] . '/uploads/' . $zavatar . "\" name=\"avatar\" id=\"avatar\" height='20'>";

        echo '</td><td align=center>';

        if (1 != $ismyfriend[$zuid]) {
            echo "<a href='../../userinfo.php?uid=$zuid' target=new><font size=2>" . ucfirst($zuname) . '</font></a>';
        } else {
            echo "<a href='../../userinfo.php?uid=$zuid' target=new><font color='#D13313' size=2><b>" . ucfirst($zuname) . '</b></font></a>';
        }

        echo '</td><td align=center>';

        if (1 != $ismyfriend[$zuid]) {
            echo "<a href=\"buddy.php?task=ajouter&uid=$zuid\"><font size=2>Ajouter</font></a>";
        } else {
            echo "<a href=\"buddy.php?task=retirer&uid=$zuid\"><font size=2>Retirer</font></a>";
        }

        echo '</td></tr>';
    }

    echo '</table>';

    echo '<br><center>';

    if (!isset($let_in)) {
        echo _MF_MEMBERS . ' ' . $aff_inf . ' ' . _MF_TO . ' ' . $aff_sup . '<br><br>';

        echo $prevlink . $nextlink;

        if ($numpage > 2 && $numpage < 20) {
            echo '<br>' . _MF_PAGES . ' ';

            echo $pagesLinks;
        }

        if ($numpage > 20) {
            echo '';
        }
    }

    echo '</center>';
}

function addFriend($fuid_in)
{
    global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF;

    $myid = $xoopsUser->uid();

    //control if $fuid is not already a friend

    $sqlstr1 = 'SELECT uid, fuid FROM ' . $xoopsDB->prefix('buddyfriends') . " WHERE uid=$myid ORDER BY fuid ASC";

    $req1 = $GLOBALS['xoopsDB']->queryF($sqlstr1);

    while (list($uid, $fuid) = $GLOBALS['xoopsDB']->fetchRow($req1)) {
        if ($fuid == $fuid_in) {
            friendExists();

            $doNot = 1;
        }
    }

    //add a friend in database

    //& secure? &

    if (false == is_numeric($fuid_in)) {
        header('Location: ./buddy.php');
    }

    //&&

    if (1 != $doNot) {
        $sqlstr = 'INSERT INTO ' . $xoopsDB->prefix('buddyfriends') . " (uid, fuid) VALUES ($myid, $fuid_in)";

        $req = $GLOBALS['xoopsDB']->queryF($sqlstr);

        if ($req) {
            echo "<table align='center' cellpadding='0' border='0'><tr><td align='center'>";

            echo '<br><br><b>' . _MF_FRIENDADDED . '</b>';

            echo "<br><br><br><a href='buddy.php?task=mod'>" . _MF_BACKTOMODPAGE . '</a>';

            echo "<br><br><a href='buddy.php?task=buddyfriend'>" . _MF_BACKTOLIST . '</a>';

            echo '</td></tr></table>';
        } else {
            echo _MF_PROBLEM;
        }
    }
}

function deleteFriend($fuid_in)
{
    //& secure? &

    if (false == is_numeric($fuid_in)) {
        header('Location: ./buddy.php');
    }

    global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF;

    $myid = $xoopsUser->uid();

    $sqlstr = 'DELETE FROM ' . $xoopsDB->prefix('buddyfriends') . " WHERE (uid=$myid AND fuid=$fuid_in)";

    $req1 = $GLOBALS['xoopsDB']->queryF($sqlstr);

    echo "<table align='center' cellpadding='0' border='0'><tr><td align='center'>";

    if ($req1) {
        echo '<br><br><b>' . _MF_FRIEND_DELETED . '</b>';
    }

    echo "<br><br><br><a href='buddy.php?task=mod'>" . _MF_BACKTOMODPAGE . '</a>';

    echo "<br><br><a href='buddy.php?task=buddyfriend'>" . _MF_BACKTOLIST . '</a>';

    echo '</td></tr></table>';
}

///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////

switch ($task) {
        case 'buddel':
        buddel($prev_msg, $delete);
        break;
        case 'buddyread':
        buddyread($msg_id, $msg_time);
        break;
        case 'allusers':
        allusers($alpha);
        break;
        case 'buddycompose':
        buddycompose($to, $subject, $delete, $prev_msg);
        break;
        case 'buddyfriend':
        displayFriendsList($beg);
        break;
      case 'mod':
        displayUsersList($beg, $letter);
        break;
      case 'ajouter':
        addFriend($uid);
        break;
      case 'retirer':
        deleteFriend($uid);
        break;
        default:
        buddylist();
        break;
}
