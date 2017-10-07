<div class="line">
	<div class="headingline">Thư viện ảnh & Video</div>
	<div class="home-gallery-video">
		<div class="sp-image-container">
			@if(sizeof($arrImg) > 0)
				<h2 class="title-path-ext"><a href="{{URL::route('site.pageLibrary')}}" title="Thư viện ảnh">Thư viện ảnh</a></h2>
				<div id="sliderPro" class="slider-pro">
					@foreach($arrImg as $k=>$items)
                        <?php $arrListImg = ($items->image_image_other != '') ? unserialize($items->image_image_other) : array();?>
						@if(!empty($arrListImg))
							<div class="sp-slides">
								@foreach($arrListImg as $item)
									<div class="sp-slide">
										<img class="sp-image" src="{{URL::route('site.home')}}/assets/frontend/img/blank.gif"
											 data-src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $items['image_id'], $item, CGlobal::sizeImage_1000)}}"
											 data-small="{{ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $items['image_id'], $item, CGlobal::sizeImage_1000)}}"
											 data-medium="{{ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $items['image_id'], $item, CGlobal::sizeImage_1000)}}"
											 data-large="{{ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $items['image_id'], $item, CGlobal::sizeImage_1000)}}"
											 data-retina="{{ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $items['image_id'], $item, CGlobal::sizeImage_1000)}}"/>
										<p class="sp-layer sp-white sp-padding"
										   data-horizontal="50" data-vertical="50"
										   data-show-transition="left" data-show-delay="400">{{$items['image_title']}}
										</p>
									</div>
								@endforeach
							</div>
							<div class="sp-thumbnails">
								@foreach($arrListImg as $item)
									<img class="sp-thumbnail" src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $items['image_id'], $item, CGlobal::sizeImage_500)}}"/>
								@endforeach
							</div>
						@endif
					@endforeach
				</div>
				<script type="text/javascript">
                    $( document ).ready(function( $ ) {
                        $( '#sliderPro' ).sliderPro({
                            width: 570,
                            height: 265,
                            fade: true,
                            arrows: true,
                            buttons: false,
                            fullScreen: true,
                            shuffle: true,
                            smallSize: 500,
                            mediumSize: 1000,
                            largeSize: 3000,
                            thumbnailArrows: true,
                            autoplay: false
                        });
                    });
				</script>
			@endif
		</div>
		<div class="home-video">
			<h2 class="title-path-ext"><a href="{{URL::route('site.pageVideo')}}" title="Video">Video</a></h2>
			@if(sizeof($arrVideo) > 0)
				@foreach($arrVideo as $k=>$item)
					@if($k == 0)
                        <?php
                        $_video = str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $item->video_link);
                        $embed = '<iframe width="540" height="350" src="'.$_video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
                        echo $embed;
                        ?>
					@endif
				@endforeach
			@endif
		</div>
	</div>
</div>