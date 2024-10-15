<?php

class ArticleRepository
{
    private string $filename;

    public function __construct(string $theFilename)
    {
        $this->filename = $theFilename;
    }

    /**
     * @return Article[]
     */
    public function getAllArticles(): array
    {
        if (!file_exists($this->filename)) {
            return [];
        }
        $fileContents = file_get_contents($this->filename);
        if (!$fileContents) {
            return [];
        }
        $decodedArticles = json_decode($fileContents, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }
        $articles = [];
        foreach ($decodedArticles as $decodedArticle) {
            $articleId = $decodedArticle['id'];
            $articleTitle = $decodedArticle['title'];
            $articleUrl = $decodedArticle['url'];

            $articles[] = new Article($articleTitle, $articleUrl, $articleId);
        }
        return $articles;
    }

    /**
     * Get a single article by ID
     * @param int $id
     * @return Article|null
     */
    public function getArticleById(int $id): Article|null
    {
        $articles = $this->getAllArticles();
        foreach ($articles as $article) {
            if ($article->getId() === $id) {
                return $article;
            }
        }
        return null;
    }

    /**
     * @param int $id
     */
    public function deleteArticleById(int $id): void
    {
        $articles = $this->getAllArticles();

        //Filter out the article with the matching ID and only keep articles where the ID doesn't match
        $updatedArticles = array_filter($articles, function ($article) use ($id) {
            return $article->getId() !== $id;
        });

        //Save the updated articles to the JSON file
        $this->saveAllArticles($updatedArticles);
    }

    /**
     * @param Article[] $articles
     */
    private function saveAllArticles(array $articles): void
    {
        $articleData = array_map(function ($article) {
            return [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'url' => $article->getUrl()
            ];
        }, $articles);

        file_put_contents($this->filename, json_encode($articleData, JSON_PRETTY_PRINT));
    }

    /**
     * @param Article $article
     */
    public function saveArticle(Article $article): void
    {
        // TODO
    }

    /**
     * @param int $id
     * @param Article $updatedArticle
     */
    public function updateArticle(int $id, Article $updatedArticle): void
    {
        // TODO
    }
}
