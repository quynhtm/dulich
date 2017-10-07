<div class="col-lg-6 col-md-6 col-sm-12 contact col-middle w43">
	<h1 class="title-path"><a href="{{FunctionLib::buildLinkCategory($arrCat->category_id, $arrCat->category_name)}}" title="{{$arrCat->category_name}}">{{$arrCat->category_name}}</a></h1>
	<div class="list-library">
		@if(isset($arrItem) && sizeof($arrItem) > 0)
			@if(count($arrItem) > 1)
			<div class="page-list-library list-post">
				@foreach($arrItem as $item)
					<div class="item-post">
						@if($item['news_image'] != '')
							<a class="post-title" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">
							<img alt="{{$item['news_title']}}"
								 src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_NEWS, $item['news_id'], $item['news_image'], CGlobal::sizeImage_500)}}">
							</a>
						@endif
						<div class="title-list-item">
							<a class="post-title" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">
								{{stripslashes($item['news_title'])}}
							</a>
						</div>
						@if($item['news_create'] != '')
						<div class="date"><i class="icon-other icon-date"></i>{{date('h:i', $item['news_create'])}} ngày {{date('d/m/Y', $item['news_create'])}}</div>
						@endif
						<div class="post-intro">
							@if($item['news_intro'] != '')
								{{FunctionLib::substring(stripslashes($item['news_intro']), 200, '...') }}
							@else
								{{FunctionLib::substring(stripslashes($item['news_content']), 200, '...') }}
							@endif

							<a class="arrow-more" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}"><span>Chi Tiết</span></a>
						</div>
					</div>
				@endforeach
			</div>
			@else
				@foreach($arrItem as $item)
					<h1 class="title-view">{{$item->news_title}}</h1>
					@if($item['news_create'] != '')
					<div class="date"><i class="icon-other icon-date"></i>{{date('h:i', $item['news_create'])}} ngày {{date('d/m/Y', $item['news_create'])}}</div>
					@endif
					@if($item->news_desc_sort != '')
						<div class="library-intro">
							<b>{{stripslashes($item['news_desc_sort'])}}</b>
						</div>
					@endif
					@if($item->news_content != '')
						<div class="library-intro">
							{{stripslashes($item['news_content'])}}
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