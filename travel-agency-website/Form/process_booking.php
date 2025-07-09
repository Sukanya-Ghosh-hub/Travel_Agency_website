<?php
header('Content-Type: application/json');

// Create bookings directory if it doesn't exist
if (!file_exists('bookings')) {
    mkdir('bookings', 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect all form data
    $bookingData = [
        'personal' => [
            'fullName' => $_POST['fullName'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'dob' => $_POST['dob'] ?? ''
        ],
        'trip' => [
            'destination' => $_POST['destination'] ?? '',
            'tripType' => $_POST['tripType'] ?? '',
            'departureDate' => $_POST['departureDate'] ?? '',
            'returnDate' => $_POST['returnDate'] ?? '',
            'travelers' => $_POST['travelers'] ?? '',
            'budget' => $_POST['budget'] ?? ''
        ],
        'accommodation' => [
            'accommodationType' => $_POST['accommodation'] ?? '',
            'roomType' => $_POST['roomType'] ?? '',
            'mealPlan' => $_POST['mealPlan'] ?? '',
            'specialRequests' => $_POST['specialRequests'] ?? ''
        ],
        'preferences' => [
            'interests' => $_POST['interests'] ?? [],
            'flightClass' => $_POST['flightClass'] ?? 'economy'
        ],
        'timestamp' => date('Y-m-d H:i:s')
    ];

    // Generate a unique filename
    $filename = 'bookings/' . uniqid('booking_') . '_' . preg_replace('/[^a-z0-9]/i', '_', strtolower($bookingData['personal']['fullName'])) . '.json';
    
    // Save to JSON file
    file_put_contents($filename, json_encode($bookingData, JSON_PRETTY_PRINT));
    
    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Booking submitted successfully!'
    ]);
} else {
    // Return error if not POST
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed'
    ]);
}
?>