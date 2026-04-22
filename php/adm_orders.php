<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $sql = "UPDATE orders SET order_status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $order_status, $order_id);
    $stmt->execute();
}

$result = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Orders</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Admin – Manage Orders</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Customer</th>
        <th>Type</th>
        <th>Status</th>
        <th>Update</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
            <td><?php echo $row['order_type']; ?></td>
            <td><?php echo $row['order_status']; ?></td>
            <td>
                <form method="POST" class="inline-form">
                    <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                    <select name="order_status">
                        <option value="Pending" <?php if ($row['order_status']=='Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Preparing" <?php if ($row['order_status']=='Preparing') echo 'selected'; ?>>Preparing</option>
                        <option value="Ready for Collection" <?php if ($row['order_status']=='Ready for Collection') echo 'selected'; ?>>Ready for Collection</option>
                        <option value="Out for Delivery" <?php if ($row['order_status']=='Out for Delivery') echo 'selected'; ?>>Out for Delivery</option>
                        <option value="Completed" <?php if ($row['order_status']=='Completed') echo 'selected'; ?>>Completed</option>
                    </select>
                    <button type="submit">Save</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<p><a href="checkout.php">Back to checkout</a></p>
</body>
</html>
