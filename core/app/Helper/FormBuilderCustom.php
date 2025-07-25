<?php

namespace App\Helper;

use App\Models\FormBuilder;
use Illuminate\Support\Str;
use plugins\FormBuilder\SanitizeInput;

class FormBuilderCustom
{
    public static function render_form($id,$form_id = null,$action = null,$button_class = null,$form_class = null){
        $form_details = FormBuilder::find($id);
        if (empty($form_details)){
            return __('form not found');
        }

        $fields = self::render_fields($form_details->fields);
        $render_submit_button = self::render_submit_button($form_details->button_text,$button_class);
        $action = $action ?? route('custom.form.submit');
        $rand = Str::random(10);
        $csrf = '<input type="hidden" name="_token" value="'.csrf_token().'">';
        $google_recaptcha = '<input type="hidden" name="gcaptcha_token" id="gcaptcha_token" value="">';
        return <<<HTML
        <form action="{$action}" {$form_id} method="post" id="custom_form_builder_{$rand}" class="custom-form-builder-form message-contact-form {$form_class}" enctype="multipart/form-data">
            {$csrf}
            {$google_recaptcha}
        <input type="hidden" name="custom_form_id" value="{$id}">
        <div class="error-message"></div>
        {$fields}
        {$render_submit_button}
    </form>
    HTML;

    }
    private static function render_fields($fields): string
    {
        $fields = json_decode($fields);
        $output = '';

        foreach ($fields->field_type as $key => $type) {
            $name = $fields->field_name[$key] ?? null;
            $placeholder = $fields->field_placeholder[$key] ?? '';
            $required = $fields->field_required->$key ?? '';
            $mimes = $fields->mimes_type->$key ?? '';
            $options = [];

            if ($type === 'select' && isset($fields->select_options->$name)) {
                $options = $fields->select_options->$name;
            }

            $output .= self::get_field_by_type($type, $name, $placeholder, $options, $required, $mimes);
        }

        return $output;
    }

    private static function render_submit_button($text,$button_class = '') :string
    {
        $preloader = self::render_submit_preloader();
        $text = SanitizeInput::esc_html($text);
        return <<<HTML
        <div class="btn-wrapper">
            <button id="contact_form_btn" type="submit" class="submit-btn custom_submit_form_button {$button_class}">{$text}</button>
            {$preloader}
        </div>
        HTML;

    }
    private static function render_submit_preloader() :string
    {
        return <<<HTML
<div class="ajax-loading-wrap hide">
    <div class="sk-fading-circle">
        <div class="sk-circle1 sk-circle"></div>
        <div class="sk-circle2 sk-circle"></div>
        <div class="sk-circle3 sk-circle"></div>
        <div class="sk-circle4 sk-circle"></div>
        <div class="sk-circle5 sk-circle"></div>
        <div class="sk-circle6 sk-circle"></div>
        <div class="sk-circle7 sk-circle"></div>
        <div class="sk-circle8 sk-circle"></div>
        <div class="sk-circle9 sk-circle"></div>
        <div class="sk-circle10 sk-circle"></div>
        <div class="sk-circle11 sk-circle"></div>
        <div class="sk-circle12 sk-circle"></div>
    </div>
</div>
HTML;
    }

    private static function get_field_by_type($type, $name, $placeholder, $options = [], $requried = null, $mimes = null)
{
    if (empty($name)) return;

    $markup = '';
    $name = SanitizeInput::esc_html($name);
    $placeholder = SanitizeInput::esc_html($placeholder);
    $required_markup = !empty($requried) ? 'required="required"' : '';

    switch ($type) {
        case('email'):
        case('tel'):
        case('url'):
        case('date'):
            $markup = <<<HTML
<div class="form-group">
    <label for="{$name}">{$placeholder}</label>
    <input type="{$type}" id="{$name}" name="{$name}" class="form-control" placeholder="{$placeholder}" {$required_markup}>
</div>
HTML;
            break;

        case('textarea'):
            $markup = <<<HTML
<div class="form-group textarea">
    <label for="{$name}">{$placeholder}</label>
    <textarea name="{$name}" id="{$name}" cols="30" rows="3" class="form-control" placeholder="{$placeholder}" {$required_markup}></textarea>
</div>
HTML;
            break;

        case('file'):
            $mimes_type_markup = str_replace('mimes:', __('Accept File Type:') . ' ', $mimes);
            $markup = <<<HTML
<div class="form-group file">
    <label for="{$name}">{$placeholder}</label>
    <input type="file" id="{$name}" name="{$name}" class="form-control" {$required_markup}>
    <span class="help-info">{$mimes_type_markup}</span>
</div>
HTML;
            break;

        case('checkbox'):
            $markup = <<<HTML
<div class="form-group checkbox">
    <input type="checkbox" id="{$name}" name="{$name}" class="form-control" {$required_markup}>
    <label for="{$name}">{$placeholder}</label>
</div>
HTML;
            break;

        case('select'):
            $option_markup = '<option value="" selected disabled>' . $placeholder . '</option>';
            foreach ($options as $opt) {
                $option_markup .= '<option value="' . e($opt) . '">' . e($opt) . '</option>';
            }
            $markup = <<<HTML
<div class="form-group select">
    <label for="{$name}">{$placeholder}</label>
    <select id="{$name}" name="{$name}" class="form-control" {$required_markup}>
        {$option_markup}
    </select>
</div>
HTML;
            break;

        default:
            $markup = <<<HTML
<div class="form-group">
    <label for="{$name}">{$placeholder}</label>
    <input type="text" id="{$name}" name="{$name}" class="form-control" placeholder="{$placeholder}" {$required_markup}>
</div>
HTML;
            break;
    }

    return $markup;
}




