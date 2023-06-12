<?php

class Blog
{
    /**
     * 該当ページのアイテムを取得（ページネーション）
     *
     * @param [obj] $pdo: PDOのインスタンス
     * @param [int] $current_page: 現在のページ番号
     * @param [int] $items_per_page: 1ページ当たりのアイテム数
     * @return $blogs: ページナビに関する色々な情報を2次元連想配列にしたもの
     */
    public static function getBlogsByPage($pdo, $current_page, $items_per_page)
    {
        $start_row = ($current_page - 1) * $items_per_page;
        $end_row = $start_row + $items_per_page;
        $sql = "SELECT B.id, B.user_id, B.title, B.text, B.img, B.create_time
                FROM (SELECT * ,
                            ROW_NUMBER() OVER (ORDER BY id DESC) RN
                            FROM BLOGS) B
                            WHERE B.RN > :start_row AND B.RN <= :end_row";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('start_row', $start_row, \PDO::PARAM_INT);
        $stmt->bindValue('end_row', $end_row, \PDO::PARAM_INT);
        $stmt->execute();
        $blogs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $blogs;
    }

    /**
     * アイテムの総数を取得
     *
     * @param [obj] $pdo: PDOのインスタンス
     * @return $total["count"]: アイテムの総数
     */
    public static function getTotal($pdo)
    {
        $sql = "SELECT COUNT(*) AS count FROM BLOGS";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $total = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $total["count"];
    }
}
