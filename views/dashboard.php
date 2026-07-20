<?php
require_once 'layout/header.php';
?>

<div class="dashboard-container">
    <h1>Dashboard</h1>
    
    <div class="dashboard-grid">
        <!-- Today's Summary -->
        <div class="dashboard-card">
            <h3>Today's Sales</h3>
            <div class="stat-value">₱<?php echo number_format($todaysSales['total'] ?? 0, 2); ?></div>
            <p class="stat-label"><?php echo ($todaysSales['count'] ?? 0) . ' orders'; ?></p>
        </div>

        <!-- Low Stock Alert -->
        <div class="dashboard-card alert-card">
            <h3>Low Stock Items</h3>
            <div class="stat-value warning"><?php echo count($lowStock); ?></div>
            <p class="stat-label">Items below reorder point</p>
        </div>

        <!-- Recent Sales -->
        <div class="dashboard-card full-width">
            <h3>Recent Sales</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Cashier</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentSales as $sale): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($sale['id']); ?></td>
                            <td>₱<?php echo number_format($sale['total'], 2); ?></td>
                            <td><?php echo htmlspecialchars($sale['cashier']); ?></td>
                            <td><?php echo formatDateTime($sale['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once 'layout/footer.php';
?>