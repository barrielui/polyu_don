<?php  
	$pmrecipient = $_GET['pmrecipient'];
?>
<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript">
		function autoFill(){
			document.getElementById('pmrecipient').value = "<?php echo $pmrecipient; ?>";
		}
		function pmValidate(f){

		}
	</script>
	<title></title>
</head>
<body onload="autoFill()">
<form method="get" action="pm-sent.php" onsubmit="return pmValidate(this)">
	<table>
		<tr><td><label for="pmrecipient">Recipient: </label></td><td><input type="text" maxlength="30" id="pmrecipient" name="pmrecipient" placeholder="username" style="width:370px;"></td></tr>
		<tr><td><label for="pmtopic">Title: </label></td><td><input type="text" maxlength="30" name="pmtopic" placeholder="Write the topic" style="width:370px;"></td></tr>
		<tr><td><label for="pmcontent">Content: </label></td><td><textarea name="pmcontent" id="pmcontent" rows="10" cols="50" maxlength="300" placeholder="What you want to tell..."></textarea></td></tr>
	</table>
</form>
</body>
</html>