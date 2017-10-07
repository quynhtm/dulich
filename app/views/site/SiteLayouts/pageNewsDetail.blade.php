<div class="col-lg-6 col-md-6 col-sm-12 contact col-middle w43">
	<h2 class="title-path"><a href="{{FunctionLib::buildLinkCategory($item->news_category_id, $item->news_category_name)}}" title="{{$item->news_category_name}}">{{$item->news_category_name}}</a></h2>
	<h1 class="title-view">{{stripslashes($item->news_title)}}</h1>
	<div class="list-library-ext">
		@if(isset($item) && sizeof($item) > 0)
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
		@endif
	</div>
	<div class="line">
		@if(isset($newsSame) && sizeof($newsSame) > 0)
		<div class="title-same">Bài viết khác</div>
			<ul class="list-same">
				@foreach($newsSame as $k=>$item)
					<li><a class="post-title" title="{{$item['news_title']}}" href="{{FunctionLib::buildLinkDetailNews($item['news_category_name'], $item['news_title'], $item['news_id'])}}">{{$item['news_title']}}</a></li>
				@endforeach
			</ul>
		</div>
		@endif
	</div>
</div>