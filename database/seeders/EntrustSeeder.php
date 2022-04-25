<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\User;
use App\Models\UserAddress;
use Carbon\Carbon;
use Faker\Factory;

class EntrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();


        $superAdminRole     = Role::create(['name' => 'superAdmin',  'display_name' => 'Administrator',  'description' => 'System Administrator', 'allowed_route' => 'admin']);
        $adminRole          = Role::create(['name' => 'admin',       'display_name' => 'admin',          'description' => 'System Admin',         'allowed_route' => 'admin']);
        $userRole           = Role::create(['name' => 'user',        'display_name' => 'User',           'description' => 'System User',          'allowed_route' => 'admin']);
        $customerRole       = Role::create(['name' => 'customer',    'display_name' => 'Customer',       'description' => 'Website Customer',     'allowed_route' => null   ]);

        $superAdmin = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'username' => 'System Administrator',
            'email' => 'superAdmin@superAdmin.com',
            'mobile' => '01234567890',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('password'),
            'user_image'=>'images/user/avatar.png',
            'remember_token' => Str::random(10),
        ]);
        UserAddress::create([
            'user_id' => $superAdmin->id,
        ]);
        $superAdmin->attachRole($superAdminRole);


        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'System',
            'username' => 'System Admin',
            'email' => 'admin@admin.com',
            'mobile' => '01234567880',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('password'),
            'user_image'=>'images/user/avatar.png',
            'remember_token' => Str::random(10),
        ]);
        UserAddress::create([
            'user_id' => $admin->id,
        ]);
        $admin->attachRole($adminRole);


        $user = User::create([
            'first_name' => 'User',
            'last_name' => 'System',
            'username' => 'System User',
            'email' => 'user@user.com',
            'mobile' => '01234567800',
            'password' => bcrypt('password'),
            'email_verified_at' => Carbon::now(),
            'user_image'=>'images/user/avatar.png',
            'remember_token' => Str::random(10),
        ]);
        UserAddress::create([
            'user_id' => $user->id,
        ]);
        $user->attachRole($userRole);


        $user1 = User::create([ 'first_name' => 'Customer', 'last_name' => 'Customer', 'username' => 'Customer Customer', 'email' => 'customer@customer.com',  'mobile' => '01234567999','status'=> 1, 'password' => bcrypt('password'),'email_verified_at' => Carbon::now(), 'user_image'=>'images/customer/avatar.png', 'remember_token' => Str::random(10), ]);
        UserAddress::create(['user_id' => $user1->id]);
        $user1->attachRole($customerRole);

        $user2 = User::create(['first_name' => 'Mohamed',   'last_name' => 'Farh',     'username' => 'Mohamed Farh',     'email' => 'mohamed@yahoo.com', 'mobile' => '01234567799','status'=> 1, 'password' => bcrypt('password'),'email_verified_at' => Carbon::now(), 'user_image'=>'images/customer/avatar.png', 'remember_token' => Str::random(10), ]);
        UserAddress::create(['user_id' => $user2->id]);
        $user2->attachRole($customerRole);

        $user3 = User::create(['first_name' => 'Ahmed',     'last_name' => 'Farh',     'username' => 'Ahmed Farh',       'email' => 'ahmed@yahoo.com',       'mobile' => '01234567699','status'=> 1, 'password' => bcrypt('password'),'email_verified_at' => Carbon::now(), 'user_image'=>'images/customer/avatar.png', 'remember_token' => Str::random(10), ]);
        UserAddress::create(['user_id' => $user3->id]);
        $user3->attachRole($customerRole);

        for ($i = 0; $i <10; $i++) {
            $user_i = User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'username' => $faker->userName,
                'email' => $faker->email,
                'mobile' => '9665' . random_int(10000000, 99999999),
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('password'),
                'user_image'=>'images/customer/avatar.png',
                'status'=> 1,
                'remember_token' => Str::random(10),
            ]);
            UserAddress::create(['user_id' => $user_i->id]);
            $user_i->attachRole($customerRole);
        }





        // MAIN
        $manageMain = Permission::create([
            'name' => 'main',
            'display_name' => 'الرئيسية',
            'description' => 'Administrator Dashboard',
            'route' => 'index',
            'module' => 'index',
            'as' => 'index',
            'icon' => 'fa fa-home',
            'parent' => '0',
            'parent_original' => '0',
            'sidebar_link' => '1',
            'appear' => '1',
            'ordering' => '1',
        ]);
        $manageMain->parent_show = $manageMain->id;
        $manageMain->save();



        // Admins
        $manageAdmins = Permission::create([ 'name' => 'manage_admins', 'display_name' => 'الأدمن', 'route' => 'admins', 'module' => 'admins', 'as' => 'admins.index', 'icon' => 'fas fa-user-shield', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '0', 'appear' => '1', 'ordering' => '200', ]);
        $manageAdmins->parent_show = $manageAdmins->id;
        $manageAdmins->save();
        $showAdmins    = Permission::create([ 'name' => 'show_admins',          'display_name' => 'الأدمن',              'route' => 'admins.index',          'module' => 'admins', 'as' => 'admins.index',       'icon' => 'fas fa-user-shield',  'parent' => $manageAdmins->id, 'parent_show' => $manageAdmins->id, 'parent_original' => $manageAdmins->id,'sidebar_link' => '0', 'appear' => '1', ]);
        $createAdmins  = Permission::create([ 'name' => 'create_admins',        'display_name' => 'انشاء ادمن',       'route' => 'admins.create',         'module' => 'admins', 'as' => 'admins.create',      'icon' => null,                  'parent' => $manageAdmins->id, 'parent_show' => $manageAdmins->id, 'parent_original' => $manageAdmins->id,'sidebar_link' => '0', 'appear' => '0', ]);
        $updateAdmins  = Permission::create([ 'name' => 'update_admins',        'display_name' => 'تعديل ادمن',       'route' => 'admins.edit',           'module' => 'admins', 'as' => 'admins.edit',        'icon' => null,                  'parent' => $manageAdmins->id, 'parent_show' => $manageAdmins->id, 'parent_original' => $manageAdmins->id,'sidebar_link' => '0', 'appear' => '0', ]);
        $destroyAdmins = Permission::create([ 'name' => 'delete_admins',        'display_name' => 'حذف ادمن',       'route' => 'admins.destroy',        'module' => 'admins', 'as' => 'admins.destroy',     'icon' => null,                  'parent' => $manageAdmins->id, 'parent_show' => $manageAdmins->id, 'parent_original' => $manageAdmins->id,'sidebar_link' => '0', 'appear' => '0', ]);

        // Users
        $manageUsers = Permission::create([ 'name' => 'manage_users', 'display_name' => 'المستخدمين', 'route' => 'admins', 'module' => 'users', 'as' => 'users.index', 'icon' => 'fas fa-users', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '0', 'appear' => '1', 'ordering' => '210', ]);
        $manageUsers->parent_show = $manageUsers->id;
        $manageUsers->save();
        $showUsers    = Permission::create([ 'name' => 'show_users',          'display_name' => 'المستخدمين',              'route' => 'users.index',          'module' => 'users', 'as' => 'users.index',       'icon' => 'fas fa-users',        'parent' => $manageUsers->id, 'parent_show' => $manageUsers->id, 'parent_original' => $manageUsers->id,'sidebar_link' => '0', 'appear' => '1', ]);
        $createUsers  = Permission::create([ 'name' => 'create_users',        'display_name' => 'انشاء مستخدم',       'route' => 'users.create',         'module' => 'users', 'as' => 'users.create',      'icon' => null,                  'parent' => $manageUsers->id, 'parent_show' => $manageUsers->id, 'parent_original' => $manageUsers->id,'sidebar_link' => '0', 'appear' => '0', ]);
        $updateUsers  = Permission::create([ 'name' => 'update_users',        'display_name' => 'تعديل مستخدم',       'route' => 'users.edit',           'module' => 'users', 'as' => 'users.edit',        'icon' => null,                  'parent' => $manageUsers->id, 'parent_show' => $manageUsers->id, 'parent_original' => $manageUsers->id,'sidebar_link' => '0', 'appear' => '0', ]);
        $destroyUsers = Permission::create([ 'name' => 'delete_users',        'display_name' => 'حذف مستخدم',       'route' => 'users.destroy',        'module' => 'users', 'as' => 'users.destroy',     'icon' => null,                  'parent' => $manageUsers->id, 'parent_show' => $manageUsers->id, 'parent_original' => $manageUsers->id,'sidebar_link' => '0', 'appear' => '0', ]);


        //Buildings
        $manageBuildings = Permission::create([ 'name' => 'manage_buildings', 'display_name' => 'العقارات', 'route' => 'buildings', 'module' => 'buildings', 'as' => 'buildings.index', 'icon' => 'fas fa-city', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '5', ]);
        $manageBuildings->parent_show = $manageBuildings->id;
        $manageBuildings->save();
        $showBuildings    = Permission::create([ 'name' => 'show_buildings',          'display_name' => 'فئات العقارات',       'route' => 'buildings.index',         'module' => 'buildings', 'as' => 'buildings.index',       'icon' => 'fas fa-building',           'parent' => $manageBuildings->id, 'parent_show' => $manageBuildings->id, 'parent_original' => $manageBuildings->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createBuildings  = Permission::create([ 'name' => 'create_buildings',        'display_name' => 'انشاء عقار',     'route' => 'buildings.create',        'module' => 'buildings', 'as' => 'buildings.create',      'icon' => null,                  'parent' => $manageBuildings->id, 'parent_show' => $manageBuildings->id, 'parent_original' => $manageBuildings->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateBuildings  = Permission::create([ 'name' => 'update_buildings',        'display_name' => 'تعديل عقار',     'route' => 'buildings.edit',          'module' => 'buildings', 'as' => 'buildings.edit',        'icon' => null,                  'parent' => $manageBuildings->id, 'parent_show' => $manageBuildings->id, 'parent_original' => $manageBuildings->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyBuildings = Permission::create([ 'name' => 'delete_buildings',        'display_name' => 'حذف عقار',       'route' => 'buildings.destroy',       'module' => 'buildings', 'as' => 'buildings.destroy',     'icon' => null,                  'parent' => $manageBuildings->id, 'parent_show' => $manageBuildings->id, 'parent_original' => $manageBuildings->id,'sidebar_link' => '1', 'appear' => '0', ]);
        #Building Products
        // $showBuildingProducts    = Permission::create([ 'name' => 'show_buildingProducts',          'display_name' => 'العقارات',       'route' => 'buildingProducts.index',         'module' => 'buildings', 'as' => 'buildingProducts.index',       'icon' => 'fas fa-building',     'parent' => $manageBuildings->id, 'parent_show' => $manageBuildings->id, 'parent_original' => $manageBuildings->id,'sidebar_link' => '1', 'appear' => '1', ]);
        // $createBuildingProducts  = Permission::create([ 'name' => 'create_buildingProducts',        'display_name' => 'انشاء عقار',     'route' => 'buildingProducts.create',        'module' => 'buildings', 'as' => 'buildingProducts.create',      'icon' => null,                  'parent' => $manageBuildings->id, 'parent_show' => $manageBuildings->id, 'parent_original' => $manageBuildings->id,'sidebar_link' => '1', 'appear' => '0', ]);
        // $updateBuildingProducts  = Permission::create([ 'name' => 'update_buildingProducts',        'display_name' => 'تعديل عقار',     'route' => 'buildingProducts.edit',          'module' => 'buildings', 'as' => 'buildingProducts.edit',        'icon' => null,                  'parent' => $manageBuildings->id, 'parent_show' => $manageBuildings->id, 'parent_original' => $manageBuildings->id,'sidebar_link' => '1', 'appear' => '0', ]);
        // $destroyBuildingProducts = Permission::create([ 'name' => 'delete_buildingProducts',        'display_name' => 'حذف عقار',       'route' => 'buildingProducts.destroy',       'module' => 'buildings', 'as' => 'buildingProducts.destroy',     'icon' => null,                  'parent' => $manageBuildings->id, 'parent_show' => $manageBuildings->id, 'parent_original' => $manageBuildings->id,'sidebar_link' => '1', 'appear' => '0', ]);


        //Cars
        $manageCars = Permission::create([ 'name' => 'manage_cars', 'display_name' => 'السيارات', 'route' => 'cars', 'module' => 'cars', 'as' => 'carCategories.index', 'icon' => 'fas fa-car-side', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '10', ]);
        $manageCars->parent_show = $manageCars->id;
        $manageCars->save();
        $showCars     = Permission::create([ 'name' => 'show_cars',          'display_name' => 'فئات السيارات',   'route' => 'carCategories.index',         'module' => 'cars', 'as' => 'carCategories.index',       'icon' => 'fas fa-car',           'parent' => $manageCars->id, 'parent_show' => $manageCars->id, 'parent_original' => $manageCars->id,'sidebar_link' => '1', 'appear' => '1', ]);
        ##carTypes
        $showCarTypes = Permission::create([ 'name' => 'show_carTypes',       'display_name' => 'انواع السيارات',   'route' => 'carTypes.index',             'module' => 'cars', 'as' => 'carTypes.index',       'icon' => 'fas fa-shopping-cart',           'parent' => $manageCars->id, 'parent_show' => $manageCars->id, 'parent_original' => $manageCars->id,'sidebar_link' => '1', 'appear' => '1', ]);


        //Medical
        $manageMedical = Permission::create([ 'name' => 'manage_medical', 'display_name' => 'خدمات طبية', 'route' => 'Medical', 'module' => 'Medical', 'as' => 'Medical', 'icon' => 'fas fa-stethoscope', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '15', ]);
        $manageMedical->parent_show = $manageMedical->id;
        $manageMedical->save();
            ##Social Media
            $showSocials    = Permission::create([ 'name' => 'show_doctor',     'display_name' => 'الطب',       'route' => 'medicalDoctors.index',      'module' => 'Medical',     'as' => 'medicalDoctors.index',      'icon' => 'fas fa-user-md',           'parent' => $manageMedical->id, 'parent_show' => $manageMedical->id, 'parent_original' => $manageMedical->id,'sidebar_link' => '1', 'appear' => '1', ]);
            ##Phone Number
            $showPhones     = Permission::create([ 'name' => 'show_nurse',      'display_name' => 'التمريض',    'route' => 'medicalNurses.index',       'module' => 'Medical',     'as' => 'medicalNurses.index',       'icon' => 'fas fa-user-nurse',    'parent' => $manageMedical->id, 'parent_show' => $manageMedical->id, 'parent_original' => $manageMedical->id,'sidebar_link' => '1', 'appear' => '1', ]);
            ##E_Mail
            $showEmails     = Permission::create([ 'name' => 'show_medicine',   'display_name' => 'الصيدلة',    'route' => 'medicalMedicines.index',    'module' => 'Medical',     'as' => 'medicalMedicines.index',    'icon' => 'fas fa-capsules',  'parent' => $manageMedical->id, 'parent_show' => $manageMedical->id, 'parent_original' => $manageMedical->id,'sidebar_link' => '1', 'appear' => '1', ]);

        //jobs
        $manageJob = Permission::create([ 'name' => 'manage_jobs', 'display_name' => 'فرص عمل', 'route' => 'Job', 'module' => 'Job', 'as' => 'Job', 'icon' => 'fas fa-briefcase', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '20', ]);
        $manageJob->parent_show = $manageJob->id;
        $manageJob->save();
            ##Social Media
            $showjobCategories  = Permission::create([ 'name' => 'show_jobCategories',  'display_name' => 'اقسام الوظائف',  'route' => 'jobCategories.index',   'module' => 'Job',     'as' => 'jobCategories.index',   'icon' => 'fas fa-clipboard-list',     'parent' => $manageJob->id, 'parent_show' => $manageJob->id, 'parent_original' => $manageJob->id,'sidebar_link' => '1', 'appear' => '1', ]);
            ##Phone Number
            $showJobs           = Permission::create([ 'name' => 'show_jobs',           'display_name' => 'الوظائف',        'route' => 'jobs.index',            'module' => 'Job',     'as' => 'jobs.index',            'icon' => 'fas fa-business-time',       'parent' => $manageJob->id, 'parent_show' => $manageJob->id, 'parent_original' => $manageJob->id,'sidebar_link' => '1', 'appear' => '1', ]);


        //Products
        $manageProducts = Permission::create([ 'name' => 'manage_products', 'display_name' => 'المنتجات', 'route' => 'products', 'module' => 'products', 'as' => 'products.index', 'icon' => 'fas fa-tshirt', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '25', ]);
        $manageProducts->parent_show = $manageProducts->id;
        $manageProducts->save();
        //Categories
        $showCategories     = Permission::create([ 'name' => 'show_categories', 'display_name' => 'الاقسام',    'route' => 'categories.index',  'module' => 'products', 'as' => 'categories.index',      'icon' => 'fas fa-th-large',           'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '1', ]);
        //Products
        $showProducts       = Permission::create([ 'name' => 'show_products',   'display_name' => 'المنتجات',  'route' => 'products.index',    'module' => 'products', 'as' => 'products.index',       'icon' => 'fas fa-tshirt',       'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '1', ]);
        ## Product Coupons ##
        // $showProductCoupons    = Permission::create([ 'name' => 'show_productCoupons',          'display_name' => 'كوبونات الخصم',              'route' => 'productCoupons.index',          'module' => 'products', 'as' => 'productCoupons.index',       'icon' => 'fas fa-money-bill-wave', 'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '1', ]);
        // $createProductCoupons  = Permission::create([ 'name' => 'create_productCoupons',        'display_name' => 'انشاء كوبون',       'route' => 'productCoupons.create',         'module' => 'products', 'as' => 'productCoupons.create',      'icon' => null,                     'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '0', ]);
        // $updateProductCoupons  = Permission::create([ 'name' => 'update_productCoupons',        'display_name' => 'تعديل كوبون',       'route' => 'productCoupons.edit',           'module' => 'products', 'as' => 'productCoupons.edit',        'icon' => null,                     'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '0', ]);
        // $destroyProductCoupons = Permission::create([ 'name' => 'delete_productCoupons',        'display_name' => 'حذف كوبون',       'route' => 'productCoupons.destroy',        'module' => 'products', 'as' => 'productCoupons.destroy',     'icon' => null,                     'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '0', ]);
        // ## Product Reviews ##
        // $showProductReviews    = Permission::create([ 'name' => 'show_productReviews',          'display_name' => 'تقييمات المنتجات',              'route' => 'productReviews.index',          'module' => 'products', 'as' => 'productReviews.index',       'icon' => 'fas fa-comments',     'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '1', ]);
        // $createProductReviews  = Permission::create([ 'name' => 'create_productReviews',        'display_name' => 'انشاء تقييم',       'route' => 'productReviews.create',         'module' => 'products', 'as' => 'productReviews.create',      'icon' => null,                  'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '0', ]);
        // $updateProductReviews  = Permission::create([ 'name' => 'update_productReviews',        'display_name' => 'تعديل تقييم',       'route' => 'productReviews.edit',           'module' => 'products', 'as' => 'productReviews.edit',        'icon' => null,                  'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '0', ]);
        // $destroyProductReviews = Permission::create([ 'name' => 'delete_productReviews',        'display_name' => 'حذف تقييم',       'route' => 'productReviews.destroy',        'module' => 'products', 'as' => 'productReviews.destroy',     'icon' => null,                  'parent' => $manageProducts->id, 'parent_show' => $manageProducts->id, 'parent_original' => $manageProducts->id,'sidebar_link' => '1', 'appear' => '0', ]);


        //Customers
        $manageCustomers = Permission::create([ 'name' => 'manage_customers', 'display_name' => 'العملاء', 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.index', 'icon' => 'fas fa-user', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '25', ]);
        $manageCustomers->parent_show = $manageCustomers->id;
        $manageCustomers->save();
        $showCustomers    = Permission::create([ 'name' => 'show_customers',          'display_name' => 'العملاء',       'route' => 'customers.index',          'module' => 'customers', 'as' => 'customers.index',       'icon' => 'fas fa-user',         'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createCustomers  = Permission::create([ 'name' => 'create_customers',        'display_name' => 'انشاء عميل',   'route' => 'customers.create',         'module' => 'customers', 'as' => 'customers.create',      'icon' => null,                  'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateCustomers  = Permission::create([ 'name' => 'update_customers',        'display_name' => 'تعديل عميل',   'route' => 'customers.edit',           'module' => 'customers', 'as' => 'customers.edit',        'icon' => null,                  'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyCustomers = Permission::create([ 'name' => 'delete_customers',        'display_name' => 'حذف عميل',     'route' => 'customers.destroy',        'module' => 'customers', 'as' => 'customers.destroy',     'icon' => null,                  'parent' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'parent_original' => $manageCustomers->id,'sidebar_link' => '1', 'appear' => '0', ]);


        //Advs
        $manageAdvs = Permission::create([ 'name' => 'manage_advs', 'display_name' => 'الاعلانات', 'route' => 'advs', 'module' => 'advs', 'as' => 'advs.index', 'icon' => 'fas fa-ad', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '25', ]);
        $manageAdvs->parent_show = $manageAdvs->id;
        $manageAdvs->save();
        $showAdvs    = Permission::create([ 'name' => 'show_advs',          'display_name' => 'الاعلانات',       'route' => 'advs.index',          'module' => 'advs', 'as' => 'advs.index',       'icon' => 'fas fa-ad',         'parent' => $manageAdvs->id, 'parent_show' => $manageAdvs->id, 'parent_original' => $manageAdvs->id,'sidebar_link' => '1', 'appear' => '1', ]);


        //Countries
        $manageCountries = Permission::create([ 'name' => 'manage_countries', 'display_name' => 'الدول', 'route' => 'countries', 'module' => 'countries', 'as' => 'countries.index', 'icon' => 'fas fa-globe', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '100', ]);
        $manageCountries->parent_show = $manageCountries->id;
        $manageCountries->save();
        $showCountries    = Permission::create([ 'name' => 'show_countries',          'display_name' => 'الدول',              'route' => 'countries.index',          'module' => 'countries', 'as' => 'countries.index',       'icon' => 'fas fa-globe',        'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createCountries  = Permission::create([ 'name' => 'create_countries',        'display_name' => 'انشاء دولة',       'route' => 'countries.create',         'module' => 'countries', 'as' => 'countries.create',      'icon' => null,                  'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateCountries  = Permission::create([ 'name' => 'update_countries',        'display_name' => 'تعديل دولة',       'route' => 'countries.edit',           'module' => 'countries', 'as' => 'countries.edit',        'icon' => null,                  'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyCountries = Permission::create([ 'name' => 'delete_countries',        'display_name' => 'حذف دولة',       'route' => 'countries.destroy',        'module' => 'countries', 'as' => 'countries.destroy',     'icon' => null,                  'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '0', ]);
        //States
        $showStates    = Permission::create([ 'name' => 'show_states',          'display_name' => 'المحافظات',              'route' => 'states.index',          'module' => 'countries', 'as' => 'states.index',       'icon' => 'fas fa-map-marker-alt', 'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createStates  = Permission::create([ 'name' => 'create_states',        'display_name' => 'انشاء محافظة',       'route' => 'states.create',         'module' => 'countries', 'as' => 'states.create',      'icon' => null,                    'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateStates  = Permission::create([ 'name' => 'update_states',        'display_name' => 'تعديل محافظة',       'route' => 'states.edit',           'module' => 'countries', 'as' => 'states.edit',        'icon' => null,                    'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyStates = Permission::create([ 'name' => 'delete_states',        'display_name' => 'حذف محافظة',       'route' => 'states.destroy',        'module' => 'countries', 'as' => 'states.destroy',     'icon' => null,                    'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '0', ]);
        //Cities
        $showCities    = Permission::create([ 'name' => 'show_cities',          'display_name' => 'المدن',              'route' => 'cities.index',          'module' => 'countries', 'as' => 'cities.index',       'icon' => 'fas fa-university',   'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '1', ]);
        $createCities  = Permission::create([ 'name' => 'create_cities',        'display_name' => 'انشاء مدينة',       'route' => 'cities.create',         'module' => 'countries', 'as' => 'cities.create',      'icon' => null,                  'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $updateCities  = Permission::create([ 'name' => 'update_cities',        'display_name' => 'تعديل مدينة',       'route' => 'cities.edit',           'module' => 'countries', 'as' => 'cities.edit',        'icon' => null,                  'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '0', ]);
        $destroyCities = Permission::create([ 'name' => 'delete_cities',        'display_name' => 'حذف مدينة',       'route' => 'cities.destroy',        'module' => 'countries', 'as' => 'cities.destroy',     'icon' => null,                  'parent' => $manageCountries->id, 'parent_show' => $manageCountries->id, 'parent_original' => $manageCountries->id,'sidebar_link' => '1', 'appear' => '0', ]);


        //Contact
        $manageContacts = Permission::create([ 'name' => 'manage_contacts', 'display_name' => 'الاتصال', 'route' => 'Contacts', 'module' => 'Contacts', 'as' => 'Contacts', 'icon' => 'fas fa-mobile-alt', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '115', ]);
        $manageContacts->parent_show = $manageContacts->id;
        $manageContacts->save();
            ##Social Media
            $showSocials    = Permission::create([ 'name' => 'show_social', 'display_name' => 'وسائل التواصل الاجتماعي',   'route' => 'socials.index',     'module' => 'Contacts',     'as' => 'socials.index',    'icon' => 'fas fa-thumbs-up',           'parent' => $manageContacts->id, 'parent_show' => $manageContacts->id, 'parent_original' => $manageContacts->id,'sidebar_link' => '1', 'appear' => '1', ]);
            ##Phone Number
            $showPhones     = Permission::create([ 'name' => 'show_phone',  'display_name' => 'الموبيل',         'route' => 'phones.index',      'module' => 'Contacts',     'as' => 'phones.index',     'icon' => 'fas fa-phone-square-alt',    'parent' => $manageContacts->id, 'parent_show' => $manageContacts->id, 'parent_original' => $manageContacts->id,'sidebar_link' => '1', 'appear' => '1', ]);
            ##E_Mail
            $showEmails     = Permission::create([ 'name' => 'show_email',  'display_name' => 'البريد الالكتروني',        'route' => 'emails.index',      'module' => 'Contacts',     'as' => 'emails.index',     'icon' => 'fas fa-envelope-open-text',  'parent' => $manageContacts->id, 'parent_show' => $manageContacts->id, 'parent_original' => $manageContacts->id,'sidebar_link' => '1', 'appear' => '1', ]);


        //About App
        $manageAbout = Permission::create([ 'name' => 'manage_abouts', 'display_name' => 'حول التطبيق', 'route' => 'Abouts', 'module' => 'Abouts', 'as' => 'Abouts', 'icon' => 'fas fa-id-card-alt', 'parent' => '0', 'parent_original' => '0','sidebar_link' => '1', 'appear' => '1', 'ordering' => '120', ]);
        $manageAbout->parent_show = $manageAbout->id;
        $manageAbout->save();
            ##Social Media
            $showAbout    = Permission::create([ 'name' => 'show_abouts', 'display_name' => 'حول التطبيق',   'route' => 'abouts.index',     'module' => 'Abouts',     'as' => 'abouts.index',    'icon' => 'fas fa-address-card',           'parent' => $manageAbout->id, 'parent_show' => $manageAbout->id, 'parent_original' => $manageAbout->id,'sidebar_link' => '1', 'appear' => '1', ]);













    }
}
