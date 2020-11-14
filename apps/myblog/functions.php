<?php
/**
 * 関数
 */

 /**
  * 全ての投稿を取得する
  */
function getAllPosts() {
    global $dbh;
    $sql = 'SELECT * FROM posts';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * 投稿を1件取得する
 */
function findPostById($postId) {
    global $dbh;
    $sql = 'SELECT * FROM posts WHERE id = :postId';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * 投稿を作成する
 */
function createPost($postTitle, $postContent) {
    global $dbh;
    $stmt = $dbh->prepare("INSERT INTO posts(post_title, post_content) VALUES (:postTitle, :postContent)");
    $stmt->bindParam(':postTitle', $postTitle, PDO::PARAM_STR);
    $stmt->bindParam(':postContent', $postContent, PDO::PARAM_STR);
    $stmt->execute();
    return $dbh->lastInsertId();
}

/**
 * コメントを作成する
 */
function createComment($postId, $comment) {
    global $dbh;
    $stmt = $dbh->prepare("INSERT INTO comments(post_id, comment) VALUES (:postId, :comment)");
    $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->execute();
    return $dbh->lastInsertId();
}

/**
 * 投稿に紐づいたコメントを取得
 */
function findCommentsByPostId($postId) {
    global $dbh;
    $sql = 'SELECT * FROM comments WHERE post_id = :postId';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}