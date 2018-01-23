@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Sopa de letras</div>

                <div class="panel-body">

                    @if (session('status'))
                        <div class="alert alert-success">
                            estado de la session {{ session('status') }}
                        </div>

                    @endif


                        <form method="POST" id ='form-sopa' name='form-sopa' action="//sopa/generarsopa">
                            {{ csrf_field() }}



                        <div class="form-group">
                            <label for="titulo_filas">Filas</label>
                            <input class="form-control " id="txt_filas" name="txt_filas" type="text">
                            <label for="txt_filas-error" class="error" id="txt_filas-error"></label>



                        </div>


                        <div class="form-group">
                            <label for="titulo_columnas">Columnas</label>
                            <input class="form-control" id="txt_columnas" name="txt_columnas" type="text">
                            <label for="txt_columnas-error" class="error" id="txt_columnas-error"></label>

                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Generar</button>

                        </div>

                        </form>



                        <div class="form-group">
                            <label for="buscar">Palabra a buscar</label>
                            <input class="form-control" id="txt_buscar" name="txt_buscar" type="text" value ="OIE" required >
                        </div>

                        <div class="form-group">

                            <table id="tabla_sopa" name=="tabla_sopa" class="table table-bordered">
                                    <thead>
                                    </thead>
                                <tbody>


                                </tbody>

                            </table>

                        </div>

                        <div class="form-group">
                            <h3>Salida : <span class="semi-bold" name="salida" id="salida">0</span></h3>
                        </div>

                        <div class="form-group">
                            <button type="button" id="btn-generar" name="btn-generar" class="btn btn-primary">Encontrar palabra</button>
                        </div>

                </div>
        </div>
    </div>
</div>
@endsection

@section('script')

        <script type="text/javascript">



        </script>

@endsection

