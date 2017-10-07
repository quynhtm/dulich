<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class ExcelTuyensinh extends Eloquent
{
    protected $table = 'web_excel_tuyensinh';
    protected $primaryKey = 'tuyensinh_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('tuyensinh_id','tuyensinh_sohoso'
    , 'tuyensinh_sobaodanh', 'tuyensinh_sobaodanh_search'
    , 'tuyensinh_hoten','tuyensinh_ngaysinh'
    ,'tuyensinh_gioitinh','tuyensinh_cmt', 'tuyensinh_khuvuc_uutien', 'tuyensinh_diem_uutien','tuyensinh_tinhthanh','tuyensinh_quanhuyen'
    ,'tuyensinh_monthi_mot', 'tuyensinh_diem_monthimot', 'tuyensinh_monthi_hai','tuyensinh_diem_monthihai', 'tuyensinh_monthi_ba','tuyensinh_diem_monthiba'
    ,'tuyensinh_diemlech', 'tuyensinh_tongdiemchua_uutien', 'tuyensinh_diem_uutien_quydoi','tuyensinh_tongdiemco_uutien', 'tuyensinh_nganhtrungtuyen'
    ,'tuyensinh_dotxettuyen','tuyensinh_trinhdo','tuyensinh_hinhthucxettuyen'
    ,'tuyensinh_ngaytao','tuyensinh_nguoitao','tuyensinh_ngaycapnhat','tuyensinh_nguoicapnhat'
    );

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = ExcelTuyensinh::where('tuyensinh_id','>',0);
            if (isset($dataSearch['tuyensinh_hoten']) && $dataSearch['tuyensinh_hoten'] != '') {
                $query->where('tuyensinh_hoten','LIKE', '%' . $dataSearch['tuyensinh_hoten'] . '%');
            }
            if (isset($dataSearch['tuyensinh_sobaodanh']) && $dataSearch['tuyensinh_sobaodanh'] != '') {
                $query->where('tuyensinh_sobaodanh',$dataSearch['tuyensinh_sobaodanh']);
            }
            $query->orderBy('tuyensinh_id', 'asc');
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
        $new = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_TUYENSINH_ID.$id) : array();
        if (sizeof($new) == 0) {
            $new = ExcelTuyensinh::where('tuyensinh_id', $id)->first();
            if($new && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_TUYENSINH_ID.$id, $new, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
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
            $data = new ExcelTuyensinh();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->tuyensinh_id) && $data->tuyensinh_id > 0){
                    self::removeCache($data->tuyensinh_id);
                }
                return $data->tuyensinh_id;
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
            $dataSave = ExcelTuyensinh::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
                if(isset($dataSave->tuyensinh_id) && $dataSave->tuyensinh_id > 0){
                    self::removeCache($dataSave->tuyensinh_id);
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
            $dataSave = ExcelTuyensinh::find($id);
            $dataSave->delete();
            if(isset($dataSave->tuyensinh_id) && $dataSave->tuyensinh_id > 0){
                self::removeCache($dataSave->tuyensinh_id);
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
            Cache::forget(Memcache::CACHE_TUYENSINH_ID.$id);
        }
    }
    public static function searchSiteByCondition($dataSearch = array(), $limit =0){
        try{
            $query = ExcelTuyensinh::where('tuyensinh_id','>',0);
            if (isset($dataSearch['tuyensinh_cmt']) && $dataSearch['tuyensinh_cmt'] != '') {
                $query->where('tuyensinh_cmt', $dataSearch['tuyensinh_cmt']);
            }
            if (isset($dataSearch['tuyensinh_hoten']) && $dataSearch['tuyensinh_hoten'] != '') {
                $query->where('tuyensinh_hoten', $dataSearch['tuyensinh_hoten']);
            }
            if (isset($dataSearch['tuyensinh_trinhdo']) && $dataSearch['tuyensinh_trinhdo'] != '') {
                $query->where('tuyensinh_trinhdo', $dataSearch['tuyensinh_trinhdo']);
            }
            $query->orderBy('tuyensinh_id', 'asc');

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