<div class="col-lg-12 item">
    <div class="item-area" style="padding: 4px; border-radius: 4px; margin-bottom:4px; border: 1px solid #dedede; height: 41px">
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <input type="text" class="form-control form-control-sm label-box" placeholder="Field Name" name="fields[label][]" value="{{ isset($field) ? $field['label'] : '' }}">
                </div>
            </div>
            <div class="col-lg-1">
                <div class="form-group m-0">
                    <select name="fields[form][]" id=""
                            class="form-control form-control-sm">
                        <option value="">Form Type</option>
                        <option{{ isset($field) && $field['form'] == 'text' ? ' selected' : '' }}>text</option>
                        <option{{ isset($field) && $field['form'] == 'textarea' ? ' selected' : '' }}>textarea</option>
                        <option{{ isset($field) && $field['form'] == 'select' ? ' selected' : '' }}>select</option>
                        <option{{ isset($field) && $field['form'] == 'image' ? ' selected' : '' }}>image</option>
                        <option{{ isset($field) && $field['form'] == 'images' ? ' selected' : '' }}>images</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-1">
                <div class="form-group m-0">
                    <select name="fields[table_type][]" id=""
                            class="form-control form-control-sm">
                        <option value="">Database Type</option>
                        <option{{ isset($field) && $field['table_type'] == 'string' ? ' selected' : '' }}>string</option>
                        <option{{ isset($field) && $field['table_type'] == 'text' ? ' selected' : '' }}>text</option>
                        <option{{ isset($field) && $field['table_type'] == 'longText' ? ' selected' : '' }}>longText</option>
                        <option{{ isset($field) && $field['table_type'] == 'boolean' ? ' selected' : '' }}>boolean</option>
                        <option{{ isset($field) && $field['table_type'] == 'integer' ? ' selected' : '' }}>integer</option>
                        <option{{ isset($field) && $field['table_type'] == 'date' ? ' selected' : '' }}>date</option>
                        <option{{ isset($field) && $field['table_type'] == 'datetime' ? ' selected' : '' }}>datetime</option>
                        <option{{ isset($field) && $field['table_type'] == 'timestamp' ? ' selected' : '' }}>timestamp</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group m-0">
                    <select name="fields[type][]" id=""
                            class="form-control form-control-sm">
                        <option value="">Type (ex. hasMany, array etc.)</option>
                        <option{{ isset($field) && $field['type'] == 'array' ? ' selected' : '' }}>array</option>
                        <option{{ isset($field) && $field['type'] == 'hasOne' ? ' selected' : '' }}>hasOne</option>
                        <option{{ isset($field) && $field['type'] == 'hasMany' ? ' selected' : '' }}>hasMany</option>
                        <option{{ isset($field) && $field['type'] == 'belongsTo' ? ' selected' : '' }}>belongsTo</option>
                        <option{{ isset($field) && $field['type'] == 'belongsToMany' ? ' selected' : '' }}>belongsToMany</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group m-0">
                    <input type="text" class="form-control form-control-sm" placeholder="Values" name="fields[values][]" value="{{ isset($field) && isset($field['values']) ? json_encode($field['values']) : '' }}">
                </div>
            </div>
            <input type="hidden" {{ isset($field) && $field['required'] ? 'data-' : ''  }}name="fields[required][]" value="0">
            <input type="hidden" {{ isset($field) && $field['column'] ? 'data-' : ''  }}name="fields[column][]" value="0">
            <input type="hidden" {{ isset($field) && $field['only_main_lang'] ? 'data-' : ''  }}name="fields[only_main_lang][]" value="0">
            <div class="col-lg-3">
                <div class="form-group m-0">
                    <div class="custom-control custom-checkbox" style="width:50px; float: left;"  title="Required">
                        <input type="checkbox" class="custom-control-input attr-item" {{ isset($field) && $field['required'] ? '' : 'data-'  }}name="fields[required][]" id="customCheckDisabled1{{ isset($index) ? $index : 1 }}" data-toggle="tooltip" value="1"{{ isset($field) && $field['required'] ? ' checked' : ''  }}>
                        <label class="custom-control-label" for="customCheckDisabled1{{ isset($index) ? $index : 1 }}">R</label>
                    </div>
                    <div class="custom-control custom-checkbox" style="width:50px; float: left;" title="Column">
                        <input type="checkbox" class="custom-control-input attr-item" {{ isset($field) && $field['column'] ? '' : 'data-'  }}name="fields[column][]" id="customCheckDisabled2{{ isset($index) ? $index : 1 }}" data-toggle="tooltip" value="1"{{ isset($field) && $field['column'] ? ' checked' : ''  }}>
                        <label class="custom-control-label" for="customCheckDisabled2{{ isset($index) ? $index : 1 }}">C</label>
                    </div>
                    <div class="custom-control custom-checkbox" style="width:50px; float: left;" title="Show only Default Language">
                        <input type="checkbox" class="custom-control-input attr-item" {{ isset($field) && $field['only_main_lang'] ? '' : 'data-'  }}name="fields[only_main_lang][]" id="customCheckDisabled3{{ isset($index) ? $index : 1 }}" data-toggle="tooltip" value="1"{{ isset($field) && $field['only_main_lang'] ? ' checked' : ''  }}>
                        <label class="custom-control-label" for="customCheckDisabled3{{ isset($index) ? $index : 1 }}">L</label>
                    </div>
                </div>
            </div>
            <div class="col-lg-1">
                <button type="button" class="btn btn-danger float-right btn-sm delete-row" onClick="delete_row(this)"><i class="icon-close"></i></button>
            </div>
        </div>
    </div>
</div>
