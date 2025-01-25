<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Form Validation</title>
</head>

<body>
    <main>
    <aside class="left-box">
    <h3>Borrowed Books</h3>
    <?php
    $jsonData = file_get_contents('bookInfo.json');
    $jsonArray = json_decode($jsonData, true);

    foreach ($jsonArray as $item) {
        if (isset($item['token'])) {
            echo '<p>Token: ' . htmlspecialchars($item['token']) .  '</p>';
        }
    }
    ?>
</aside>


        <div>
            <section>
            <div class="box1">
    <h2 style="text-align: center;">All Available Books</h2>

    <div class="allbooks">
        <?php
        include('connect.php'); // Ensure the database connection is included

        // Query to fetch all books from the database
        $sql = 'SELECT * FROM booksinfo';
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            // Display SQL error if the query fails
            die("<p style='color: red;'>Error fetching books: " . mysqli_error($conn) . "</p>");
        }

        if (mysqli_num_rows($result) > 0) {
            // Loop through each book and display it in the box
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="book-item" style="border: 1px solid #ddd; margin: 10px; padding: 15px; border-radius: 5px; background: #f9f9f9;">';
                echo '<h3 style="color: #4a90e2;">' . htmlspecialchars($row['book_Name']) . '</h3>';
                echo '<p><strong>Author:</strong> ' . htmlspecialchars($row['author_Name']) . '</p>';
                echo '<p><strong>Quantity:</strong> ' . htmlspecialchars($row['quantity']) . '</p>';
                echo '</div>';
            }
        } else {
            // Display a message if no books are found
            echo '<p style="text-align: center; color: red;">No books found in the database.</p>';
        }
        ?>
    </div>
</div>


<div class="box1">
    <h2 style="text-align: center;">Search Books</h2>

    <!-- Search Books Form -->
    <form action="" method="get" class="bookFormRow">
        <label for="searchBookValue">Search</label>
        <input class="input" type="text" name="searchBookValue" id="searchBookValue" placeholder="Enter Book Name or ID">
        <input class="input" type="submit" name="searchBook" value="Search Book">
    </form>

    <?php
    if (isset($_GET['searchBook']) && isset($_GET['searchBookValue'])) {
        include('connect.php');

        $searchValue = $_GET['searchBookValue'];

        // SQL query to search for books
        $sql = is_numeric($searchValue)
            ? "SELECT * FROM booksinfo WHERE id=$searchValue"
            : "SELECT * FROM booksinfo WHERE book_Name='$searchValue'";

        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($book = mysqli_fetch_assoc($result)) {
                echo '<div class="book-item" style="border: 1px solid #ddd; margin: 10px; padding: 15px; border-radius: 5px; background: #f9f9f9;">';
                echo '<h3 style="color: #4a90e2;">' . htmlspecialchars($book['book_Name']) . '</h3>';
                echo '<p><strong>Author:</strong> ' . htmlspecialchars($book['author_Name']) . '</p>';
                echo '<p><strong>Quantity:</strong> ' . htmlspecialchars($book['quantity']) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p style="text-align: center; color: red;">No books found with the given details.</p>';
        }
    }
    ?>
</div>




