<?php
    include "../../vendor/autoload.php";
    use Helpers\Auth;
    use Helpers\HTTP;
    use Libs\Database\MySQL;
    use Libs\Database\UsersTable;

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
	<title>Profile</title>
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>

<body class="bg-white">
	<div class="container mt-5 p-4 rounded border shadow bg-light" style="max-width: 540px">
		<div class="d-flex justify-content-between align-items center">
			<a href="../home.view.php" class="btn btn-sm btn-outline-primary mb-2 shadow-sm">&laquo;&laquo; Home
				Page</a>
			<a href="table.view.php" class="btn btn-sm btn-outline-primary mb-2 shadow-sm">Manage Users
				&raquo;&raquo;</a>
		</div>
		<?php if($user->photo) :?>
		<div class="mb-3">
			<img class="img img-thumbnail shadow-sm"
				src="../../actions/photos/users/<?= $user->photo ?>"
				alt="Profile Img" style="max-width: 200px; max-height: 200px;">
		</div>
		<?php else :?>
		<div class="mb-3">
			<img class="img img-thumbnail" src="../../actions/photos/users/profile.jpg" alt="Profile Img"
				style="max-width: 200px; max-height: 200px;">
		</div>
		<?php endif ?>

		<h1 class="h3 mb-3">
			<?= htmlspecialchars($user->name) ?>
			( <?= htmlspecialchars($user->role) ?> )
		</h1>
		<?php if($auth->id === $user->id) :?>
		<form action="../../actions/users/upload.php" method="post" enctype="multipart/form-data">
			<div class="input-group mb-3">
				<input type="file" name="photo" class="form-control">
				<input type="submit" value="Upload" class="btn btn-secondary">
			</div>
		</form>
		<?php endif ?>
		<ul class="list-group mb-3">
			<li class="list-group-item list-group-item-action">
				<b>Email: </b> <?= htmlspecialchars($user->email) ?>
			</li>
			<li class="list-group-item list-group-item-action">
				<b>Phone: </b> <?= htmlspecialchars($user->phone) ?>
			</li>
			<li class="list-group-item list-group-item-action">
				<b>Address: </b>
				<?= htmlspecialchars($user->address) ?>
			</li>
		</ul>
		<?php if($auth->id === $user->id) :?>
		<a class="btn btn-sm btn-outline-danger" href="../../actions/users/logout.php">Logout</a>
		<?php endif ?>
	</div>
</body>

</html>