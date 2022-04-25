<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BuildingProductRequest;
use App\Http\Requests\Backend\CarProductRequest;
use App\Http\Requests\Backend\JobRequest;
use App\Http\Requests\Backend\MedicalRequest;
use App\Http\Requests\Backend\ProductRequest;
use App\Models\About;
use App\Models\Adv;
use App\Models\BuildingCategory;
use App\Models\BuildingProduct;
use App\Models\CarCategory;
use App\Models\CarProduct;
use App\Models\CarType;
use App\Models\Category;
use App\Models\City;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\Like;
use App\Models\Medical;
use App\Models\Product;
use App\Models\State;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    ######################################## Country - State - city ################################
    public function frontGetState(Request $request)
    {
        $states = State::whereCountryId($request->country_id)->whereStatus(true)->get(['id', 'name'])->toArray();
        return response()->json($states);
    }
    public function frontGetCity(Request $request)
    {
        $cities = City::whereStateId($request->state_id)->whereStatus(true)->get(['id', 'name'])->toArray();
        return response()->json($cities);
    }
    ######################################## Main ###################################################
    public function index()
    {
        return view('frontend.index');
    }
    ##################################################################################################
    ######################################## Building ################################################
    ##################################################################################################
    public function mainBuildings()
    {
        $buildingCategories = BuildingCategory::withCount(['products' => function ($query) {
            $query->where('status', '=', 1);
        }])->latest()->whereStatus(true)->get();
        return view('frontend.buildings.buildingMain', compact('buildingCategories'));
    }
    #####
    public function buildings(Request $request)
    {
        $buildingProducts = BuildingProduct::with('buildingCategory', 'firstMedia')->whereStatus(true)->where('building_category_id', $request->buildingCategory)->latest()->get();
        $buildingCategory = $request->buildingCategory;
        return view('frontend.buildings.buildings', compact('buildingProducts', 'buildingCategory'));
    }
    #####
    public function buildingDetails(Request $request)
    {
        $buildingDetails = BuildingProduct::with('buildingCategory', 'firstMedia')->whereStatus(true)->where('id', $request->buildingProduct)->first();
        return view('frontend.buildings.buildingDetails', compact('buildingDetails'));
    }
    #####
    public function buildingSearch(Request $request)
    {
        $buildingProducts = BuildingProduct::with('buildingCategory', 'firstMedia')
            ->whereStatus(true)->where('building_category_id', $request->buildingCategory)
            ->when(\request()->country_id != null, function ($query) {
                $query->whereCountryId(\request()->country_id);
            })
            ->when(\request()->state_id != null, function ($query) {
                $query->whereStateId(\request()->state_id);
            })
            ->when(\request()->city_id != null, function ($query) {
                $query->whereCityId(\request()->city_id);
            })
            ->latest()->get();
        $buildingCategory = $request->buildingCategory;
        return view('frontend.buildings.buildings', compact('buildingProducts', 'buildingCategory'));
    }
    ###### Like ######
    public function buildingLikeAndDislike(Request $request)
    {
        if (Auth::check()) {
            $isLike = Like::whereUserId(auth()->user()->id)
                ->whereProductId($request->product_id)
                ->whereType('BuildingProduct')
                ->first();
            if ($isLike) {
                $isLike->delete();
            } else {
                Like::create([
                    'user_id'    => auth()->user()->id,
                    'product_id' => $request->product_id,
                    'type'       => $request->type,
                ]);
            }
            return response()->json(['success' => 'Successfully']);
        }
    }
    ##################################################################################################
    ########################################   Cars   ################################################
    ##################################################################################################
    public function mainCars()
    {
        $carCategories = CarCategory::withCount(['products' => function ($query) {
            $query->where('status', '=', 1);
        }])->latest()->whereStatus(true)->get();
        return view('frontend.cars.carMain', compact('carCategories'));
    }
    #####
    public function carTypes(Request $request)
    {
        $carTypeIds = CarProduct::whereStatus(true)->where('car_category_id', $request->carCategory)->latest()->distinct()->pluck('car_type_id')->toArray();
        $carTypes = CarType::withCount(['products' => function ($query) {
            $query->where('status', '=', 1);
        }])->whereStatus(true)->whereIn('id', $carTypeIds)->latest()->get();
        $carCategory = $request->carCategory;
        return view('frontend.cars.carTypes', compact('carTypes', 'carCategory'));
    }
    #####
    public function carTypeSearch(Request $request)
    {
        $carProducts = CarProduct::with('carCategory', 'carType', 'firstMedia')
            ->whereStatus(true)
            ->where('car_category_id', $request->carCategory)
            ->when(\request()->car_type_id != null, function ($query) {
                $query->whereCarTypeId(\request()->car_type_id);
            })
            ->when(\request()->year != null, function ($query) {
                $query->where('year', (\request()->year));
            })
            ->latest()->get();

        $carCategory = $request->carCategory;
        $carType = $request->carType;
        return view('frontend.cars.cars', compact('carProducts', 'carType', 'carCategory'));
    }
    #####
    public function cars(Request $request)
    {
        $carProducts = CarProduct::with('carCategory', 'carType', 'firstMedia')
            ->whereStatus(true)
            ->where('car_type_id', $request->carType)
            ->latest()->get();

        $carCategory = $request->carCategory;
        $carType     = $request->carType;
        return view('frontend.cars.cars', compact('carProducts', 'carCategory', 'carType'));
    }
    #####
    public function carDetails(Request $request)
    {
        $carDetails = CarProduct::with('carCategory', 'carType', 'firstMedia')->whereStatus(true)->where('id', $request->carProduct)->first();
        return view('frontend.cars.carDetails', compact('carDetails'));
    }
    #####
    public function carSearch(Request $request)
    {
        $carProducts = CarProduct::with('carCategory', 'carType', 'firstMedia')
            ->whereStatus(true)
            ->where('car_category_id', $request->carCategory)
            ->where('car_type_id', $request->carType)
            ->when(\request()->country_id != null, function ($query) {
                $query->whereCountryId(\request()->country_id);
            })
            ->when(\request()->state_id != null, function ($query) {
                $query->whereStateId(\request()->state_id);
            })
            ->when(\request()->city_id != null, function ($query) {
                $query->whereCityId(\request()->city_id);
            })
            ->latest()->get();
        // dd($carProducts);
        $carCategory = $request->carCategory;
        $carType     = $request->carType;
        return view('frontend.cars.carSearch', compact('carProducts', 'carCategory', 'carType'));
    }
    ###### Like ######
    public function carLikeAndDislike(Request $request)
    {
        if (Auth::check()) {
            $isLike = Like::whereUserId(auth()->user()->id)
                ->whereProductId($request->product_id)
                ->whereType('CarProduct')
                ->first();
            if ($isLike) {
                $isLike->delete();
            } else {
                Like::create([
                    'user_id'    => auth()->user()->id,
                    'product_id' => $request->product_id,
                    'type'       => $request->type,
                ]);
            }
            return response()->json(['success' => 'Successfully']);
        }
    }

    ##################################################################################################
    ######################################## Medicals ################################################
    ##################################################################################################
    public function medicalMain()
    {
        return view('frontend.medicals.medicalMain');
    }
    #####
    public function medicals(Request $request)
    {
        // dd($request);
        if ($request->medicalType == 'Doctor') {
            $medicals = Medical::whereStatus(true)->where('medical_type', 'Doctor')->latest()->get();
            $title = 'الطب';
            $medicalType = 'Doctor';
        } elseif ($request->medicalType == 'Nurse') {
            $medicals = Medical::whereStatus(true)->where('medical_type', 'Nurse')->latest()->get();
            $title = 'التمريض';
            $medicalType = 'Nurse';
        } elseif ($request->medicalType == 'Medicine') {
            $medicals = Medical::whereStatus(true)->where('medical_type', 'Medicine')->latest()->get();
            $title = 'الصيدلة';
            $medicalType = 'Medicine';
        }

        return view('frontend.medicals.medicals', compact('medicals', 'title', 'medicalType'));
    }
    #####
    public function medicalDetails(Request $request)
    {

        $medicalDetails = Medical::whereStatus(true)->where('id', $request->medical)->first();
        return view('frontend.medicals.medicalDetails', compact('medicalDetails'));
    }
    #####
    public function medicalSearch(Request $request)
    {
        $medicals = Medical::whereStatus(true)->where('medical_type', $request->medicalType)
            ->when(\request()->country_id != null, function ($query) {
                $query->whereCountryId(\request()->country_id);
            })
            ->when(\request()->state_id != null, function ($query) {
                $query->whereStateId(\request()->state_id);
            })
            ->when(\request()->city_id != null, function ($query) {
                $query->whereCityId(\request()->city_id);
            })
            ->latest()->get();
        $medicalType = $request->medicalType;
        $title = $request->title;
        return view('frontend.medicals.medicals', compact('medicals', 'medicalType', 'title'));
    }
    ###### Like ######
    public function medicalLikeAndDislike(Request $request)
    {
        if (Auth::check()) {
            $isLike = Like::whereUserId(auth()->user()->id)
                ->whereProductId($request->product_id)
                ->whereType('MedicalProduct')
                ->first();
            if ($isLike) {
                $isLike->delete();
            } else {
                Like::create([
                    'user_id'    => auth()->user()->id,
                    'product_id' => $request->product_id,
                    'type'       => $request->type,
                ]);
            }
            return response()->json(['success' => 'Successfully']);
        }
    }

    ##################################################################################################
    ########################################  Jobs    ################################################
    ##################################################################################################
    public function jobMain()
    {
        $jobCategories = JobCategory::withCount(['jobs' => function ($query) {
            $query->where('status', '=', 1);
        }])
            ->latest()->whereStatus(true)->get();
        return view('frontend.jobs.jobMain', compact('jobCategories'));
    }
    #####
    public function jobCategorySearch(Request $request)
    {
        $jobCategories = JobCategory::withCount(['jobs' => function ($query) {
            $query->where('status', '=', 1);
        }])
            ->whereStatus(true)
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->latest()->get();
        return view('frontend.jobs.jobMain', compact('jobCategories'));
    }
    #####
    public function jobs(Request $request)
    {
        $jobs = Job::whereStatus(true)->where('job_category_id', $request->jobCategory)->latest()->get();
        $jobCategory = $request->jobCategory;
        return view('frontend.jobs.jobs', compact('jobs', 'jobCategory'));
    }
    #####
    public function jobSearch(Request $request)
    {
        $jobs = Job::whereStatus(true)->where('job_category_id', $request->jobCategory)
            ->when(\request()->country_id != null, function ($query) {
                $query->whereCountryId(\request()->country_id);
            })
            ->when(\request()->state_id != null, function ($query) {
                $query->whereStateId(\request()->state_id);
            })
            ->when(\request()->city_id != null, function ($query) {
                $query->whereCityId(\request()->city_id);
            })
            ->latest()->get();
        $jobCategory = $request->jobCategory;
        return view('frontend.jobs.jobs', compact('jobs', 'jobCategory'));
    }
    #####
    public function jobDetails(Request $request)
    {
        $jobDetails = Job::whereStatus(true)->where('id', $request->job)->first();
        return view('frontend.jobs.jobDetails', compact('jobDetails'));
    }
    ###### Like ######
    public function jobLikeAndDislike(Request $request)
    {
        if (Auth::check()) {
            $isLike = Like::whereUserId(auth()->user()->id)
                ->whereProductId($request->product_id)
                ->whereType('JobProduct')
                ->first();
            if ($isLike) {
                $isLike->delete();
            } else {
                Like::create([
                    'user_id'    => auth()->user()->id,
                    'product_id' => $request->product_id,
                    'type'       => $request->type,
                ]);
            }
            return response()->json(['success' => 'Successfully']);
        }
    }
    ##################################################################################################
    ######################################## Products ################################################
    ##################################################################################################
    public function productMain()
    {
        $productCategories = Category::whereParentId(null)->latest()->whereStatus(true)->get();
        return view('frontend.products.productMain', compact('productCategories'));
    }
    #######
    public function productSub(Request $request)
    {
        $productCategories = Category::whereParentId($request->parent_id)->latest()->whereStatus(true)->get();
        $category = Category::whereStatus('1')->whereId($request->parent_id)->first();
        return view('frontend.products.productSub', compact('productCategories', 'category'));
    }
    #####
    public function productCategoryMainSearch(Request $request)
    {
        $productCategories = Category::whereStatus(true)->whereParentId(null)
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->latest()->get();
        return view('frontend.products.productMain', compact('productCategories'));
    }
    #######
    public function productCategorySubSearch(Request $request)
    {
        // dd($request);
        $productCategories = Category::whereStatus(true)->where('parent_id', '!=', null)
            ->when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->latest()->get();

        $category = Category::whereStatus('1')->whereId($request->category)->first();
        return view('frontend.products.productSub', compact('productCategories', 'category'));
    }
    #####
    public function products(Request $request)
    {
        $products = Product::whereStatus(true)->where('category_id', $request->productCategory)->latest()->get();
        $category = Category::whereStatus('1')->whereId($request->productCategory)->first();
        return view('frontend.products.products', compact('products', 'category'));
    }
    #####
    public function productSearch(Request $request)
    {
        $products = Product::whereStatus(true)->where('category_id', $request->category)
            ->when(\request()->country_id != null, function ($query) {
                $query->whereCountryId(\request()->country_id);
            })
            ->when(\request()->state_id != null, function ($query) {
                $query->whereStateId(\request()->state_id);
            })
            ->when(\request()->city_id != null, function ($query) {
                $query->whereCityId(\request()->city_id);
            })
            ->latest()->get();
        $category = Category::whereStatus('1')->whereId($request->category)->first();
        return view('frontend.products.products', compact('products', 'category'));
    }
    #####
    public function productDetails(Request $request)
    {
        $productDetails = Product::whereStatus(true)->where('id', $request->product)->first();
        return view('frontend.products.productDetails', compact('productDetails'));
    }
    ###### Like ######
    public function productLikeAndDislike(Request $request)
    {
        if (Auth::check()) {
            $isLike = Like::whereUserId(auth()->user()->id)
                ->whereProductId($request->product_id)
                ->whereType('Product')
                ->first();
            if ($isLike) {
                $isLike->delete();
            } else {
                Like::create([
                    'user_id'    => auth()->user()->id,
                    'product_id' => $request->product_id,
                    'type'       => $request->type,
                ]);
            }
            return response()->json(['success' => 'Successfully']);
        }
    }
    ##################################################################################################
    ################################################ Pages ###########################################
    ##################################################################################################
    public function profile()
    {
        $userAddress = UserAddress::whereUserId(auth()->user()->id)->first();
        return view('frontend.profile.profile', compact('userAddress'));
    }
    #######
    public function editProfile(Request $request)
    {
        return view('frontend.profile.editProfile');
    }
    #######
    public function updateProfile(Request $request)
    {
        $customer = User::whereId(auth()->user()->id)->first();
        $input['first_name']    = $request->first_name;
        $input['last_name']     = $request->last_name;
        $input['username']      = $request->username;
        $input['email']         = $request->email;
        $input['mobile']        = $request->mobile;

        if (trim($request->password) != '') {
            $input['password']      = bcrypt($request->password);
        }

        if ($image = $request->file('user_image')) {
            if ($customer->user_image != null && File::exists($customer->user_image)) {
                unlink($customer->user_image);
            }
            $filename = time() . '.' . $image->getClientOriginalExtension();   //علشان تكون اسم الصورة نفس اسم الكاتيجوري
            $path = ('images/customer/' . $filename);
            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();  //لتنسيق العرض مع الطول
            })->save($path, 100);  //الجودة و درجة الوضوح تكون 100%
            $input['user_image']  = $path;
        }

        $customer->update($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت
        Alert::success('تم تعديل بيانات حسابكم بنجاح', 'بوابتك');
        return view('frontend.profile.profile');
        // return redirect()->route('frontend.updateProfile');
    }
    #######
    public function editLocation(Request $request)
    {
        $userAddress = UserAddress::whereUserId(auth()->user()->id)->first();
        return view('frontend.profile.editLocation', compact('userAddress'));
    }
    #######
    public function updateLocation(Request $request)
    {
        $userAddress = UserAddress::whereUserId(auth()->user()->id)->first();

        $input['address']       = $request->address;
        $input['country_id']    = $request->country_id;
        $input['state_id']      = $request->state_id;
        $input['city_id']       = $request->city_id;
        $input['zip_code']      = $request->zip_code;
        $input['po_box']        = $request->po_box;
        $userAddress->update($input);

        Alert::success('تم تعديل موقعكم بنجاح', 'بوابتك');
        // return view('frontend.profile.profile');
        return view('frontend.profile.profile', compact('userAddress'));
    }
    #####################
    #####################
    public function advDetails(Request $request)
    {
        $advDetails = Adv::whereStatus(true)->where('id', $request->advProduct)->first();
        return view('frontend.advDetails', compact('advDetails'));
    }
    ###### Like ######
    public function advLikeAndDislike(Request $request)
    {
        if (Auth::check()) {
            $isLike = Like::whereUserId(auth()->user()->id)
                ->whereProductId($request->product_id)
                ->whereType('Adv')
                ->first();
            if ($isLike) {
                $isLike->delete();
            } else {
                Like::create([
                    'user_id'    => auth()->user()->id,
                    'product_id' => $request->product_id,
                    'type'       => $request->type,
                ]);
            }
            return response()->json(['success' => 'Successfully']);
        }
    }

    ##################################################################################################
    ################################################ Pages ###########################################
    ##################################################################################################
    public function about()
    {
        $about = About::first();
        return view('frontend.about', compact('about'));
    }

    public function weather()
    {
        return view('frontend.weather');
    }
    public function prayer()
    {
        return view('frontend.prayer');
    }
    public function money()
    {
        return view('frontend.money');
    }
    public function likes()
    {
        if (Auth::check()) {
            $userLikes = \App\Models\Like::whereStatus('1')->whereUserId(auth()->user()->id)->latest()->get();
            return view('frontend.likes', compact('userLikes'));
        } else {
            Alert::alert('يجب التسجيل اولا للدخول الي هذة الصفحة', 'Alert Message');
            return redirect()->back();
        }
    }
    // public function buildingLikeAndDislike(Request $request)
    // {
    //     if (Auth::check()) {
    //         $isLike = Like::whereUserId(auth()->user()->id)
    //             ->whereProductId($request->product_id)
    //             ->whereType('BuildingProduct')
    //             ->first();
    //         if ($isLike) {
    //             $isLike->delete();
    //         } else {
    //             Like::create([
    //                 'user_id'    => auth()->user()->id,
    //                 'product_id' => $request->product_id,
    //                 'type'       => $request->type,
    //             ]);
    //         }
    //         return response()->json(['success' => 'Successfully']);
    //     }
    // }


    ##################################################################################################
    ################################################ Add   ###########################################
    ##################################################################################################
    public function addPage()
    {
        if (Auth::check()) {
            return view('frontend.addPage');
        } else {
            Alert::alert('يجب التسجيل اولا للدخول الي هذة الصفحة', 'Alert Message');
            return redirect()->back();
        }
    }
    public function addFrontBuildings(BuildingProductRequest $request)
    {
        if (Auth::check()) {
            DB::beginTransaction();
            try {
                $input['user_id']       = auth()->user()->id;
                $input['name']          = $request->name;
                $input['description']   = $request->description;
                $input['address']       = $request->address;
                $input['size']          = $request->size;
                $input['bedroom']       = $request->bedroom;
                $input['bathroom']      = $request->bathroom;
                $input['hall']          = $request->hall;
                $input['price']         = $request->price;
                $input['phone']         = $request->phone;
                $input['building_category_id']   = $request->building_category_id;
                $input['country_id']    = $request->country_id;
                $input['state_id']      = $request->state_id;
                $input['city_id']       = $request->city_id;
                $input['rent']          = $request->rent;

                $product = BuildingProduct::create($input); //قم بانشاء كاتيجوري جديدة وخد المتغيرات بتاعتك من المتغير اللي اسمه انبوت

                if ($request->images && count($request->images) > 0) {
                    $i = 1;
                    foreach ($request->images as $file) {
                        $filename = $product->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                        $file_size = $file->getSize();
                        $file_type = $file->getMimeType();
                        $path = ('images/builgingProduct/' . $filename);
                        Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($path, 100);

                        $product->media()->create([
                            'file_name'     => $path,
                            'file_size'     => $file_size,
                            'file_type'     => $file_type,
                            'file_status'   => true,
                            'file_sort'     => $i,
                        ]);
                        $i++;
                    }
                }

                DB::commit(); // insert data
                Alert::success('تم اضافة اعلان عقار جديد بنجاح', 'Success Message');
                return redirect()->route('frontend.addPage');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        } else {
            Alert::alert('يجب التسجيل اولا للدخول الي هذة الصفحة', 'Alert Message');
            return redirect()->back();
        }
    }
    public function addFrontCars(CarProductRequest $request)
    {
        // dd('Yes');
        if (Auth::check()) {
            DB::beginTransaction();
            try {
                $input['user_id']       = auth()->user()->id;
                $input['name']          = $request->name;
                $input['description']   = $request->description;
                $input['address']       = $request->address;
                $input['year']          = $request->year;
                $input['color']         = $request->color;
                $input['rent']          = $request->rent;
                $input['price']         = $request->price;
                $input['manual']        = $request->manual;
                $input['distance']      = $request->distance;
                $input['motor']         = $request->motor;
                $input['sound']         = $request->sound;
                $input['seat']          = $request->seat;
                $input['phone']         = $request->phone;
                $input['car_category_id']   = $request->car_category_id;
                $input['car_type_id']       = $request->car_type_id;
                $input['country_id']    = $request->country_id;
                $input['state_id']      = $request->state_id;
                $input['city_id']       = $request->city_id;

                $carProduct = CarProduct::create($input);

                if ($request->images && count($request->images) > 0) {
                    $i = 1;
                    foreach ($request->images as $file) {
                        $filename = $carProduct->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                        $file_size = $file->getSize();
                        $file_type = $file->getMimeType();
                        $path = ('images/carProduct/' . $filename);
                        Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($path, 100);

                        $carProduct->media()->create([
                            'file_name'     => $path,
                            'file_size'     => $file_size,
                            'file_type'     => $file_type,
                            'file_status'   => true,
                            'file_sort'     => $i,
                        ]);
                        $i++;
                    }
                }

                DB::commit(); // insert data
                Alert::success('تم اضافة اعلان سيارة جديد بنجاح', 'Success Message');
                return redirect()->route('frontend.addPage');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        } else {
            Alert::alert('يجب التسجيل اولا للدخول الي هذة الصفحة', 'Alert Message');
            return redirect()->back();
        }
    }
    public function addFrontProducts(ProductRequest $request)
    {
        if (Auth::check()) {
            DB::beginTransaction();
            try {
                $input['user_id']       = auth()->user()->id;
                $input['name']          = $request->name;
                $input['description']   = $request->description;
                $input['quantity']      = $request->quantity;
                $input['price']         = $request->price;
                $input['category_id']   = $request->category_id;
                $input['featured']      = $request->featured;
                $input['start_date']    = $request->start_date;
                $input['end_date']      = $request->end_date;
                $input['phone']         = $request->phone;
                $input['country_id']    = $request->country_id;
                $input['state_id']      = $request->state_id;
                $input['city_id']       = $request->city_id;

                $product = Product::create($input);

                if ($request->images && count($request->images) > 0) {
                    $i = 1;
                    foreach ($request->images as $file) {
                        $filename = $product->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                        $file_size = $file->getSize();
                        $file_type = $file->getMimeType();
                        $path = ('images/product/' . $filename);
                        Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($path, 100);

                        $product->media()->create([
                            'file_name'     => $path,
                            'file_size'     => $file_size,
                            'file_type'     => $file_type,
                            'file_status'   => true,
                            'file_sort'     => $i,
                        ]);
                        $i++;
                    }
                }

                DB::commit(); // insert data
                Alert::success('تم اضافة اعلان منتج جديد بنجاح', 'Success Message');
                return redirect()->route('frontend.addPage');
            } catch (\Exception $e) {
                DB::rollback();
                Alert::error('لقد حدث خظا ما , يرجي اعادة ادخال البيانات مرة اخري', 'Error Message');
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        } else {
            Alert::alert('يجب التسجيل اولا للدخول الي هذة الصفحة', 'Alert Message');
            return redirect()->back();
        }
    }
    public function addFrontJobs(JobRequest $request)
    {
        if (Auth::check()) {
            try {
                $input['user_id']       = auth()->user()->id;
                $input['name']          = $request->name;
                $input['gender']        = $request->gender;
                $input['speciality']    = $request->speciality;
                $input['description']   = $request->description;
                $input['address']       = $request->address;
                $input['exp_years']     = $request->exp_years;
                $input['phone']         = $request->phone;
                $input['job_category_id']  = $request->job_category_id;
                $input['country_id']    = $request->country_id;
                $input['state_id']      = $request->state_id;
                $input['city_id']       = $request->city_id;

                Job::create($input);
                Alert::success('تم اضافة اعلان وظيفة جديد بنجاح', 'Success Message');
                return redirect()->route('frontend.addPage');
            } catch (\Exception $e) {
                Alert::error('لقد حدث خظا ما , يرجي اعادة ادخال البيانات مرة اخري', 'Error Message');
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        } else {
            Alert::alert('يجب التسجيل اولا للدخول الي هذة الصفحة', 'Alert Message');
            return redirect()->back();
        }
    }
    public function addFrontDoctors(MedicalRequest $request)
    {
        if (Auth::check()) {
            try {
                $input['user_id']       = auth()->user()->id;
                $input['name']          = $request->name;
                $input['gender']        = $request->gender;
                $input['medical_type']  = $request->medical_type;
                $input['type']          = $request->type;
                $input['speciality']    = $request->speciality;
                $input['description']   = $request->description;
                $input['address']       = $request->address;
                $input['work_hours']    = $request->work_hours;
                $input['exp_years']     = $request->exp_years;
                $input['phone']         = $request->phone;
                $input['country_id']    = $request->country_id;
                $input['state_id']      = $request->state_id;
                $input['city_id']       = $request->city_id;

                Medical::create($input);
                Alert::success('تم اضافة اعلان خدمة طبية جديد بنجاح', 'Success Message');
                return redirect()->route('frontend.addPage');
            } catch (\Exception $e) {
                Alert::error('لقد حدث خظا ما , يرجي اعادة ادخال البيانات مرة اخري', 'Error Message');
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        } else {
            Alert::alert('يجب التسجيل اولا للدخول الي هذة الصفحة', 'Alert Message');
            return redirect()->back();
        }
    }
    public function addFrontMedicines(MedicalRequest $request)
    {
        if (Auth::check()) {
            try {
                $input['user_id']       = auth()->user()->id;
                $input['name']          = $request->name;
                $input['medical_type']  = $request->medical_type;
                $input['description']   = $request->description;
                $input['address']       = $request->address;
                $input['work_hours']    = $request->work_hours;
                $input['phone']         = $request->phone;
                $input['country_id']    = $request->country_id;
                $input['state_id']      = $request->state_id;
                $input['city_id']       = $request->city_id;

                Medical::create($input);
                Alert::success('تم اضافة اعلان خدمة طبية جديد بنجاح', 'Success Message');
                return redirect()->route('frontend.addPage');
            } catch (\Exception $e) {
                Alert::error('لقد حدث خظا ما , يرجي اعادة ادخال البيانات مرة اخري', 'Error Message');
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        } else {
            Alert::alert('يجب التسجيل اولا للدخول الي هذة الصفحة', 'Alert Message');
            return redirect()->back();
        }
    }
    ##################################################################################################
    ################################################ Edit   ###########################################
    ##################################################################################################
    #########################
    ######  Building   ######
    public function profileEditBuilding(Request $request)
    {
        $buildingProduct = BuildingProduct::whereId($request->id)->whereUserId(auth()->user()->id)->first();
        return view('frontend.profile.edit.editBuilding', compact('buildingProduct'));
    }
    public function profileUpdateBuilding(BuildingProductRequest $request)
    {
        if (Auth::check()) {
            $buildingProduct = BuildingProduct::findOrFail($request->id);
            DB::beginTransaction();
            try {
                $input['name']          = $request->name;
                $input['description']   = $request->description;
                $input['address']       = $request->address;
                $input['size']          = $request->size;
                $input['bedroom']       = $request->bedroom;
                $input['bathroom']      = $request->bathroom;
                $input['hall']          = $request->hall;
                $input['price']         = $request->price;
                $input['phone']         = $request->phone;
                $input['building_category_id']   = $request->building_category_id;
                $input['country_id']    = $request->country_id;
                $input['state_id']      = $request->state_id;
                $input['city_id']       = $request->city_id;
                $input['rent']          = $request->rent;
                $input['admin_check']   = '0';

                $buildingProduct->update($input);

                if ($request->images && count($request->images) > 0) {
                    $i = $buildingProduct->media()->count() + 1;
                    foreach ($request->images as $file) {
                        $filename = $buildingProduct->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                        $file_size = $file->getSize();
                        $file_type = $file->getMimeType();
                        $path = ('images/builgingProduct/' . $filename);
                        Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($path, 100);

                        $buildingProduct->media()->create([
                            'file_name'     => $path,
                            'file_size'     => $file_size,
                            'file_type'     => $file_type,
                            'file_status'   => true,
                            'file_sort'     => $i,
                        ]);
                        $i++;
                    }
                }

                DB::commit(); // insert data
                Alert::success('تم تعديل اعلان عقار بنجاح', 'Success Message');
                return redirect()->route('frontend.profile');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        } else {
            Alert::alert('يجب التسجيل اولا للدخول الي هذة الصفحة', 'Alert Message');
            return redirect()->back();
        }
    }
    public function buildingRemoveImage(Request $request)
    {
        $product = BuildingProduct::findOrFail($request->buildingProduct_id);
        $image   = $product->media()->whereId($request->image_id)->first();
        if ($image) {
            if (File::exists($image->file_name)) {
                unlink($image->file_name);
            }
        }
        $image->delete();
        return true;
    }
    ####################
    ######  Car   ######
    public function profileEditCar(Request $request)
    {
        $carProduct = CarProduct::whereId($request->id)->whereUserId(auth()->user()->id)->first();
        return view('frontend.profile.edit.editCar', compact('carProduct'));
    }
    public function profileUpdateCar(CarProductRequest $request)
    {
        if (Auth::check()) {
            $carProduct = CarProduct::findOrFail($request->id);
            DB::beginTransaction();
            try {
                $input['name']          = $request->name;
                $input['description']   = $request->description;
                $input['address']       = $request->address;
                $input['year']          = $request->year;
                $input['color']         = $request->color;
                $input['rent']          = $request->rent;
                $input['price']         = $request->price;
                $input['manual']        = $request->manual;
                $input['distance']      = $request->distance;
                $input['motor']         = $request->motor;
                $input['sound']         = $request->sound;
                $input['seat']          = $request->seat;
                $input['phone']         = $request->phone;
                $input['country_id']    = $request->country_id;
                $input['car_type_id']   = $request->car_type_id;
                $input['state_id']      = $request->state_id;
                $input['city_id']       = $request->city_id;
                $input['admin_check']   = '0';

                $carProduct->update($input);

                if ($request->images && count($request->images) > 0) {
                    $i = $carProduct->media()->count() + 1;
                    foreach ($request->images as $file) {
                        $filename = $carProduct->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                        $file_size = $file->getSize();
                        $file_type = $file->getMimeType();
                        $path = ('images/carProduct/' . $filename);
                        Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($path, 100);

                        $carProduct->media()->create([
                            'file_name'     => $path,
                            'file_size'     => $file_size,
                            'file_type'     => $file_type,
                            'file_status'   => true,
                            'file_sort'     => $i,
                        ]);
                        $i++;
                    }
                }

                DB::commit(); // insert data
                Alert::success('تم تعديل اعلان سيارة بنجاح', 'Success Message');
                return redirect()->route('frontend.profile');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        } else {
            Alert::alert('يجب التسجيل اولا للدخول الي هذة الصفحة', 'Alert Message');
            return redirect()->back();
        }
    }
    public function carRemoveImage(Request $request)
    {
        $carProduct = CarProduct::findOrFail($request->carProduct_id);
        $image   = $carProduct->media()->whereId($request->image_id)->first();
        if ($image) {
            if (File::exists($image->file_name)) {
                unlink($image->file_name);
            }
        }
        $image->delete();
        return true;
    }
    ####################
    ######  Job   ######
    public function profileEditJob(Request $request)
    {
        $job = Job::whereId($request->id)->whereUserId(auth()->user()->id)->first();
        return view('frontend.profile.edit.editJob', compact('job'));
    }
    public function profileUpdateJob(JobRequest $request)
    {
        if (Auth::check()) {
            $job = Job::findOrFail($request->id);
            try {
                $input['name']          = $request->name;
                $input['gender']        = $request->gender;
                $input['speciality']    = $request->speciality;
                $input['description']   = $request->description;
                $input['address']       = $request->address;
                $input['exp_years']     = $request->exp_years;
                $input['phone']         = $request->phone;
                $input['job_category_id']  = $request->job_category_id;
                $input['country_id']    = $request->country_id;
                $input['state_id']      = $request->state_id;
                $input['city_id']       = $request->city_id;
                $input['admin_check']   = '0';

                $job->update($input);
                Alert::success('تم تعديل اعلان وظيفة بنجاح', 'Success Message');
                return redirect()->route('frontend.profile');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        } else {
            Alert::alert('يجب التسجيل اولا للدخول الي هذة الصفحة', 'Alert Message');
            return redirect()->back();
        }
    }
    ########################
    ######  Medical   ######
    public function profileEditMedicalDoctor(Request $request)
    {
        $medical = Medical::whereId($request->id)->whereUserId(auth()->user()->id)->first();
        return view('frontend.profile.edit.editMedicalDoctor', compact('medical'));
    }
    public function profileUpdateMedicalDoctor(MedicalRequest $request)
    {
        if (Auth::check()) {
            $medical = Medical::findOrFail($request->id);
            try {
                $input['name']          = $request->name;
                $input['gender']        = $request->gender;
                $input['type']          = $request->type;
                $input['speciality']    = $request->speciality;
                $input['description']   = $request->description;
                $input['address']       = $request->address;
                $input['work_hours']    = $request->work_hours;
                $input['exp_years']     = $request->exp_years;
                $input['phone']         = $request->phone;
                $input['country_id']    = $request->country_id;
                $input['state_id']      = $request->state_id;
                $input['city_id']       = $request->city_id;
                $input['admin_check']   = '0';

                $medical->update($input);
                Alert::success('تم تعديل اعلان خدمة طبية بنجاح', 'Success Message');
                return redirect()->route('frontend.profile');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        } else {
            Alert::alert('يجب التسجيل اولا للدخول الي هذة الصفحة', 'Alert Message');
            return redirect()->back();
        }
    }
    #####
    public function profileEditMedicalMedicine(Request $request)
    {
        $medical = Medical::whereId($request->id)->whereUserId(auth()->user()->id)->first();
        return view('frontend.profile.edit.editMedicalMedicine', compact('medical'));
    }
    public function profileUpdateMedicalMedicine(MedicalRequest $request)
    {
        if (Auth::check()) {
            $medical = Medical::findOrFail($request->id);
            try {
                $input['name']          = $request->name;
                $input['description']   = $request->description;
                $input['address']       = $request->address;
                $input['work_hours']    = $request->work_hours;
                $input['phone']         = $request->phone;
                $input['country_id']    = $request->country_id;
                $input['state_id']      = $request->state_id;
                $input['city_id']       = $request->city_id;
                $input['admin_check']   = '0';

                $medical->update($input);
                Alert::success('تم تعديل اعلان خدمة طبية بنجاح', 'Success Message');
                return redirect()->route('frontend.profile');
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        } else {
            Alert::alert('يجب التسجيل اولا للدخول الي هذة الصفحة', 'Alert Message');
            return redirect()->back();
        }
    }
    ########################
    ######  Product   ######
    public function profileEditProduct(Request $request)
    {
        $product = Product::whereId($request->id)->whereUserId(auth()->user()->id)->first();
        return view('frontend.profile.edit.editProduct', compact('product'));
    }
    public function profileUpdateProduct(ProductRequest $request)
    {
        if (Auth::check()) {
            $product = Product::findOrFail($request->id);
            DB::beginTransaction();
            try {
                $input['name']          = $request->name;
                $input['description']   = $request->description;
                $input['quantity']      = $request->quantity;
                $input['price']         = $request->price;
                $input['category_id']   = $request->category_id;
                $input['featured']      = $request->featured;
                $input['start_date']    = $request->start_date;
                $input['end_date']      = $request->end_date;
                $input['phone']         = $request->phone;
                $input['country_id']    = $request->country_id;
                $input['state_id']      = $request->state_id;
                $input['city_id']       = $request->city_id;
                $input['city_id']       = $request->city_id;
                $input['admin_check']   = '0';

                $product->update($input);


                $product->tags()->sync($request->tags);
                if ($request->images && count($request->images) > 0) {
                    $i = $product->media()->count() + 1;
                    foreach ($request->images as $file) {
                        $filename = $product->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                        $file_size = $file->getSize();
                        $file_type = $file->getMimeType();
                        $path = ('images/product/' . $filename);
                        Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($path, 100);

                        $product->media()->create([
                            'file_name'     => $path,
                            'file_size'     => $file_size,
                            'file_type'     => $file_type,
                            'file_status'   => true,
                            'file_sort'     => $i,
                        ]);
                        $i++;
                    }
                }

                DB::commit(); // insert data
                Alert::success('تم تعديل اعلان منتج بنجاح', 'Success Message');
                return redirect()->route('frontend.profile');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        } else {
            Alert::alert('يجب التسجيل اولا للدخول الي هذة الصفحة', 'Alert Message');
            return redirect()->back();
        }
    }
    public function productRemoveImage(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $image   = $product->media()->whereId($request->image_id)->first();
        if ($image) {
            if (File::exists($image->file_name)) {
                unlink($image->file_name);
            }
        }
        $image->delete();
        return true;
    }
}
