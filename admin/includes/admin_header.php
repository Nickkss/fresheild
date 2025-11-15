<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Freshield Admin'; ?> - Freshield 관리자</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Custom Admin Styles -->
    <style>
        :root {
            --sidebar-width: 250px;
            --topbar-height: 60px;
            --primary-color: #667eea;
            --secondary-color: #764ba2;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-brand {
            padding: 20px;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand a {
            color: white;
            text-decoration: none;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            padding: 12px 25px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: block;
            transition: all 0.3s;
        }

        .menu-item:hover,
        .menu-item.active {
            background: rgba(255,255,255,0.1);
            color: white;
            padding-left: 30px;
        }

        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
        }

        .topbar {
            background: white;
            height: var(--topbar-height);
            border-bottom: 1px solid #e3e6f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-avatar {
            width: 35px;
            height: 35px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .content-wrapper {
            padding: 30px;
        }

        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border-radius: 0.35rem;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        .badge-superadmin {
            background: #f6c23e;
            color: #333;
        }

        .badge-admin {
            background: #4e73df;
        }

        .stat-card {
            border-left: 4px solid;
        }

        .stat-card.primary {
            border-left-color: var(--primary-color);
        }

        .stat-card.success {
            border-left-color: #1cc88a;
        }

        .stat-card.info {
            border-left-color: #36b9cc;
        }

        .stat-card.warning {
            border-left-color: #f6c23e;
        }

        /* Table Styles */
        .table {
            color: #858796;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            font-size: 0.875rem;
            color: #4e73df;
        }

        /* Form Styles */
        .form-label {
            font-weight: 600;
            color: #5a5c69;
            margin-bottom: 0.5rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar.show {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
