<?php
// Get all booking files
$bookingFiles = glob('bookings/*.json');

// Read all bookings into an array
$bookings = [];
foreach ($bookingFiles as $file) {
    $bookingData = json_decode(file_get_contents($file), true);
    if ($bookingData) {
        $bookings[] = $bookingData;
    }
}

// Sort by timestamp (newest first)
usort($bookings, function($a, $b) {
    return strtotime($b['timestamp']) - strtotime($a['timestamp']);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel Bookings</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #4361ee;
      --secondary-color: #3f37c9;
      --accent-color: #4cc9f0;
      --light-color: #f8f9fa;
      --dark-color: #212529;
      --success-color: #4bb543;
      --warning-color: #f0ad4e;
      --danger-color: #d9534f;
      --border-radius: 8px;
      --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      --transition: all 0.3s ease;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f7ff;
      color: var(--dark-color);
      padding: 20px;
      line-height: 1.6;
    }

    .container {
      max-width: 1800px;
      margin: 30px auto;
      padding: 0 15px;
    }

    header {
      text-align: center;
      margin-bottom: 40px;
    }

    h1 {
      color: var(--primary-color);
      margin-bottom: 10px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 10px;
    }

    .table-container {
      background: white;
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      overflow: hidden;
      position: relative;
    }

    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      min-width: 1000px;
    }

    thead {
      position: sticky;
      top: 0;
      z-index: 10;
    }

    th {
      background-color: var(--primary-color);
      color: white;
      padding: 16px 20px;
      text-align: left;
      font-weight: 500;
      text-transform: uppercase;
      font-size: 0.75rem;
      letter-spacing: 0.5px;
      position: relative;
    }

    th:not(:last-child)::after {
      content: "";
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-50%);
      height: 60%;
      width: 1px;
      background-color: rgba(255, 255, 255, 0.2);
    }

    td {
      padding: 14px 20px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      vertical-align: middle;
      font-size: 0.85rem;
    }

    tr:last-child td {
      border-bottom: none;
    }

    tr:hover td {
      background-color: rgba(67, 97, 238, 0.05);
    }

    .interest-tag {
      background: rgba(76, 201, 240, 0.1);
      padding: 4px 10px;
      margin: 2px;
      border-radius: 20px;
      display: inline-block;
      font-size: 0.7rem;
      color: var(--accent-color);
      font-weight: 500;
      white-space: nowrap;
    }

    .no-bookings {
      text-align: center;
      padding: 60px 40px;
      background-color: white;
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      max-width: 600px;
      margin: 0 auto;
    }

    .no-bookings i {
      font-size: 3.5rem;
      color: #e0e0e0;
      margin-bottom: 20px;
    }

    .no-bookings h2 {
      color: var(--dark-color);
      margin-bottom: 10px;
    }

    .no-bookings p {
      color: #6c757d;
      font-size: 0.9rem;
    }

    .status-badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 0.7rem;
      font-weight: 500;
    }

    .status-pending {
      background-color: rgba(240, 173, 78, 0.1);
      color: var(--warning-color);
    }

    .status-confirmed {
      background-color: rgba(75, 181, 67, 0.1);
      color: var(--success-color);
    }

    .table-footer {
      display: flex;
      justify-content: end;
      align-items: center;
      padding: 15px 20px;
      background-color: white;
      border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table-actions {
      display: flex;
      gap: 10px;
    }

    .btn {
      padding: 8px 16px;
      border-radius: var(--border-radius);
      font-size: 0.8rem;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
      border: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .btn-primary {
      background-color: var(--primary-color);
      color: white;
    }

    .btn-primary:hover {
      background-color: var(--secondary-color);
    }

    .btn-outline {
      background-color: transparent;
      border: 1px solid #dee2e6;
      color: var(--dark-color);
    }

    .btn-outline:hover {
      background-color: #f8f9fa;
    }

    .pagination {
      display: flex;
      gap: 8px;
    }

    .page-item {
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 4px;
      font-size: 0.8rem;
      cursor: pointer;
      transition: var(--transition);
    }

    .page-item:hover {
      background-color: #f1f3ff;
    }

    .page-item.active {
      background-color: var(--primary-color);
      color: white;
    }

    @media (max-width: 992px) {
      .container {
        padding: 0 10px;
      }
      
      .table-footer {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
      }
    }

    @media (max-width: 768px) {
      .no-bookings {
        padding: 40px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <h1><i class="fas fa-plane-departure"></i> Travel Bookings Management</h1>
      <p>Comprehensive overview of all travel bookings</p>
    </header>

    <?php if (empty($bookings)): ?>
      <div class="no-bookings">
        <i class="fas fa-calendar-times"></i>
        <h2>No Bookings Found</h2>
        <p>There are currently no travel bookings in the system.</p>
      </div>
    <?php else: ?>
      <div class="table-container">
        <div class="table-responsive">
          <table>
            <thead>
              <tr>
                <th>Client</th>
                <th>Contact</th>
                <th>Trip Details</th>
                <th>Accommodation</th>
                <th>Preferences</th>
                <th>Requested</th>
                <th>Submitted</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($bookings as $booking): ?>
                <tr>
                  <td>
                    <div style="font-weight: 500;"><?= htmlspecialchars($booking['personal']['fullName']) ?></div>
                    <div style="font-size: 0.75rem; color: #6c757d;">ID: <?= substr(md5($booking['personal']['email']), 0, 8) ?></div>
                  </td>
                  <td>
                    <div><?= htmlspecialchars($booking['personal']['email']) ?></div>
                    <div style="font-size: 0.75rem;"><?= htmlspecialchars($booking['personal']['phone']) ?></div>
                  </td>
                  <td>
                    <div><strong><?= htmlspecialchars($booking['trip']['destination']) ?></strong></div>
                    <div style="font-size: 0.75rem;">
                      <?= date('M j', strtotime($booking['trip']['departureDate'])) ?> - 
                      <?= date('M j, Y', strtotime($booking['trip']['returnDate'])) ?>
                    </div>
                    <div style="display: flex; gap: 8px; margin-top: 4px;">
                      <span style="font-size: 0.7rem; background: #f1f3ff; padding: 2px 6px; border-radius: 4px;">
                        <?= htmlspecialchars($booking['trip']['tripType']) ?>
                      </span>
                      <span style="font-size: 0.7rem; background: #f1f3ff; padding: 2px 6px; border-radius: 4px;">
                        <?= htmlspecialchars($booking['trip']['travelers']) ?> travelers
                      </span>
                      <span style="font-size: 0.7rem; background: #f1f3ff; padding: 2px 6px; border-radius: 4px;">
                        <?= htmlspecialchars($booking['trip']['budget']) ?>
                      </span>
                    </div>
                  </td>
                  <td>
                    <div><?= htmlspecialchars($booking['accommodation']['accommodationType']) ?></div>
                    <div style="font-size: 0.75rem; display: flex; gap: 6px; margin-top: 4px;">
                      <span><?= htmlspecialchars($booking['accommodation']['roomType']) ?></span>
                      <span>•</span>
                      <span><?= htmlspecialchars($booking['accommodation']['mealPlan']) ?></span>
                    </div>
                  </td>
                  <td>
                    <div style="margin-bottom: 6px;">
                      <span style="font-size: 0.7rem; background: #f1f3ff; padding: 2px 6px; border-radius: 4px;">
                        <?= ucfirst(htmlspecialchars($booking['preferences']['flightClass'])) ?>
                      </span>
                    </div>
                    <div>
                      <?php
                        $interests = json_decode($booking['preferences']['interests']);
                        if (!empty($interests)) {
                          foreach ($interests as $interest) {
                            echo '<span class="interest-tag">' . ucfirst(htmlspecialchars($interest)) . '</span>';
                          }
                        }
                      ?>
                    </div>
                  </td>
                  <td style="max-width: 200px;">
                    <?= !empty($booking['accommodation']['specialRequests']) ? 
                        '<div style="font-size: 0.8rem; line-height: 1.4;">' . htmlspecialchars($booking['accommodation']['specialRequests']) . '</div>' : 
                        '<span style="color: #6c757d; font-size: 0.8rem;">No special requests</span>' ?>
                  </td>
                  <td>
                    <div><?= date('M j, Y', strtotime($booking['timestamp'])) ?></div>
                    <div style="font-size: 0.75rem; color: #6c757d;">
                      <?= date('H:i', strtotime($booking['timestamp'])) ?>
                    </div>
                    <div class="status-badge status-pending" style="margin-top: 4px;">
                      Pending Review
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        
        <div class="table-footer">
          <div style="font-size: 0.8rem; color: #6c757d;">
            Showing <strong>1-<?= count($bookings) ?></strong> of <strong><?= count($bookings) ?></strong> bookings
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>