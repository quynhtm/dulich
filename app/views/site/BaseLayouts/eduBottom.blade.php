<div class="line bd2">
	<div class="headingline">Tuyển sinh và đào tạo</div>
	<div class="tabLine" id="tabContaier">
		<ul>
			@if(sizeof($arrTab) > 0)
				@foreach($arrTab as $k=>$item)
					<li><h3><a @if($item->tab_link=='')href="javascript:void(0)" data="tab{{$k}}" @else href="{{$item->tab_link}}" data="" @endif @if($k==0)class="active"@endif >{{$item->tab_name}}</a></h3></li>
				@endforeach
			@endif
		</ul>
	</div>
	<div class="tabDetails">
		@if(sizeof($arrTab) > 0)
			@foreach($arrTab as $k=>$item)
			<?php $arrTabSub = TabSub::searchSubTabLimitAsc($item->tab_id, 4);?>
			<div @if($item->tab_link=='')id="tab{{$k}}"@endif class="tabContents @if($k==0)active @endif">
				@if(sizeof($arrTabSub) > 0)
					<?php $totals = count($arrTabSub); ?>
					@foreach($arrTabSub as $s=>$sub)
					<div class="box-brand @if($totals == $s+1) box-brand-last @endif">
						<a href="{{$sub->tab_sub_link}}">
							<span class="transit mask"></span>
							@if($sub['tab_sub_image'] != '')
							<img src="{{ ThumbImg::getImageThumb(CGlobal::FOLDER_TAB_SUB, $sub['tab_sub_id'], $sub['tab_sub_image'], CGlobal::sizeImage_600, '', true, CGlobal::type_thumb_image_product, false)}}" alt="{{$sub->tab_sub_name}}">
							@endif
						</a>
						<h4>{{$sub->tab_sub_name}}</h4>
					</div>
					@endforeach
				@endif
			</div>
			@endforeach
		@endif
		<!--Tab fix cứng-->
        <?php $arrTabSubFix = TabSub::searchSubTabLimitAsc($catTabFix, 4);?>
		@if(sizeof($arrTabSubFix) > 0)
			<?php $totals = count($arrTabSubFix); ?>
			@foreach($arrTabSubFix as $s=>$sub)
				<div class="box-brand @if($totals == $s+1) box-brand-last @endif">
					<a href="{{$sub->tab_sub_link}}">
						<span class="transit mask"></span>
						@if($sub['tab_sub_image'] != '')
							<img src="{{ ThumbImg::getImageThumb(CGlobal::FOLDER_TAB_SUB, $sub['tab_sub_id'], $sub['tab_sub_image'], CGlobal::sizeImage_600, '', true, CGlobal::type_thumb_image_product, false)}}" alt="{{$sub->tab_sub_name}}">
						@endif
					</a>
					<h4>{{$sub->tab_sub_name}}</h4>
				</div>
			@endforeach
		@endif
	</div>
</div>