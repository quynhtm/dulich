<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class TabSub extends Eloquent
{
    protected $table = 'web_tab_sub';
    protected $primaryKey = 'tab_sub_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('tab_sub_id','tab_sub_name','tab_parent_id','tab_sub_link','tab_sub_image', 'tab_sub_order', 'tab_sub_status');

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = TabSub::where('tab_sub_id','>',0);
            if (isset($dataSearch['tab_sub_name']) && $dataSearch['tab_sub_name'] != '') {
                $query->where('tab_sub_name','LIKE', '%' . $dataSearch['tab_sub_name'] . '%');
            }
            if (isset($dataSearch['tab_sub_status']) && $dataSearch['tab_sub_status'] != -1) {
                $query->where('tab_sub_status', $dataSearch['tab_sub_status']);
            }
            $query->orderBy('tab_sub_id', 'desc');
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
            return $e->getMessage();
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
            $data = new TabSub();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->tab_sub_id) && $data->tab_sub_id > 0){
                    self::removeCache($data->tab_sub_id);
                    self::removeCacheTabParent($data->tab_parent_id);
                }
                return $data->tab_sub_id;
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
            $dataSave = TabSub::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
                if(isset($dataSave->tab_sub_id) && $dataSave->tab_sub_id > 0){
                    self::removeCache($dataSave->tab_sub_id);
                    self::removeCacheTabParent($dataSave->tab_parent_id);
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
            $dataSave = TabSub::find($id);
            $dataSave->delete();
            if(isset($dataSave->tab_sub_id) && $dataSave->tab_sub_id > 0){
                self::removeCache($dataSave->tab_sub_id);
                self::removeCacheTabParent($dataSave->tab_parent_id);
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
            //Cache::forget(Memcache::CACHE_CATEGORY_DEPARTMENT_ID.$id);
        }
    }
    public static function removeCacheTabParent($parent_id = 0){
        if($parent_id > 0){
            Cache::forget(Memcache::CACHE_ALL_SUB_TAB_PARENT.$parent_id);
        }
    }
    public static function searchSubTabLimitAsc($parent_id=0, $limit =0){

        $data = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_ALL_SUB_TAB_PARENT . $parent_id) : array();
        if (sizeof($data) == 0) {
            $query = TabSub::where('tab_sub_id', '>', 0);
            $query->where('tab_parent_id',$parent_id);
            $query->where('tab_sub_status',CGlobal::status_show);
            if($limit > 0){
                $query->take($limit);
            }
            $data = $query->orderBy('tab_sub_id','asc')->get();
            if($data && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_ALL_SUB_TAB_PARENT . $parent_id, $data, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $data;
    }
}