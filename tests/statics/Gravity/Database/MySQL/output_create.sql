/*!40101 SET @saved_cs_client = @@character_set_client */; /*!40101 SET character_set_client = utf8 */; CREATE TABLE `table` ( `param1` varchar(?) NOT NULL, `param2` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`changedData`)), `param3` int(?) NOT NULL, `param4` bigint(?) NOT NULL, `param5` enum('?','?','?') NOT NULL, `param6` varchar(?) GENERATED ALWAYS AS (json_value(from_base64(`id`),'?')) STORED, `param7` tinyint(?) GENERATED ALWAYS AS (if(json_value(from_base64(`id`),'?') = '?',?,?)) STORED, `param8` date GENERATED ALWAYS AS (json_value(from_base64(`id`),'?')) STORED, `param9` char(?) GENERATED ALWAYS AS (json_value(from_base64(`id`),'?')) STORED, `param10` char(?) GENERATED ALWAYS AS (json_value(from_base64(`id`),'?')) STORED, `param11` char(?) GENERATED ALWAYS AS (json_value(from_base64(`id`),'?')) STORED, PRIMARY KEY (`param1`,`param2`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 `PAGE_COMPRESSED`=?; /*!40101 SET character_set_client = @saved_cs_client */;