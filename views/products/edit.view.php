<?php
include "../../vendor/autoload.php";
use Libs\Database\MySQL;
use Libs\Database\ProductsTable;
use Helpers\Auth;
use Helpers\HTTP;

$id = $_GET['id'];
$auth = Auth::check();
$productsTable = new ProductsTable(new MySQL());
$product = $productsTable->findById($id);

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add Item</title>
	<link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>

<body>
	<div class="container mt-md-5 p-4 bg-light border rounded" style="max-width: 460px">
		<h1 class="h3 py-3 text-center">Edit Item</h1>
		<?php if($product->photo) :?>
		<img src="../../actions/photos/products/<?= htmlspecialchars($product->photo) ?>"
			alt="" class="img-thumbnail mb-2">
		<?php else : ?>
		<img src="../../actions/photos/products/office.jpeg?>" alt="" class="img-thumbnail mb-2">
		<?php endif ?>

		<form
			action="../../actions/products/update.photo.php?id=<?= htmlspecialchars($product->id) ?>"
			method="post" enctype="multipart/form-data">
			<div class="input-group mb-2">
				<input type="file" name="photo" class="form-control" required>
				<input type="submit" value="Update" class="btn btn-secondary">
			</div>
		</form>

		<form
			action="../../actions/products/update.product.php?id=<?= htmlspecialchars($product->id) ?>"
			method="post">
			<input type="text" name="title" placeholder="Title" class="form-control mb-2" required
				value="<?= $product->title ?>">
			<input name="description" class="form-control mb-2" placeholder="Description" required
				value="<?= $product->description ?>">
			<input type="number" class="form-control mb-2" name="price" required placeholder="Price (Kyats)"
				value="<?= $product->price ?>">
			<input type="number" name="stock" class="form-control mb-2" placeholder="Stock"
				value="<?= $product->stock ?>">
			<input type="submit" value="Update Item" class="btn btn-primary"></input>
		</form>
	</div>
</body>

</html>