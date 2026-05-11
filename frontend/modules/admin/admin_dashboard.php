<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Admin Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { display: flex; background-color: #f1f5f9; }
        
        .sidebar { width: 260px; height: 100vh; background: #0f172a; color: white; position: fixed; padding: 20px; }
        .sidebar h2 { text-align: center; margin-bottom: 30px; font-size: 20px; color: #2563eb; }
        .sidebar ul { list-style: none; }
        .sidebar ul li { padding: 15px; border-bottom: 1px solid #1e293b; transition: 0.3s; }
        .sidebar ul li:hover { background: #1e293b; cursor: pointer; }
        .sidebar ul li a { color: white; text-decoration: none; display: block; }
        
        .main-content { margin-left: 260px; padding: 40px; width: 100%; }
        .header { margin-bottom: 30px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; }
        .header h1 { color: #0f172a; }
        .header p { color: #475569; margin-top: 5px; }

        .MINI_CARDS_GRID {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .mini_card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border: 1px solid #e2e8f0;
        }
        .stat_info h4 { color: #64748b; font-size: 14px; font-weight: 500; margin-bottom: 8px; }
        .stat_info h2 { color: #0f172a; font-size: 28px; font-weight: 700; margin-bottom: 5px; }
        .trend { font-size: 14px; font-weight: 600; }
        .trend.up { color: #10b981; }
        .trend.down { color: #f43f5e; }

        .title { margin: 30px 0 20px 0; color: #0f172a; font-size: 1.5rem; }
        .card-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; }
        .card { 
            background: #ffffff; 
            padding: 28px; 
            border-radius: 16px; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.03); 
            text-align: center; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            border: 1px solid #e2e8f0;
        }
        .card:hover { 
            transform: translateY(-6px); 
            box-shadow: 0 20px 25px -12px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.05);
            border-top: 3px solid #2563eb;
            border-color: #2563eb;
        }
        .card h3 { color: #0f172a; margin-bottom: 12px; font-weight: 600; font-size: 1.25rem; }
        .card p { color: #475569; font-size: 14px; line-height: 1.5; }
        .btn { 
            display: inline-block; 
            margin-top: 18px; 
            padding: 10px 26px; 
            background: #2563eb; 
            color: white; 
            text-decoration: none; 
            border-radius: 12px; 
            font-size : 16px; 
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
        }
        .btn:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>  Admin Panel</h2>
        <ul>
            <li> <a href="#users">  User Management</a> </li>
            <li> <a href="#branches">  Branch Management</a> </li>
            <li> <a href="#products">  Product Management</a> </li>
            <li> <a href="#inventory">  Inventory Overview</a> </li>
            <li> <a href="#suppliers">  Supplier Management</a> </li>
            <li> <a href="#reports">  Reports & Analytics</a> </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>  Admin Dashboard</h1>
            <p>WELCOME TO THE ADMIN PANEL</p>
        </div>

        <div class="MINI_CARDS_GRID">
            <div class="mini_card">
                <div class="stat_info">
                    <h4>Total Sales Today</h4>
                    <h2>LKR 12,450</h2>
                    <span class="trend up">+12.5%</span>
                </div>
            </div>

            <div class="mini_card">
                <div class="stat_info">
                    <h4>Total Revenue</h4>
                    <h2>LKR 245,890</h2>
                    <span class="trend up">+8.2%</span>
                </div>
            
            </div>

            <div class="mini_card">
                <div class="stat_info">
                    <h4>Low Stock Items</h4>
                    <h2>23</h2>
                    <span class="trend down" style="color: #f97316;">5 Critical</span >
                </div>
            
            </div>

            <div class="mini_card">
                <div class="stat_info">
                    <h4>Active Branches</h4>
                    <h2>8</h2>
                    <span class="trend up">100%</span>
                </div>
    
            </div>
        </div>
        
        <h2 class="title">System Modules</h2>

        <div class="card-container">
            <div class="card" id="users">
                <h3>User Management</h3>
                <p>Register new users and assign roles (Admin, Manager, Cashier)</p>
                <a href="v.html" class="btn">Manage Users →</a>
            </div>

            <div class="card" id="branches">
                <h3> Branch Management</h3>
                <p>Add and manage branch locations and contact details</p>
                <a href="#" class="btn">Manage Branches →</a>
            </div>

            <div class="card" id="products">
                <h3> Product Management</h3>
                <p>Define product categories and prise list</p>
                <a href="#" class="btn">Manage Products →</a>
            </div>

            <div class="card" id="inventory">
                <h3> Inventory Overview</h3>
                <p>View of stock levels across all branches</p>
                <a href="#" class="btn">View Global Stock →</a>
            </div>

            <div class="card" id="suppliers">
                <h3>Supplier Management</h3>
                <p>Manage and add the supliers and informations</p>
                <a href="#" class="btn">Manage Suppliers →</a>
            </div>

            <div class="card" id="reports">
                <h3> Reports & Analytics</h3>
                <p>Monitor revenue, stock levels, and business losses</p>
                <a href="" class="btn">View Reports →</a>
            </div>
        </div>
    </div>

</body>
</html>