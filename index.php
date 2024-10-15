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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="styles/input.css" rel="stylesheet">

</head>

<body>

    <?php require_once 'layout/navigation.php' ?>

    <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">

        <h2 id="page-title" class="text-3xl font-semibold text-center text-indigo-700 mt-10">Articles</h2>

        <div class="d-flex flex-column align-items-center">
            <?php if (!empty($articles)) : ?>
                <?php foreach ($articles as $article) : ?>
                    <div class="col-md-6 col-lg-4 mb-4"> 
                        <div class="card" style="max-width: 50rem;">  
                            <div class="card-body d-flex justify-content-between align-items-center">  
                                
                                <!-- Article card -->
                                <h5 class="card-title mb-0">
                                    <a href="<?php echo htmlspecialchars($article->getUrl()); ?>" target="_blank" class="text-warning no-underline">
                                        <?php echo htmlspecialchars($article->getTitle()); ?>
                                    </a>
                                </h5>

                                <!-- Delete button -->
                                <form action="delete_article.php" method="POST" class="ml-3">
                                    <!-- Hidden input to hold the article ID -->
                                    <input type="hidden" name="id" value="<?php echo $article->getId(); ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center text-gray-500">No articles found.</p>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>