<?php
    include "../../vendor/autoload.php";

    use Libs\Database\MySQL;
    use Libs\Database\UsersTable;
    use Helpers\Auth;
    use Helpers\HTTP;

    $auth = Auth::check();
    $table = new UsersTable(new MySQL());
    $users = $table->getAll();
    ?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Manage Users</title>
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>

<body>
	<div class="container mt-5">
		<div class="d-flex justify-content-between align-items-center bg-light border py-2 px-2">
			<a href="../home.view.php" class="btn btn-sm btn-outline-primary mb-2"
				style="min-width: 200px">&laquo;&laquo; Home Page</a>
			<h1 class="h4 p-0 m-0">

				<span class="text-primary"><?= $auth->name ?></span>
				-
				<span class="text-primary"><?= $auth->role ?></span>
			</h1>
			<a href="auth.view.php?id=<?= $auth->id ?>"
				class="text-end" style="min-width: 200px">
				<?php if($auth->photo) :?>
				<img class="rounded-circle me-2 shadow border"
					src="../../actions/photos/users/<?= $auth->photo ?>"
					alt="Profile Image" style="max-width:50px">
				<?php else :?>
				<img class="rounded-circle me-2 shadow border" src="../../actions/photos/users/profile.jpg"
					alt="Profile Image" style="max-width:50px">
				<?php endif ?>
			</a>
		</div>
		<table class="table table-striped border shadow">
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Address</th>
				<th>Role</th>
				<th>Actions</th>
			</tr>
			<?php foreach ($users as $user) :?>
			<tr>
				<td> <?= $user->id ?> </td>
				<td> <?= $user->name ?> </td>
				<td> <?= $user->email ?> </td>
				<td> <?= $user->phone ?> </td>
				<td> <?= $user->address ?> </td>
				<td>
					<?php if($user->role_id >= 3) :?>
					<span class="badge bg-success">
						<?= $user->role ?>
					</span>
					<?php elseif ($user->role_id >= 2):?>
					<span class="badge bg-primary">
						<?= $user->role ?>
					</span>
					<?php else :?>
					<span class="badge bg-secondary">
						<?= $user->role ?>
					</span>
					<?php endif ?>
				</td>
				<td>
					<div class="btn-group dropdown">
						<?php if($auth->role_id >= 3) :?>
						<a href="#" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
							Change Role
						</a>
						<?php endif ?>
						<div class="dropdown-menu dropdown-menu-dark">
							<a href="../../actions/users/role.php?id=<?= $user->id ?>&role=1"
								class="dropdown-item">User</a>
							<a href="../../actions/users/role.php?id=<?= $user->id ?>&role=2"
								class="dropdown-item">Editor</a>
							<a href="../../actions/users/role.php?id=<?= $user->id ?>&role=3"
								class="dropdown-item">Admin</a>
						</div>
						<!-- end changeRole  -->
						<?php if($user->role_id >=3 & $auth->role_id <=2) :?>
						<?php elseif ($auth->role_id >=2) :?>
						<?php if($user->suspended) :?>
						<a href="../../actions/users/unsuspend.php?id=<?= $user->id ?>"
							class="btn btn-sm btn-warning">UnBan</a>
						<?php else :?>
						<a href="../../actions/users/suspend.php?id=<?= $user->id ?>"
							class="btn btn-sm btn-outline-warning">Ban</a>
						<?php endif ?>
						<?php endif ?>
						<!-- end suspended -->
						<?php if($auth->role_id >= 3) :?>
						<a href="../../actions/users/delete.php?id=<?= $user->id ?>"
							class="btn btn-sm btn-outline-danger" onClick="return confirm('Are you sure to delete?')">
							Delete
						</a>
						<?php endif ?>
						<!-- end delete  -->
						<?php if($auth->role_id >= $user->role_id & $auth->role_id >= 3) :?>
						<a href="edit.view.php?id=<?= $user->id ?>"
							class="btn btn-sm btn-warning">
							Edit
						</a>
						<?php elseif ($auth->id === $user->id) : ?>
						<a href="edit.view.php?id=<?= $user->id ?>"
							class="btn btn-sm btn-warning">
							Edit
						</a>
						<?php endif ?>
						<!-- end edit  -->
					</div>
				</td>
			</tr>
			<?php endforeach ?>
		</table>
	</div>
	<script src="../../js/bootstrap.bundle.min.js"></script>
</body>

</html>