<?php

namespace App\Models;

use PDO;
use Core\Model;

/**
 * Post model
 * 
 * PHP version 7.1.9
 */
class Post extends Model
{
    /**
     * Get all posts
     *
     * @return array
     **/
    public static function getAll()
    {
        try {
            $db = static::getDB();
            $stmt = $db->query('SELECT id, title, body FROM posts ORDER BY created_at');
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $results;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
