<?php

if (isset($_POST["submit"])) {
    $error_message = "";

    // Validate student name
    if (preg_match("/^[A-Za-z ]+$/", $_POST["studentName"])) {
        $studentName = $_POST["studentName"];
    } else {
        $error_message .= "Invalid student name. Must start with a capital letter and contain only letters and spaces.<br>";
    }

    // Validate student ID
    if (preg_match("/^\\d{2}-\\d{5}-\\d{1}$/", $_POST["studentID"])) {
        $studentID = $_POST["studentID"];
    } else {
        $error_message .= "Invalid student ID. Format must be NN-NNNNN-N.<br>";
    }

    // Validate student email
    if (preg_match("/^\\d{2}-\\d{5}-\\d{1}@student\\.aiub\\.edu$/", $_POST["studentEmail"])) {
        $studentEmail = $_POST["studentEmail"];
    } else {
        $error_message .= "Invalid student email. Format must be NN-NNNNN-N@student.aiub.edu.<br>";
    }

    // Set book title and cookie
    if (isset($_POST["bookTitle"])) {
        $bookTitle = $_POST["bookTitle"];
        $cookie_name = str_replace(" ", "", $bookTitle);
        $cookie_value = $_POST["studentName"];
    }

    require_once './utils.php';

    // Validate token
    $token = $_POST['token'] ?? '';
    if (!validateToken($token)) {
        echo json_encode(['Invalid token. Please use a valid token.']);
        exit;
    }
    // Check if the token is already in use
    $jsonFile = 'bookInfo.json';
    if (!file_exists($jsonFile)) {
        file_put_contents($jsonFile, json_encode([])); // Create an empty JSON file
    }
    $jsonArray = json_decode(file_get_contents($jsonFile), true) ?? [];

    if (!is_array($jsonArray)) {
        $jsonArray = []; // Ensure it's an array
    }

    if (!empty($token)) {
        $isTokenUsed = array_filter($jsonArray, function ($borrowInfo) use ($token) {
            return isset($borrowInfo['token']) && $borrowInfo['token'] === $token;
        });

        if ($isTokenUsed) {
            echo json_encode(['status' => 'error', 'message' => 'The token is already in use.']);
            exit;
        }
    }


    // Calculate borrowing duration
    $borrowDate = new DateTime($_POST["borrowDate"]);
    $returnDate = new DateTime($_POST["returnDate"]);
    $duration = $borrowDate->diff($returnDate)->days;   

    if ($borrowDate >= $returnDate) {
        $error_message .= "Return date must be after the borrow date.<br>";
    }

    // Stop processing if there are errors
    if (!empty($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
        exit;
    }

    // Prepare data to save
    $formData = [
        'name' => $studentName,
        'student_Id' => $studentID,
        'student_email' => $studentEmail,
        'bookTitle' => $bookTitle,
        'borrow_date' => $_POST["borrowDate"],
        'return_date' => $_POST["returnDate"],
        'fees' => $_POST["fees"],
    ];

    // Include token only if the duration is greater than 10 days
    if ($duration > 10) {
        $formData['token'] = $token;
    }

    // Save data to JSON
    $jsonFile = 'bookInfo.json';
    $jsonArray = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];
    $jsonArray[] = $formData;

    if (file_put_contents($jsonFile, json_encode($jsonArray))) {
        echo "Data successfully saved to JSON file!";
    } else {
        echo "Error saving data to JSON file!";
        exit;
    }


echo '
<div style="
    width: 100%; 
    max-width: 600px; 
    margin: 20px auto; 
    padding: 20px; 
    border: 1px solid #e0e0e0; 
    border-radius: 10px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    background-color: #f9f9f9; 
    font-family: Arial, sans-serif; 
    color: #333;">
    <h2 style="text-align: center; color: green; margin-bottom: 20px;">Thanks for borrowing a book!</h2>
    <h3 style="margin: 10px 0; color: #4a90e2;">Student Name: <span style="color: #555;">' . htmlspecialchars($studentName) . '</span></h3>
    <h3 style="margin: 10px 0; color: #4a90e2;">Student ID: <span style="color: #555;">' . htmlspecialchars($studentID) . '</span></h3>
    <h3 style="margin: 10px 0; color: #4a90e2;">Student Email: <span style="color: #555;">' . htmlspecialchars($studentEmail) . '</span></h3>
    <h3 style="margin: 10px 0; color: #4a90e2;">Book Title: <span style="color: #555;">' . htmlspecialchars($bookTitle) . '</span></h3>
    <h3 style="margin: 10px 0; color: #4a90e2;">Borrow Date: <span style="color: #555;">' . htmlspecialchars($_POST["borrowDate"]) . '</span></h3>
    <h3 style="margin: 10px 0; color: #4a90e2;">Return Date: <span style="color: #555;">' . htmlspecialchars($_POST["returnDate"]) . '</span></h3>
    <h3 style="margin: 10px 0; color: #4a90e2;">Token: <span style="color: #555;">' . htmlspecialchars($_POST["token"]) . '</span></h3>
    <h3 style="margin: 10px 0; color: #4a90e2;">Fees: <span style="color: #555;">' . htmlspecialchars($_POST["fees"]) . ' BDT</span></h3>
</div>';


    
    
    
    // if ($duration > 10) {
    //     echo '<h3>Token: ' . htmlspecialchars($token) . '</h3>';
    // }
    // echo '<h3>Fees: ' . htmlspecialchars($_POST["fees"]) . '</h3>
    //     </div>';
}
?>
