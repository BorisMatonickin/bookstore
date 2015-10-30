<?php
    require_once('Model.php');
    
    class Categories extends Model {

        /*
         * selects list of categories listed in menu on the sidebar
         * @return array
         */
        public function categoriesForSidebar() {
            $queryStr = "SELECT cat_id, category FROM categories ORDER BY RAND() LIMIT 12";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'cat_id');
        }
        
        /*
         * displays list of categories on categories page
         * @return array
         */
        public function listCategories() {
            $queryStr = "SELECT c.cat_id AS categoryId, c.category, c.description AS catDescription, COUNT(bc.book_id) AS booksNumber FROM categories c "
                    . "LEFT OUTER JOIN book_category bc ON c.cat_id = bc.cat_id GROUP BY c.category";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'category');
        }
        
        /*
         * lists books in the selected category
         * @param string $category - current category selected
         * @return array
         */
        public function listBooksFromCategory($category) {
            $queryStr = "SELECT b.book_id, b.title AS bookTitle, b.image, b.date_published, b.description AS bookDescription, "
                    . "(SELECT IFNULL(ROUND(sum(rating)/count(*), 2), 0) FROM book_ratings br WHERE br.book_id = b.book_id) AS averageRating, "
                    . "GROUP_CONCAT(DISTINCT a.first_name, ' ', a.last_name SEPARATOR ', ') AS authorName, "
                    . "a.author_id AS authorId FROM books b "
                    . "JOIN book_category bc ON b.book_id = bc.book_id "
                    . "JOIN categories c ON bc.cat_id = c.cat_id "
                    . "JOIN book_authors ba ON b.book_id = ba.book_id "
                    . "JOIN authors a ON a.author_id = ba.author_id "
                    . "WHERE c.category = ? GROUP BY ba.book_id ORDER BY b.date_published DESC";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'bookTitle', [$category]);
        }
         
        /*
         * gets category data for usage in creating URL bits
         * @return array
         */
        public function selectCategoriesForUrl() {
            $queryStr = "SELECT cat_id, category FROM categories";
            return $this->_registry->getObject('db')->makeMultiDataArray($queryStr, 'cat_id');
        }
    }