<?php
require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    //Get the ID from the POST request
    $articleId = (int)$_POST['id'];

    $articleRepository = new ArticleRepository('articles.json');

    $articleRepository->deleteArticleById($articleId);

    //Redirect back to the index page after deletion
    header('Location: index.php');
    exit();
}
?>
