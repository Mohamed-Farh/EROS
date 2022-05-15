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
use App\Models\Booking;
use App\Models\BuildingCategory;
use App\Models\BuildingProduct;
use App\Models\CarCategory;
use App\Models\CarProduct;
use App\Models\CarType;
use App\Models\Category;
use App\Models\City;
use App\Models\ContactMessage;
use App\Models\Country;
use App\Models\HomePage;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\Like;
use App\Models\Medical;
use App\Models\PageTitle;
use App\Models\Product;
use App\Models\State;
use App\Models\User;
use App\Models\UserAddress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    ######################################## Country - State - city ################################
    public function frontState(Request $request)
    {
        $states = State::whereCountryId($request->country_id)->whereStatus(true)->get(['id', 'name'])->toArray();
        return response()->json($states);
    }
    public function frontCity(Request $request)
    {
        $cities = City::whereStateId($request->state_id)->whereStatus(true)->get(['id', 'name'])->toArray();
        return response()->json($cities);
    }

    public function getProducts($id)
    {
        $products = Product::where('category_id', $id)->pluck("name", "id");
        return $products;
    }
    ######################################## Main ###################################################
    public function index()
    {
        $sliders = HomePage::whereType('Slider')->whereStatus('1')->latest()->get();
        $homeAbouts = HomePage::whereType('About Us')->whereStatus('1')->latest()->get();
        $footers = PageTitle::whereStatus('1')->latest()->get();
        $bestProducts = Product::whereFeatured('1')->whereStatus('1')->latest()->paginate(8);
        $categories = Category::whereStatus('1')->latest()->paginate(8);

        return view('frontend.index', compact('sliders', 'footers', 'homeAbouts', 'categories', 'bestProducts'));
    }
    public function categories()
    {
        $categories = Category::whereStatus(1)->latest()->paginate(16);
        return view('frontend.categories', compact('categories'));
    }
    public function categoryDetails(Category $category)
    {
        $products = Product::whereStatus(1)->whereCategoryId($category->id)->paginate(16);
        return view('frontend.categoryDetails', compact('category', 'products'));
    }
    public function sendContactMessage(Request $request)
    {
        try {
            $input['name']          = $request->name;
            $input['company']       = $request->company;
            $input['country_id']    = $request->country_id;
            $input['state_id']      = $request->state_id;
            $input['city_id']       = $request->city_id;
            $input['email']        = $request->email;
            $input['mobile']        = $request->mobile;
            $input['subject']          = $request->subject;
            $input['message']          = $request->message;
            $input['status']          = '1';
            ContactMessage::create($input);
            Alert::success('Success', 'Your Message Sent Successfully');
            return redirect()->back();
        }catch (\Exception $e) {
            Alert::error('Error Message', 'SomeThing Wrong, Please Try Again');
            return redirect()->back();
        }
    }
    public function contactUs()
    {
        return view('frontend.contactUs');
    }
    public function aboutUs()
    {
        $abouts = About::whereStatus(1)->latest()->get();
        return view('frontend.aboutUs', compact('abouts'));
    }
    public function booking()
    {
        $categories = Category::get(['id', 'name']);
        return view('frontend.booking', compact('categories'));
    }
    public function bookingBooking(Request $request)
    {
        // try {
            $input['user_id']       = $request->user_id;
            $input['name']          = $request->name;
            $input['mobile']        = $request->mobile;
            $input['email']         = $request->email;
            $input['category_id']   = $request->category_id;
            $input['product_id']    = $request->product_id;
            $input['subject']       = $request->subject;
            $input['message']       = $request->message;
            $input['country_id']    = $request->country_id;
            $input['state_id']      = $request->state_id;
            $input['city_id']       = $request->city_id;
            $input['day']           = $request->day;
            $input['start']         = $request->start;
            $Booking = Booking::create($input);
            Alert::success('Success', 'Your Booking Sent Successfully');
            return redirect()->back();
        // }catch (\Exception $e) {
        //     Alert::error('Error Message', 'SomeThing Wrong, Please Try Again');
        //     return redirect()->back();
        // }
    }



    #####
    public function productDetails(Request $request)
    {
        $productDetails = Product::whereStatus(true)->where('id', $request->product)->first();
        return view('frontend.productDetails', compact('productDetails'));
    }

    ##################################################################################################
    ################################################ Pages ###########################################
    ##################################################################################################
    public function profile()
    {
        Carbon::setLocale('ar');
        $userAddress = UserAddress::whereUserId(auth()->user()->id)->first();

        $bookings = Booking::whereStatus(0)->whereUserId(auth()->user()->id)->get();
        $bookings = Booking::whereDate('day', '>=', Carbon::today())->whereUserId(auth()->user()->id)->get();
        $finishedBookings = Booking::whereDate('day', '<=', Carbon::today())->whereStatus(1)->whereUserId(auth()->user()->id)->get();
        return view('frontend.profile.profile', compact('bookings', 'userAddress', 'finishedBookings'));
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
        Alert::success('تم تعديل بيانات حسابكم بنجاح', 'EROS');

        Carbon::setLocale('ar');
        $bookings = Booking::whereStatus(0)->whereUserId(auth()->user()->id)->get();
        $finishedBookings = Booking::whereStatus(1)->whereUserId(auth()->user()->id)->get();
        $userAddress = UserAddress::whereUserId(auth()->user()->id)->first();
        return view('frontend.profile.profile', compact('bookings', 'userAddress', 'finishedBookings'));
        // return redirect()->back();
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

        Alert::success('تم تعديل موقعكم بنجاح', 'EROS');

        Carbon::setLocale('ar');
        $bookings = Booking::whereStatus(0)->whereUserId(auth()->user()->id)->get();
        $finishedBookings = Booking::whereStatus(1)->whereUserId(auth()->user()->id)->get();
        return view('frontend.profile.profile', compact('bookings', 'userAddress', 'finishedBookings'));

    }


}
