<?php

// $Id: xoops_version.php,v 1.1 2006/02/22 00:35:20 mikhail Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2006 xoopscube.org                       //
//                       <http://xoopscube.org>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

$modversion['name'] = _MI;
$modversion['version'] = '2.3';
$modversion['description'] = '_MI_DESC';
$modversion['official'] = 'no';
$modversion['author'] = 'Original version by<br>Tim Cook tim@boinng.com and p4@directfriends.com';
$modversion['credits'] = 'Xoops version by<br>Pascal Le Boustouller<br> http://www.e-xoopsfr.com <br>and P4<br> http://www.directfriends.com';
$modversion['admin'] = 0;
$modversion['dirname'] = 'buddyfriends';
$modversion['image'] = 'buddyfriends_logo.png';
$modversion['license'] = 'GPL see LICENSE';
$modversion['namemod'] = 'buddyfriends';

// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables created by sql file (without prefix!)
$modversion['tables'][0] = 'buddyfriends';
// Menu
$modversion['hasMain'] = 1;
