<!DOCTYPE html>
<html>
<head>
	<title>shibboleth attributes</title>
</head>
<body>

<p> <?php echo 'uid: ' . $_SERVER['uid']; </p>
<p> <?php echo 'givenName: ' . $_SERVER['givenName']; </p>
<p> <?php echo 'mail: ' . $_SERVER['mail']; </p>
<p> <?php echo 'sn: ' . $_SERVER['sn']; </p>
<p> <?php echo 'eduPersonAffiliation: ' . $_SERVER['eduPersonAffiliation']; </p>
<p> <?php echo 'cuEduPersonHomeDepartment: ' . $_SERVER['cuEduPersonHomeDepartment']; </p>


</body>
</html>