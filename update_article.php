<?php

require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';

$articleRepository = new ArticleRepository('articles.json');
$response = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $articleId = (int)$_POST['id'];
    $updatedTitle = htmlspecialchars($_POST['title']);
    $updatedUrl = htmlspecialchars($_POST['url']);

    if (empty($updatedTitle) || empty($updatedUrl)) {
        $response = "No empty fields allowed.";
    } elseif (!filter_var($updatedUrl, FILTER_VALIDATE_URL)) {
        $response = "Invalid URL.";
    } else {
        $article = $articleRepository->getArticleById($articleId);

        if ($article !== null) {
            $updatedArticle = new Article($updatedTitle, $updatedUrl, $article->getId());
            $articleRepository->updateArticle($articleId, $updatedArticle);
            header('Location: index.php');
            exit();
        } else {
            $response = "Article not found.";
        }
    }
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$articleId = (int)$_GET['id'];

$article = $articleRepository->getArticleById($articleId);

if ($article === null) {
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Update Article</title>
	<link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<?php require_once 'layout/navigation.php'; ?>
	
    <div class="container mt-5">
        <h2 class="mb-4">Update Article</h2>

        <?php if (!empty($response)) : ?>
            <div class="alert alert-warning"><?php echo $response; ?></div>
        <?php endif; ?>

        <form action="update_article.php?id=<?php echo htmlspecialchars($article->getId()); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($article->getId()); ?>">

            <div class="mb-3">
                <label for="title" class="form-label">Article Title</label>
                <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($article->getTitle()); ?>" required>
            </div>

            <div class="mb-3">
                <label for="url" class="form-label">Article URL</label>
                <input type="text" id="url" name="url" class="form-control" value="<?php echo htmlspecialchars($article->getUrl()); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Article</button>
        </form>
    </div>
</body>
</html>
