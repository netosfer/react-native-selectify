<?php

namespace App\Http\Controllers\Backend;

use App\Models\setting;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SettingsBackendController extends BackendController
{

    public function index(Request $request)
    {
        $columns = ["site_title" => __("settings.site_title")];
        if ($request->ajax()) {
            $data = setting::where('lang', $this->default_lang['shortname'])->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="' . route('settings.edit', ["uniq_key" => $row->uniq_key]) . '" class="btn btn-warning"><i class="icon-note"></i> '.__('global.edit').'</a>
                              <a href="javascript:;" class="btn btn-danger delete-button" onClick="swalert(this)" data-url="' . route('settings.delete', ["uniq_key" => $row->uniq_key]) . '" data-table=".setting_datatable"><i class="icon-trash"></i> '.__('global.delete').'</a>
                            </div>';
                    return $btn;
                })
                ->addColumn('select_item', static function ($row) {
                    return '<div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input bulk-item" id="bulk_item' . $row->uniq_key . '" name="bulk_item[]" value="' . $row->uniq_key . '">
                          <label class="custom-control-label" for="bulk_item' . $row->uniq_key . '"></label>
                        </div>';
                })
                ->rawColumns(['action', 'select_item'])
                ->make(true);
        }
        return $this->render('backend.settings.index', ['table_columns' => $columns]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $validate = $request->validate(["logo" => "required", "footer_logo" => "required", "favicon" => "nullable", "site_title." . $lang->shortname => "required", "site_description." . $lang->shortname => "required", "admin_email." . $lang->shortname => "required", "copyright." . $lang->shortname => "required", "cookie_alert" => "nullable", "color" => "required", "html_codes" => "nullable", "social_links" => "nullable", "smtp_configurations" => "nullable", "google_recaptcha" => "nullable"]);
        } catch (\Throwable $err) {
            session()->flash("flash_notification", [
                "level" => "danger",
                "message" => __('settings.added_message')
            ]);
        }
        $uniq_key = $this->helper->uniq_generate();
        foreach ($this->languages as $lang) {
            $values = $request->only("logo", "footer_logo", "favicon", "site_title." . $lang->shortname, "site_description." . $lang->shortname, "admin_email." . $lang->shortname, "copyright." . $lang->shortname, "cookie_alert", "color", "html_codes", "smtp_configurations", "google_recaptcha");
            $new_values = ['uniq_key' => $uniq_key];
            $new_values['lang'] = $lang->shortname;

            $socials = [];
            for ($i = 0; $i < count($request->social['link']); $i++) {
                $add['icon'] = $request->social['icon'][$i];
                $add['link'] = $request->social['link'][$i];
                $socials[] = $add;
            }
            $new_values['social_links'] = $socials;

            foreach ($values as $key => $val) {
                if (is_array($val)) {
                    $new_values[$key] = $val[$lang->shortname];
                } else {
                    $new_values[$key] = $val;
                }
            }
            $setting = new setting($new_values);
            $setting->save();
        }

        session()->flash("flash_notification", [
            "level" => "success",
            "message" => __('settings.added_message')
        ]);
        return redirect()->route('settings.index');
    }

    public function show($uniq_key=null)
    {
        $setting = [];
        $socials = [['icon' => '', 'link' => '']];
        $uniq_key = $uniq_key ?? (new \MainHelper())->uniq_generate();
        foreach ($this->languages as $lang) {
            $setting[$lang->shortname] = setting::where('lang', $lang->shortname)->first();
            if ($lang->default && $setting[$lang->shortname]) {
                $uniq_key = $setting[$lang->shortname]->uniq_key;
                $socials = $setting[$lang->shortname]->social_links;
            }
        }
        return $this->render('backend.settings.form', ['setting' => $setting, 'socials' => $socials, 'uniq_key' => $uniq_key]);
    }

    public function update(Request $request, $uniq_key): \Illuminate\Http\RedirectResponse
    {
        try {
            foreach ($this->languages as $lang) {
                $validate = $request->validate(["logo" => "required", "footer_logo" => "required", "favicon" => "nullable", "site_title." . $lang->shortname => "required", "site_description." . $lang->shortname => "required", "admin_email." . $lang->shortname => "required", "copyright." . $lang->shortname => "required", "cookie_alert" => "nullable", "color" => "required", "html_codes" => "nullable", "social_links" => "nullable", "smtp_configurations" => "nullable", "google_recaptcha" => "nullable"]);
            }
        } catch (\Throwable $err) {
            session()->flash("flash_notification", [
                "level" => "danger",
                "message" => __('settings.added_message')
            ]);
        }
        foreach ($this->languages as $lang) {
            $values = $request->only("logo", "footer_logo", "favicon", "site_title." . $lang->shortname, "site_description." . $lang->shortname, "admin_email." . $lang->shortname, "copyright." . $lang->shortname, "cookie_alert", "color", "html_codes", "social_links", "smtp_configurations", "google_recaptcha");
            $new_values = ['uniq_key' => $uniq_key];
            $new_values['lang'] = $lang->shortname;

            $socials = [];
            for ($i = 0; $i < count($request->social['link']); $i++) {
                $add['icon'] = $request->social['icon'][$i];
                $add['link'] = $request->social['link'][$i];
                $socials[] = $add;
            }
            $new_values['social_links'] = $socials;

            foreach ($values as $key => $val) {
                if (is_array($val)) {
                    print_r($val);
                    $new_values[$key] = $val[$lang->shortname] ?? $val[config('app.locale')];
                } else {
                    $new_values[$key] = $val;
                }
            }
            $setting = setting::updateOrCreate(['uniq_key' => $uniq_key, 'lang' => $lang->shortname], $new_values);
        }
        session()->flash("flash_notification", [
            "level" => "success",
            "message" => __('settings.updated_message')
        ]);
        return redirect()->route('settings.index');
    }

    public function destroy($uniq_key): int
    {
        return setting::where('uniq_key', $uniq_key)->delete();
    }

    public function bulk_delete(Request $request)
    {
        return setting::whereIn('uniq_key', $request->get('ids'))->delete();
    }

}
