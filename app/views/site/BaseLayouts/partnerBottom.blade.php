@if(sizeof($arrBannerPartner) > 0)
<div class="line">
	<div class="wrapp-partner-footer">
		<div class="sldersline sliderBottomPartner" id="owl-carousel">
			@foreach($arrBannerPartner as $item)
			@if($item->banner_image != '')
				<div class="image-item">
					<a @if($item->banner_is_rel == CGlobal::LINK_NOFOLLOW) rel="nofollow" @endif @if($item->banner_is_target == CGlobal::BANNER_TARGET_BLANK) target="_blank" @endif href="@if($item->banner_link != '') {{$item->banner_link}} @else javascript:void(0) @endif" title="{{$item->banner_name}}">
						<img src="{{ThumbImg::thumbImageBannerNormal($item->banner_id,$item->banner_parent_id, $item->banner_image, CGlobal::sizeImage_1000,CGlobal::sizeImage_200, $item->banner_name,true,true)}}" alt="{{$item->banner_name}}" />
					</a>
					@endif
				</div>
				@endforeach
				<script>
					$(document).ready(function(){
						$("#owl-carousel").owlCarousel({
							autoPlay : true,
							navigation : true,
							navigationText : ["prev","next"],
						});
					});
				</script>
		</div>
	</div>
</div>
@endif