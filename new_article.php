<?php

require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';
require_once 'helpers/helpers.php';

$response = "";
$jsonFile = "articles.json";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title']);
    $url = htmlspecialchars($_POST['url']);

    if (empty($title) || empty($url)) {
        $response = "No empty fields allowed.";
    } elseif (!filter_var($url, FILTER_VALIDATE_URL)) {
        $response = "Invalid URL.";
    } else {
        $article = new Article($title, $url);

        $jsonData = json_encode($article, JSON_PRETTY_PRINT);

        if (file_exists($jsonFile)) {
            $currentData = file_get_contents($jsonFile);
            $jsonArray = json_decode($currentData, true);
            if (!is_array($jsonArray)) {
                $jsonArray = [];
            }
        } else {
            $jsonArray = [];
        }

        $jsonArray[] = json_decode($jsonData, true);

        if (file_put_contents($jsonFile, json_encode($jsonArray, JSON_PRETTY_PRINT))) {
            header('Location: index.php');
            exit();
        } else {
            $response = "Error saving data to $jsonFile";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Article</title>
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once 'layout/navigation.php'; ?>

    <div class="container mt-5">
        <h2 class="mb-4">Add New Article</h2>

        <?php if (!empty($response)) : ?>
            <div class="alert alert-warning"><?php echo $response; ?></div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Article Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="url" class="form-label">Article URL</label>
                <input type="text" id="url" name="url" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
