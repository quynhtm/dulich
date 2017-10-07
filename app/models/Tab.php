<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class Tab extends Eloquent
{
    protected $table = 'web_tab';
    protected $primaryKey = 'tab_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('tab_id','tab_name', 'tab_link', 'tab_order','tab_status');

    public static function getDepart(){
        $data = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_ALL_TAB) : array();
        if (sizeof($data) == 0) {
            $tab = Tab::where('tab_id', '>', 0)
                ->where('tab_status',CGlobal::status_show)
                ->orderBy('tab_order','asc')->get();
            if($tab){
                foreach($tab as $itm) {
                    $data[$itm['tab_id']] = $itm['tab_name'];
                }
            }
            if($data && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_ALL_TAB, $data, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $data;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Tab::where('tab_id','>',0);
            if (isset($dataSearch['tab_name']) && $dataSearch['tab_name'] != '') {
                $query->where('tab_name','LIKE', '%' . $dataSearch['tab_name'] . '%');
            }
            if (isset($dataSearch['tab_status']) && $dataSearch['tab_status'] != -1) {
                $query->where('tab_status', $dataSearch['tab_status']);
            }
            $query->orderBy('tab_order', 'asc');
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
            $data = new Tab();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->tab_id) && $data->tab_id > 0){
                    self::removeCache($data->tab_id);
                }
                return $data->tab_id;
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
            $dataSave = Tab::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
                if(isset($dataSave->tab_id) && $dataSave->tab_id > 0){
                    self::removeCache($dataSave->tab_id);
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
            $dataSave = Tab::find($id);
            $dataSave->delete();
            if(isset($dataSave->tab_id) && $dataSave->tab_id > 0){
                self::removeCache($dataSave->tab_id);
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
            Cache::forget(Memcache::CACHE_ALL_TAB);
            Cache::forget(Memcache::CACHE_ALL_TAB_LINK);
        }
    }

    public static function searchTabLimitAsc($limit =0){

        $data = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_ALL_TAB_LINK) : array();
        if (sizeof($data) == 0) {
            $query = Tab::where('tab_id', '>', 0);
            $query->where('tab_status',CGlobal::status_show);
            if($limit > 0){
                $query->take($limit);
            }
            $data = $query->orderBy('tab_order','asc')->get();

            if($data && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_ALL_TAB_LINK, $data, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $data;
    }
}