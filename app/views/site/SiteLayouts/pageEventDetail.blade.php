<div class="col-lg-6 col-md-6 col-sm-12 contact col-middle w43">
	<h2 class="title-path"><a href="{{URL::route('site.pageEvent')}}" title="Video">Lịch sự kiện</a></h2>
	<h1 class="title-view">{{stripslashes($item->event_title)}}</h1>
	<div class="list-library-ext">
		@if(isset($item) && sizeof($item) > 0)
			@if($item->event_desc_sort != '')
				<div class="library-intro">
					{{stripslashes($item->event_desc_sort)}}
				</div>
			@endif
			@if($item->event_content != '')
				<div class="library-intro">
					{{stripslashes($item->event_content)}}
				</div>
			@endif
		@endif
	</div>
	<div class="line">
		@if(isset($newsSame) && sizeof($newsSame) > 0)
			<div class="title-same">Lịch sự kiện khác</div>
			<ul class="list-same">
				@foreach($newsSame as $k=>$item)
					<li><a class="post-title" title="{{$item->event_title}}" href="{{FunctionLib::buildLinkDetailEvent($item->event_title, $item->event_id)}}">{{stripslashes($item['event_title'])}}</a></li>
				@endforeach
			</ul>
		@endif
	</div>
</div>