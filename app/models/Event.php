<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class EventNew extends Eloquent
{
    protected $table = 'web_event';
    protected $primaryKey = 'event_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('event_id','event_title', 'event_desc_sort','event_depart_id',
        'event_content', 'event_image', 'event_image_other','event_create','event_order','event_common_page','event_show_cate_id',
        'event_type', 'event_category_id','event_category_name', 'event_status', 'event_time_start', 'event_time_end');

    public static function getByID($id) {
        $new = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_EVENT_ID.$id) : array();
        if (sizeof($new) == 0) {
            $new = EventNew::where('event_id', $id)->first();
            if($new && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_EVENT_ID.$id, $new, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $new;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = EventNew::where('event_id','>',0);
            if (isset($dataSearch['event_title']) && $dataSearch['event_title'] != '') {
                $query->where('event_title','LIKE', '%' . $dataSearch['event_title'] . '%');
            }
            if (isset($dataSearch['event_status']) && $dataSearch['event_status'] != -1) {
                $query->where('event_status', $dataSearch['event_status']);
            }
            if (isset($dataSearch['event_category_id']) && $dataSearch['event_category_id'] > 0) {
                $query->where('event_category_id', $dataSearch['event_category_id']);
            }
            if (isset($dataSearch['string_depart_id']) && $dataSearch['string_depart_id'] != '') {
                $query->whereIn('event_depart_id', explode(',',$dataSearch['string_depart_id']));
            }
            if (isset($dataSearch['not_event_id']) && $dataSearch['not_event_id'] > 0) {
                $query->where('event_id','<>', $dataSearch['not_event_id']);
            }
            $total = $query->count();
            $query->orderBy('event_id', 'desc');

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
            $data = new EventNew();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->event_id) && $data->event_id > 0){
                    self::removeCache($data->event_id);
                }
                return $data->event_id;
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
            $dataSave = EventNew::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
                if(isset($dataSave->event_id) && $dataSave->event_id > 0){
                    self::removeCache($dataSave->event_id);
                }
            }
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            //return $e->getMessage();
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
            $dataSave = EventNew::find($id);
            $dataSave->delete();
            if(isset($dataSave->event_id) && $dataSave->event_id > 0){
                if($dataSave->event_image != ''){//xoa anh c?
                    //xoa anh upload
                    FunctionLib::deleteFileUpload($dataSave->event_image,$dataSave->event_id,CGlobal::FOLDER_EVENT);
                    //x?a anh thumb
                    $arrSizeThumb = CGlobal::$arrSizeImage;
                    foreach($arrSizeThumb as $k=>$size){
                        $sizeThumb = $size['w'].'x'.$size['h'];
                        FunctionLib::deleteFileThumb($dataSave->event_image,$dataSave->event_id,CGlobal::FOLDER_EVENT,$sizeThumb);
                    }
                }
                //x?a ?nh kh?c
                if(!empty($dataSave->event_image_other)){
                    $arrImagOther = unserialize($dataSave->event_image_other);
                    if(sizeof($arrImagOther) > 0){
                        foreach($arrImagOther as $k=>$val){
                            //xoa anh upload
                            FunctionLib::deleteFileUpload($val,$id,CGlobal::FOLDER_EVENT);
                            //x?a anh thumb
                            $arrSizeThumb = CGlobal::$arrSizeImage;
                            foreach($arrSizeThumb as $k=>$size){
                                $sizeThumb = $size['w'].'x'.$size['h'];
                                FunctionLib::deleteFileThumb($val,$id,CGlobal::FOLDER_EVENT,$sizeThumb);
                            }

                        }
                    }
                }
                self::removeCache($dataSave->event_id);
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
            Cache::forget(Memcache::CACHE_EVENT_ID.$id);
        }
    }

    public static function getPostEventNew($dataField='', $limit=10){
        try{
            $result = array();
            if($limit>0){
                $query = EventNew::where('event_id','>', 0);
                $query->where('event_title', '<>', '');
                $query->where('event_status', CGlobal::status_show);
                $query->orderBy('event_time_end', 'desc');

                $fields = (isset($dataField['field_get']) && trim($dataField['field_get']) != '') ? explode(',',trim($dataField['field_get'])): array();
                if(!empty($fields)){
                    $result = $query->take($limit)->get($fields);
                }else{
                    $result = $query->take($limit)->get();
                }
            }
            return $result;

        }catch (PDOException $e){
            throw new PDOException();
        }
    }
    public static function getSamePost($dataField='', $id=0, $limit=10, $lang){
        try{
            $result = array();
            if($id>0 && $limit>0){
                $query = EventNew::where('event_id','<>', $id);
                $query->where('event_status', CGlobal::status_show);
                if($lang > 0){
                    $query->where('type_language', $lang);
                }
                $query->orderBy('event_id', 'desc');
                $fields = (isset($dataField['field_get']) && trim($dataField['field_get']) != '') ? explode(',',trim($dataField['field_get'])): array();
                if(!empty($fields)){
                    $result = $query->take($limit)->get($fields);
                }else{
                    $result = $query->take($limit)->get();
                }
            }
            return $result;
        }catch (PDOException $e){
            throw new PDOException();
        }
    }
}