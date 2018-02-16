<div class="form-horizontal">
    <div class="form-check form-check-inline">
        {!! Form::checkbox('in_shift',
                            1,
                            auth()->user()->inShift(),
                            [
                                'class' => "form-check-input",
                                 'id' => "in-shift"
                            ])
        !!}
        <label class="form-check-label" for="in-shift"> - In Shift</label>
    </div>
</div>