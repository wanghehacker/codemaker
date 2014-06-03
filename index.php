<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>codemaker</title>
	
</head>
<body>
<?php 
	require 'db.php';
	$dbhelper = new MySQL();
// 	输出文件路径
	$filepath = "hrl/table_to_record.hrl";
	$header = "%%%------------------------------------------------\n";
	$header .= "%%%	File    : table_to_record.erl	\n";
	$header .= "%%%	Author  : whe	\n";
	$header .= "%%%	Created :	".date("Y-m-d H:i:s", time())."	\n";
	$header .= "Description: 从mysql表生成的record			\n";
	$header .= "Warning:  由程序自动生成，请不要随意修改！			\n";
	$header .= "%%%------------------------------------------------\n\n\n";
	
	$tables = $dbhelper->ExecuteSQL("select table_name from information_schema.tables where table_schema='titandata'");
// 	创建文件
// 	if (!file_exists($filepath)) {
// 		touch($filepath);
// 	}
// 	else
// 	{
// // 		unlink($filepath);
// 	}
	
	$file = fopen($filepath, "w");
// 	fwrite($file, $header,strlen($header));
// 	fclose($file);
	
	$content = $header;
	
	if (count($tables)>1) 
	{
		foreach ($tables as $table)
		{
			$tablecomment = $dbhelper->ExecuteSQL("select table_name,table_comment from information_schema.tables  where table_schema = 'titandata' and table_name ='".$table['table_name']."'");
// 		表注释			
			$content .=("%%%"."	".$tablecomment[0]['table_comment']."\n");
// 		记录名
			$content .=("%%%"."	".$table['table_name']."==>".$table['table_name']."\n");
			$content .=("-record(".$table['table_name'].",{\n");
			echo $table['table_name']." ".$tablecomment[0]['table_comment'].":----------------------------------------------------------<br><br>";
// 		获取表的列		
			$rows = $dbhelper->ExecuteSQL("SHOW FULL COLUMNS FROM ".$table['table_name']);
			$rowcount = count($rows);
			$index = 0;	
			foreach ($rows as $row)
			{
				$index++;
				$line = getNspace(6);
				if(strpos($row["Type"],"char")!=false)
				{
					echo "made\n";
					$line.=($row["Field"]."=");
					$line.=("\"".$row["Default"]."\"");
				}
				else
				{
					$line.=($row["Field"]."=");
					$line.=($row["Default"]);
				}
// 			逗号
				if($index!=$rowcount)
				{
					$line.=",";
				}

				$line.=getNspace(30-strlen($line));
				$line.=("%%%".$row["Comment"]."\n");
				$content .=$line;
				echo $row["Field"]." | ".$row["Type"]." | ".$row["Default"]." | ".$row["Comment"];
				echo "<br>";
			}
			
			$content.="}).\n\n";
			
			echo "--------------------------------------------------------<br>";
			echo "<br>";
			echo "<br>";
		}
		
		fwrite($file, $content,strlen($content));
		fclose($file);
		
		echo "生成完毕！";
	}
	else 
	{
		echo "没有表";
	}
	
	function getNspace($n)
	{
		$result ="";
		for ($i=0;$i<$n;$i++)
		{
			$result.=" ";
		}
		return $result;
	}
	
?>
</body>
</html>

