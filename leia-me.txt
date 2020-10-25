##############################################################
#  Buddyfriends 2.0 for Xoops 2                              #
#                                                            #
#  Original version by:                                      #
#  Tim Cook tim@boinng.com and p4@directfriends.com          #
#                                                            #
#  Adaptation to Xoops and modifications:                    #
#  Pascal Le Boustouller - http://www.e-xoopsfr.com          #
#  and P4 - http://www.directfriends.com                     #
#                                                            #
#  Modules Buddy and DirectFriends grouped in BuddyFriends   #
#  by Lmaix : http://www.bahut.com/                          #
#  Readme files, logo and sounds                             #
#  by sylvain B. : http://larando.com/xoops/                 #
#                                                            #
#  Licence : GPL                                             #
#  Please let this copyright in place...                     #
##############################################################



+ installation: 
- Unzip the files and directories in the directory modules of Xoops.
- then do not forget to activate Buddyfriends in your administration


Attention, to do before installation of the module:
Look at well what is your version of xoops 2!
This is very important, indeed starting from the version xoops2 rc3
the management of the themes was modified.
For this reason, there are two versions of the file buddy.php.

You will find the version concerning: 
- xoops2 rc1 - > xoops2 rc2 in the directory buddyphprc2. 
- xoops2 rc3 - > xoops 2.0.2 in the directory buddyphp202
 

By default, the version of the file in the directory of the module
is for xoops 2.0.2.
To be able to use buddyfriends in a normal way,
according to your version of xoops, 
replace simply the file buddy.php in the module directory
by that which is appropriate to you!

Moreover, in the directory newmessagewav, 
you have two other directories different containers a sound. 
With you to choose that which you like more. 
For that, copy the new sound instead of the current one. 
You can, of course, choose another one of your composition of them.

--------------------------------------------------------------

Advise to the webmasters who's already downloaded the DirectFriends module.
The tables of these two modules are different, same structure but different. 
If you wish to profit, and make profit, to the "friends" already recorded
in the table of DirectFriends, you've got to do this:

 


Via PhpMyAdmin, seek the table prefixxoops_myfriends of DirectFriends, 
choose then Export - > Data only. You then obtain an sql file containing all the data 
(yours but also those of your members) recorded. 
Using an editor, open the sql file and rename the table "myfriends" in "buddyfriends". 
Proceed thus for each entry. 
This made and after installation of BuddyFriends, go in the table buddyfriends 
and made SQL (execute a request), then "look into" 
and seek your sql file which you have just modified. 
Click then on Execute and voila. 
You can now deactivate DirectFriends and uninstall it.


For all questions:

- http://www.frxoops.org  FORUM
- https://xoops.org FORUM

Or on our respective sites. 

Sylvain B. webmaster XOOPS-JP 2.0.2 SITE TEST
