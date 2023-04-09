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
	<link rel="stylesheet" href="../../fontawesome-free/css/all.min.css">
</head>

<body class="bg-light">
	<div class="container-fluid mt-3">
		<div class="d-flex justify-content-between align-items-center bg-light border py-2 px-2">
			<h1 class="h4 p-0 m-0">

				<span
					class="text-primary"><?= htmlspecialchars($auth->name) ?></span>
				-
				<span
					class="text-primary"><?= htmlspecialchars($auth->role) ?></span>
			</h1>
			<a href="auth.view.php?id=<?= $auth->id ?>"
				class="d-flex justify-content-end">
				<?php if($auth->photo) :?>
				<img class="rounded-circle me-2 shadow-sm border border-3 border-white"
					src="../../actions/photos/users/<?= $auth->photo ?>"
					alt="Profile Image" style="max-width:50px">
				<?php else :?>
				<div class="border rounded-circle border-3 border-white shadow-sm d-flex justify-content-center align-items-center bg-light"
					style="width: 50px; height: 50px">
					<i class="fas fa-user fa-lg text-secondary"></i>
				</div>
				<?php endif ?>
			</a>
		</div>
		<table class="table table-striped border shadow-sm">
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
				<td> <?= htmlspecialchars($user->id) ?> </td>
				<td> <?= htmlspecialchars($user->name) ?> </td>
				<td> <?= htmlspecialchars($user->email) ?> </td>
				<td> <?= htmlspecialchars($user->phone) ?> </td>
				<td> <?= htmlspecialchars($user->address) ?> </td>
				<td>
					<?php if($user->role_id >= 3) :?>
					<span class="badge bg-success">
						<?= htmlspecialchars($user->role) ?>
					</span>
					<?php elseif ($user->role_id >= 2):?>
					<span class="badge bg-primary">
						<?= htmlspecialchars($user->role) ?>
					</span>
					<?php else :?>
					<span class="badge bg-secondary">
						<?= htmlspecialchars($user->role) ?>
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
	<?php require("../nav.view.php"); ?>
	<script src="../../js/bootstrap.bundle.min.js"></script>
</body>

</html>