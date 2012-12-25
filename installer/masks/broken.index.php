<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{company_name}</title>
</head>

<body>
	<h1>{error_title}</h1>
	<p>
		{breaokdown_desc}
	</p>
<?php
	
	// Javascript automatci refreshes
	$autoRefresh = {auto_refresh};
	if($AutoRefreshThePage)
	{
?>
		<b>The JavaScript code that will refresh the page and stuff</b>
<?
	}
	else
	{
		// Do nothing ??
	}
?>
</body>
</html>
