@extends('layouts.public')
@section('css')
    @parent
    <link rel="stylesheet" href="{{asset('/assets/css/public/sweetalert.css')}}">
    <style>
    .modal-charity {
      background-image: url("{{asset('/assets/logo/charity-1.png')}}");
      background-size: 100% 13%;
      background-repeat: no-repeat;
    }
    </style>
@endsection
@section('content')

<div id="step-booking-kereta">
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">QUESTIONNAIRE</h3>
                </div>
            </div>
            <br>
            <div class="table-responsive dataTable">
    							<table id="data-table" class="text-center table table-striped table-bordered dt-responsive nowrap table-custom-blue">
    								<thead>
    									<tr>
  										<th class="text-center">No.</th>
											<th class="text-center">Judul Kuisioner</th>
											<th class="text-center">Status</th>
  										<th class="text-center">&nbsp;</th>
											<th></th>
    									</tr>

    								</thead>
    								<tbody><?php $smartPrice=0; ?>
    									@forelse($questionnaires as $key => $questionnaire)
												<tr>
													<td>{{ $key+1 }}</td>
													<td>{{ $questionnaire->title }}</td>
													<td>
                            <?php
switch ($questionnaire->statusRes) {
case 0:
	echo '<label class=\'label label-info\'>Belum Mengisi</label>';
	break;
case 1:
	echo '<label class=\'label label-success\'>Sudah Mengisi</label>';
	break;
default:
	echo '<label class=\'label label-danger\'>ERROR</label>';
	break;
}
?>
													</td>
                          <td>

                          </td>
													<td>
                            <form method="get" action="{{route('questionnaires.form')}}">
                              {{csrf_field()}}
                              <input type="hidden" name="questionnaire_id" value="{{$questionnaire->id}}">
                              <button type="submit" class="btn btn-info" @if($questionnaire->statusRes === 1) disabled @endif ><i class="fa fa-pencil"></i></button>
                            </form>
													</td>
												</tr>
										@empty
											<tr>
												<td colspan="8">Tidak Ada Data Kuisioner</td>
											</tr>
    									@endforelse
    								</tbody>
    							</table>
						</div>
        </div>
    </section>
</div>
@endsection
@section('js')
    @parent
    <script src="{{asset('/assets/js/public/sweetalert.min.js')}}"></script>
@endsection