    public  static function render_drag_drop_form_builder($content = '')
    {
        $output = '';

        $form_fields = json_decode($content);
        $output .= '<ul id="sortable" class="available-form-field main-fields">';
        if (!empty($form_fields)) {
            $select_index = 0;
            foreach ($form_fields->field_type as $key => $ftype) {
                $args = [];
                $required_field = '';
                if (property_exists($form_fields, 'field_required')) {
                    $filed_requirement = (array)$form_fields->field_required;
                    $required_field = !empty($filed_requirement[$key]) ? 'on' : '';
                }
                if ($ftype === 'select') {
                    $args['select_option'] = $form_fields->select_options[$select_index] ?? '';
                    $select_index++;
                }
                if ($ftype === 'file') {
                    $args['mimes_type'] = $form_fields->mimes_type->$key ?? '';
                }
                $output .= self::form_builder_field_markup($key, $ftype, $form_fields->field_name[$key], $form_fields->field_placeholder[$key], $required_field, $args);
            }
        } else {
            $output .= self::form_builder_field_markup('1', 'text', 'your-name', 'Your Name', '');
        }

        $output .= '</ul>';
        return $output;
    }

    private static function form_builder_field_markup($key, $type, $name, $placeholder, $required, $args = [])
    {
        $name = SanitizeInput::esc_html($name);
        $placeholder = SanitizeInput::esc_html($placeholder);
        $required_check = !empty($required) ? 'checked' : '';
        $output = '<li class="ui-state-default">
                     <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                    <span class="remove-fields">x</span>
                    <a data-toggle="collapse" href="#fileds_collapse_' . $key . '" role="button"
                       aria-expanded="false" aria-controls="collapseExample">
                        ' . ucfirst($type) . ': <span
                                class="placeholder-name">' . $placeholder . '</span>
                    </a>';
        $output .= '<div class="collapse" id="fileds_collapse_' . $key . '">
            <div class="card card-body margin-top-30">
                <input type="hidden" class="form-control" name="field_type[]"
                       value="' . $type . '">
                <div class="form-group">
                    <label>' . __('Name') . '</label>
                    <input type="text" class="form-control " name="field_name[]"
                           placeholder="' . __('enter field name') . '"
                           value="' . $name . '" >
                </div>
                <div class="form-group">
                    <label>' . __('Placeholder/Label') . '</label>
                    <input type="text" class="form-control field-placeholder"
                           name="field_placeholder[]" placeholder="' . __('enter field placeholder/label') . '"
                           value="' . $placeholder . '" >
                </div>
                <div class="form-group">
                    <label ><strong>' . __('Required') . '</strong></label>
                    <label class="switch">
                        <input type="checkbox" class="field-required" ' . $required_check . ' name="field_required[' . $key . ']">
                        <span class="slider onff"></span>
                    </label>
                </div>';
        if ($type === 'select') {
            $output .= '<div class="form-group">
                        <label>' . __('Options') . '</label>
                            <textarea name="select_options[]" class="form-control max-height-120" cols="30" rows="10"
                                required>' . SanitizeInput::esc_html($args['select_option']) . '</textarea>
                           <small>' . __('separate option by new line') . '</small>
                    </div>';
        }
        if ($type === 'file') {
            $output .= '<div class="form-group"><label>' . __('File Type') . '</label><select name="mimes_type[' . $key . ']" class="form-control mime-type">';
            $output .= '<option value="mimes:jpg,jpeg,png"';
            if (isset($args['mimes_type']) && $args['mimes_type'] == 'mimes:jpg,jpeg,png') {
                $output .= "selected";
            }
            $output .= '>' . __('mimes:jpg,jpeg,png') . '</option>';

            $output .= '<option value="mimes:txt,pdf"';
            if (isset($args['mimes_type']) && $args['mimes_type'] == 'mimes:txt,pdf') {
                $output .= "selected";
            }
            $output .= '>' . __('mimes:txt,pdf') . '</option>';

            $output .= '<option value="mimes:doc,docx"';
            if (isset($args['mimes_type']) && $args['mimes_type'] == 'mimes:mimes:doc,docx') {
                $output .= "selected";
            }
            $output .= '>' . __('mimes:mimes:doc,docx') . '</option>';

            $output .= '<option value="mimes:doc,docx,jpg,jpeg,png,txt,pdf"';
            if (isset($args['mimes_type']) && $args['mimes_type'] == 'mimes:doc,docx,jpg,jpeg,png,txt,pdf') {
                $output .= "selected";
            }
            $output .= '>' . __('mimes:doc,docx,jpg,jpeg,png,txt,pdf') . '</option>';

            $output .= '</select></div>';
        }
        $output .= '</div></div></li>';

        return $output;
    }

}