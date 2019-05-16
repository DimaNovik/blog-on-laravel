@extends ('admin.layout')

@section ('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Додати категорію
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                {!! Form::open(['route'=> 'categories.store']) !!}
                <div class="box-header with-border">
                    <h3 class="box-title">Додати категорію</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Назва категорії</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="title">


                        </div>

                        <div class="form-group">
                            <label>
                                <input type="number" class="minimal" name="parent" id="parent" value="0">
                            </label>
                            <label>
                                Батьківська категорія
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Посилання</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="link">
                        </div>

                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-default">Назад</button>
                    <button class="btn btn-success pull-right">Додати</button>
                </div>
                <!-- /.box-footer-->
                {!! Form::close(); !!}
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection