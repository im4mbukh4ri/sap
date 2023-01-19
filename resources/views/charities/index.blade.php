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



@foreach (['danger', 'warning', 'success', 'info'] as $msg)
  @if(Session::has('alert-' . $msg))
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content modal-charity">
          <div class="modal-body">
            <br><br>
            <div align="center" align="middle">
            <img src="{{asset('/assets/logo/charity-2.png')}}" width="50%" height="50%">
            </div>

            <h4 align="center">{{ Session::get('alert-' . $msg) }}</h4>
            <h4 align="center">Terima Kasih Smartpreneur</h4>
            <h6 align="center">Atas Kebesaran Hati Anda Membantu Sesama</h6>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function () {
        $('#myModal').modal('show');
      });
    </script>
  @endif
@endforeach

<div id="step-booking-kereta">
    <section class="section-pilih-seat">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="blue-title-big">CHARITY</h3>
                </div>
            </div>
            <div class="row">
                <div class="content-middle">

                    <div class="col-md-6">
                        <div class="main-faq faq-acc">
                            <div class="panel-group panel-custom" id="accordion" role="tablist" aria-multiselectable="true">
                                <?php $key = 0;
$no = 0;
$charites = App\Charity::where('status', 1)->get();
?>
                                @foreach($charites as $chariti)
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingDep{{$key}}">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDep{{$key}}" <?=($key === 0) ? "aria-expanded=\"true\" " : " class=\"collapsed\" aria-expanded=\"false\"";?> aria-controls="collapseDep{{$key}}">
                                                    {{ $chariti->title }} <span class="pull-right">{{ date('d M Y H:i',strtotime($chariti->created_at)) }} &nbsp;&nbsp;&nbsp;</span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseDep{{$key}}" class="panel-collapse collapse <?=($key === 0) ? 'in' : ''?>" role="tabpanel" aria-labelledby="headingDep{{$key}}">
                                            <div class="panel-body" style="background-color: white;">
                                                @if($chariti->url_image)
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <img src="{{ $chariti->url_image}}" class="img-responsive" alt="{{$chariti->url_image}}" style="display: block;margin: auto;">
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        {!! $chariti->content !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $key++;
$no = $key + 1;?>
                                @endforeach
                                @if($no == 0)
                                <div class="panel panel-default">
                                    <div id="collapseDep1" class="panel-collapse collapse1" role="tabpanel" aria-labelledby="headingDep1">
                                        <div class="panel-body" style="background-color: white;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                  <center>PROGRAM CHARITY BELUM TERSEDIA</center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="row" v-if="success">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Form Charity</h4>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="{{route('charities.store')}}" method="post">
                                         {{csrf_field()}}
                                        <div class="form-group <?=(count($errors) > 0) ? 'has-error' : ''?>">
                                            <label for="nominal"><i class="fa fa-user prefix"></i> Program Charity</label>
                                            <select name="charity_id" class="form-control" required>
                                                <option value="">Pilih Charity</option>
                                                @foreach($charites as $chariti)
                                                <option value="{{$chariti->id}}">{{$chariti->title}}</option>
                                                @endforeach
                                            </select>
                                            @if (count($errors) > 0)
                                                @foreach ($errors->all() as $error)
                                                    <span class="alert-danger">{{ $error }}</span>
                                                @endforeach
                                            @endif
                                        </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script type="text/javascript">
        $('.money').mask("#,##0", {reverse: true});
</script>
                                        <div class="form-group">
                                            <label for="nominal"><i class="fa fa-money prefix"></i> Nominal</label>
                                            <input type="text" id="nominal" name="nominal" class="form-control money" value="" required placeholder="Minimal Charity Rp 1.000 ">
                                        </div>
                                        <div class="form-group">
                                            <label for="password"><i class="fa fa-lock prefix"></i> Password</label>
                                            <input type="password" name="password" class="form-control" required>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn btn-blue js-submit-confirm" type="submit"> Kirim</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('js')
    @parent
    <script src="{{asset('/assets/js/public/sweetalert.min.js')}}"></script>
    <script>
        $(document).ready(function(){
             $(document.body).on('click', '.js-submit-confirm', function (event) {
                event.preventDefault();
                var $form = $(this).closest('form');
                var $el = $(this);
                var text = $el.data('confirm-message') ? $el.data('confirm-message') : 'Anda tidak bisa membatalkan proses ini!';
                var img = "{{asset('/assets/logo/infocharities-1.png')}}";
                swal({
                        title: 'Anda akan melakukan transfer charity sebesar IDR '+$('#nominal').val(),
                        text: text,
                        imageUrl: img,
                        showCancelButton: true,
                        confirmButtonColor: '#0c5484',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal',
                        closeOnConfirm: true
                    },
                    function () {
                        $form.submit()
                    })
            });
        });
    </script>

@endsection
