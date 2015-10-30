<?php
    class Paginator {
        /*
         * registry object reference
         */
        private $_registry;
        
        /*
         * URL bits used for pagination
         */
        private $_urlBits;
        
        /*
         * final data to display in pagination
         */
        private $_paginatedData;
        
        /*
         * object constructor, loads registry object
         * @param $registry - an object instance of type Registry
         */
        public function __construct(Registry $registry) {
            $this->_registry = $registry;
        }
        
        /*
         * process the pagination
         * @param array $values - array of values which needs to be paginated
         * @param int $perPage - the number of items displayed per page
         * @param int $urlBit - place in the URL which will contain number of the page (default 1)
         * @return array - array of finished paginated data to display on page
         */
        
        public function paginate($values, $perPage, $urlBit = 1) {
            $numbersOfPages = array();
            $totalValues = count($values);
            $this->_urlBits = $this->_registry->getObject('url')->getURLBits();
            if (isset($this->_urlBits[$urlBit]) && filter_var($this->_urlBits[$urlBit], FILTER_VALIDATE_INT)) {
                $currentPage = $this->_urlBits[$urlBit];
            } else {
                $currentPage = 1;
            }
            $counts = ceil($totalValues / $perPage);
            $offset = ($currentPage - 1) * $perPage;
            $this->_paginatedData = array_slice($values, $offset, $perPage);
            for ($x = 1; $x <= $counts; $x++) {
                $numbersOfPages[] = $x;
            }
            return $numbersOfPages;
        }
        
        /*
         * gets finished paginated data ready to display
         * @return array - array of data contains number of rows to display per page
         */
        public function displayPaginatedData() {
            return $this->_paginatedData;
        }
    }
