<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register</title>
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>

<body class="bg-white">
	<div class="container mt-5 p-4 rounded border shadow bg-light" style="max-width: 360px">
		<form action="../../actions/users/create.php" method="post">
			<h1 class="h3 text-center mb-3">Register</h1>
			<input type="name" class="form-control mb-3" name="name" placeholder="Name" required>
			<input type="email" class="form-control mb-3" name="email" placeholder="Email" required>
			<input type="phone" class="form-control mb-3" name="phone" placeholder="Phone" required>
			<textarea name="address" class="form-control mb-3" required></textarea>
			<input type="password" class="form-control mb-3" name="password" placeholder="Password" required>
			<div class="text-center">
				<input type="submit" value="Register" class="btn btn-primary mb-3 w-100"> <br>
				<a href="../../index.php">Login?</a>
			</div>
		</form>
	</div>
</body>

</html>