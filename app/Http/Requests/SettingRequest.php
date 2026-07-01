<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(isset($this->is_validate)){
            return [
                'title' => 'required|max:255',
                'footer_address' => 'required|max:255',
                'footer_phone' => 'required|max:255',
                'footer_email' => 'required|max:255',
                'copy_right' => 'required|max:255',
                'friday_start' => 'required|max:255',
                'friday_end' => 'required|max:255',
                'working_days_from_to' => 'required|max:255',
                'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg,ico|max:2048',
                'meta_image' => 'nullable|image|mimes:jpeg,jpg,png,webp,svg|max:4096',
                'loader' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg,ico|max:2048',
                'favicon' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg,ico|max:2048',
                'feature_image' => 'mimes:jpeg,jpg,png,svg',
                'home_background' => 'mimes:jpeg,jpg,png,svg',
                'breadcumb_background' => 'mimes:jpeg,jpg,png,svg',
                'footer_background' => 'mimes:jpeg,jpg,png,svg',
                'popup_banner' => 'mimes:jpeg,jpg,png,svg',
                'footer_gateway_img' => 'mimes:jpeg,jpg,png,svg'
            ];
        }else{
            return [

            ];
        }

    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'logo.image' => __('Logo must be a valid image.'),
            'logo.mimes' => __('Logo image type must be jpg, jpeg, png, webp, svg, or ico.'),
            'logo.max' => __('Logo image must not be larger than 2 MB.'),
            'loader.image' => __('Loader must be a valid image.'),
            'loader.mimes' => __('Loader image type must be jpg, jpeg, png, webp, svg, or ico.'),
            'loader.max' => __('Loader image must not be larger than 2 MB.'),
            'favicon.image' => __('Favicon must be a valid image.'),
            'favicon.mimes' => __('Favicon image type must be jpg, jpeg, png, webp, svg, or ico.'),
            'favicon.max' => __('Favicon image must not be larger than 2 MB.'),
            'meta_image.image' => __('Meta image must be a valid image.'),
            'meta_image.mimes' => __('Meta image type must be jpg, jpeg, png, webp, or svg.'),
            'meta_image.max' => __('Meta image must not be larger than 4 MB.'),
            'feature_image.mimes'    => __('Feature Image type must be jpg,jpeg,png,svg.'),
            'home_background.mimes'    => __('Background Image type must be jpg,jpeg,png,svg.'),
            'breadcumb_background.mimes'    => __('Background Image type must be jpg,jpeg,png,svg.'),
            'footer_background.mimes'    => __('Background Image type must be jpg,jpeg,png,svg.'),
            'popup_banner.mimes'    => __('Popup Banner must be jpg,jpeg,png,svg.'),
        ];
    }

}
