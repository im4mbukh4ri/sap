<div class="panel panel-primary panel-click">
    <div class="panel-heading">
        <h3 class="panel-title">List Free User</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="table-responsive" style="height: 400px;">
                <table class="table">
                    <thead>
                    <tr>
                        <th style="text-align: center;">No.</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Tlp.</th>
                        <th>Waktu Registrasi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user->childs as $key=> $child)
                        <tr>
                            <td style="text-align: center;">{{ $key+1 }}</td>
                            <td>{{ $child->username }}</td>
                            <td>{{ $child->email }}</td>
                            <td>{{ $child->address->phone }}</td>
                            <td>{{ date('d M y H:i',strtotime($child->created_at)) }}</td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>