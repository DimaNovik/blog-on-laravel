@extends('admin.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Керування сторінкою - Користувачі
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            {{ Form::open(['route' => 'users.store', 'files' => true]) }}
            <!-- Default box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Користувачі</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>ПІБ</th>
                            <th>Email</th>
                            <th>Телефон</th>
                            <th>Логін</th>
                            <th>Статус</th>
                            <th>Дії з постом</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->login}}</td>
                            <td>{{$user->is_active}}</td>
                            <td><a href="{{route('users.edit', $user->id)}}" class="fa fa-pencil"></a>
                                {{Form::open(['route'=>['users.destroy', $user->id], 'method'=>'delete'])}}
                                <button class="delete" onclick="return confirm('Вы уверены в удалении материала?')">
                                    <i class="fa fa-remove"></i>
                                </button>
                                {{Form::close()}}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            {{Form::close()}}

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection