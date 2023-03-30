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
	<link rel="stylesheet" href="../css/custom.css">
	<link rel="stylesheet" href="../fontawesome-free/css/all.min.css">
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
			<!-- Start Profile Section  -->
			<div class="col-3 p-1 ps-3 d-none d-lg-inline">
				<div class="alert alert-info py-4 px-3 rounded border shadow-sm">
					<div class="d-flex justify-content-center mb-2">
						<a
							href="users/auth.view.php?id=<?= $auth->id ?>">
							<?php if($auth->photo) :?>
							<img src="../actions/photos/users/<?= htmlspecialchars($auth->photo) ?>"
								alt="Profile Image" class="rounded-circle shadow-sm border border-3 border-white"
								style="max-width: 150px">
							<?php else :?>
							<div class="border rounded-circle border-3 border-white shadow-sm d-flex justify-content-center align-items-center bg-light"
								style="min-width: 150px; min-height: 150px">
								<i class="fas fa-user fa-5x text-secondary"></i>
							</div>
							<?php endif ?>
						</a>
					</div>
					<h1 class="h3 text-center">
						<?= htmlspecialchars($auth->name) ?>
					</h1>
					<ul class="list-group mb-3">
						<li class="list-group-item active bg-secondary border-secondary muted">User Info</li>
						<li class="list-group-item list-group-item-action">
							<b>Email:</b>
							<?= htmlspecialchars($auth->email) ?>
						</li>
						<li class="list-group-item list-group-item-action">
							<b>Phone:</b>
							<?= htmlspecialchars($auth->phone) ?>
						</li>
						<li class="list-group-item list-group-item-action">
							<b>Address:</b>
							<?= htmlspecialchars($auth->address) ?>
						</li>
						<li class="list-group-item list-group-item-action">
							<b>Role:</b>
							<?= htmlspecialchars($auth->role) ?>
						</li>
						<li class="list-group-item list-group-item-action">
							<b>Created Date:</b>
							<small>
								<?= htmlspecialchars($auth->created_at) ?>
							</small>
						</li>
					</ul>
					<?php if($auth->role_id >= 2) :?>
					<ul class="list-group mb-3">
						<li class="list-group-item active bg-secondary border-secondary muted">Control</li>
						<a href="users/table.view.php" class="list-group-item list-group-item-action">
							<i class="fas fa-users fa-fw me-2"></i>
							Manage Users
						</a>
						<a href="products/table.view.php" class="list-group-item list-group-item-action">
							<i class="fas fa-edit fa-fw me-2"></i>
							Manage Products
						</a>
						<a href="carts/cart.view.php" class="list-group-item list-group-item-action">
							<i class="fas fa-shopping-cart fa-fw me-2"></i>
							Shopping Cart <div class="badge bg-primary px-2 ms-2">
								<?= htmlspecialchars($cartTotal) ?>
							</div>
						</a>
					</ul>
					<?php endif ?>
					<div class="text-center">
						<a href="../actions/users/logout.php" class="btn btn-outline-danger">Logout</a>
					</div>
				</div>
			</div>
			<!-- End Profile Section  -->
			<div class="col-12 col-lg-9">
				<div class="row">
					<div class="col-12 pt-1">
						<div class="alert alert-info border rounded p-2 shadow-sm">
							<div class="d-flex justify-content-between align-items-center">
								<h1 class="h4 ps-2 py-2 m-0 text-secondary">Welcome,
									<?= htmlspecialchars($auth->name) ?>
								</h1>
								<a href="#" class="btn btn-sm btn-primary d-none d-lg-inline shadow-sm">
									<i class="fas fa-key"></i>
								</a>
								<a href="#" class="btn btn-secondary d-md-none shadow-sm">
									<i class="fas fa-bars fa-lg"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div
						class="col-12 <?php if($auth->role_id >= 2) :?> col-lg-8 <?php endif ?>">
						<!-- Order Section Start  -->
						<?php if($cartTotal) :?>
						<a href="carts/cart.view.php" class="position-fixed dNone" id="cart">
							<div class="alert alert-info position-relative d-flex align-items-center justify-content-center shadow border border-info"
								style="max-width: 50px; max-height: 50px;">
								<span>
									<i class="fas fa-shopping-cart fa-lg"></i>
								</span>
								<div
									class="badge bg-info position-absolute top-0 start-100 translate-middle border border-info shadow-sm">
									<?= htmlspecialchars($cartTotal) ?>
								</div>
							</div>
						</a>
						<?php endif ?>
						<!-- Order Section End  -->
						<div class="row px-1">
							<!-- Start Products Section  -->
							<?php foreach ($products as $product) :?>
							<div
								class="col-12 <?php if($auth->role_id >= 2) :?> col-lg-6 <?php else : ?> col-lg-4 <?php endif ?> px-2 pb-3">
								<div class="card border rounded cardSize shadow-sm position-relative">
									<div class="badge p-2 alert alert-warning position-absolute top-0 start-0">
										Brand New
									</div>
									<?php if($product->photo) :?>
									<div class="d-flex justify-content-center rounded shadow-sm">
										<img src="../actions/photos/products/<?= htmlspecialchars($product->photo) ?>"
											class="py-4" alt="Product Img" style="height: 200px">
									</div>
									<?php else :?>
									<div class="d-flex justify-content-center border rounded shadow-sm">
										<img src="../actions/photos/products/office.jpeg" alt="Product Img"
											style="height: 200px">
									</div>
									<?php endif ?>
									<div class="card-body">
										<div class="d-flex justify-content-between align-items-center">
											<h1 class="h6 p-0 mb-2">
												<?= htmlspecialchars($product->title) ?>
											</h1>
											<h1 class="h5">
												<?= htmlspecialchars($product->price) ?>
												(Ks)
											</h1>
										</div>
										<?php if($product->stock > 0) :?>
										<span class="badge bg-success p-2 position-absolute top-0 end-0">
											In Stock -
											<?= htmlspecialchars($product->stock) ?>
										</span>
										<?php else : ?>
										<span class="badge bg-danger p-2 position-absolute top-0 end-0">
											Out of Stock
										</span>
										<?php endif ?>
										<div>
											<small>
												<b>Description : </b>
												<?= htmlspecialchars($product->description) ?>
											</small>
										</div>
										<?php if($product->stock > 0) :?>
										<a href="../actions/carts/add.php?product_id=<?= htmlspecialchars($product->id) ?>"
											class="btn btn-sm btn-info w-100 mt-2 border shadow-sm">Add
											to
											cart</a>
										<?php else :?>
										<a href="orders/order.view.php?product_id=<?= htmlspecialchars($product->id) ?>"
											class="btn btn-sm btn-danger w-100 mt-2 border shadow-sm">Pre
											Order
											Now!</a>
										<?php endif ?>
									</div>
								</div>
							</div>
							<?php endforeach ?>
							<!-- End Products Section  -->
						</div>
					</div>
					<!-- Start All Users Section  -->
					<?php if($auth->role_id >= 2) :?>
					<div class="col-4 d-none d-lg-inline">
						<div class="alert alert-info shadow-sm">
							<h1 class="alert alert-info border border-3 border-white text-center h5 m-0 mb-2 shadow-sm">
								All Users
							</h1>
							<?php foreach ($users as $user) :?>
							<?php if($auth->id !== $user->id) :?>
							<a href="users/profile.view.php?id=<?= htmlspecialchars($user->id) ?>"
								class="d-flex align-items-center border rounded bg-light mb-1 p-1 dNone shadow-sm">
								<?php if(isset($user->photo)) :?>
								<img src="../actions/photos/users/<?= htmlspecialchars($user->photo) ?>"
									alt="" class="border rounded-circle border-3 border-white shadow-sm"
									style="max-width: 45px">
								<?php else :?>
								<div class="border rounded-circle border-3 border-white shadow-sm d-flex justify-content-center align-items-center bg-light"
									style="min-width: 45px; min-height: 45px">
									<i class="fas fa-user fa-lg text-secondary"></i>
								</div>
								<?php endif ?>
								<h1 class="h6 p-0 m-0 ps-2 ">
									<?= htmlspecialchars($user->name) ?>
									<span
										class="text-danger">(<?= htmlspecialchars($user->role) ?>)</span>
								</h1>
							</a>
							<?php endif ?>
							<?php endforeach ?>
						</div>
					</div>
					<?php endif ?>
					<!-- End All Users Section  -->
				</div>
			</div>
		</div>
	</div>
</body>

</html>