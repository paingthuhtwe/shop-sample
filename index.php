<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Main Page</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body class="bg-white">
	<div class="container mt-5 rounded border bg-light shadow p-4" style="max-width: 360px">
		<h1 class="h3 text-center mb-3">Login</h1>

		<?php if(isset($_GET['incorrect'])) :?>
		<div class="alert alert-warning text-center">Incorrect email or password!</div>
		<?php endif ?>

		<?php if(isset($_GET['register'])) :?>
		<div class="alert alert-success text-center">Register success, Login here.</div>
		<?php endif ?>

		<?php if(isset($_GET['suspended'])) :?>
		<div class="alert alert-danger text-center">Suspended Account!</div>
		<?php endif ?>

		<form action="actions/users/login.php" method="post">
			<input type="email" class="form-control mb-3" name="email" placeholder="Email" required>
			<input type="password" class="form-control mb-3" name="password" placeholder="Password" required>
			<div class="text-center">
				<input type="submit" value="Login" class="btn btn-primary mb-3 w-100"> <br>
				<a class="text-center" href="views/users/register.view.php">Register?</a>
			</div>
		</form>
	</div>
</body>

</html>