**Trong** ```static private function _fetch_course_tree_recursion($category_array, &$sortorder) {}```  
**Thêm**  
```
if (isset($category_array['object']->elorating) && $category_array['object']->elorating==GRADE_TYPE_NONE ) { // Nhien
    return null;
}
```  
**RESULT**
![image](https://user-images.githubusercontent.com/32034702/146160560-d0257a52-5b04-47b9-8140-372770c452ac.png)
