<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Amrudinbalic\Marketplace\Http\Request;
use Amrudinbalic\Marketplace\Http\Session;
use PDO;

class MarketController
{
    public function index(Article $article, Category $category, Request $request, PDO $pdo): string
    {
        $categoryId = $request->get('category');

        if($categoryId) {
            $articles = $article->where(['category_id' => $categoryId]);
        } else {
            $articles = $article->fetchAll();
        }
        
        $categories = $category->fetchAll();

        return twig('market', [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }

    public function filter(Request $request, PDO $pdo): string
    {
        // Inputs
        $limit = (int) ($request->get('limit') ?? 50);
        $categoryId = (int) ($request->get('category') ?? 0);

        // Validate limit
        if ($limit <= 0 || $limit > 300) {
            $limit = 50;
        }

        // build query
        $sql = "SELECT a.* FROM articles a";
        $params = [];

        // Add category filter if provided
        if (!empty($categoryId)) {
            $sql .= " WHERE a.category_id = :categoryId";
            $params['categoryId'] = $categoryId;
        }

        $sql .= " LIMIT $limit";

        // get data
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $articles = $stmt->fetchAll();

        return json_encode(['articles' => $articles]);
    }

    // get the article
    public function article(PDO $pdo, int $id): string
    {
        $stmt = $pdo->prepare("
            SELECT 
                a.*,
                c.id,
                c.name as category_name,
                u.id as user_id,
                u.name as user_name
            FROM articles a 
            INNER JOIN categories c -- belongs to
                ON a.category_id = c.id 
            INNER JOIN users u -- owns it
                ON a.user_id = u.id
            WHERE a.id = :id
        ");
        $stmt->execute(['id' => $id]);
        $article = $stmt->fetch();

        return twig('market/article', ['article' => $article]);
    }

    // get the user/owner
    public function user(User $user, int $id, PDO $pdo): string
    {
        $user = $user->get($id);
        
        // fetch user's articles
        $stmt = $pdo->prepare("
            SELECT 
                a.*,
                c.name as category_name
            FROM articles a 
            INNER JOIN categories c 
                ON a.category_id = c.id 
            WHERE a.user_id = :user_id
            ORDER BY a.created_at DESC
        ");
        $stmt->execute(['user_id' => $id]);
        $articles = $stmt->fetchAll();

        return twig('market/user', [
            'user' => $user,
            'articles' => $articles
        ]);
    }

    public function messages(PDO $pdo, int $id)
    {
        if(!Session::authenticated()) {
            redirect('/marketplace/user/login', [
                'error' => 'Please login to send messages'
            ]);
        }

        return twig('market/messages', ['id' => $id]);
    }
}