<div class="box1">
    <h2 style="text-align: center;">Update Books</h2>

    <!-- Search Form for Update -->
    <form action="" method="get" class="bookFormRow">
        <label for="updateSearchValue">Search by Book ID or Name:</label>
        <input class="input" type="text" name="updateSearchValue" id="updateSearchValue" placeholder="Enter Book ID or Name" required>
        <input class="input" type="submit" name="updateSearchBook" value="Search Book">
    </form>

    <?php
    if (isset($_GET['updateSearchBook'])) {
        include('connect.php');

        $searchValue = $_GET['updateSearchValue'];

        // SQL query to search for the book by ID or Name
        $sql = is_numeric($searchValue)
            ? "SELECT * FROM booksinfo WHERE id=$searchValue"
            : "SELECT * FROM booksinfo WHERE book_Name='$searchValue'";

        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $book = mysqli_fetch_assoc($result);

            // Extract book details
            $bookId = $book['id'];
            $bookName = $book['book_Name'];
            $authorName = $book['author_Name'];
            $quantity = $book['quantity'];
            ?>

            <!-- Update Form -->
            <form action="bookProcess.php" method="post" style="display: flex; flex-direction: column; gap: 10px;">
                <input type="hidden" name="bookId" value="<?php echo $bookId; ?>">

                <div class="bookFormRow">
                    <label for="bookName">Book Name:</label>
                    <input class="input" type="text" name="bookName" id="bookName" value="<?php echo htmlspecialchars($bookName); ?>" required>
                </div>
                <div class="bookFormRow">
                    <label for="authorName">Author Name:</label>
                    <input class="input" type="text" name="authorName" id="authorName" value="<?php echo htmlspecialchars($authorName); ?>" required>
                </div>
                <div class="bookFormRow">
                    <label for="quantity">Quantity:</label>
                    <input class="input" type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($quantity); ?>" required>
                </div>
                <div class="bookFormRow">
                    <input class="input" type="submit" name="updateBook" value="Update Book">
                </div>
            </form>

        <?php
        } else {
            echo '<p style="color: red; text-align: center;">No book found with the given details.</p>';
        }
    }
    ?>
</div>







                

                <div class="box1">
                    <h2 style="text-align: center;">Add Books</h2>

                    <form action="bookProcess.php" method="post" style="display: flex; flex-direction: column; gap: 10px;">
                        <div class="bookFormRow">
                            <label for="bookName">Book Name:</label>
                            <input class="input" type="text" name="bookName" id="bookName">
                        </div>
                        <div class="bookFormRow">
                            <label for="authorName">Author Name:</label>
                            <input class="input" type="text" name="authorName" id="authorName">
                        </div>
                        <div class="bookFormRow">
                            <label for="quantity">Quantity:</label>
                            <input class="input" type="text" name="quantity" id="quantity">
                        </div>
                        <div class="bookFormRow">
                            <input class="input" type="submit" name="addBook" value="Add Book">
                        </div>
                    </form>

                </div>
            </section>

            <section class="section2">
                <div class="box2"></div>
                <div class="box2"></div>
                <div class="box2"></div>
            </section>

            <section class="section2">
                <div>
                    <form class="form" action="process.php" method="post">
                        <h2>Book Borrow Form</h2>
                        <input class="input" type="text" name="studentName" placeholder="Student Name">
                        <input class="input" type="text" name="studentID" placeholder="Student ID">
                        <input class="input" type="email" name="studentEmail" placeholder="Email">
                        <!-- <input class="input" type="text" name="bookTitle" placeholder="Book Title"> -->
                        <select name="bookTitle" id="" class="input">
    <option value="">Select Book</option>
    <?php
    include('connect.php'); // Ensure the database connection is included

    // Fetch all books from the database
    $sql = 'SELECT * FROM booksinfo';
    $result = mysqli_query($conn, $sql);
    
    $allBooks = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $allBooks[] = $row; // Store each book in the array
        }
    }
    if (!empty($allBooks)) {
        foreach ($allBooks as $book) {
            echo '<option value="' . htmlspecialchars($book['book_Name']) . '">' . htmlspecialchars($book['book_Name']) . '</option>';
        }
    } else {
        echo '<option value="">No books available</option>';
    }
    ?>
</select>

                        <input class="input" type="date" name="borrowDate" placeholder="Borrow Date">
                        <input class="input" type="text" name="token" placeholder="Token">
                        <input class="input" type="date" name="returnDate" placeholder="Return Date">
                        <input class="input" type="number" name="fees" placeholder="Fees">
                        <input class="input" type="submit" name="submit" value="submit">
                    </form>
                </div>

                <div class="box3">
    <h3>Available Tokens</h3>
    <?php
    include './utils.php'; // Ensure utils.php is included

    // Fetch the predefined tokens
    $validTokens = getAllTokens();
    foreach ($validTokens as $token) {
        echo '<p>' . htmlspecialchars($token) . '</p>';
    }
    ?>
</div>


                
            </section>
        </div>

        <aside class="right-box">
            <!-- <img src="./images//21-45844-3.PNG" alt="student ID" width="200px"> -->
        </aside>
    </main>

</body>

</html>