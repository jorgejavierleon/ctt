<div class="row">
    <div class="col-md-6">
        {{-- name --}}
        <div class="form-group <?php if ($errors->has('name')) echo 'has-error has-feedback'; ?>">
            {!! Form::label('name', 'Nombre *', ['class' => 'control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
            {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
    <div class="col-md-6">
        {{-- email --}}
        <div class="form-group <?php if ($errors->has('email')) echo 'has-error has-feedback'; ?>">
            {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
            {!! Form::text('email', null, ['class' => 'form-control']) !!}
            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        {!! Form::submit('Guardar', ['class' => 'btn btn-success pull-right']) !!}
    </div>
</div>