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
	<div class="container mt-5 p-4 bg-light border rounded" style="max-width: 460px">
		<h1 class="h3 py-3">Add Item</h1>
		<form action="../../actions/products/create.php" method="post" enctype="multipart/form-data">
			<div class="input-group mb-2">
				<input type="file" name="photo" class="form-control" required>
			</div>
			<input type="text" name="title" placeholder="Title" class="form-control mb-2" required>
			<textarea name="description" class="form-control mb-2" placeholder="Description" required></textarea>
			<input type="number" class="form-control mb-2" name="price" required placeholder="Price (Kyats)">
			<input type="number" name="stock" class="form-control mb-2" placeholder="Stock">
			<input type="submit" value="+ Add Item" class="btn btn-primary"></input>
		</form>
	</div>
</body>

</html>