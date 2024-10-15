<?php
require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';

$articleRepository = new ArticleRepository('articles.json');
$articles = $articleRepository->getAllArticles();
?>

<!doctype html>
<html lang="en">

<?php require_once 'layout/header.php' ?>

<head>

    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="styles/input.css" rel="stylesheet">

</head>

<body>

    <?php require_once 'layout/navigation.php' ?>

    <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">

        <h2 id="page-title" class="text-3xl font-semibold text-center text-indigo-700 mt-10">Articles</h2>

        <div class="mt-8 grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">

            <?php if (!empty($articles)) : ?>
                <?php foreach ($articles as $article) : ?>
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-lg font-semibold text-gray-800">
                                <a href="<?php echo htmlspecialchars($article->getUrl()); ?>" target="_blank" class="text-warning no-underline">
                                    <?php echo htmlspecialchars($article->getTitle()); ?>
                                </a>
                            </h3>
                        </div>
                    </div>
                    <br>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center text-gray-500">No articles found.</p>
            <?php endif; ?>

        </div>
    </div>

</body>

</html>