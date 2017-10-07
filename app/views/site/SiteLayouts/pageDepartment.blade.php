<div class="col-lg-6 col-md-6 col-sm-12 contact col-middle w43">
	<h1 class="title-path"><a title="{{$item['department_name']}}" href="{{FunctionLib::buildLinkCategoryDepartment($item['department_alias'], $item['department_name'], $item['department_id'])}}">{{$item->department_name}}</a></h1>
	<div class="list-library-ext">

		@if(!empty($menuCategoriessAll))
			@foreach($menuCategoriessAll as $cat)
				@if($cat['category_show_center'] == CGlobal::status_show)
					@if($cat['category_depart_id'] == $departmentId)
                        <?php $arrItem = BaseSiteController::getPostInCategoryId($cat['category_id'], $limit=5); ?>
						<div class="top-title">
							<span><a @if($cat['category_link'] != '') href="{{$cat['category_link']}}" target="_blank" @else href="{{FunctionLib::buildLinkCategory($cat['category_id'], $cat['category_name'])}}" @endif title="{{$cat['category_name']}}">{{$cat['category_name']}}</a></span>
						</div>
						@if(sizeof($arrItem) > 0)
						<div class="box-item box-item-ext">
							@foreach($arrItem as $k=>$item)
								@if($k == 0)
								<div class="item-main">
									<a href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}" class="title-main" title="{{stripslashes($item['news_title'])}}">{{stripslashes($item['news_title'])}}</a>
								</div>
								<div class="intro-main">
									@if($item['news_image'] != '')
										<a title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">
											<img alt="{{$item['news_title']}}"
												 src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_NEWS, $item['news_id'], $item['news_image'], CGlobal::sizeImage_500)}}">
										</a>
									@endif
									<span>
										@if($item['news_intro'] != '')
											{{FunctionLib::substring(trim($item['news_intro']), 500, '...')}}
										@else
											{{FunctionLib::substring(trim($item['news_content']), 500, '...')}}
										@endif
									</span>
								</div>
								<a class="arrow-more" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}"><span>Chi Tiết</span></a>
								@endif
							@endforeach
							@if(count($arrItem)> 1)
								<div class="list-main">
									<ul>
										@foreach($arrItem as $k=>$item)
											@if($k > 0)
												<li><a title="{{stripslashes($item['news_title'])}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">{{stripslashes($item['news_title'])}}</a></li>
											@endif
										@endforeach
									</ul>
								</div>
							@endif
						</div>
						@endif

					@endif
				@endif
			@endforeach
		@endif
	</div>
</div>