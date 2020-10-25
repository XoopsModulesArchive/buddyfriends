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

function updateLastseen()
{
    global $xoopsConfig, $xoopsDB, $xoopsUser, $xoopsTheme, $xoopsLogger, $xoopsMF, $REMOTE_ADDR;

    $past = time() - 300; // anonymous records are deleted after 10 minutes
    $userpast = time() - 8640000; // user records idle for the past 100 days are deleted
    $ip = $REMOTE_ADDR;

    if ($xoopsUser) {
        $uid = $xoopsUser->getVar('uid');

        $uname = $xoopsUser->getVar('uname');
    } else {
        $uid = 0;

        $uname = 'Anonymous';
    }

    $sql = 'SELECT * FROM ' . $xoopsDB->prefix('online') . ' WHERE online_uname=' . $uname . '';

    if (0 == $uid) {
        $sql .= " AND ip='" . $ip . "'";
    }

    //echo $sql;

    $result = $xoopsDB->query($sql);

    [$getRowsNum] = $xoopsDB->fetchRow($result);
}

function buddy_smile($message)
{
    $message = str_replace(':)', '<IMG SRC="../../images/smilies/icon_smile.gif">', $message);

    $message = str_replace(':-)', '<IMG SRC="../../images/smilies/icon_smile.gif">', $message);

    $message = str_replace(':(', '<IMG SRC="../../images/smilies/icon_frown.gif">', $message);

    $message = str_replace(':-(', '<IMG SRC="../../images/smilies/icon_frown.gif">', $message);

    $message = str_replace(':-D', '<IMG SRC="../../images/smilies/icon_biggrin.gif">', $message);

    $message = str_replace(':D', '<IMG SRC="../../images/smilies/icon_biggrin.gif">', $message);

    $message = str_replace(';)', '<IMG SRC="../../images/smilies/icon_wink.gif">', $message);

    $message = str_replace(';-)', '<IMG SRC="../../images/smilies/icon_wink.gif">', $message);

    $message = str_replace(':o', '<IMG SRC="../../images/smilies/icon_eek.gif">', $message);

    $message = str_replace(':O', '<IMG SRC="../../images/smilies/icon_eek.gif">', $message);

    $message = str_replace(':-o', '<IMG SRC="../../images/smilies/icon_eek.gif">', $message);

    $message = str_replace(':-O', '<IMG SRC="../../images/smilies/icon_eek.gif">', $message);

    $message = str_replace('8)', '<IMG SRC="../../images/smilies/icon_cool.gif">', $message);

    $message = str_replace('8-)', '<IMG SRC="../../images/smilies/icon_cool.gif">', $message);

    $message = str_replace(':?', '<IMG SRC="../../images/smilies/icon_confused.gif">', $message);

    $message = str_replace(':-?', '<IMG SRC="../../images/smilies/icon_confused.gif">', $message);

    $message = str_replace(':p', '<IMG SRC="../../images/smilies/icon_razz.gif">', $message);

    $message = str_replace(':P', '<IMG SRC="../../images/smilies/icon_razz.gif">', $message);

    $message = str_replace(':-p', '<IMG SRC="../../images/smilies/icon_razz.gif">', $message);

    $message = str_replace(':-P', '<IMG SRC="../../images/smilies/icon_razz.gif">', $message);

    $message = str_replace(':-|', '<IMG SRC="../../images/smilies/icon_mad.gif">', $message);

    $message = str_replace(':|', '<IMG SRC="../../images/smilies/icon_mad.gif">', $message);

    return($message);
}

function buddy_bbencode($message)
{
    // [CODE] and [/CODE] for posting code (HTML, PHP, C etc etc) in your posts.

    $matchCount = preg_match_all("#\[code\](.*?)\[/code\]#si", $message, $matches);

    for ($i = 0; $i < $matchCount; $i++) {
        $currMatchTextBefore = preg_quote($matches[1][$i]);

        $currMatchTextAfter = htmlspecialchars($matches[1][$i], ENT_QUOTES | ENT_HTML5);

        $message = preg_replace("#\[code\]$currMatchTextBefore\[/code\]#si", "<!-- BBCode Start --><TABLE BORDER=0 ALIGN=CENTER WIDTH=85%><TR><TD><font class=\"pn-sub\">Code:</font><HR></TD></TR><TR><TD><FONT class=\"pn-sub\"><PRE>$currMatchTextAfter</PRE></FONT></TD></TR><TR><TD><HR></TD></TR></TABLE><!-- BBCode End -->", $message);
    }

    // [QUOTE] and [/QUOTE] for posting replies with quote, or just for quoting stuff.

    $message = preg_replace("#\[quote\](.*?)\[/quote]#si", '<!-- BBCode Quote Start --><TABLE BORDER=0 ALIGN=CENTER WIDTH=85%><TR><TD><font class="pn-sub">Quote:</font><HR></TD></TR><TR><TD><FONT class="pn-sub"><BLOCKQUOTE>\\1</BLOCKQUOTE></FONT></TD></TR><TR><TD><HR></TD></TR></TABLE><!-- BBCode Quote End -->', $message);

    // [b] and [/b] for bolding text.

    $message = preg_replace("#\[b\](.*?)\[/b\]#si", '<!-- BBCode Start --><B>\\1</B><!-- BBCode End -->', $message);

    // [i] and [/i] for italicizing text.

    $message = preg_replace("#\[i\](.*?)\[/i\]#si", '<!-- BBCode Start --><I>\\1</I><!-- BBCode End -->', $message);

    // [url]www.phpbb.com[/url] code..

    $message = preg_replace("#\[url\](http://)?(.*?)\[/url\]#si", '<!-- BBCode Start --><A HREF="http://\\2" TARGET="_blank">\\2</A><!-- BBCode End -->', $message);

    // [url=www.phpbb.com]phpBB[/url] code..

    $message = preg_replace("#\[url=(http://)?(.*?)\](.*?)\[/url\]#si", '<!-- BBCode Start --><A HREF="http://\\2" TARGET="_blank">\\3</A><!-- BBCode End -->', $message);

    // [email]user@domain.tld[/email] code..

    $message = preg_replace("#\[email\](.*?)\[/email\]#si", '<!-- BBCode Start --><A HREF="mailto:\\1">\\1</A><!-- BBCode End -->', $message);

    // [img]image_url_here[/img] code..

    $message = preg_replace("#\[img\](.*?)\[/img\]#si", '<!-- BBCode Start --><IMG SRC="\\1"><!-- BBCode End -->', $message);

    // unordered list code..

    $matchCount = preg_match_all("#\[list\](.*?)\[/list\]#si", $message, $matches);

    for ($i = 0; $i < $matchCount; $i++) {
        $currMatchTextBefore = preg_quote($matches[1][$i]);

        $currMatchTextAfter = preg_replace("#\[\*\]#si", '<LI>', $matches[1][$i]);

        $message = preg_replace("#\[list\]$currMatchTextBefore\[/list\]#si", "<!-- BBCode ulist Start --><UL>$currMatchTextAfter</UL><!-- BBCode ulist End -->", $message);
    }

    // ordered list code..

    $matchCount = preg_match_all("#\[list=([a1])\](.*?)\[/list\]#si", $message, $matches);

    for ($i = 0; $i < $matchCount; $i++) {
        $currMatchTextBefore = preg_quote($matches[2][$i]);

        $currMatchTextAfter = preg_replace("#\[\*\]#si", '<LI>', $matches[2][$i]);

        $message = preg_replace("#\[list=([a1])\]$currMatchTextBefore\[/list\]#si", "<!-- BBCode olist Start --><OL TYPE=\\1>$currMatchTextAfter</OL><!-- BBCode olist End -->", $message);
    }

    return($message);
}

function buddy_make_clickable($text)
{
    $ret = eregi_replace(' ([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])', ' <a href="\\1://\\2\\3" target="_blank" target="_new">\\1://\\2\\3</a>', $text);

    $ret = eregi_replace(' (([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)([[:alnum:]-]))', ' <a href="mailto:\\1" target="_new">\\1</a>', $ret);

    return($ret);
}

function move()
{
    echo '<SCRIPT LANGUAGE="javascript">
<!--
window.moveTo(10,10);
//-->
</SCRIPT>';
}
