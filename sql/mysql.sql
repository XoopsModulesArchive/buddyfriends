#
# Table structure for table 'xoops_buddyfriends'
#

CREATE TABLE buddyfriends (
    ref  INT(11) NOT NULL AUTO_INCREMENT,
    uid  INT(5)  NOT NULL DEFAULT '0',
    fuid INT(5)  NOT NULL DEFAULT '0',
    PRIMARY KEY (ref),
    UNIQUE KEY REF (ref)
)
    ENGINE = ISAM;
