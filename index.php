<?php 
	require 'db.php';
	$dbhelper = new MySQL();
	$where['table_schema'] = 'titandata';
// 	$rows = $dbhelper->ExecuteSQL("SHOW COLUMNS FROM test");

	$tables = $dbhelper->ExecuteSQL("select table_name from information_schema.tables where table_schema='titandata'");
	
	if (count($tables)>1) 
	{
		foreach ($tables as $table)
		{
			echo $table['table_name'].":<br><br>";
			$rows = $dbhelper->ExecuteSQL("SHOW COLUMNS FROM ".$table['table_name']);
// 			echo var_dump($rows);	
			foreach ($rows as $row)
			{
				echo $row["Field"]." ".$row["Type"]." ".$row["Default"];
				echo "<br>";
			}
			echo "<br>";
			echo "<br>";
			echo "<br>";
		}
	}
	else 
	{
		echo "Ã»ÓÐ±í";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>codemaker</title>
	
</head>
<body>

</body>
</html>