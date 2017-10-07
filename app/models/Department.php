<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class Department extends Eloquent
{
    protected $table = 'web_department';
    protected $primaryKey = 'department_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('department_name','department_alias','department_logo','department_status','department_type','department_layouts', 'department_order', 'department_link');

    public static function getByID($id) {
        $category = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_DEPARTMENT_ID.$id) : array();
        if (sizeof($category) == 0) {
            $category = Department::where('department_id','=', $id)->first();
            if($category && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_DEPARTMENT_ID.$id, $category, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $category;
    }

    public static function getDepart(){
        $data = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_ALL_DEPARTMENT) : array();
        if (sizeof($data) == 0) {
            $department = Department::where('department_id', '>', 0)
                ->where('department_status',CGlobal::status_show)
                ->orderBy('department_order','asc')->get();
            if($department){
                foreach($department as $itm) {
                    $data[$itm['department_id']] = $itm['department_name'];
                }
            }
            if($data && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_ALL_DEPARTMENT, $data, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $data;
    }
    public static function getFullDepart(){
        $data = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_LIST_DEPARTMENT) : array();
        if (sizeof($data) == 0) {
            $data = Department::where('department_id', '>', 0)
                    ->where('department_status',CGlobal::status_show)
                    ->orderBy('department_order','asc')->get();
            if($data && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_LIST_DEPARTMENT, $data, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $data;
    }
    public static function getDepartWithUser($userDepar = array(),$is_root = false){
        $arrDepart = self::getDepart();
        if($is_root) return $arrDepart;
        if(!empty($userDepar)){
            $arrDepartWithUser = array();
            foreach($userDepar as $depart_id){
                if(isset($arrDepart[(int)$depart_id])){
                    $arrDepartWithUser[(int)$depart_id] = $arrDepart[(int)$depart_id];
                }
            }
            return $arrDepartWithUser;
        }
        return array();
    }


    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Department::where('department_id','>',0);
            if (isset($dataSearch['department_name']) && $dataSearch['department_name'] != '') {
                $query->where('department_name','LIKE', '%' . $dataSearch['department_name'] . '%');
            }
            if (isset($dataSearch['department_status']) && $dataSearch['department_status'] != -1) {
                $query->where('department_status', $dataSearch['department_status']);
            }
            if (isset($dataSearch['department_type']) && $dataSearch['department_type'] != '') {
                $query->where('department_type', $dataSearch['department_type']);
            }
            if (isset($dataSearch['department_layouts']) && $dataSearch['department_layouts'] != '') {
                $query->where('department_layouts', $dataSearch['department_layouts']);
            }
            $query->orderBy('department_id', 'desc');
            $total = $query->count();

            //get field can lay du lieu
            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
            if(!empty($fields)){
                $result = $query->take($limit)->skip($offset)->get($fields);
            }else{
                $result = $query->take($limit)->skip($offset)->get();
            }
            return $result;

        }catch (PDOException $e){
            throw new PDOException();
        }
    }

    /**
     * @desc: Tao Data.
     * @param $data
     * @return bool
     * @throws PDOException
     */
    public static function addData($dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = new Department();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->department_id) && $data->department_id > 0){
                    self::removeCache($data->department_id);
                }
                return $data->department_id;
            }
            DB::connection()->getPdo()->commit();
            return false;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @desc: Update du lieu
     * @param $id
     * @param $data
     * @return bool
     * @throws PDOException
     */
    public static  function updateData($id, $dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = Department::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
                if(isset($dataSave->department_id) && $dataSave->department_id > 0){
                    self::removeCache($dataSave->department_id);
                }
            }
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @desc: Update Data.
     * @param $id
     * @param $status
     * @return bool
     * @throws PDOException
     */
    public static function deleteData($id){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = Department::find($id);
            $dataSave->delete();
            if(isset($dataSave->department_id) && $dataSave->department_id > 0){
                self::removeCache($dataSave->department_id);
            }
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function removeCache($id = 0){
        if($id > 0){
            Cache::forget(Memcache::CACHE_DEPARTMENT_ID.$id);
        }
        Cache::forget(Memcache::CACHE_ALL_DEPARTMENT);
        Cache::forget(Memcache::CACHE_LIST_DEPARTMENT);
    }

    public static function getItemByType($department_type='', $limit=0){
        try{
            $result = array();
            if($department_type != '' && $limit > 0){
                $query = News::where('department_id','>', 0);
                $query->where('department_type', $department_type);
                $query->where('news_status', CGlobal::status_show);
                $query->orderBy('department_order', 'asc');
                $result = $query->take($limit)->get();
            }
            return $result;

        }catch (PDOException $e){
            throw new PDOException();
        }
    }

}