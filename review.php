<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "awaiz2";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $review = $_POST['review'];
    $stars = $_POST['stars'];

    
    $sql = "INSERT INTO `aw3` (`username`, `review`, `stars`) VALUES ('$username', '$review', '$stars')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      echo '<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
      <strong>Success!</strong> Your review has been submitted successfully!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>';
  } else {
      echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
      <strong>Error!</strong> We are facing some technical issue and your review was not submitted successfully! We regret the inconvenience caused!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>';
  }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Reviews</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Add custom CSS styles here */
        .review-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        body{
          background-image: url('https://img.freepik.com/free-vector/blue-curve-background_53876-113112.jpg?w=2000');
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h1>Customer Reviews</h1>
    <form action="review.php" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Enter your username" required>
        </div>
        <div class="form-group">
            <label for="review">Review</label>
            <textarea name="review" class="form-control" id="review" rows="4" placeholder="Write your review"
                      required></textarea>
        </div>
        <div class="form-group">
            <label for="stars">Stars</label>
            <select name="stars" class="form-control" id="stars" required>
                <option value="5">5 Stars</option>
                <option value="4">4 Stars</option>
                <option value="3">3 Stars</option>
                <option value="2">2 Stars</option>
                <option value="1">1 Star</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <h2 class="mt-4">Customer Reviews</h2>
    <div id="reviews-container">
        <!-- Reviews will be fetched and displayed here using API -->
    </div>
</div>

<!-- Add Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        function fetchAndDisplayReviews() {
            $.ajax({
                url: "fetchapi.php", // Use the API URL to fetch data
                type: "GET",
                dataType: "json",
                success: function (data) {
                    var reviewsContainer = $("#reviews-container");
                    reviewsContainer.empty();

                    if (data.length === 0) {
                        reviewsContainer.append("<p>No reviews yet.</p>");
                    } else {
                        $.each(data, function (index, item) {
                            var stars = "<span class='stars'>&#9733;</span>".repeat(item.stars);
                            var reviewHtml = "<div class='review-box'>";
                            reviewHtml += "<p><strong>Username: </strong>" + item.username + "</p>";
                            reviewHtml += "<p><strong>Rating: </strong>" + stars + "</p>";
                            reviewHtml += "<p><strong>Review: </strong>" + item.review + "</p>";
                            reviewHtml += "</div>";
                            reviewsContainer.append(reviewHtml);
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("Error fetching data: " + textStatus + " - " + errorThrown);
                }
            });
        }

        fetchAndDisplayReviews();
    });
</script>
</body>
</html>
