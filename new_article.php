<?php

require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';
require_once 'helpers/helpers.php';
// ... you'll probably need some of the require statements above

$response = "";
$jsonFile = "articles.json";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$title = htmlspecialchars($_POST['title']);
	$url = htmlspecialchars($_POST['url']);

	if (empty($title) || empty($url)) {
		$response = "No empty fields allowed.";
	}
	elseif (!filter_var($url, FILTER_VALIDATE_URL)) {
		$response = "Invalid URL.";
	} else {
		$article = new Article($title, $url);

		$jsonData = json_encode($article, JSON_PRETTY_PRINT);

		if (file_exists($jsonFile)) {
            // Read the existing content from the file
            $currentData = file_get_contents($jsonFile);
            
            // Decode the existing content to an array
            $jsonArray = json_decode($currentData, true);

            // If the file is empty or invalid, initialize as an empty array
            if (!is_array($jsonArray)) {
                $jsonArray = [];
            }
        } else {
            // If the file doesn't exist, initialize as an empty array
            $jsonArray = [];
        }

        // Add the new person data to the array
        $jsonArray[] = json_decode($jsonData, true);

        // Encode the updated array back into JSON and write it to the file
        if (file_put_contents($jsonFile, json_encode($jsonArray, JSON_PRETTY_PRINT))) {
            $response = "Data successfully saved to $jsonFile";
        } else {
            $response = "Error saving data to $jsonFile";
        }
	}
}

?>

<!doctype html>
<html lang="en">
<?php require_once 'layout/header.php' ?>

<body>
	<?php require_once 'layout/navigation.php' ?>
	<div class="flex min-h-full items-center justify-center px-4 mt-16 sm:px-6 lg:px-8">
		<div class="w-full max-w-xl space-y-8">

			The new article page. Handle displaying the new article form and handling article submissions here.

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
			Title: <input type="text" name="title" required><br><br>
			URL: <input type="text" name="url" required><br><br>
			<input type="submit" value="Submit">
		</form>

		<!-- Display a response message -->
		<h2>Status:</h2>
		<?php
		if (!empty($response)) {
			echo "<p>" . $response . "</p>";
		}
		?>

		</div>
	</div>
</body>

</html>