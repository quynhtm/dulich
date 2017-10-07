<div class="box-check">
	<h1 class="title-box-check"><a href="{{URL::route('tracuu.traCuuXetTuyenSinh')}}" title="Tra cứu kết quả xét tuyển">Tra cứu kết quả xét tuyển</a></h2>
	<div class="content-box-check">
		<div class="input-ext" id="boxTraCuuXetTuyenSinh">
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
					<label class="control-label">Trình độ</label>
					<select id="ipTrinhDo" name="ipTrinhDo" class="form-control">
						<option value="1">Trung cấp</option>
						<option value="2">Cao đẳng</option>
						<option value="3">Cao đẳng liên thông</option>

					</select>
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-12 ext-items">
				<div class="form-group">
					<label class="control-label">&nbsp;</label>
					<span id="submitTraCuuXetTuyenSinh" class="btn btn-primary btn-ext">Tra cứu</span>
				</div>
				<span class="loading"></span>
			</div>
			{{Form::close()}}
		</div>
		<div class="line-equal">
			<div class="title-equal"><span>Thông tin kết quả xét tuyển</span></div>
			<div class="box-list-equal">
				<div class="inputInfo">Nhập số CMND, họ và tên và trình độ.</div>
			</div>
		</div>
	</div>
</div>