INSERT INTO `database`.`table` (`identifier`, `language`, `content`) VALUES (COALESCE("?","?",?),"?","?") ,(COALESCE("?","?",?),"?","?") ,(COALESCE("?","?",?),"?","?") ,(COALESCE("?","?",?),"?","?") ,(COALESCE("?","?",?),"?","?") ON DUPLICATE KEY UPDATE `content`="?";