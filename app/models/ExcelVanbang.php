<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class ExcelVanbang extends Eloquent
{
    protected $table = 'web_excel_vanbangchungchi';
    protected $primaryKey = 'vanbang_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('vanbang_id','vanbang_hoten', 'vanbang_ngaysinh', 'vanbang_noisinh','vanbang_gioitinh'
    ,'vanbang_dantoc', 'vanbang_nganhdaotao', 'vanbang_namtotnghiep','vanbang_xeploai'
    ,'vanbang_machungchi','vanbang_machungchi_search'
    ,'vanbang_chungchiso', 'vanbang_khoahoc','vanbang_trinhdo'
    ,'vanbang_htdaotao', 'vanbang_sototnghiep', 'vanbang_ngaytotnghiep'
    ,'vanbang_ngaytao', 'vanbang_nguoitao', 'vanbang_capnhat','vanbang_nguoicapnhat');

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = ExcelVanbang::where('vanbang_id','>',0);
            if (isset($dataSearch['vanbang_hoten']) && $dataSearch['vanbang_hoten'] != '') {
                $query->where('vanbang_hoten','LIKE', '%' . $dataSearch['vanbang_hoten'] . '%');
            }
            if (isset($dataSearch['vanbang_machungchi']) && $dataSearch['vanbang_machungchi'] != '') {
                $query->where('vanbang_machungchi', $dataSearch['vanbang_machungchi']);
            }
            $query->orderBy('vanbang_id', 'asc');
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

    public static function getNewByID($id) {
        $new = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_VANBANG_ID.$id) : array();
        if (sizeof($new) == 0) {
            $new = ExcelVanbang::where('vanbang_id', $id)->first();
            if($new && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_VANBANG_ID.$id, $new, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $new;
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
            $data = new ExcelVanbang();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->vanbang_id) && $data->vanbang_id > 0){
                    self::removeCache($data->vanbang_id);
                }
                return $data->vanbang_id;
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
            $dataSave = ExcelVanbang::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
                if(isset($dataSave->vanbang_id) && $dataSave->vanbang_id > 0){
                    self::removeCache($dataSave->vanbang_id);
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
            $dataSave = ExcelVanbang::find($id);
            $dataSave->delete();
            if(isset($dataSave->vanbang_id) && $dataSave->vanbang_id > 0){
                self::removeCache($dataSave->vanbang_id);
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
            Cache::forget(Memcache::CACHE_VANBANG_ID.$id);
        }
    }

    public static function searchSiteByCondition($dataSearch = array(), $limit =0){
        try{
            $query = ExcelVanbang::where('vanbang_id','>',0);
            if (isset($dataSearch['vanbang_machungchi']) && $dataSearch['vanbang_machungchi'] != '') {
                $query->where('vanbang_machungchi_search', $dataSearch['vanbang_machungchi']);
            }
            $query->orderBy('vanbang_id', 'asc');

            //get field can lay du lieu
            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
            if(!empty($fields)){
                $result = $query->take($limit)->get($fields);
            }else{
                $result = $query->take($limit)->get();
            }
            return $result;

        }catch (PDOException $e){
            return $e->getMessage();
            throw new PDOException();
        }
    }
}