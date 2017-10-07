<div class="col-lg-6 col-md-6 col-sm-12 contact col-middle w43">
	<h1 class="title-path"><a href="{{URL::route('site.pageLibrary')}}" title="Thư viện ảnh">Thư viện ảnh</a></h1>
	<div class="list-library">
		@if(isset($arrItem) && sizeof($arrItem) > 0)
			<div class="row page-list-library">
				@foreach($arrItem as $k=>$item)
					<div class="col-lg-6 col-sm-6 item-library w48">
						<a title="{{$item->image_title}}" href="{{FunctionLib::buildLinkDetailLibrary($item->image_title, $item->image_id)}}">
							<div class="thumbL">
								<img src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $item['image_id'], $item['image_image'], CGlobal::sizeImage_500)}}" />
							</div>
							<div class="titleL">{{stripslashes($item->image_title)}}</div>
						</a>
					</div>
				@endforeach
			</div>
		@endif
	</div>
	<div class="show-box-paging" style="margin-top:20px; ">
		<div class="showListPage">
			{{$paging}}
		</div>
	</div>
</div>