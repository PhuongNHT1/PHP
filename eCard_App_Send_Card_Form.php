<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Congratulations! Ecard</title>

<style>

#image {
position: absolute;
top: 3px;
left: 3px;
z-index: 1;
}

#form {
position: absolute;
margin-bottom: 10%;
left: 134px;
border: none;
z-index: 2;
height: 60px;
width: 488px;
top: 350px;
}

.note {
font-family: Arial, Helvetica, sans-serif;
font-size: 8pt;
color: #F00;
text-align: center;
}

.input_fields {
font-family: Arial, Helvetica, sans-serif;
font-size: 10pt;
font-weight: bold;
text-align: center;
}

.submit {
font-family: Arial, Helvetica, sans-serif;
font-size: 10pt;
font-weight: bolder;
text-align: center;	
}

.input_fields {
text-align: center;
}

</style>

<!--Validate fields-->
<script language="javascript" type="text/javascript">
function validate()
{
if(document.form.recipientname.value == "")
{
alert("Please enter a recipient name!");
document.form.recipientname.focus();
return false;
}
else if(document.form.roomnum.value == "")
{
alert("Please enter a room number!");
document.form.roomnum.focus();
return false;
}
else if(document.form.sendername.value == "")
{
alert("Please enter your name!");
document.form.sendername.focus();
return false;
}
else if(document.form.senderemail.value == "")
{
alert("Please enter email address!");
document.form.senderemail.focus();
return false;
}
else if(document.form.message.value == "") 
{
alert("Please enter your message!");
document.form.message.focus();
return false;
}

else
{
return true; 
}
}
</script>

<script language="javascript" type="text/javascript"> 
function CountLeft(field, count, max) {
if (field.value.length > max)
field.value = field.value.substring(0, max);
else
count.value = max - field.value.length;
}
</script>

</head>

<body class="input_fields">
<div id="image">
<img src="congratulations.jpg" width="750" height="1125" border="1" alt="Congratulations Ecard!" />
</div>
<form id="form" method="post" action="congratulations.php" name="form" >
Recipient First and Last Name:<input name="recipientname" type="text" maxlength="75" />
Room #:<input name="roomnum" type="text" size="4" maxlength="5" />
<br />
<br />
Your Name:<input type="text" name="sendername" maxlength="50" /> 
Your Email:<input type="text" name="senderemail" maxlength="50" />
<br />
<br />
<textarea name="message" id="message" rows="10" cols="55" 
onKeyDown="CountLeft(this.form.message, this.form.left,125);" 
onKeyUp="CountLeft(this.form.message,this.form.left,125);"
>
</textarea>
<br />
<input readonly type="text" name="left" size=3 maxlength=3 value="125"> characters left for the message on your card.
<p class="note">Recipient name, room #, and message will appear on printed card in this section.<br />
<br />
<input type="submit" value="Send Your Card!" onclick="return validate();" />
</p>
</form>
</body>

</html>
