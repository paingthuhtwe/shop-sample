<?php
include "../vendor/autoload.php";

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Libs\Database\ProductsTable;
use Libs\Database\CartsTable;
use Helpers\Auth;
use Helpers\HTTP;

$auth = Auth::check();
$table = new UsersTable(new MySQL());
$users = $table->getAll();
$productsTable = new ProductsTable(new MySQL());
$products = $productsTable->getAll();
$cartsTable = new CartsTable(new MySQL());
$carts = $cartsTable->findByUserId($auth->id);
$cartTotal = 0;
foreach ($carts as $cart) {
    $cartTotal += $cart->cart;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home Page</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/all.min.css">
	<link rel="stylesheet" href="../css/custom.css">
	<style>
		#cart {
			bottom: 10%;
			right: 5%;
			z-index: 1;
		}
	</style>
</head>

<body>
	<div class="container-fluid mt-3">
		<div class="row">
			<div class="col-3 p-1 ps-3 d-none d-lg-inline">
				<div class="bg-light border rounded py-4 px-3" style="height: 778px;">
					<div class="d-flex justify-content-center mb-2">
						<a
							href="users/auth.view.php?id=<?= $auth->id ?>">
							<?php if($auth->photo) :?>
							<img src="../actions/photos/users/<?= $auth->photo ?>"
								alt="Profile Image" class=" border border-2 rounded-circle" style="max-width: 150px">
							<?php else :?>
							<img src="../actions/photos/users/profile.jpg" alt="Profile Image"
								class=" border border-2 rounded-circle" style="max-width: 150px">
							<?php endif ?>
						</a>
					</div>
					<h1 class="h3 text-center">
						<?= $auth->name ?>
						(<?= $auth->role ?>)
					</h1>
					<ul class="list-group mb-3">
						<li class="list-group-item list-group-item-action">
							<b>Email:</b> <?= $auth->email ?>
						</li>
						<li class="list-group-item list-group-item-action">
							<b>Phone:</b> <?= $auth->phone ?>
						</li>
						<li class="list-group-item list-group-item-action">
							<b>Address:</b> <?= $auth->address ?>
						</li>
						<li class="list-group-item list-group-item-action">
							<b>Role:</b> <?= $auth->role ?>
						</li>
						<li class="list-group-item list-group-item-action">
							<b>Created Date:</b>
							<small>
								<?= $auth->created_at ?>
							</small>
						</li>
					</ul>
					<div class="text-center">
						<a href="../actions/users/logout.php" class="btn btn-outline-danger">Logout</a>
					</div>
				</div>
			</div>
			<div class="col-12 col-lg-9">
				<div class="row p-1 mb-2">
					<div class="col-12">
						<div class="bg-light border rounded p-2">
							<div class="d-flex justify-content-between align-items-center">
								<h1 class="h4 py-2 m-0 text-secondary">Welcome,
									<?= $auth->name ?>
								</h1>
								<a href="users/auth.view.php">
									<img src="../actions/photos/users/<?= $auth->photo ?>"
										alt="" class="border border-2 rounded-circle d-lg-none" style="max-width: 50px">
								</a>
								<a href="users/table.view.php" class="btn btn-sm btn-primary d-none d-lg-inline"> Manage
									Users
									&raquo;&raquo;</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row p-1">
					<div class="col-12 col-lg-8">
						<!-- Order Section Start  -->
						<?php if($cartTotal) :?>
						<a href="carts/cart.view.php" class="position-fixed dNone" id="cart">
							<div class="alert alert-info position-relative d-flex align-items-center justify-content-center shadow border border-info"
								style="max-width: 50px; max-height: 50px;">
								<b>
									Cart
								</b>
								<div
									class="badge bg-info position-absolute top-0 start-100 translate-middle border border-info shadow-sm">
									<?= $cartTotal ?>
								</div>
							</div>
						</a>
						<?php endif ?>
						<!-- Order Section End  -->
						<div class="">
							<div
								class="bg-light border rounded p-2 d-flex justify-content-between align-itmes-center mb-2">
								<a href="users/auth.view.php?id=<?= $auth->id ?>"
									class="dNone">
									<?php if(isset($auth->photo)) :?>
									<img src="../actions/photos/users/<?= $auth->photo ?>"
										alt="" class="border rounded-circle" style="max-width: 40px; max-height: 40px">
									<?php else :?>
									<img src="../actions/photos/users/profile.jpg" alt="" class="border rounded-circle"
										style="max-width: 40px; max-height: 40px">
									<?php endif ?>
								</a>
								<span class="d-flex justify-content-center align-items-center">
									<a href="products/add.view.php"
										class="h4 px-3 m-0 btn btn-sm btn-outline-primary me-2">+ Add
										Item</a>
									<a href="products/table.view.php" class="h4 px-2 m-0 btn btn-sm btn-primary">Manage
										Products &raquo;&raquo;</a>
								</span>
							</div>
							<div class="row px-1">
								<?php foreach ($products as $product) :?>
								<div class="col-12 col-lg-6 p-2 ">
									<div class="card border border-success cardSize shadow-sm">
										<?php if($product->photo) :?>
										<img src="../actions/photos/products/<?= $product->photo ?>"
											alt="Product Img" class="card-img border rounded shadow-sm">
										<?php else :?>
										<img src="../actions/photos/products/office.jpeg" alt="Product Img"
											class="card-img border rounded shadow-sm">
										<?php endif ?>
										<div class="card-body">
											<div class="d-flex justify-content-between align-items-center">
												<h1 class="h6 p-0 mb-2">
													<?= $product->title ?>
												</h1>
												<h1 class="h5">
													<?= $product->price ?>
													(Ks)
												</h1>
											</div>
											<?php if($product->stock > 0) :?>
											<span class="badge bg-secondary">
												In Stock -
												<?= $product->stock ?>
											</span>
											<?php else : ?>
											<span class="badge bg-danger">
												Out of Stock
											</span>
											<?php endif ?>
											<div>
												<small>
													<b>Description : </b>
													<?= $product->description ?>
												</small>
											</div>
											<div class="d-flex justify-content-between mt-2">
												<a href="../actions/carts/add.php?product_id=<?= $product->id ?>"
													class="btn btn-sm btn-success w-100">Add to cart</a>
											</div>
										</div>
									</div>
								</div>
								<?php endforeach ?>
							</div>
						</div>
					</div>
					<div class="col-4 d-none d-lg-inline">
						<div class="bg-light border rounded p-2" style="height: 700px">
							<?php foreach ($users as $user) :?>
							<?php if($auth->id !== $user->id) :?>
							<a href="users/profile.view.php?id=<?= $user->id ?>"
								class="d-flex align-items-center border rounded bg-white mb-1 p-1 dNone">
								<?php if(isset($user->photo)) :?>
								<img src="../actions/photos/users/<?= $user->photo ?>"
									alt="" class="border rounded-circle" style="max-width: 45px">
								<?php else :?>
								<img src="../actions/photos/users/profile.jpg" alt="" class="border rounded-circle"
									style="max-width: 45px">
								<?php endif ?>
								<h1 class="h6 p-0 m-0 ps-2 ">
									<?= $user->name ?>
									<span
										class="text-danger">(<?= $user->role ?>)</span>
								</h1>
							</a>
							<?php endif ?>
							<?php endforeach ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>