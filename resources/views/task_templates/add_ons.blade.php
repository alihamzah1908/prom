<div id="main_target">
    @if(count($section))
        <div class="card">
            <div class="card-body">
            @foreach($section as $section)
                <div class="card">
                    <div class="card-header">
                        <input class="card-title input-transparent section_name" value="{{$section->name}}" name="section_name[]">
                        <div class="card-tools"></div>
                    </div>
                    <div class="card-body row card_body_target" id="{{$section->section_id}}">
                        @foreach(\App\TemplatesAddOns::where('id_section', $section->id)->orderBy('id','ASC')->get() as $field)
                            <?php $encode = ['id' => $field->field_id, 'name' => $field->name, 'type' => $field->type, 'default_value' => $field->default_value, 'parent' => isset($field->section)?$field->section->section_id:'',]; ?>
                            <div class="form-group tooltip col-md-6 handle" data-type="{{$field->type}}">
                                @if($field->type == "EMPTY_ROW")
                                <input class='form-field' hidden id="{{$field->field_id}}" data-field="{{json_encode($encode)}}" hidden>
                                <span class="tooltiptext">Empty Row</span>
                                @else
                                <label>{{$field->name}}</label>
                                <input class='form-control form-field' placeholder="{{$field->name}}" type="{{$field->type}}" id="{{$field->field_id}}" 
                                      data-field="{{json_encode($encode)}}" autocomplete="{{$field['autocomplete']}}" readonlys value="{{$field->default_value}}">
                                <span class="tooltiptext">Double Click to modify!</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            </div>
            <div class="card-footer">
                <a class="btn btn-sm btn-success text-light save-form-template-add-ons" data-action="/setup/template-form/{{$id_template}}/template_add_ons?id={{request()->id}}">
                    Save Add-Ons
                </a>
            </div>
        </div>
    @else
    <div class="card">
        <div class="card-header">
            <input class="card-title input-transparent section_name" value="Section Name" name="section_name[]">
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body row card_body_target" id="{{random_code(5)}}"></div>
        <div class="card-footer">
            <a class="btn btn-sm btn-success text-light save-form-template-add-ons" data-action="/setup/template-form/{{$id_template}}/template_add_ons?id={{request()->id}}">
                Save Add-Ons
            </a>
        </div>
    </div>
    @endif
</div>