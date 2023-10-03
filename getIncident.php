<!DOCTYPE html>
<?php
session_start();
$uid = $_SESSION['UID'];
?>


<html>
<head>
	<script src = "http://code.jquery.com/jquery-3.5.1.js"></script>
	<script src = "https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src = "getIncident.js"></script>

	<title>Input the incident info</title>
</head>
<body>
	<label for="picker">Select the day the incident occured: </label>
	<input type="date" id="start">
	<br>
	<p>Enter Incident Description:</p>
	<textarea id="incidentDesc" name="incidentDesc" rows="4" cols="50"></textarea>
	<br> <br>
	<label for="iType">Pick an Incident Type: </label>
	<select name="iType" id="iType">
    </select>
	<br> <br>
	<p>Describe the perpitrator(s), if applicable:</p>
	<textarea id="personDesc" name=personDesc" rows="4" cols="50"></textarea>
	<br> <br>
	<label for="img">Attach photo (optional):</label>
	<input type="file" id="img" name="img" accept="image/*">
	<br> <br>
	<button type="button" id="submit" onclick="submitClicked()">Submit incident</button>
	<input type="hidden" name="type" id ="uId" value="<?= $uid ?>" >
</body>
</html>
