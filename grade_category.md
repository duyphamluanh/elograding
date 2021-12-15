**Trong** ```static private function _fetch_course_tree_recursion($category_array, &$sortorder) {}```  
**Thêm**  
```
        if (isset($category_array['object']->elorating) && $category_array['object']->elorating==GRADE_TYPE_NONE ) { // Nhien Tao Thay May roi
            return null;
        }
```  
**RESULT**
```
    /**
     * An internal function that recursively sorts grade categories within a course
     *
     * @param array $category_array The seed of the recursion
     * @param int   $sortorder The current sortorder
     * @return array An array containing 'object', 'type', 'depth' and optionally 'children'
     */
    
        if (isset($category_array['object']->elorating) && $category_array['object']->elorating==GRADE_TYPE_NONE ) { // Nhien Tao Thay May roi
            return null;
        }
```
