<div class="panel panel-primary panel-click">
    <div class="panel-heading">
        <h3 class="panel-title">Reset Mobile Device</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3">
                <strong>Device Aktif</strong>
                <p class="muted">Device yang terdaftar.</p>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <div class="form-group">
                        <label for="name">Daftar Device</label>
                        <div class="row">
                            @foreach($user->client_secrets as $client)
                            <div class="col-md-4 text-center">
                                <form action="{{route('admin.users_reset_device',$client->device_id)}}" method="POST">
                                    {{ csrf_field() }}
                                <img src="{{ asset('/images/logo/devices/'.$client->device_type.'.png') }}" alt="{{$client->device_type}}" class="img-rounded" style="display: block;margin: auto">
                                <br><p><strong>Device ID : {{substr($client->device_id,0,5)}}*****</strong></p>
                                    <button class="btn btn-orange">Reset device {{$client->device_type}}</button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>