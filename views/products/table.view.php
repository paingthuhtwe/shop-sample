<?php

include "../../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\ProductsTable;
use Libs\Database\UsersTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();
$productsTable = new ProductsTable(new MySQL());
$products = $productsTable->getAll();
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
				style="min-width: 150px">&laquo;&laquo; Home
				Page</a>
			<h1 class="h4 p-0 m-0">

				<span class="text-primary"><?= $auth->name ?></span>
				-
				<span class="text-primary"><?= $auth->role ?></span>
			</h1>
			<a href="add.view.php" class="btn btn-sm btn-outline-primary" style="min-width: 150px">
				+ Add Item
			</a>
		</div>
		<table class="table table-striped border shadow">
			<tr>
				<th>ID</th>
				<th>Title</th>
				<th>Description</th>
				<th>Instock</th>
				<th>Price</th>
				<th>Actions</th>
			</tr>
			<?php foreach ($products as $product) :?>
			<tr>
				<td> <?= $product->id ?> </td>
				<td> <?= $product->title ?> </td>
				<td> <?= $product->description ?> </td>
				<td>
					<?php if($product->stock > 0) :?>
					<span class="badge bg-success px-3">
						<?= $product->stock ?>
						<?php else :?>
						<span class="badge bg-secondary px-3">
							0
							<?php endif ?>
						</span>
				</td>
				<td> <?= $product->price ?> </td>
				<td>
					<div class="btn-group">
						<?php if($auth->role_id >=3) : ?>
						<a href="../../actions/products/delete.php?id=<?= $product->id ?>"
							class="btn btn-sm btn-outline-danger"
							onClick="return confirm('Are you sure to Delete?')">Delete</a>
						<?php endif ?>
						<?php if($auth->role_id >=2) : ?>
						<a href="edit.view.php?id=<?= $product->id ?>"
							class="btn btn-sm btn-outline-warning">Edit</a>
						<?php else : ?>
						###
						<?php endif ?>
					</div>
				</td>
			</tr>
			<?php endforeach ?>
		</table>
	</div>
</body>

</html>