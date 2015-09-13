<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Date and Time Test</title>
    
    <?php include_once "db_open.php"; ?>
</head>

<body>
	<h1>This is a test for dates and times</h1>
    
    <?php
		$currentDate = date('d M Y');
		$yesterday = date('d M Y',strtotime("-1 days"));
		$tomorrow = date('d M Y',strtotime("+1 days"));
		//to change months and years just use the key words 'months' and 'years'
		
		$postedDate = mysql_query("INSERT INTO Post (Date) VALUES ($currentDate)");
	?>
    
    <h2>Today: <?php echo $currentDate; ?></h2>
    <h2>Yesterday: <?php echo $yesterday; ?></h2>
    <h2>Tomorrow: <?php echo $tomorrow; ?></h2><br/><br/>
    
    <h2>Posted: <?php 
	
	 
	 $result =  mysql_query("SELECT Date FROM Post WHERE PostID = 4"); 
	
	while($row = mysql_fetch_assoc($result))
	{
		$date = $row["Date"];
		echo $date;
		 
	}
		 ?></h2>
</body>
    <?php include_once "db_close.php"; ?>
</html>