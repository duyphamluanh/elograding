```
 /**
     * Adds all the standard elements to a form to edit the settings for an activity module.
     */
    function get_elorating($courseid,$itemtype,$itemmodule,$iteminstance,$itemnumber = 0){
        global $DB;
         if (is_null($courseid) or is_null($itemtype)) {
            debugging('Missing courseid or itemtype');
            return -1;
        }
        $wheresql = 'courseid = ' . $courseid . ' AND ' . 'itemtype = \'' . $itemtype . '\' AND ' . 'itemmodule = \'' . $itemmodule .
                '\' AND ' . 'iteminstance = ' . $iteminstance . ' AND ' . 'itemnumber = ' . $itemnumber;
        $rs = $DB->get_recordset_select('grade_items', $wheresql);
            //returning false rather than empty array if nothing found
            if (!$rs->valid()) {
                $rs->close();
                return -1;
            }
        $old_multfactor =1;
        $gradetype = 1;            
        if (count($rs) == 1){
         foreach($rs as $data){
                $data = (array)$data;
                foreach ($data as $var => $value){
                    if($var == 'gradetype')
                        $gradetype = $value;
                    if($var == 'multfactor')
                        $old_multfactor = $value;
                }
            }
        }
        $rs->close();
        if($old_multfactor < 1 && $gradetype == 1)
            $gradetype = 2;
        return $gradetype;
    }
```


```
function standard_coursemodule_elements(){
        global $COURSE, $CFG, $DB;
        $mform =& $this->_form;
  //Nhien Add
        if (!empty($this->_cm)) {
            if (!$this->_features->rating)
            {
                $isupdate = true;
                if($isupdate){      
                $old_elorating = $this->get_elorating($COURSE->id,'mod',$this->_cm->modname,$this->_cm->instance,0);
//                $eloratings = array(get_string('elononegrading', 'question'),
  //                                  get_string('eloofficialgrading', 'question')
    //                                );
                $eloratings = array(get_string('elononegrading', 'question'),
                                    get_string('eloofficialgrading', 'question'),
                                    get_string('eloexprirationgrading', 'question')
                                    );                                
                if($old_elorating==NULL)
                    $old_elorating = 1;
/*                $old_elorating_order = 0;
                if($old_elorating == 0){
                    $old_elorating_order = count($eloratings) - 1;
                }else if($old_elorating == 1){
                    $old_elorating_order = 0;
                }else{
                    $old_elorating_order = 2;
                }*/
                if($old_elorating!=-1){
                    $mform->addElement('header', 'modstandardgrade','Elo Grating');
                    $mform->addElement('select', 'elorating', get_string('elokind', 'question'),$eloratings);
                    $mform->addHelpButton('elorating', 'elokind', 'question');
                    $mform->setDefault('elorating', $old_elorating);
                    }
                }
            }       
        }
```
