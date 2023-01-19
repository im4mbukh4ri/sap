<html>
  <body>
      <tr>
        <td>Username</td>
        <td>Upline</td>
        <td>Nama</td>
        <td>Kontak</td>
        <td>Email</td>
        <td>Register</td>
        <td>Last Login</td>
      </tr>
    @foreach($users as $key => $user)
      <tr>
        <td>{{ $user->username }}</td>
        <td>{{ $user->parent->username }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->address->phone }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ date("d-M-y H:i",strtotime($user->created_at))}}</td>
        <td>{{ date("d-M-y H:i",strtotime($user->updated_at)) }}</td>
      </tr>
	  @endforeach
  </body>
</html>
