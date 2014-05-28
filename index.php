<?php
	@header('Content-type: text/html;charset=UTF-8');

	$hostname = 'localhost';
	$username = 'root';
	$password = '888888';
	$database = 'titandata';

	$conn = new mysqli($hostname,$username,$password,$database);
	$conn->query("set names 'utf8'");
	$result = $conn->query('select * from test');
	$row = $result->fetch_row();
	echo $row[1];
?>