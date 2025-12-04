<?php
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Add Product</title></head>
<body>
<h1>Add Product</h1>
<form action="store.php" method="post" enctype="multipart/form-data">
    <label>Name: <input type="text" name="name" required maxlength="100"></label><br><br>
    <label>Category:
        <select name="category" required>
            <option value="">--select--</option>
            <option value="Electronics">Electronics</option>
            <option value="Clothing">Clothing</option>
            <option value="Book">Book</option>
        </select>
    </label><br><br>
    <label>Price: <input type="number" name="price" step="0.01" min="0" required></label><br><br>
    <label>Stock: <input type="number" name="stock" min="0" required></label><br><br>
    <label>Image: <input type="file" name="image"></label><br><br>
    <label>Status:
        <select name="status" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </label><br><br>
    <button type="submit">Save</button>
</form>
<p><a href="index.php">Back to list</a></p>
</body>
</html>
