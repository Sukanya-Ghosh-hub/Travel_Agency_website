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
            --primary: #4a6fa5;
            --secondary: #166088;
            --accent: #4fc3a1;
            --light: #f8f9fa;
            --dark: #343a40;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: var(--dark);
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        h1 {
            color: var(--primary);
            margin-bottom: 10px;
        }
        
        .bookings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }
        
        .booking-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 25px;
            transition: transform 0.3s ease;
        }
        
        .booking-card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-header h2 {
            color: var(--secondary);
            font-size: 1.4rem;
        }
        
        .card-date {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .card-section {
            margin-bottom: 15px;
        }
        
        .card-section h3 {
            color: var(--primary);
            font-size: 1.1rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .card-section h3 i {
            color: var(--accent);
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 6px;
        }
        
        .detail-label {
            font-weight: 500;
            min-width: 120px;
            color: #555;
        }
        
        .interests-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }
        
        .interest-tag {
            background-color: rgba(79, 195, 161, 0.2);
            color: var(--accent);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        
        .no-bookings {
            text-align: center;
            grid-column: 1 / -1;
            padding: 40px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        @media (max-width: 768px) {
            .bookings-grid {
                grid-template-columns: 1fr;
            }
            
            .detail-row {
                flex-direction: column;
            }
            
            .detail-label {
                margin-bottom: 2px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-plane"></i> Travel Bookings</h1>
            <p>View all customer travel requests</p>
        </header>
        
        <div class="bookings-grid">
            <?php if (empty($bookings)): ?>
                <div class="no-bookings">
                    <i class="fas fa-plane-slash" style="font-size: 3rem; color: #ccc; margin-bottom: 20px;"></i>
                    <h2>No Bookings Yet</h2>
                    <p>No travel bookings have been submitted yet.</p>
                </div>
            <?php else: ?>
                <?php foreach ($bookings as $booking): ?>
                    <div class="booking-card">
                        <div class="card-header">
                            <h2><?= htmlspecialchars($booking['personal']['fullName']) ?></h2>
                            <span class="card-date"><?= date('M j, Y', strtotime($booking['timestamp'])) ?></span>
                        </div>
                        
                        <div class="card-section">
                            <h3><i class="fas fa-user"></i> Personal Info</h3>
                            <div class="detail-row">
                                <span class="detail-label">Email:</span>
                                <span><?= htmlspecialchars($booking['personal']['email']) ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Phone:</span>
                                <span><?= htmlspecialchars($booking['personal']['phone']) ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">DOB:</span>
                                <span><?= date('M j, Y', strtotime($booking['personal']['dob'])) ?></span>
                            </div>
                        </div>
                        
                        <div class="card-section">
                            <h3><i class="fas fa-map-marked-alt"></i> Trip Details</h3>
                            <div class="detail-row">
                                <span class="detail-label">Destination:</span>
                                <span><?= htmlspecialchars($booking['trip']['destination']) ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Trip Type:</span>
                                <span><?= htmlspecialchars($booking['trip']['tripType']) ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Dates:</span>
                                <span>
                                    <?= date('M j', strtotime($booking['trip']['departureDate'])) ?> - 
                                    <?= date('M j, Y', strtotime($booking['trip']['returnDate'])) ?>
                                </span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Travelers:</span>
                                <span><?= htmlspecialchars($booking['trip']['travelers']) ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Budget:</span>
                                <span><?= htmlspecialchars($booking['trip']['budget']) ?></span>
                            </div>
                        </div>
                        
                        <div class="card-section">
                            <h3><i class="fas fa-hotel"></i> Accommodation</h3>
                            <div class="detail-row">
                                <span class="detail-label">Type:</span>
                                <span><?= htmlspecialchars($booking['accommodation']['accommodationType']) ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Room:</span>
                                <span><?= htmlspecialchars($booking['accommodation']['roomType']) ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Meals:</span>
                                <span><?= htmlspecialchars($booking['accommodation']['mealPlan']) ?></span>
                            </div>
                            <?php if (!empty($booking['accommodation']['specialRequests'])): ?>
                                <div class="detail-row">
                                    <span class="detail-label">Requests:</span>
                                    <span><?= htmlspecialchars($booking['accommodation']['specialRequests']) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-section">
                            <h3><i class="fas fa-route"></i> Preferences</h3>
                            <div class="detail-row">
                                <span class="detail-label">Flight Class:</span>
                                <span><?= ucfirst(htmlspecialchars($booking['preferences']['flightClass'])) ?></span>
                            </div>
                            <?php if (!empty($booking['preferences']['interests'])): ?>
                                <div class="detail-row">
                                    <span class="detail-label">Interests:</span>
                                    <div class="interests-list">
                                        <?php foreach (json_decode($booking['preferences']['interests']) as $interest): ?>
                                            <span class="interest-tag"><?= ucfirst(htmlspecialchars($interest)) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>