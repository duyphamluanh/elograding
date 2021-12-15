**course/modlib.php**  

**Thêm function update_elorating_moduleinfo()**

```
/**
 * Update the module info.
 * This function doesn't check the user capabilities. It updates the course module and the module instance.
 * Then execute common action to create/update module process (trigger event, rebuild cache, save plagiarism settings...).
 *
 * @param object $cm course module
 * @param object $moduleinfo module info
 * @param object $course course of the module
 * @param object $mform - the mform is required by some specific module in the function MODULE_update_instance(). This is due to a hack in this function.
 * @return array list of course module and module info.
 */

//Nhien update_elorating_moduleinfo
function update_elorating_moduleinfo($courseid,$itemtype,$itemmodule,$iteminstance,$itemnumber = 0, $elorating = 1) {
    global $DB;
    
    $israting  = plugin_supports($itemtype,$itemmodule, FEATURE_RATE, false);
    if($israting)
        return true;
     if (is_null($courseid) or is_null($itemtype)) {
        debugging('Missing courseid or itemtype');
        return GRADE_UPDATE_FAILED;
    }
    $wheresql = 'courseid = ' . $courseid . ' AND ' . 'itemtype = \'' . $itemtype . '\' AND ' . 'itemmodule = \'' . $itemmodule .
            '\' AND ' . 'iteminstance = ' . $iteminstance . ' AND ' . 'itemnumber = ' . $itemnumber;
    $rs = $DB->get_recordset_select('grade_items', $wheresql);
        //returning false rather than empty array if nothing found
        if (!$rs->valid()) {
            $rs->close();
            return false;
        }
    $old_elorating = 0;
    $grade_item_id = -1;
    $old_multfactor = 1;
    if (count($rs) == 1){
     foreach($rs as $data){
            $data = (array)$data;
            foreach ($data as $var => $value){
                if($var == 'gradetype'){  // elorating
                    $old_elorating = $value;
                }
                if($var == 'id'){   
                    $grade_item_id = $value;
                }
                if($var == 'multfactor'){                   
                $old_multfactor = $value;
                }
            }
        }
    }
    $rs->close();
    if($old_elorating == 1 && $old_multfactor !=1 && $elorating == 2 ) // khong set
    {
        return true;
    }
    if($old_elorating == 1 && $old_multfactor ==1 && $elorating == 1 ) // khong set
    {
        return true;
    }
    if($old_elorating == 0 && $elorating == 0 ) // khong set
    {
        return true;
    }
    
    $datarating->id = $grade_item_id;
    $datarating->gradetype = $elorating;// elorating
    if($elorating == 2){
        $datarating->gradetype = 1;
        if($old_multfactor == 1)
            $datarating->multfactor = 0.8;// elorating
    }
    else if ($elorating == 1){
        $datarating->gradetype = 1;
        $datarating->multfactor = 1;
    }
    $DB->update_record('grade_items', $datarating);
    return true;
}
```
**Trong function add_moduleinfo($moduleinfo, $course, $mform = null) {}**  
thêm trước ```return $moduleinfo;```  
```
    if(isset($moduleinfo->elorating))
    {
        if(!update_elorating_moduleinfo($newcm->course,'mod',$moduleinfo->modulename,$moduleinfo->instance,0,$moduleinfo->elorating)){// Nhien
          print_error('cannotcreatemod', '', course_get_url($course, $newcm->section), $moduleinfo->modulename);
        }// End Nhien
    }
```  
![image](https://user-images.githubusercontent.com/32034702/146161491-fdfbf5cf-10d2-4cfe-ace4-8608d7a80093.png)  


**Trong function update_moduleinfo($cm, $moduleinfo, $course, $mform = null) {}**  
Sau
```
    $updateinstancefunction = $moduleinfo->modulename."_update_instance";
    if (!$updateinstancefunction($moduleinfo, $mform)) {
        print_error('cannotupdatemod', '', course_get_url($course, $cm->section), $moduleinfo->modulename);
    }
```
Thêm
```
    // Nhien update_elorating_moduleinfo    
    if(isset($moduleinfo->elorating))
    {
        if(!update_elorating_moduleinfo($cm->course,'mod',$moduleinfo->modulename,$cm->instance,0,$moduleinfo->elorating)){// Nhien Update elorating
          print_error('cannotupdatemod', '', course_get_url($course, $cm->section), $moduleinfo->modulename);
        }// End Nhien Update elorating
    }
```  
![image](https://user-images.githubusercontent.com/32034702/146161628-3dd57d6d-5e50-427c-94f0-efd294e09a57.png)

