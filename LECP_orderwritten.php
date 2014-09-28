<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>LECP</title>
<link rel="stylesheet" href="css/main.css" type="text/css" />
<script language="javascript" type="text/javascript" src="js/fieldvalidation.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />


<body>
<h1>Lovenox (enoxaparin)/Epidural Catheter Protocol</h1>
<form method="post" name="orderwrittenresults" action="orderwrittenresults.php" onSubmit="return order_written_question();" />
<h2>Has an order been written to discontinue the epidural catheter?</h2>
Yes<input type="checkbox" name="orderwritten" value="Yes" />&nbsp;&nbsp;&nbsp;
No<input type="checkbox" name="orderwritten" value="No" />
<br />
<br />
<input type="submit" name="submit" value="Continue" />
</form>
</body>

</html>
