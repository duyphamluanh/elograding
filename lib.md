**Thêm code vào cuối**  ```public function load_final_grades() {}```

```
     // Elorating calculate final grade
     foreach ($userids as $userid) {
         foreach ($allgradeitems as $itemid => $gradeitem) {
                 $elogradeitem = $this->allgrades[$userid][$itemid]->grade_item;
                 $elofinalgrade = $this->allgrades[$userid][$itemid]->finalgrade;
                 if($elogradeitem->elorating == 2 && isset($elofinalgrade))
                 {
                     $this->allgrades[$userid][$itemid]->finalgrade = $elofinalgrade*0.8;
                     $this->grades[$userid][$itemid]->finalgrade = $elofinalgrade*0.8;
                 }
         }
     }        
```  
**Trong** ```protected function get_allgradeitems() {```  
     ***Trước***
```return $item->gradetype != GRADE_TYPE_NONE; ```  
     ***Thêm***
```
if(isset($item->elorating) && $item->elorating == GRADE_TYPE_NONE) return false;// Nhien
```  
