<?php
    /**
     * プロジェクトIDに紐づくカテゴリを取得する
     */
    function get_categories_by_project_id($project_id) {
        global $dbh;
        $stmt = $dbh->prepare("SELECT * from categories WHERE project_id = ?;");
        $stmt->bindParam(1, $project_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * カテゴリIDに紐づくタスクを全て削除する
     */
    function delete_all_task_by_category_id($category_id) {
        global $dbh;
        $stmt = $dbh->prepare("DELETE from tasks WHERE category_id = ?;");
        $stmt->bindParam(1, $category_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * カテゴリを削除する
     */
    function delete_category_by_category_id($category_id) {
        global $dbh;
        $stmt = $dbh->prepare("DELETE from categories WHERE category_id = ?;");
        $stmt->bindParam(1, $category_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * 全てのプロジェクトを取得する
     */
    function get_all_projects() {
        global $dbh;
        $stmt = $dbh->prepare("SELECT * from projects;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * プロジェクトを削除する
     */
    function delete_project_by_project_id($project_id) {
        global $dbh;
        $stmt = $dbh->prepare("DELETE from projects WHERE project_id = ?;");
        $stmt->bindParam(1, $project_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

