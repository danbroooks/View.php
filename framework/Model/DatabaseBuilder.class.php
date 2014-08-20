<?php

class DatabaseBuilder {

	public static function build($db) {
		$database = $db->config('dbname');
		$dataObjects = $db->classGraph->getDescendantsOf('DataObject');

		$db->query("USE {$database};");

		foreach ($dataObjects as $dataObject) {
			
			$db->query("DROP TABLE IF EXISTS {$dataObject};");

			$query = "CREATE TABLE IF NOT EXISTS {$dataObject} (
					ID int NOT NULL AUTO_INCREMENT,";

			foreach($dataObject::$fields as $field => $type) {
				$query .= "{$field} varchar(255),";
			}


			$query .= "PRIMARY KEY (ID)
				);";

			$db->query($query);
		}
	}
}
