<div class="col-lg-6 col-md-6 col-sm-12 contact col-middle w43">
	<h1 class="title-path"><a href="{{URL::route('site.pageEvent')}}" title="Lịch sự kiện">Lịch sự kiện</a></h1>
	<div class="list-library">
		@if(isset($arrItem) && sizeof($arrItem) > 0)
			@if(count($arrItem) > 1)
			<div class="page-list-library list-post">
				@foreach($arrItem as $item)
					<div class="item-post">
						@if($item['event_image'] != '')
							<a class="post-title" title="{{$item->event_title}}" href="{{FunctionLib::buildLinkDetailEvent($item->event_title, $item->event_id)}}">
							<img alt="{{$item['event_title']}}"
								 src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_EVENT, $item['event_id'], $item['event_image'], CGlobal::sizeImage_500)}}">
							</a>
						@endif
						<div class="title-list-item">
							<a class="post-title" title="{{$item['event_title']}}" href="{{FunctionLib::buildLinkDetailEvent($item->event_title, $item->event_id)}}">
								{{stripslashes($item['event_title'])}}
							</a>
						</div>
						<div class="date"><i class="icon-other icon-date"></i>
							@if((int)$item->event_time_start > 0)
							Ngày bắt đầu {{date('d/m/Y', $item['event_time_start'])}}
							@endif
							@if((int)$item->event_time_end > 0)
							Ngày kết thúc {{date('d/m/Y', $item['event_time_end'])}}
							@endif
						</div>
						<div class="post-intro">
							@if($item['event_desc_sort'] != '')
								{{FunctionLib::substring(stripslashes($item['event_desc_sort']), 200, '...') }}
							@else
								{{FunctionLib::substring(stripslashes($item['event_content']), 200, '...') }}
							@endif
						</div>
					</div>
				@endforeach
			</div>
			@else
				@foreach($arrItem as $item)
					<h1 class="title-view">{{stripslashes($item->news_title)}}</h1>
					<div class="date"><i class="icon-other icon-date"></i>{{date('h:i', $item['news_create'])}} ngày {{date('d/m/Y', $item['news_create'])}}</div>
					@if($item->news_desc_sort != '')
						<div class="library-intro">
							<b>{{stripslashes($item['news_desc_sort'])}}</b>
						</div>
					@endif
					@if($item->news_content != '')
						<div class="library-intro">
							{{stripslashes(stripslashes($item['news_content']))}}
						</div>
					@endif

				@endforeach
			@endif
		@endif
	</div>
	<div class="show-box-paging" style="margin-top:20px; ">
		<div class="showListPage">
			{{$paging}}
		</div>
	</div>
</div>