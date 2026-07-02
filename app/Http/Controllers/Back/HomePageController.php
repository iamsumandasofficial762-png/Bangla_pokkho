<?php

namespace App\Http\Controllers\Back;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\HomeCutomize;
use App\Models\HomePageSection;
use App\Models\HeroSlider;
use App\Support\HomePageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomePageController extends Controller
{

     /**
     * Constructor Method.
     *
     * Setting Authentication
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('adminlocalize');
    }


    public function index(){
        $sliders = HeroSlider::orderBy('sort_order')->orderBy('id')->get();
        $selectedSlider = request()->boolean('new')
            ? new HeroSlider([
                'status' => 'active',
                'overlay_enabled' => true,
                'overlay_color' => '#000000',
                'overlay_opacity' => 20,
                'sort_order' => ((int) $sliders->max('sort_order')) + ($sliders->isEmpty() ? 0 : 1),
            ])
            : ($sliders->firstWhere('id', request()->integer('slide')) ?? $sliders->first() ?? new HeroSlider([
                'status' => 'active',
                'overlay_enabled' => true,
                'overlay_color' => '#000000',
                'overlay_opacity' => 20,
                'sort_order' => 0,
            ]));

        return view('back.home-page.index', [
            'sliders' => $sliders,
            'selectedSlider' => $selectedSlider,
        ]);
    }

    public function updateBanglaPokkhoHome(Request $request)
    {
        $request->validate([
            'sections' => 'array',
            'images' => 'array',
        ]);
        $this->validateHomeImages($request);

        $inputSections = $request->input('sections', []);
        $existingSections = HomePageContent::all();
        $uploadedImages = $request->file('images', []);

        foreach (HomePageContent::keys() as $index => $key) {
            $data = $inputSections[$key] ?? [];
            $data['enabled'] = $request->boolean("sections.$key.enabled");
            $data = array_replace_recursive($existingSections[$key] ?? [], $data);
            if (in_array($key, ['recent_blog', 'all_blog_section']) && !$request->has("sections.$key.post_ids")) {
                $data['post_ids'] = [];
            }
            if ($key === 'faq_section') {
                $data['items'] = $inputSections[$key]['items'] ?? [];
            }
            $data = $this->normalizeHomeSectionData($data);
            $data = $this->mergeHomeSectionImages($data, $uploadedImages[$key] ?? [], $existingSections[$key] ?? []);

            HomePageSection::updateOrCreate(
                ['section_key' => $key],
                [
                    'title' => $data['heading'] ?? $data['title'] ?? null,
                    'subtitle' => $data['label'] ?? $data['subtitle'] ?? null,
                    'content' => $data['description'] ?? null,
                    'data' => $data,
                    'is_enabled' => (bool) ($data['enabled'] ?? true),
                    'sort_order' => $index,
                ]
            );
        }

        return redirect()->back()->withSuccess(__('Home page updated successfully.'));
    }

    private function validateHomeImages(Request $request)
    {
        $rules = [];
        $this->collectHomeImageRules($request->allFiles()['images'] ?? [], 'images', $rules);

        if ($rules) {
            $request->validate($rules);
        }
    }

    private function collectHomeImageRules($files, $prefix, array &$rules)
    {
        foreach ($files as $key => $value) {
            $path = $prefix . '.' . $key;

            if (is_array($value)) {
                $this->collectHomeImageRules($value, $path, $rules);
            } else {
                $rules[$path] = 'image|mimes:jpg,jpeg,png,webp';
            }
        }
    }

    private function normalizeHomeSectionData(array $data)
    {
        foreach (['post_ids', 'small_post_ids'] as $key) {
            if (isset($data[$key]) && is_array($data[$key])) {
                $data[$key] = array_values(array_filter($data[$key]));
            }
        }

        foreach (['cards', 'features', 'tabs', 'items'] as $key) {
            if (isset($data[$key]) && is_array($data[$key])) {
                $data[$key] = array_values($data[$key]);
            }
        }

        if (isset($data['tabs']) && is_array($data['tabs'])) {
            foreach ($data['tabs'] as $tabIndex => $tab) {
                $bullets = $tab['bullets'] ?? [];
                if (is_string($bullets)) {
                    $bullets = preg_split('/\r\n|\r|\n/', $bullets);
                }
                $data['tabs'][$tabIndex]['bullets'] = array_values(array_filter(array_map('trim', (array) $bullets)));
            }
        }

        return $data;
    }

    private function mergeHomeSectionImages(array $data, array $files, array $existing)
    {
        foreach ($files as $field => $value) {
            if (is_array($value)) {
                foreach ($value as $index => $nestedFiles) {
                    foreach ((array) $nestedFiles as $nestedField => $file) {
                        if ($file) {
                            $old = $existing[$field][$index][$nestedField] ?? null;
                            $data[$field][$index][$nestedField] = $this->storeHomeImage($file, $old);
                        }
                    }
                }
            } elseif ($value) {
                $data[$field] = $this->storeHomeImage($value, $existing[$field] ?? null);
            }
        }

        return $data;
    }

    private function storeHomeImage($file, $old = null)
    {
        $name = ImageHelper::handleUploadedImage($file, 'images', $old);
        $storedPath = storage_path('app/public/images/' . $name);
        $publicPath = public_path('storage/images/' . $name);

        File::ensureDirectoryExists(dirname($publicPath));
        if (File::exists($storedPath)) {
            File::copy($storedPath, $publicPath);
        }

        if ($old && $old !== $name) {
            File::delete(public_path('storage/images/' . $old));
        }

        return $name;
    }

    public function hero_banner_update(Request $request)
    {
        $request->validate([
            'img1' => 'image',
            'img2' => 'image',
            'title1' => 'required|max:200',
            'title2' => 'required|max:200',
            'subtitle1' => 'required|max:200',
            'url1' => 'required|max:200',
            'url2' => 'required|max:200',

        ]);
        $all_images_names = ['img1','img2'];
        $input = $request->all();
        foreach($all_images_names as $single_image){
            if($request->hasFile($single_image)){
                $data = HomeCutomize::first();
                $check = json_decode($data->hero_banner,true);
                $input[$single_image] = ImageHelper::handleUploadedImage($request->$single_image,'images',isset($check[$single_image]) ? $check[$single_image] : null);
            }
        }

        unset($input['_token']);
        $data = HomeCutomize::first();
        foreach(json_decode($data->hero_banner,true) as $key => $value){
            if(isset($input[$key])){
                $input[$key] =  $input[$key];
            }else{
                $input[$key] = $value;
            }
        }


        $data->hero_banner = json_encode($input,true);
        $data->update();
        return redirect()->back()->withSuccess(__('Banner Update Successfully'));

    }
    public function first_banner_update(Request $request)
    {
        $request->validate([
            'img1' => 'image',
            'img2' => 'image',
            'img3' => 'image',
            'firsturl1' => 'required|max:200',
            'firsturl2' => 'required|max:200',
            'firsturl3' => 'required|max:200',
        ]);
        $all_images_names = ['img1','img2','img3'];

        $input = $request->all();

        $data = HomeCutomize::first();

        foreach($all_images_names as $single_image){
            if($request->hasFile($single_image)){
                $data = HomeCutomize::first();
                $check = json_decode($data->banner_first,true);
                $input[$single_image] = ImageHelper::handleUploadedImage($request->$single_image,'images',$check[$single_image]);
            }else{
                $check = json_decode($data->banner_first,true);
                $input[$single_image] = $check[$single_image];
            }
        }

        unset($input['_token']);


        $data->banner_first = json_encode($input,true);
        $data->update();
        return redirect()->back()->withSuccess(__('Banner Update Successfully'));

    }

    public function secend_banner_update(Request $request)
    {
        $request->validate([
            'img1' => 'image',
            'img2' => 'image',
            'img3' => 'image',
            'url1' => 'required|max:200',
            'url2' => 'required|max:200',
            'url3' => 'required|max:200',
        ]);
        $all_images_names = ['img1','img2','img3'];
        $input = $request->all();

        $data = HomeCutomize::first();

        foreach($all_images_names as $single_image){
            if($request->hasFile($single_image)){
                $data = HomeCutomize::first();
                $check = json_decode($data->banner_secend,true);
                $input[$single_image] = ImageHelper::handleUploadedImage($request->$single_image,'images',$check[$single_image]);
            }else{
                $check = json_decode($data->banner_secend,true);
                $input[$single_image] = $check[$single_image];
            }
        }

        unset($input['_token']);


        $data->banner_secend = json_encode($input,true);
        $data->update();
        return redirect()->back()->withSuccess(__('Banner Update Successfully'));

    }

    public function third_banner_update(Request $request)
    {

        $request->validate([
            'img1' => 'image',
            'img2' => 'image',
            'url1' => 'required|max:200',
            'url2' => 'required|max:200',
        ]);
        $all_images_names = ['img1','img2'];

        $input = $request->all();
        $data = HomeCutomize::first();

        foreach($all_images_names as $single_image){
            if($request->hasFile($single_image)){
                $data = HomeCutomize::first();
                $check = json_decode($data->banner_third,true);
                $input[$single_image] = ImageHelper::handleUploadedImage($request->$single_image,'images',$check[$single_image]);
            }else{
                $check = json_decode($data->banner_third,true);
                $input[$single_image] = $check[$single_image];
            }
        }
        unset($input['_token']);




        $data->banner_third = json_encode($input,true);
        $data->update();
        return redirect()->back()->withSuccess(__('Banner Update Successfully'));

    }


    public function popular_category_update(Request $request)
    {
        $request->validate([
            'popular_title' => 'required|max:255',
        ]);
        $input = $request->all();
        unset($input['_token']);
        $data = HomeCutomize::first();
        $data->popular_category = json_encode($input,true);
        $data->update();
        return redirect()->back()->withSuccess(__('Popular Category Update Successfully'));
    }

    public function tree_column_category_update(Request $request)
    {
        $input = $request->all();
        unset($input['_token']);
        $data = HomeCutomize::first();
        $data->two_column_category = json_encode($input,true);
        $data->update();
        return redirect()->back()->withSuccess(__('Tree Column Category Update Successfully'));
    }


    public function feature_category_update(Request $request)
    {
        $request->validate([
            'feature_title' => 'required|max:255',
        ]);
        $input = $request->all();
        unset($input['_token']);
        $data = HomeCutomize::first();
        $data->feature_category = json_encode($input,true);
        $data->update();
        return redirect()->back()->withSuccess(__('Popular Category Update Successfully'));
    }


    public function homepage4update(Request $request)
    {
        $request->validate([
            'img1' => 'image',
            'img2' => 'image',
            'img3' => 'image',
            'img4' => 'image',
            'img5' => 'image',
            'url1' => 'required|max:200',
            'url2' => 'required|max:200',
            'url3' => 'required|max:200',
            'url4' => 'required|max:200',
            'url5' => 'required|max:200',
            'label1' => 'required|max:200',
            'label2' => 'required|max:200',
            'label3' => 'required|max:200',
            'label4' => 'required|max:200',
            'label5' => 'required|max:200',
        ]);
        $all_images_names = ['img1','img2','img3','img4','img5'];
        $input = $request->all();
        foreach($all_images_names as $single_image){
            if($request->hasFile($single_image)){
                $data = HomeCutomize::first();
                $check = json_decode($data->home_page4,true);
                $input[$single_image] = ImageHelper::handleUploadedImage($request->$single_image,'images',$check[$single_image]);
            }
        }

        unset($input['_token']);

        $data = HomeCutomize::first();
        if(!$data->home_page4){
        $data->home_page4 = json_encode($input,true);
        $data->update();
        }else{
            foreach(json_decode($data->home_page4,true) as $key => $value){
                if(isset($input[$key])){
                    $input[$key] =  $input[$key];
                }else{
                    $input[$key] = $value;
                }
            }
            $data->home_page4 = json_encode($input,true);
            $data->update();
        }

        return redirect()->back()->withSuccess(__('Banner Update Successfully'));


    }


    public function homepage4categoryupdate(Request $request)
    {
       $category = json_encode($request->home_4_popular_category,true);
       $data = HomeCutomize::first();
       $data->home_4_popular_category = $category;
       $data->update();
       return redirect()->back()->withSuccess(__('Banner Update Successfully'));

    }
}
