<?php
if (isset($_POST['addBook'])) {
    $conn = mysqli_connect("localhost", "root", "", "books_info");

    if ($conn) {

        $bookName = $_POST['bookName'];
        $authorName = $_POST['authorName'];
        $quantity = $_POST['quantity'];

        $sql = "INSERT INTO booksinfo (book_Name, author_Name, quantity) VALUES ('$bookName', '$authorName', '$quantity')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            // echo "Book added successfully.";

            echo "<script>
                document.write('Book added successfully.');
                setInterval(function() {
                    window.location.href = 'index.php';
                }, 2000);
            </script>";
        } else {
            echo "Failed to add book.";
        }
    }
}

if (isset($_POST['updateBook'])) {
    $conn = mysqli_connect("localhost", "root", "", "books_info");

    $bookId = intval($_POST['bookId']);
    $bookName = $_POST['bookName'];
    $authorName = $_POST['authorName'];
    $quantity = $_POST['quantity'];

    $sql = "UPDATE booksinfo SET book_Name='$bookName', author_Name='$authorName', quantity='$quantity' WHERE id='$bookId' OR book_Name='$bookName'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // echo "Book updated successfully.";

        echo "<script>
                document.write('Book updated successfully.');
                setInterval(function() {
                    window.location.href = 'index.php';
                }, 2000);
            </script>";
    } else {
        echo "Failed to update.";
    }
}
