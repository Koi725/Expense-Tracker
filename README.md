Simple PHP Expense Tracker with User-Based Access

A lightweight PHP-based expense tracker app that supports:

    🔐 User login and registration

    👤 Role-based access (Admin vs Regular User)

    ➕ Add income/expense transactions

    📄 View your own transactions

    🧾 Admin can view all users' transactions

    💾 Data stored in simple JSON files (no database needed)

├── index.php → Redirect or home
├── login.php → Login form
├── register.php → Register new user
├── dashboard.php → Dashboard for users/admins
├── add_transaction.php → Add a new transaction
├── view_my_transactions.php → View current user's transactions
├── view_all_transactions.php → Admin-only: View all transactions
├── transactions.json → Stores all transactions
├── users.json → Stores registered users
├── includes/
│ └── auth.php → Handles auth/session/role check

Features

    No external libraries or DBs

    Clean UI with modern CSS

    Session-based user management

    Secure access handling via auth.php

    Separate dashboards for Admin and User

    Works fully offline (ideal for demos / small orgs)

Notes

    This app is JSON-based, so no database required.

    Designed for learning, personal use, or simple team expense logging.

    For production: always hash passwords and sanitize inputs

Author

Made with ❤️ by Kousha
