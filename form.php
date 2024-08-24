<?php
session_start();

if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

// Hàm kiểm tra trùng user_id và email
function isDuplicate($user_id, $email) {
    foreach ($_SESSION['users'] as $user) {
        if ($user['user_id'] != $user_id && $user['email'] == $email) {
            return true;
        }
    }
    return false;
}

// Add hoặc Edit User
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];

    // Kiểm tra số điện thoại có đúng định dạng không
    if (!preg_match('/^\d{10,11}$/', $phone)) {
        echo "<script>alert('Số điện thoại phải là số và có độ dài từ 10 đến 11 ký tự');</script>";
    } elseif (isDuplicate($user_id, $email)) {
        echo "<script>alert('Email đã tồn tại!');</script>";
    } else {
        $user = [
            'user_id' => $user_id ?: count($_SESSION['users']) + 1,
            'username' => $username,
            'email' => $email,
            'address' => $address,
            'phone' => $phone,
            'gender' => $gender
        ];

        if ($user_id) {
            $_SESSION['users'][$user_id - 1] = $user;
        } else {
            $_SESSION['users'][] = $user;
        }
    }
}

// Delete
if (isset($_GET['delete'])) {
    unset($_SESSION['users'][$_GET['delete'] - 1]);
}

// Get User
$editingUser = isset($_GET['edit']) ? $_SESSION['users'][$_GET['edit'] - 1] : null;

$users = $_SESSION['users'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        h1{
    color: white;
    padding: 10px;;
    text-align: center;
    background-color: #007bff;
}
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        form, table {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>User Management</h1>

    <form method="POST">
        <input type="hidden" name="user_id" value="<?php echo $editingUser['user_id'] ?? ''; ?>">
        <input type="text" name="username" placeholder="Username" required value="<?php echo $editingUser['username'] ?? ''; ?>">
        <input type="email" name="email" placeholder="Email" required value="<?php echo $editingUser['email'] ?? ''; ?>">
        <input type="text" name="address" placeholder="Address" value="<?php echo $editingUser['address'] ?? ''; ?>">
        <input type="text" name="phone" placeholder="Phone number" pattern="\d{10,11}" value="<?php echo $editingUser['phone'] ?? ''; ?>">
        <select name="gender">
            <option value="Male" <?php echo isset($editingUser) && $editingUser['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo isset($editingUser) && $editingUser['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
            <option value="Other" <?php echo isset($editingUser) && $editingUser['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
        </select>
        <button type="submit"><?php echo $editingUser ? 'Edit' : 'Add User'; ?></button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Address</th>
            <th>Phone number</th>
            <th>Gender</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?php echo $user['user_id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['address']; ?></td>
                <td><?php echo $user['phone']; ?></td>
                <td><?php echo $user['gender']; ?></td>
                <td>
                    <a href="?edit=<?php echo $user['user_id']; ?>">Edit</a> | 
                    <a href="?delete=<?php echo $user['user_id']; ?>" onclick="return confirm('Are you sure want to delete?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
