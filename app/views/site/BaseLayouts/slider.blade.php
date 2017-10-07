@if(sizeof($arrBannerSlider) > 0)
	<?php $check = 0;?>
	@foreach($arrBannerSlider as $item)
		@if($item->banner_page == $departmentId)
			<?php $check++;?>
		@endif
	@endforeach
@if($check > 0)
<script type="text/javascript" language="javascript">
	$(document).ready(function() {
		$('._sliders').skitter({
			numbers: false,
			dots: true
		});
	});
</script>
@endif
<?php $rands = array('cube', 'cubeRandom', 'block', 'cubeStop', 'showBars', 'horizontal', 'fadeFour', 'paralell', 'blind', 'directionTop', 'directionBottom', 'directionRight'); ?>
<div class="line">
	<div class="skitter-large-box">
		<div class="skitter skitter-large _sliders">
			<ul>
				@foreach($arrBannerSlider as $item)
					@if($item->banner_page == $departmentId)
						@if($item->banner_image != '')
							<?php $rand_item = $rands[array_rand($rands, 1)]; ?>
							<li>
								<a href="#{{$rand_item}}" @if($item->banner_is_rel == CGlobal::LINK_NOFOLLOW) rel="nofollow" @endif title="{{$item->banner_name}}">
									<img class="{{$rand_item}}" src="{{ThumbImg::thumbImageBannerNormal($item->banner_id,$item->banner_parent_id, $item->banner_image, CGlobal::sizeImage_1000,CGlobal::sizeImage_200, $item->banner_name,true,true)}}" alt="{{$item->banner_name}}" />
								</a>
							</li>
						@endif
					@endif
				@endforeach
			</ul>
		</div>
	</div>
</div>
@endif