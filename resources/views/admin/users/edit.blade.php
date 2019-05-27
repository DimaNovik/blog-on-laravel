@extends('admin.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Сторінка редагування користувачів
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            {{Form::open([
                'route' => ['users.update', $user->id],
                'method' => 'put'
            ])}}
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Редагувати користувачя</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">ПІБ</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$user->name}}" name="name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Логін</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$user->login}}" name="login">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Пароль</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$user->password}}" name="password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$user->email}}" name="email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Телефон</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$user->phone}}" name="phone">
                        </div>
                        <!-- checkbox -->
                        <div class="form-group">
                            <label>
                                {{Form::checkbox('status', '1', $user->is_admin, ['class'=>'minimal'])}}
                            </label>
                            <label>
                                Адміністратор
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                {{Form::checkbox('status', '1', $user->is_active, ['class'=>'minimal'])}}
                            </label>
                            <label>
                                Активувати користувачв
                            </label>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-default">Назад</button>
                    <button class="btn btn-warning pull-right">Змінити</button>
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
            {{Form::close()}}
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection