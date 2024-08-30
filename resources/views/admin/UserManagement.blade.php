<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/admin/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
    <style>
        /* Your existing CSS for sidebar, main content, table, and modal here */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }
        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <h2>Admin Panel</h2>
        </div>
        <ul>
            <li><a href="#user-management">User Management</a></li>
            <li><a href="#payments">Payments</a></li>
            <li><a href="#products">Products</a></li>
            <li><a href="#shipping">Shipping</a></li>
            <li><a href="#landing-pages">Landing Pages</a></li>
        </ul>
    </div>

    <div class="main-content" id="mainContent">
        <button id="toggleSidebarBtn">☰</button>
        <div id="user-management" class="content-section">
            <h2>User Management</h2>
            <button id="addUserBtn">Add New User</button>
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                <tr>
                     <td>{{ $user->email }}</td>
                     <td>••••••••</td>
                     <td class="actions">
                     <button class="edit" data-id="{{ $user->id }}" data-email="{{ $user->email }}" data-registration-date="{{ $user->registration_date }}"><i class="fas fa-pencil-alt"></i></button>
                     <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                     @csrf
                     @method('DELETE')
                    <button class="delete"><i class="fas fa-trash-alt"></i></button>
            </form>
        </td>
    </tr>
@endforeach

                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Add User -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <button class="close-btn">&times;</button>
            <form id="addUserForm" action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="add-email">Email:</label>
                    <input type="email" id="add-email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="add-password">Password:</label>
                    <input type="password" id="add-password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="add-registration-date">Registration Date:</label>
                    <input type="date" id="add-registration-date" name="registration_date" required>
                </div>
                <button type="submit">Add User</button>
            </form>
        </div>
    </div>

   <!-- Modal for Edit User -->
<div id="editUserModal" class="modal">
    <div class="modal-content">
        <button class="close-btn">&times;</button>
        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit-email">Email:</label>
                <input type="email" id="edit-email" name="email" required>
            </div>
            <div class="form-group">
                <label for="edit-password">Password (leave blank to keep current password):</label>
                <input type="password" id="edit-password" name="password">
            </div>
            <div class="form-group">
                <label for="edit-registration-date">Registration Date:</label>
                <input type="date" id="edit-registration-date" name="registration_date" required>
            </div>
            <input type="hidden" id="edit-user-id" name="user_id">
            <button type="submit">Edit User</button>
        </form>
    </div>
</div>


    <script>
        // Open modal for adding a new user
        document.getElementById('addUserBtn').addEventListener('click', function() {
            document.getElementById('addUserModal').style.display = 'block';
            document.getElementById('addUserForm').reset();
        });

        // Open modal for editing a user
    document.querySelectorAll('.edit').forEach(function(button) {
        button.addEventListener('click', function() {
            var userId = this.getAttribute('data-id');
            var userEmail = this.getAttribute('data-email');
            var registrationDate = this.getAttribute('data-registration-date');

            // Set form values
            document.getElementById('edit-email').value = userEmail;
            document.getElementById('edit-registration-date').value = registrationDate;
            document.getElementById('edit-user-id').value = userId;

            // Update the form's action to include the correct user ID
            document.getElementById('editUserForm').action = "{{ url('users') }}/" + userId;

            // Display the modal
            document.getElementById('editUserModal').style.display = 'block';
        });
    });




        // Close modal when clicking outside of the modal content
    window.addEventListener('click', function(event) {
        var addModal = document.getElementById('addUserModal');
        var editModal = document.getElementById('editUserModal');
        if (event.target == addModal) {
            addModal.style.display = 'none';
        } else if (event.target == editModal) {
            editModal.style.display = 'none';
        }
    });

    // Close modal when clicking the close button
    document.querySelectorAll('.close-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            this.closest('.modal').style.display = 'none';
        });
    });


        // Toggle sidebar
    document.getElementById('toggleSidebarBtn').addEventListener('click', function() {
        var sidebar = document.getElementById('sidebar');
        var mainContent = document.getElementById('mainContent');
        sidebar.classList.toggle('closed');
        mainContent.classList.toggle('collapsed');
        this.classList.toggle('collapsed');
    });
    </script>
</body>
</html>
