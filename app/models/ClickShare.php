<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class ClickShare extends Eloquent
{
    protected $table = 'web_click_share';
    protected $primaryKey = 'share_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('share_id','object_id', 'object_name','share_ip','share_time');

    public static function checkIpShareObject($object_id) {
        $userShare = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_SHARE_OBJECT_ID.$object_id): array();
        if (sizeof($userShare) == 0) {
            if($object_id > 0){
                $data = ClickShare::where('object_id', '=', $object_id)->orderBy('share_time','desc')->get();
                if($data){
                    foreach($data as $itm) {
                        $userShare[$itm->share_ip] = $itm->object_id;
                    }
                }
                if($userShare){
                    Cache::put(Memcache::CACHE_SHARE_OBJECT_ID.$object_id, $userShare, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
                }
            }
        }
        return $userShare? $userShare : array();
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = ClickShare::where('share_id','>',0);
            if (isset($dataSearch['object_id']) && $dataSearch['object_id'] > 0) {
                $query->where('object_id',$dataSearch['object_id']);
            }
            if (isset($dataSearch['start_time']) && $dataSearch['start_time'] > 0) {
                $query->where('share_time','>=',$dataSearch['start_time']);
            }
            if (isset($dataSearch['end_time']) && $dataSearch['end_time'] > 0) {
                $query->where('share_time','<=',$dataSearch['end_time']);
            }

            if (isset($dataSearch['object_name']) && $dataSearch['object_name'] != '') {
                $query->where('object_name','LIKE', '%' . $dataSearch['object_name'] . '%');
            }

            $total = $query->count();
            $query->orderBy('share_time', 'desc');

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
            $data = new ClickShare();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->object_id) && $data->object_id > 0){
                    self::removeCache($data->object_id);
                }
                return $data->share_id;
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
            $dataSave = ClickShare::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
            }
            DB::connection()->getPdo()->commit();
            if(isset($dataSave->object_id) && $dataSave->object_id > 0){
                self::removeCache($dataSave->object_id);
            }
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
            $dataSave = ClickShare::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            if(isset($dataSave->object_id) && $dataSave->object_id > 0){
                self::removeCache($dataSave->object_id);
            }
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @param int $id
     */
    public static function removeCache($object_id = 0){
        if($object_id > 0){
            Cache::forget(Memcache::CACHE_SHARE_OBJECT_ID.$object_id);
        }
    }

}