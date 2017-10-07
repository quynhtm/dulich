<div class="line bd2 mb">
	<div class="col-lg-3 col-md-3 col-sm-12 w25">
		<h3 class="heading-news">
			<a href="{{URL::route('site.pageEvent')}}" title="Lịch sự kiện">Lịch sự kiện</a>
		</h3>
		<div class="event-list">
			<div class="banner-week">
				@if(sizeof($arrBannerWeek) > 0)
					@foreach($arrBannerWeek as $item)
						@if($item->banner_image != '')
							<a @if($item->banner_is_rel == CGlobal::LINK_NOFOLLOW) rel="nofollow" @endif @if($item->banner_is_target == CGlobal::BANNER_TARGET_BLANK) target="_blank" @endif href="@if($item->banner_link != '') {{$item->banner_link}} @else javascript:void(0) @endif" title="{{$item->banner_name}}">
								<img src="{{ThumbImg::thumbImageBannerNormal($item->banner_id,$item->banner_parent_id, $item->banner_image, CGlobal::sizeImage_1000,CGlobal::sizeImage_200, $item->banner_name,true,true)}}" alt="{{$item->banner_name}}" />
							</a>
						@endif
					@endforeach
				@endif
			</div>
			@if(sizeof($arrEventNew) > 0)
				<?php $eventTotal = count($arrEventNew); ?>
				@foreach($arrEventNew as $k=>$item)
				<div class="event-item @if($eventTotal == $k+1) last @endif">
					<div class="n-date">
						<span>Thời gian </span>
						<strong>
						@if((int)$item->event_time_start > 0)
							{{date('d',(int)$item->event_time_start)}}-
						@endif
						@if((int)$item->event_time_end > 0)
							{{date('d/m/Y',(int)$item->event_time_end)}}
						@endif
						</strong>
					</div>
					<a title="{{$item->event_title}}" href="{{FunctionLib::buildLinkDetailEvent($item->event_title, $item->event_id)}}">
						@if($item['event_title'] != '')
							{{FunctionLib::substring($item['event_title'], 100, '...') }}
						@endif
						@if($item['event_type'] == CGlobal::NEW_TYPE_TIN_HOT)
							<i class="icon-new"></i>
						@endif
				</div>
				@endforeach
			@endif
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-12 w44">
		<h3 class="heading-news left">
			<a href="javascript:void(0)" title="Bản tin">Bản tin</a>
		</h3>
		<div class="home-news-list home-news-list-center">
			<div class="line-center">
				<div class="cold45 mgl5p">
					@if(isset($data_ts_dt_csv['post']))
						@foreach($data_ts_dt_csv['post'] as $k=>$item)
							@if($k == 0)
								<div class="home-news-first-item">
									@if($item['news_image'] != '')
										<a class="post-thumb" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">
											<img alt="{{$item['news_title']}}"
												 src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_NEWS, $item['news_id'], $item['news_image'], CGlobal::sizeImage_500)}}">
										</a>
									@endif
									<h4 class="home-news-title">
										<a class="post-title" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">
											{{$item['news_title']}}
											@if($item['news_type'] == CGlobal::NEW_TYPE_TIN_HOT)
											<i class="icon-new"></i>
											@endif
										</a>
									</h4>
									<div class="excerpt">
										@if($item['news_intro'] != '')
											{{FunctionLib::substring($item['news_intro'], 200, '...') }}
										@else
											{{FunctionLib::substring($item['news_content'], 200, '...') }}
										@endif</div>
								</div>
							@else
								<div class="home-news-item">
									<a class="post-title" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">
										<i class="fa fa-circle"></i> {{$item['news_title']}}
										@if($item['news_type'] == CGlobal::NEW_TYPE_TIN_HOT)
											<i class="icon-new"></i>
										@endif
									</a>
								</div>
							@endif
						@endforeach
					@endif
				</div>
				<div class="cold45">
					@if(isset($data_khac['post']))
						@foreach($data_khac['post'] as $k=>$item)
							@if($k == 0)
								<div class="home-news-first-item">
									@if($item['news_image'] != '')
										<a class="post-thumb" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">
											<img alt="{{$item['news_title']}}"
												 src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_NEWS, $item['news_id'], $item['news_image'], CGlobal::sizeImage_500)}}">
										</a>
									@endif
									<h4 class="home-news-title">
										<a class="post-title" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">
											{{$item['news_title']}}
											@if($item['news_type'] == CGlobal::NEW_TYPE_TIN_HOT)
												<i class="icon-new"></i>
											@endif
										</a>
									</h4>
									<div class="excerpt">
										@if($item['news_intro'] != '')
											{{FunctionLib::substring($item['news_intro'], 200, '...') }}
										@else
											{{FunctionLib::substring($item['news_content'], 200, '...') }}
										@endif</div>
								</div>
							@else
								<div class="home-news-item">
									<a class="post-title" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">
										<i class="fa fa-circle"></i> {{$item['news_title']}}
										@if($item['news_type'] == CGlobal::NEW_TYPE_TIN_HOT)
											<i class="icon-new"></i>
										@endif
									</a>
								</div>
							@endif
						@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
	@if(sizeof($data_hdsv) > 0)
	<div class="col-lg-3 col-md-3 col-sm-12 w25">
		@if(isset($data_hdsv['cat']))
		<h3 class="heading-news">
			<a @if(isset($data_hdsv['cat']['category_id']) && $data_hdsv['cat']['category_id'] > 0) href="{{FunctionLib::buildLinkCategory($data_hdsv['cat']['category_id'], $data_hdsv['cat']['category_name'])}}" @endif title="{{$data_hdsv['cat']['category_name']}}">{{$data_hdsv['cat']['category_name']}}</a>
		</h3>
		@endif
		<div class="home-news-list">
			@if(isset($data_hdsv['post']))
				@foreach($data_hdsv['post'] as $k=>$item)
				@if($k == 0)
					<div class="home-news-first-item">
						@if($item['news_image'] != '')
							<a class="post-thumb" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">
							<img alt="{{$item['news_title']}}"
								 src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_NEWS, $item['news_id'], $item['news_image'], CGlobal::sizeImage_500)}}">
							</a>
						@endif
					<h4 class="home-news-title">
						<a class="post-title" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">
							{{$item['news_title']}}
							@if($item['news_type'] == CGlobal::NEW_TYPE_TIN_HOT)
								<i class="icon-new"></i>
							@endif
						</a>
					</h4>
					<div class="excerpt">
						@if($item['news_intro'] != '')
							{{FunctionLib::substring($item['news_intro'], 200, '...') }}
						@else
							{{FunctionLib::substring($item['news_content'], 200, '...') }}
						@endif</div>
					</div>
				@else
					<div class="home-news-item">
						<a class="post-title" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">
							<i class="fa fa-circle"></i> {{$item['news_title']}}
							@if($item['news_type'] == CGlobal::NEW_TYPE_TIN_HOT)
								<i class="icon-new"></i>
							@endif
						</a>
					</div>
				@endif
				@endforeach
			@endif
				@if(isset($data_hdsv['cat']['category_id']))
				<div class="a-more">
					<i class="fa fa-angle-double-right"></i> <a @if(isset($data_hdsv['cat']['category_id']) && $data_hdsv['cat']['category_id'] > 0) href="{{FunctionLib::buildLinkCategory($data_hdsv['cat']['category_id'], $data_hdsv['cat']['category_name'])}}" @endif title="{{$data_hdsv['cat']['category_name']}}">Xem thêm</a>
				</div>
				@endif
		</div>
	</div>
	@endif
</div>