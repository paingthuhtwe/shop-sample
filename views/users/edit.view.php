<?php

include "../../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();

$table = new UsersTable(new MySQL());
$id = $_GET['id'];
$user = $table->findById($id);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit User</title>
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>

<body class="bg-white">
	<div class="container mt-md-5 p-4 rounded border bg-light" style="max-width: 400px">
		<h1 class="h3 text-center mb-3">Edit Profile</h1>
		<?php if($user->photo) :?>
		<img src="../../actions/photos/users/<?= $user->photo ?>"
			alt="Profile Image" class="img img-thumbnail mb-2" style="max-width: 150px">
		<?php else :?>
		<img src="../../actions/photos/users/profile.jpg" alt="Profile Image" class="img img-thumbnail mb-2"
			style="max-width: 150px">
		<?php endif ?>
		<form
			action="../../actions/users/upload.php?id=<?= $user->id ?>"
			method="post" enctype="multipart/form-data">
			<div class="input-group mb-2">
				<input type="file" name="photo" class="form-control">
				<input type="submit" value="Upload" class="btn btn-secondary">
			</div>
		</form>
		<form
			action="../../actions/users/edit.php?id=<?= $user->id ?>"
			method="post">
			<input type="name" class="form-control mb-2" name="name" placeholder="Name" required
				value="<?= htmlspecialchars($user->name) ?>">
			<input type="email" class="form-control mb-2" name="email" placeholder="Email" required
				value="<?= htmlspecialchars($user->email) ?>">
			<input type="phone" class="form-control mb-2" name="phone" placeholder="Phone" required
				value="<?= htmlspecialchars($user->phone) ?>">
			<input name="address" class="form-control mb-2" required
				value="<?= htmlspecialchars($user->address) ?>">
			<div class="text-center">
				<input type="submit" value="Update" class="btn btn-primary mb-2"> <br>
			</div>
		</form>
	</div>
</body>

</html>