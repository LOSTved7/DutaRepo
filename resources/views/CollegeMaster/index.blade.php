@extends('layouts.header')

@section('title')
College
@endsection

@section('content')
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb--><div class="card">
					<div class="card-body">
				<div class="page-breadcrumb d-none d-sm-flex align-items-center">
					<div>
						<h3>COLLEGE</h3>						
					</div>
					<div class="ms-auto">
						
						<div class="btn-group">
							
							<a href="{{route($current_menu.'.create')}}" class="btn btn-primary">Create College</a>
						</div>
					</div>
				</div>
					
						<form action="" method="GET">
						@csrf
					<div class="form-group row">
						
					<div class="col-md-4 p-4">
						<label for="single-select-clear-field" class="form-label">College</label>
						 <select class="form-select single-select-clear-field" name="college_id"  data-placeholder="Choose College" >
							 <option></option>
							 @foreach($college_mast as $key => $value)
							<option value="{{$key}}" {{ old('college_id',request('college_id')) == $key ? 'selected' : '' }}>{{$value}}</option>
						@endforeach
						 </select>
					 </div>
					 <div class="col-md-2 mt-4 p-4">
					 	<input type="submit" class="btn btn-light px-4" value="Find">
					 </div>
					</div>
				</form>
						<div class="table-responsive">
							
							
							<table id="example2" class="table table-striped table-bordered">
							
							<thead>
								<tr>
									
									<th>S.No.</th>
									<th>ID/CODE</th>
									<th>College Name</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$i=0; 
								?>
								@foreach($data as $key => $value)
									<?php 
										$encid = Crypt::encryptString($value->id);
									?>
								<tr>
									<td>{{++$i}}</td>
									<td>{{$value->college_id}}</td>
									<td>{{$value->college_name}}</td>
									<td>
									<a href="{{$current_menu.'/'.$encid.'/edit'}}">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg>
									</a>
									
									<button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#editFacultyModal24" data-faculty-id="eyJpdiI6IkIva2dsVkJVR3QzZjlnS0hORzFRNXc9PSIsInZhbHVlIjoiMzR3Mm9QY0VZWFRLdEFsSjhSOXV0QT09IiwibWFjIjoiYWVhYzM3NWE3ZmUyNTU1ODg1NjAwOWE4NGE1OGJkOWRhMjllMTYwZDNjZDAzMDNjMTRmYjMyOTAxODA4YjY4YiIsInRhZyI6IiJ9">
					        			<svg width="16" height="16" viewBox="-1 0 20 20" xmlns="http://www.w3.org/2000/svg">
					        				<g id="user" transform="translate(-3 -2)">
					        					<path id="secondary" fill="#2ca9bc" d="M9,15h6a5,5,0,0,1,5,5h0a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1H4a5,5,0,0,1,5-5Z"></path><path id="primary" d="M20,20h0a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1H4a5,5,0,0,1,5-5h6A5,5,0,0,1,20,20ZM12,3a4,4,0,1,0,4,4A4,4,0,0,0,12,3Z" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
							  				</g>
										</svg>
					    			</button>
					    			
									<form action="{{ route($current_menu.'.destroy', $encid) }}" method="POST" class="d-inline">
                					@csrf
					                @method('DELETE')
					                <button class="btn btn-link" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
									</svg></button>
					            	</form>
																	
								</td>

								
								</tr>
								@endforeach
							</tbody>
							</table>
						</div>
						</div>	
					</a>	
					</div>
				</div>
			
		</div>
	</div>
</div>
				

							
						
@endsection
			
@section('js')
	<script type="text/javascript">
		function download_csv(page) {
			alert(2);
			var page_name = page;
      
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            // $.ajax({
            //     type: "post",
            //     url:  '{{route("download_csv")}}',
            //     dataType: 'json',
            //     data: {
            //         'page': page_name
            //     },
            //     success: function (data) {
            //         if(data.code == 401) { }

            //         else if(data.code == 200) { 
                       
            //         }
            //         else {

            //         }
            //     }
            // });	
	        
		}
		
	</script>
@endsection
