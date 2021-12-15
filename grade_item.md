**Thêm** ```'elorating');//NhienTest 'elorating'```

class grade_item extends grade_object {
    /**
     * DB Table (used by grade_object).
     * @var string $table
     */
    public $table = 'grade_items';

    /**
     * Array of required table fields, must start with 'id'.
     * @var array $required_fields
     */
        public $required_fields = array('id', 'courseid', 'categoryid', 'itemname','itemtype', 'itemmodule', 'iteminstance',
                                 'itemnumber', 'iteminfo', 'idnumber', 'calculation', 'gradetype', 'grademax', 'grademin',
                                 'scaleid', 'outcomeid', 'gradepass', 'multfactor', 'plusfactor', 'aggregationcoef',
                                 'aggregationcoef2', 'sortorder', 'display', 'decimals', 'hidden', 'locked', 'locktime',
                                 'needsupdate', 'weightoverride', 'timecreated', 'timemodified','elorating');//NhienTest 'elorating'


