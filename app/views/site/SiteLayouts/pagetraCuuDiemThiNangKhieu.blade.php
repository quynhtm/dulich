<div class="box-check">
	<h1 class="title-box-check"><a href="{{URL::route('tracuu.traCuuDiemThiNangKhieu')}}" title="Tra cứu điểm thi năng khiếu">Tra cứu điểm thi năng khiếu</a></h2>
	<div class="content-box-check">
		<div class="input-ext" id="boxTraCuuDiemThiNangKhieu">
			{{Form::open(array('method' => 'POST', 'id'=>'formTraCuu', 'class'=>'formTraCuu', 'name'=>'formTraCuu'))}}
			<div class="col-lg-2 col-md-2 col-sm-12 ext-items">
				<div class="form-group">
					<label class="control-label">Số CMND</label>
					<input id="ipCMND" name="ipCMND" class="form-control" type="text" placeholder="- Số CMND -">
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-12 ext-items">
				<div class="form-group">
					<label class="control-label">Họ và tên</label>
					<input id="ipHoVaTen" name="ipHoVaTen" class="form-control" type="text" placeholder="- Họ và tên -">
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-12 ext-items">
				<div class="form-group">
					<label class="control-label">&nbsp;</label>
					<span id="submitTraCuuDiemThiNangKhieu" class="btn btn-primary btn-ext">Tra cứu</span>
				</div>
				<span class="loading"></span>
			</div>
			{{Form::close()}}
		</div>
		<div class="line-equal">
			<div class="title-equal"><span>Thông tin điểm thi năng khiếu</span></div>
			<div class="box-list-equal">
				<div class="inputInfo">Nhập số CMND, họ và tên.</div>
			</div>
		</div>
	</div>
</div>