```
 /**
     * Load all grade items.
     */
    protected function get_allgradeitems() {
        if (!empty($this->allgradeitems)) {
            return $this->allgradeitems;
        }
        $allgradeitems = grade_item::fetch_all(array('courseid' => $this->courseid));
        // But hang on - don't include ones which are set to not show the grade at all.
        $this->allgradeitems = array_filter($allgradeitems, function($item) {
            if(isset($item->elorating) && $item->elorating == GRADE_TYPE_NONE) return false;// Nhien
            return $item->gradetype != GRADE_TYPE_NONE; //Nhien Tao Thay May Roi
        });
        return $this->allgradeitems;
    }
```
  //Nhien ham load diem tu database
  public function load_final_grades() {
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
