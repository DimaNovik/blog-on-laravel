@extends('admin.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Керування сторінкою - Анонси
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            {{ Form::open(['route' => 'anonses.store', 'files' => true]) }}
            <!-- Default box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Анонси</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <a href="{{route('anonses.create')}}" class="btn btn-success">Додати</a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Назва</th>
                            <th>Дата проведення</th>
                            <th>Дії з постом</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($anonses as $anons)
                        <tr>
                            <td>{{$anons->id}}</td>
                            <td>{{$anons->title}}</td>
                            <td>{{$anons->date}}</td>
                            <td><a href="{{route('anonses.edit', $anons->id)}}" class="fa fa-pencil"></a>
                                {{Form::open(['route'=>['anonses.destroy', $anons->id], 'method'=>'delete'])}}
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