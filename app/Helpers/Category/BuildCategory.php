<?php

namespace App\Helpers\Category;
 
use Illuminate\Support\Facades\DB;
 
class BuildCategory 
{

	public static function buidTreeCategoryData($data, $parentId)
	{
		$data = json_decode(json_encode($data),true);
		$cateChild = [];
		$arrCheck = [];
		foreach ($data as $key => $val) {
			if($val['parent_id'] == $parentId){
				$arrCheck[] = $val['id'];
				$val['subCat'] = [];
				$cateChild[$val['id']] = $val;
			}
		}

		foreach ($data as $k => $item) {
			if(!in_array($item['id'], $arrCheck)){
				if($item['parent_id'] > 0){
					if(isset($cateChild[$item['parent_id']])){
						$item['subCat'] = [];
						$arrCheck[] = $item['id'];
						$cateChild[$item['parent_id']]['subCat'][$item['id']] = $item;
					}
				}
			}
		}

		return $cateChild;
	}

	public static function layOutCategory($data, $parentId)
	{
		$cateChild = [];
		foreach ($data as $key => $val) {
			if($val->parent_id == $parentId){
				$cateChild[] = $val;
            	unset($data[$key]);
			}
		}

		if ($cateChild) {
			echo '<nav class="navbar navbar-expand-md  navbar-light bg-light">';
				echo '<div class="collapse navbar-collapse" id="navbarMenu">';
					echo '<ul class="navbar-nav mx-auto">';
						foreach ($cateChild as $k => $val) {
							echo '<li class="nav-item">';
								echo '<a class="nav-link" href="#">'.$val->name.'</a>';
								self::layOutCategory($cateChild, $val->id);
							echo '</li>';
						}
					echo '</ul>';
				echo '</div>';
			echo '</nav>';
		}
	}
}