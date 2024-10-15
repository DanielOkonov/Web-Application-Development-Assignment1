<?php
require_once 'src/ArticleRepository.php';
require_once 'src/Models/Article.php';

$articleRepository = new ArticleRepository('articles.json');
$articles = $articleRepository->getAllArticles();
?>

<!doctype html>
<html lang="en">

<?php require_once 'layout/header.php' ?>

<body>

    <?php require_once 'layout/navigation.php' ?>

    <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">

        <h2 id="page-title" class="text-xl text-center font-semibold text-indigo-700 mt-10">Articles</h2>

        <div class="overflow-hidden">
            <ul role="list">

                <?php if (!empty($articles)) : ?>
                    <?php foreach ($articles as $article) : ?>
                        <li class="mb-4">
                            <a href="<?php echo htmlspecialchars($article->getUrl()); ?>" target="_blank" class="text-blue-500 hover:underline">
                                <?php echo htmlspecialchars($article->getTitle()); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>No articles found.</p>
                <?php endif; ?>

            </ul>
        </div>

    </div>

</body>

</html>