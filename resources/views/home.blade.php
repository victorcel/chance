@extends('layouts.app')

@section('content')
    <div class="container" >
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Anotar Tu Chance</div>

                    <div class="panel-body">
                       @include('layouts.error')

                        {!! Form::open(['route' => 'chance.store', 'method' => 'post'] ) !!}
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="auth-form-body mt-3">

                            <div class="form-group">

                            </div>
                            <div class="form-group">

                            </div>
                            <input id="numero" type="text" v-model="getCedula" class="form-control col-md-offset-4"
                                   name="numero" style="width:220px;height: 70px;text-align: center;font-size: 50px"
                                   required minlength="3" readonly>
                            {!! Form::submit('GENERAR NÚMERO DE LA SUERTE', ['class' => ' col-md-offset-4','style'=>'width:220px;height: 70px;text-align: center;background:#2693ff; color:#fff','@click.prevent="numSuerte(Math.floor(Math.random()* (9999 - 99) + 99))"']) !!}
                            </br>
                            <div class="row">
                                <div class="col-md-2 col-md-offset-4">
                                    @include('layouts.teclado')
                                </div>
                            </div>
                        </div>
                        {!! Form::submit('CHANCE', ['class' => 'btn btn-success btn-lg pull-left','style'=>'width:100px;height: 70px;text-align: center']) !!}
                        {!! Form::submit('BORRAR ', ['class' => 'btn btn-danger btn-lg pull-right','style'=>'width:100px;height: 70px;text-align: center','@click.prevent="borrarTarjeta"']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
@endsection
