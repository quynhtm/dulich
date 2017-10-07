<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/
use Illuminate\Cache\MemcachedStore;

class AttackLink extends Eloquent {
    
    protected $table = 'web_attack_link';
    protected $primaryKey = 'link_id';
    public  $timestamps = false;

    protected $fillable = array('link_id', 'link_title','link_type', 'link_url', 'link_order', 'link_status');
	//ADMIN
    public static function searchByCondition($dataSearch=array(), $limit=0, $offset=0, &$total){
    	try{
    	  
    		$query = AttackLink::where('link_id','>',0);
    	  
    		if (isset($dataSearch['link_title']) && $dataSearch['link_title'] != '') {
    			$query->where('link_title','LIKE', '%' . $dataSearch['link_title'] . '%');
    		}
    		if (isset($dataSearch['link_status']) && $dataSearch['link_status'] != -1) {
    			$query->where('link_status', $dataSearch['link_status']);
    		}
    	  
    		$total = $query->count();
    		$query->orderBy('link_id', 'desc');
    
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
     
    public static function getById($id=0){
    	$result = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_ATTACK_LINK_ID.$id) : array();
    	try {
    		if(empty($result)){
    			$result = AttackLink::where('link_id', $id)->first();
    			if($result && Memcache::CACHE_ON){
    				Cache::put(Memcache::CACHE_ATTACK_LINK_ID.$id, $result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
    			}
    		}
    	} catch (PDOException $e) {
    		throw new PDOException();
    	}
    	
    	return $result;	
    }
     
    public static function updateData($id=0, $dataInput=array()){
    	try {
    		DB::connection()->getPdo()->beginTransaction();
    		$data = AttackLink::find($id);
    		if($id > 0 && !empty($dataInput)){
    			$data->update($dataInput);
    			if(isset($data->link_id) && $data->link_id > 0){
    				self::removeCacheId($data->link_id);
    			}
    		}
    		DB::connection()->getPdo()->commit();
    		return true;
    	} catch (PDOException $e) {
    		DB::connection()->getPdo()->rollBack();
    		throw new PDOException();
    	}
    }
     
    public static function addData($dataInput=array()){
    	try {
    		DB::connection()->getPdo()->beginTransaction();
    		$data = new AttackLink();
    		if (is_array($dataInput) && count($dataInput) > 0) {
    			foreach ($dataInput as $k => $v) {
    				$data->$k = $v;
    			}
    		}
    		if ($data->save()) {
    			DB::connection()->getPdo()->commit();
    			if($data->link_id && $data->link_id > 0){
    				AttackLink::removeCacheId($data->link_id);
    			}
    			return $data->link_id;
    		}
    		DB::connection()->getPdo()->commit();
    		return false;
    	} catch (PDOException $e) {
    		DB::connection()->getPdo()->rollBack();
    		throw new PDOException();
    	}
    }

    public static function deleteId($id=0){
    	try {
    		DB::connection()->getPdo()->beginTransaction();
    		$data = AttackLink::find($id);
    		if($data != null){
    			$data->delete();
    			if(isset($data->link_id) && $data->link_id > 0){
    				self::removeCacheId($data->link_id);
    			}
    			DB::connection()->getPdo()->commit();
    		}
    		return true;
    	} catch (PDOException $e) {
    		DB::connection()->getPdo()->rollBack();
    		throw new PDOException();
    	}
    }

    public static function removeCacheId($id=0){
    	if($id>0){
    		Cache::forget(Memcache::CACHE_ATTACK_LINK_ID.$id);
    	}
    }

    //SITE
    public static function searchByConditionSite($dataSearch=array(), $limit=0){
        try{

            $query = AttackLink::where('link_id','>',0);
            $query->where('link_status', CGlobal::status_show);
            $query->orderBy('link_id', 'asc');

            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
            if(!empty($fields)){
                $result = $query->take($limit)->get($fields);
            }else{
                $result = $query->take($limit)->get();
            }
            return $result;

        }catch (PDOException $e){
            throw new PDOException();
        }
    }
}
