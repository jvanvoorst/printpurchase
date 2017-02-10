<!DOCTYPE html>
<html>
<head>
	<title>shibboleth attributes</title>
</head>
<body>

<p> <b>uid </b> <?php echo $_SERVER['uid']; ?> </p>
<p> <b>givenName </b> <?php echo $_SERVER['givenName']; ?> </p>
<p> <b>mail </b> <?php echo $_SERVER['mail']; ?> </p>
<p> <b>sn </b> <?php echo $_SERVER['sn']; ?> </p>
<p> <b>eduPersonAffiliation </b> <?php echo $_SERVER['eduPersonAffiliation']; ?> </p>
<p> <b>cuEduPersonHomeDepartment </b> <?php echo $_SERVER['cuEduPersonHomeDepartment']; ?> </p>

</body>
</html>
