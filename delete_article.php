<?php
require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $articleId = (int)$_POST['id'];

    $articleRepository = new ArticleRepository('articles.json');

    $articleRepository->deleteArticleById($articleId);

    header('Location: index.php');
    exit();
}
?>
