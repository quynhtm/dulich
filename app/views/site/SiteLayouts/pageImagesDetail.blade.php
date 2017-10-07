<div class="col-lg-6 col-md-6 col-sm-12 contact col-middle w43">
	<h2 class="title-path"><a href="{{URL::route('site.pageLibrary')}}" title="Thư viện ảnh">Thư viện ảnh</a></h2>
	<h1 class="title-view">{{stripslashes($item->image_title)}}</h1>
	<div class="list-library-ext">
		@if(isset($item) && sizeof($item) > 0)
			<div class="page-list-library row" id="gallery">
				@if(isset($item) && sizeof($item) > 0)
                    <?php $image_image_other = unserialize($item->image_image_other); ?>
						@foreach($image_image_other as $k=>$img)
							<div class="col-lg-6 col-sm-6 item-library-detail w48">
								<a title="{{$item->image_title}}" href="{{ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $item['image_id'], $img, CGlobal::sizeImage_1000)}}">
									<div class="thumbLDetail">
										<img src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $item['image_id'], $img, CGlobal::sizeImage_1000)}}" />
										<i class="fa fa-search-plus iconzoom"></i>
									</div>
								</a>
							</div>
						@endforeach
				@endif
			</div>
			@if($item->image_content != '')
				<div class="library-intro">
					{{stripslashes($item->image_content)}}
				</div>
			@endif
		@endif
	</div>
	<div class="line">
		<div class="title-same">Thư viện ảnh khác</div>
		@if(isset($newsSame) && sizeof($newsSame) > 0)
			<div class="row page-list-same">
				@foreach($newsSame as $k=>$aitem)
					<div class="col-lg-6 col-sm-6 item-video w48">
						<a title="{{$aitem->image_title}}" href="{{FunctionLib::buildLinkDetailLibrary($aitem->image_title, $aitem->image_id)}}">
							<div class="thumbL">
								<img src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_LIBRARY_IMAGE, $aitem['image_id'], $aitem['image_image'], CGlobal::sizeImage_500)}}" />
							</div>
							<div class="titleL">{{stripslashes($aitem->image_title)}}</div>
						</a>
					</div>
				@endforeach
			</div>
		@endif
	</div>
</div>
<script>
    jQuery(document).ready(function() {
        jQuery('#gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1],
            },
            image: {
                tError: 'Not load image!',
                titleSrc: function(item) {
                    return item.el.attr('title') + '<small>{{CGlobal::web_name}}</small>';
                }
            }
        });
    });
</script>