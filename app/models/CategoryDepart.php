<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class CategoryDepart extends Eloquent
{
    protected $table = 'web_category_depart';
    protected $primaryKey = 'category_depart_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('category_depart_id','category_depart_name',
        'department_id','department_name',
        'category_depart_status', 'category_depart_order');

    public static function getByID($id) {
        $category = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_CATEGORY_DEPARTMENT_ID.$id) : array();
        if (sizeof($category) == 0) {
            $category = CategoryDepart::where('category_depart_id','=', $id)->first();
            if($category && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_CATEGORY_DEPARTMENT_ID.$id, $category, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $category;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = CategoryDepart::where('category_depart_id','>',0);
            if (isset($dataSearch['category_depart_name']) && $dataSearch['category_depart_name'] != '') {
                $query->where('category_depart_name','LIKE', '%' . $dataSearch['category_depart_name'] . '%');
            }
            if (isset($dataSearch['category_depart_status']) && $dataSearch['category_depart_status'] != -1) {
                $query->where('category_depart_status', $dataSearch['category_depart_status']);
            }
            if (isset($dataSearch['department_id']) && $dataSearch['department_id'] > 0) {
                $query->where('department_id', $dataSearch['department_id']);
            }
            $query->orderBy('category_depart_id', 'desc');
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
            $data = new CategoryDepart();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->category_depart_id) && $data->category_depart_id > 0){
                    self::removeCache($data->category_depart_id);
                }
                return $data->category_depart_id;
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
            $dataSave = CategoryDepart::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
                if(isset($dataSave->category_depart_id) && $dataSave->category_depart_id > 0){
                    self::removeCache($dataSave->category_depart_id);
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
            $dataSave = CategoryDepart::find($id);
            $dataSave->delete();
            if(isset($dataSave->category_depart_id) && $dataSave->category_depart_id > 0){
                self::removeCache($dataSave->category_depart_id);
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
            Cache::forget(Memcache::CACHE_CATEGORY_DEPARTMENT_ID.$id);
        }
    }

}