<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Mail\otpmail;
use App\Mail\activationMail;
use App\Models\User;
use App\Models\Admin;
use App\Models\create_category;
use App\Models\create_offers;
use App\Models\products;
use App\Models\otp;
use App\Models\order;
use App\Models\contacts;
use App\Models\addtocart;
use App\Models\wishlist;
use App\Models\ratingReview;
use Barryvdh\DomPDF\Facade\Pdf;




class UserController extends Controller
{

    public function login(){
        return view('/.User/login');
    }
public function loginsubmit(Request $r){
    
    $validator = Validator::make($r->all(), [
        'email' => 'required|email',
        'password' => [
            'required',
            'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$^*&!])(?=.*[a-z]).{5,30}$/'
        ],
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $credentials = ['email' => $r->email, 'password' => $r->password];

    if (Auth::guard('web')->attempt($credentials)) {
        $user = Auth::guard('web')->user(); // Get the authenticated user

        if ($user->status == 'Block') {
            Auth::guard('web')->logout();
            return redirect()->back()->with(['danger' => 'Your account is blocked. Please contact us at Shoppy!']);
        } elseif ($user->status == 'Active') {
            return redirect('/'); // Redirect to user index page
        } elseif ($user->status == 'Inactive') {
            Auth::guard('web')->logout();
            return redirect()->back()->with(['danger' => 'Your account is not verified.']);
        } else {
            Auth::guard('web')->logout();
            return redirect()->back();
        }
    } else {
        // Authentication failed
        return redirect()->back()->with(['danger' => 'Invalid email or password']);
    }

    return redirect('/');
}

public function Logout(){
        Session::flush();
        Auth::guard('web')->logout();
        return redirect('/');
    }
    public function sign_up(){
        return view('./User/sign_up');
    }

public function register(Request $r) {
    // Validation with unique email check
    $validator = Validator::make($r->all(), [
        'name' => 'required|regex:/^[A-Za-z\s]+$/',
        'email' => 'required|email|unique:users,email', // Check if email is unique in users table
        'gender' => 'required',
        'password' => 'required|confirmed|regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$^*&!])(?=.*[a-z]).{5,30}$/',
        'password_confirmation' => 'required',
        'address' => 'required',
        'number' => 'required|digits:10|unique:users,mobile', // Check if mobile number is unique in users table
        'pincode' => 'required',
    ]);
    
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    $emailCount=User::where('email',$r->email)->count();
    if($emailCount>0){
        return redirect()->back()->withErrors(['email','Email is already register'])->withInput();
    }else{
        $pwd = Hash::make($r['password']);
        $user = User::create([
        'fullname' => $r['name'], 
        'email' => $r['email'],
        'mobile' => $r['number'],
        'gender' => $r['gender'],
        'password' => $pwd,
        'address' => $r['address'],
        'pincode' => $r['pincode']
        ]);
        if($user){
            $hashedToken=hash('sha256',rand(1000, 9999));
            $otp = Otp::create([
            'user_id' => $user->id,
            'status'=>'User',
            'token' =>$hashedToken,
            ]);
            Mail::to($user->email)->send(new activationMail($user->fullname, $user->id, $hashedToken));
        }else{
            return redirect('login')->with('danger', 'Registration failed. Please try again.');
        }
        return redirect('login')->with('success', 'Registration Successfully.Check your email for verification.');
    }
}

public function Activation($id,$token){
    $otp=otp::where('user_id',$id)->where('token',$token)->first();
    if($otp->status=='User'){
        $user=User::where('id',$otp->user_id)->first();
        $user->status='Active';
        $user->save();
        otp::where('id',$otp->id)->delete();
        return redirect('/login');
    }
    if($otp->status=='Admin'){
        $user=Admin::where('id',$otp->user_id)->first();
        $user->status='Admin';
        $user->save();
        otp::where('id',$otp->id)->delete();
        return redirect('/Adminlogin');
    }
}    
public function Adminlogin() {
    if (Auth::guard('web')->check()) {
        $user=Auth::guard('web')->user();
        return view('User.Adminlogin', compact('user')); // Pass the user to the view if needed
    }
    
    return view('User.Adminlogin'); // Default view if no session is set
}


public function Adminloginsubmit(Request $r){
    // Validate the input
    $validator = Validator::make($r->all(), [
        'email' => 'required|email',
        'password' => [
            'required',
            'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$^*&!])(?=.*[a-z]).{5,30}$/'
        ],
    ]);

    // If validation fails, redirect back with errors and input
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $credentials = ['email' => $r->email, 'password' => $r->password];

    // Authenticate the admin
    if (Auth::guard('admin')->attempt($credentials)) {
        $admin = Auth::guard('admin')->user(); // Use user() method to get the authenticated admin
        
        // Check admin status
        if ($admin->status == 'Block') {
            Auth::guard('admin')->logout();
            return redirect()->back()->with('danger', 'Your account is blocked. Please contact Shoppy!');
        } elseif ($admin->status == 'Owner') {
            return redirect('/Owner'); // Redirect to owner dashboard
        } elseif ($admin->status == 'Admin') {
            return redirect('/AdminIndex'); // Redirect to admin index page
        } elseif ($admin->status == 'Active') {
            Auth::guard('admin')->logout();
            return redirect()->back()->with('danger', 'Your account is not verified yet.');
        } elseif ($admin->status == 'Pending') {
            return redirect()->back()->with('danger', 'Your account is not activated. Check your email.');
        } else {
            // Log out if the status is unrecognized
            Auth::guard('admin')->logout();
            return redirect()->back()->with('danger', 'Invalid account status.');
        }
    } else {
        // Authentication failed
        return redirect()->back()->with('danger', 'Invalid email or password.');
    }
}

    public function Adminsingup(){
        return view('User.Adminsingup');
    }
   
    
public function Adminsingupform(Request $r){
    $validator = Validator::make($r->all(), [
        'name' => 'required|regex:/^[A-Za-z\s]+$/',
        'email' => 'required|email',
        'gender' => 'required',
        'password' => 'required|confirmed|regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$^*&!])(?=.*[a-z]).{5,30}$/',
        'password_confirmation' => 'required',
        'address' => 'required',
        'number' => 'required|digits:10',
        'pincode' => 'required',
        'brand' => 'required|max:15',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $pwd = Hash::make($r['password']);
    $emailCount = Admin::where('email', $r->email)->count();
    $mobileCount = Admin::where('mobile', $r->number)->count();

    if ($emailCount != 0) {
        return redirect()->back()->withErrors(['email' => 'Email already exists.'])->withInput(); // Fixed syntax
    }

    if ($mobileCount != 0) {
        return redirect()->back()->withErrors(['number' => 'Number already exists.'])->withInput(); // Fixed syntax
    }

    if ($emailCount == 0 && $mobileCount == 0) {
        $user = Admin::create([
            'fullname' => $r['name'],
            'email' => $r['email'],
            'mobile' => $r['number'],
            'gender' => $r['gender'],
            'password' => $pwd,
            'address' => $r['address'],
            'pincode' => $r['pincode'],
            'brand' => $r['brand'],
        ]);

        if ($user) {
            $hashedToken = hash('sha256', rand(1000, 9999));
            $otp = Otp::create([
                'user_id' => $user->id,
                'status' => 'Admin',
                'token' => $hashedToken,
            ]);

            Mail::to($user->email)->send(new activationMail($user->fullname, $user->id, $hashedToken));
            return redirect('/Adminlogin')->with('success', 'Registration successful. Check your email for verification.');
        } else {
            return redirect('login')->with('danger', 'Registration failed. Please try again.');
        }
    }
}



    
// User
    public function footer()
     {
        return view('./User/footer');
        
    }
public function UserProfile(){
            $user=Auth::guard('web')->user();
                return view('User.Profile',compact('user'));
    }
public function ProfileUpdate(){
         $user=Auth::guard('web')->user();
                return view('User.ProfileUpdate',compact('user'));
    }
public function ProfileUpdateForm(Request $r){
    // Validation rules
    $validator = Validator::make($r->all(), [
        'fullname' => 'required|min:2|regex:/^[a-zA-Z\s]+$/|max:20', // Alphabetical characters and spaces only
        'gender' => 'required', // Gender is required
        'email' => 'required|email|max:50', // Valid email
        'mobile' => 'required|numeric|digits:10', // 10-digit mobile number
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Check if user is authenticated
    if (Auth::guard('web')->check()) {
        $user = Auth::guard('web')->user();
        
        // Update user details
        $user->fullname = $r->fullname;
        $user->gender = $r->gender;
        $user->email = $r->email;
        $user->mobile = $r->mobile;
        $user->save(); // Save updated user information

        return redirect('/UserProfile')->with('success', 'Profile updated successfully!');
    }

    return redirect('/UserProfile')->with('error', 'User is not authenticated.');
}

    public function Setting(){
        $user=Auth::guard('web')->user();
        return view('User.Setting',compact('user'));
    }
public function UserProfileForm(Request $r){
    if (Auth::guard('web')->check()) {
        $user = Auth::guard('web')->user();

        // Check if a profile image was uploaded
        if ($r->hasFile('profile_image')) {
            // If the user already has a profile image, delete the old one
            if (!empty($user->image)) {
                if (file_exists('Profile/' . $user->image)) {
                    unlink('Profile/' . $user->image); // Delete old image
                }
            }

            // Get the file extension and generate a unique name
            $file = $r->file('profile_image');
            $extension = $file->getClientOriginalExtension();
            $originalName = time() . '.' . $extension;

            // Move the file to the "Profile" directory
            $file->move(public_path('Profile'), $originalName);

            // Update the user's profile image
            $user->image = $originalName;
            $user->save();

            return redirect()->back()->with('success', 'Profile image updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Please upload a profile image.');
        }
    } else {
        return redirect()->route('login')->with('error', 'Please log in to update your profile.');
    }
}

public function SettingForm(Request $r){
    // Validate the request input
    $validator = Validator::make($r->all(), [
        'currentPassword' => [
            'required',
            'regex:/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[!@#$%^&*]).{4,20}$/'
        ],
        'newPassword' => [
            'required',
            'same:confirmPassword',  // This ensures newPassword must match confirmPassword
            'regex:/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[!@#$%^&*]).{4,20}$/'
        ],
        'confirmPassword' => 'required|string|max:255', // Change to confirmPassword for consistency
    ]);

    // Redirect back with validation errors if validation fails
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Get the authenticated user
    $user = Auth::guard('web')->user();

    // Check if the current password matches the one in the database
    if (Hash::check($r->currentPassword, $user->password)) {
        // Update the user's password
        $user->password = Hash::make($r->newPassword);
        $user->save();

        Mail::to($user->email)->send(new PasswordChanged($user->fullname));
        return redirect('/UserSetting')->with('success', 'Password changed successfully!');
    } else {
        // Return back with an error if the current password doesn't match
        return redirect()->back()->withErrors([
            'currentPassword' => 'Current password does not match.'
        ]);
    }
}


    public function home(){
        $category=create_category::all();
        $offer=create_offers::all();
        $product=products::where('status','Active')->orderBy('id', 'desc')->get();
        if(Auth::guard('web')->check()){
            $user=Auth::guard('web')->user();
            return view('./User/home',compact('category','offer','product','user'));
        } else {
        return view('./User/home',compact('category','offer','product'));
        }
    }
public function cart() {
    $currentDate = Carbon::now()->toDateString();
    $user = Auth::guard('web')->user();
    $cart = addtocart::where('userid', $user->id)->orderBy('id', 'desc')->get();
    $totalCart=addtocart::where('userid', $user->id)->count();
    $product=products::orderBy('id', 'desc')->get();
    $offer=create_offers::all();
    $admin=Admin::all();
    return view('User.cart', compact('currentDate','user', 'cart','product','totalCart','admin','offer'));
}

public function AddCart($id) {
    $user=Auth::guard('web')->user();
    $AddtoCartCount=addtocart::where('userid',$user->id)->where('productid',$id)->count();
    if($AddtoCartCount==0){
        addtocart::create([
            'productid' => $id,
            'userid' => $user->id
        ]);
        return redirect()->back()->with('success', 'Product added successfully!!!');
    }else{
        return redirect()->back()->with('success', 'Product is already added!!!');
    }
}

public function RemoveCart($type, $id) {
    if ($type == 'Remove') {
        addtocart::where('userid', session('id'))->delete();
    } 
    if ($type == 'Delete') {
        addtocart::where('id', $id)->delete();
    }
    if($type == 'Wishlist'){

    }
    
    return redirect()->back();
}
public function AddWishlist($type, $id){
    $user=Auth::guard('web')->user();
    if ($type == 'Add') {
    wishlist::create([
        'productid' => $id,
        'userid' =>$user->id
    ]);
    }
    if($type == 'Delete'){
        wishlist::where('id',$id)->where('userid',$user->id)->delete();
    }
    return redirect()->back();
}

public function Search($item){
    $category = create_category::all();
    $offer = create_offers::all();
    $rating=[];
    $ratingReviewCount=ratingReview::all()->count();
    if($ratingReviewCount>0){
        $rating=ratingReview::all();
    }
    // Fetch products based on the category and count the products
    $product = products::where('category', $item)->orderBy('id', 'desc')->get();
    $productCount = $product->count();

    if (Auth::guard('web')->check()) {
        $user = Auth::guard('web')->user();

        // Get wishlist and wishlist count in one query
        $wishlist = wishlist::where('userid', $user->id)->get();
        $wishlistCount = $wishlist->count();

        return view('./User/Search', compact('category', 'offer', 'product', 'user', 'wishlist', 'wishlistCount', 'productCount','rating'));
    } else {
        return view('./User/Search', compact('category', 'offer', 'product', 'productCount','rating'));
    }
}
public function SearchForm(Request $r){
    if (empty($r->search)) {
        return redirect()->back();
    }
    
    $item = $r->search;
    
    // If the search item is 'cloth', map it to 'Fashion'
    if ($item == 'cloth') {
        $item = 'Fashion'; // Fixed: added missing semicolon
    }
    
    $category = create_category::all();
    $offer = create_offers::all();
    $rating=[];
    $ratingReviewCount=ratingReview::all()->count();
    if($ratingReviewCount>0){
        $rating=ratingReview::all();
    }

    // Fetch products based on the category, description, price, size, brand, or name
    $product = products::where('category', 'like', '%' . $item . '%')
    ->orWhere('description', 'like', '%' . $item . '%')
    ->orWhere('price', 'like', '%' . $item . '%')
    ->orWhere('size', 'like', '%' . $item . '%')
    ->orWhere('brand', 'like', '%' . $item . '%')
    ->orWhere('name', 'like', '%' . $item . '%')
    ->orderBy('id', 'desc')->where('status','Active')
    ->get();

    
    $productCount = $product->count();

    // If no products are found, search the offers and fetch products based on offer's category
    if ($productCount == 0) {
        $offer = create_offers::where('name', $item)
            ->orWhere('discount', $item)
            ->first();
        
        if ($offer) {
            $product = products::where('category', $offer->category)->get();
            $productCount = $product->count();
        }
    }

    if (Auth::guard('web')->check()) {
        $user = Auth::guard('web')->user();
        $wishlist = wishlist::where('userid', $user->id)->get();
        $wishlistCount = wishlist::where('userid', $user->id)->count();

        return view('./User/Search', compact('category', 'offer', 'product', 'user', 'wishlist', 'wishlistCount', 'productCount','rating'));
    } else {
        return view('./User/Search', compact('category', 'offer', 'product', 'productCount','rating'));
    }
}

public function allproduct($id) {
    // Fetch the product by ID
    $product = products::find($id);

    // Retrieve the category associated with the product
    $category = create_category::where('name', $product['category'])->get();

    // Count the number of offers available for the product's category
    $offerCount = create_offers::where('category', $product['category'])->count();

    // Count the number of ratings/reviews for the product
    $ratingReviewCount = ratingReview::where('productid', $id)->count();
    $ratingReviews = []; // Initialize empty array for reviews
    $userdetails=[];
    // Determine offers based on category or 'All'
    if ($offerCount == 0) {
        $offer = create_offers::where('category', 'All')->get();
    } else {
        $offer = create_offers::where('category', $product['category'])
                               ->orWhere('category', 'All')
                               ->get();
    }

    // Fetch rating reviews if any exist
    if ($ratingReviewCount > 0) {
        $ratingReviews = ratingReview::where('productid', $id)->get();
        $userdetails=User::all();
    }

    // Check if a user is logged in and retrieve wishlist count if so
    if (Auth::guard('web')->check()) {
        $user = Auth::guard('web')->user();
        $wishlistCount = Wishlist::where('productid', $id)
                                 ->where('userid', $user->id)
                                 ->count();
        // Return view with user-related data
        if($product->status =="Active"){
            return view('User/allproduct', compact(
            'category', 'offer', 'product', 'user', 'wishlistCount', 'ratingReviewCount', 'ratingReviews','userdetails'
        ));
        }else{
            return redirect('/')->with('error', 'Product is not available!!!');
        }
    }

    // Return view without user-related data for guests
    return view('User/allproduct', compact('product', 'category', 'offer', 'ratingReviewCount', 'ratingReviews','userdetails'));
}


public function conform_buy(Request $r,$id,$quantity){
        $user=User::find(1);
        $size=$r['size'];
        $product = products::find($id);
    $category = create_category::where('name', $product['category'])->get();
    $count = create_offers::where('category', $product['category'])->count();
    $offer = null;
    if ($count == 0) {
        $offer = create_offers::where('category', 'All')->get();
    } else {
        $offer = create_offers::where('category', $product['category'])->orwhere('category','All')->get();
    }
        return view('User.conform_buy', compact('product', 'category', 'offer','user','size','quantity'));
    }
public function conformBuy($id,$quantity,$size){
        $user=User::find(1);
        $product = products::find($id);
    $category = create_category::where('name', $product['category'])->get();
    $count = create_offers::where('category', $product['category'])->count();
    $offer = null;
    if ($count == 0) {
        $offer = create_offers::where('category', 'All')->get();
    } else {
        $offer = create_offers::where('category', $product['category'])->orwhere('category','All')->get();
    }
        return view('User.conform_buy', compact('product', 'category', 'offer','user','size','quantity'));
    }
public function contact(Request $r)
{
    // Validate the incoming request
    $validator = Validator::make($r->all(), [
        'email' => 'required|email',
        'problem' => 'required',
    ]);

    // If validation fails, redirect back with errors and input
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
    $mail=$r->email;

    // Attempt to create a new contact
    contacts::create([
        'email' => $mail,
        'problem' => $r->problem,
    ]);

    
        return redirect()->back()->with('success', 'Contact created successfully.');
 
}

 public function UpdateAddress(Request $r, $id) {
    $user = User::find($id);
    $user->address = $r['address'];
    $user->pincode = $r['pincode'];
    $user->save();
    return redirect()->back();
}

    public function masterview(){
        return view('./User/masterview');
    }

public function AddBuy(Request $r, $id, $quantity, $size, $discount) {
    $user = Auth::guard('web')->user();
    $product = products::find($id);
    $admin = Admin::where('id', $product['adminid'])->first();

    // Calculate prices
    $discountPrice = ($product['price'] * $discount) / 100;
    $originalPrice = $product['price'] - $discountPrice;
    $totalDiscountPrice = $discountPrice * $quantity;
    $totalPrice = $quantity * $originalPrice;

    // Set locale and calculate dates
    Carbon::setLocale('en_IN');
    $orderDate = Carbon::now()->toDateString(); 
    $deliveryDate = Carbon::now()->addDays(7)->toDateString(); 

    // Copy the product image to the Order folder
    $sourcePath = public_path('Product/' . $product->mainimage); // Source path
    $extension = pathinfo($product->mainimage, PATHINFO_EXTENSION);
    $originalImage = time() . '.' . $extension;
    $destinationPath = public_path('Order/' . $originalImage); // Destination path with new name

    if (file_exists($sourcePath)) {
        copy($sourcePath, $destinationPath); // Copy the file
    }

    // Create the order
    $order = order::create([
        'adminid' => $product->adminid,
        'user_id' => $user->id,
        'product_id' => $product->id,
        'name' => $product->name,
        'size' => $size,
        'quantity' => $quantity,
        'total_price' => $totalPrice,
        'price' => $product->price,
        'discount' => $discount,
        'discount_price' => $totalDiscountPrice,
        'payment_method' => 'cash',
        'status' => 'processing',
        'pincode' => $user->pincode,
        'shipping_fee' => 'free',
        'tracking_number' => $user->mobile,
        'tracking_address' => $user->address,
        'order_date' => $orderDate,
        'delivery_date' => $deliveryDate,
        'image' => $originalImage
    ]);

    // Update product stock
    $product->stock -= $quantity;
    $product->save();

    // Redirect to the Buy page
    return redirect('/Buy');
}



    public function BuyPage(){
        $user=Auth::guard('web')->user();
        $order=order::where('user_id',$user->id)->orderBy('created_at', 'desc')->get();
        $admin=Admin::all();
        $ratingReviewCount=ratingReview::where('userid',$user->id)->count();
        $rating=[];
        if($ratingReviewCount>0){
            $rating=ratingReview::where('userid',$user->id)->get();
        }
         return view('User.Buy',compact('user','order','admin','rating','ratingReviewCount'));
    }
    public function BuyPageRating($id){
        $user=Auth::guard('web')->user();
        $order=order::where('user_id',$user->id)->orderBy('created_at', 'desc')->get();
        $admin=Admin::all();
        $ratingReviewCount=ratingReview::where('userid',$user->id)->count();
        $rating=[];
        if($ratingReviewCount>0){
            $rating=ratingReview::where('userid',$user->id)->get();
        }
        return view('User.Buy',compact('user','order','admin','id','rating','ratingReviewCount'));
    }
public function RatingForm(Request $r, $id){
       $validator = Validator::make($r->all(), [
            'rating' => 'required|numeric|between:1,5', 
            'review' => [
                'required',
                'min:3'
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    $order=order::where('id',$id)->first();
    $user = Auth::guard('web')->user();
    $rating=ratingReview::create(['userid'=>$user->id,'productid'=>$order->product_id,'rating'=>$r->rating,'review'=>$r->review]);
    if($rating->save()){
        return redirect('/Buy')->with('success','Thank you for rating this product');
    }else{
        return redirect('/Buy')->with('warning','Due to technical issue rating is not done. please try a later.');
    }
}

    
public function OrderAction($type, $id) {
    $user = Auth::guard('web')->user();
    
    // Find the order and product
    $order = order::where('id', $id)->where('user_id', $user->id)->first();
    
    if (!$order) {
        // Handle case where order is not found
        return redirect()->back()->withErrors('Order not found.');
    }
    
    $product = products::where('id', $order->product_id)->first();
    
    if (!$product) {
        // Handle case where product is not found
        return redirect()->back()->withErrors('Product not found.');
    }
    
    // Process the order action based on type
    switch ($type) {
        case 'Cancel':
            $product->stock += $order->quantity;
            $order->status = 'Cancelled';
            break;
            
        case 'Refund':
            $order->status = 'Refund';
            break;
            
        case 'RefundCancel':
            $order->status = 'Completed';
            break;
            
        default:
            return redirect()->back()->withErrors('Invalid action type.');
    }
    
    // Save the product and order changes
    $product->save();
    $order->save();
    
    return redirect()->back()->with('success', 'Order updated successfully.');
}

    public function rating(){
        return view('User.rating');
    }
    public function Wishlist(){
         $category=create_category::all();
        $offer=create_offers::all();
        $product=products::orderBy('id', 'desc')->get();
            $user=Auth::guard('web')->user();
            $wishlist=wishlist::where('userid',$user->id)->get();
            $wishlistCount=wishlist::where('userid',$user->id)->count();
            return view('./User/Wishlist',compact('category','offer','product','user','wishlist','wishlistCount'));
    }
public function Forget($status){
    if(Auth::guard('web')->check()){
        $user=Auth::guard('web')->user();
        return view('User.Forget',compact('status','user'));
    }else{
        return view('User.Forget',compact('status'));
    }
}
public function ForgetSubmit(Request $r, $status) {
    // Validate the request
    $validator = Validator::make($r->all(), [
        'email' => 'required|email|max:50',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
    if($status=='User'){
        $user = User::where('email', $r->email)->first();
    }
    if($status=='Admin'){
        $user = Admin::where('email', $r->email)->first();
    }    
    if ($user) {
        // Count existing OTPs for this user and status
        otp::where('user_id', $user->id)->where('status', $status)->delete();
        // If no OTP has been sent, create a new one
            $hashedToken= hash('sha256', rand(100000, 999999)); // Hash the token for storage

            // Create a new OTP entry
            otp::create([
                'status' => $status,
                'user_id' => $user->id,
                'token' => $hashedToken
            ]);

            // Send the plain OTP via email
            Mail::to($user->email)->send(new otpmail($user->fullname, $user->id, $hashedToken)); // Use plain token in the email

            // Redirect based on user status
            if ($status == 'User') {
                return redirect('/login')->with('success', 'An OTP has been sent to your email.');
            } elseif ($status == 'Admin') {
                return redirect('/Adminlogin')->with('success', 'An OTP has been sent to your email.');
            }
    } else {
        return redirect()->back()->with('danger', 'This email is not registered. Please enter a valid email address.');
    }
}
public function ResetPassword($status,$token){
        return view('User.ResetPassword',compact('token','status'));
    }
public function ResetPasswordSubmit(Request $r, $status, $token) {
    // Validate the request
    $validator = Validator::make($r->all(), [
        'newpassword' => 'required|regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*]).{4,20}$/',
        'conformpassword' => 'required|same:newpassword', // Match this with the form input name
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Find the OTP record
    $otp = otp::where('token', $token)->where('user_id', $status)->first();

    if (!$otp) {
        return redirect()->back()->withErrors(['token' => 'Invalid or expired token.']);
    }

    // Hash the new password
    $hashedPassword = Hash::make($r->newpassword);
    $type = $otp->status;

    if ($type == 'User') {
        // Update User password
        $user = User::find($otp->user_id);
        if ($user) {
            $user->password = $hashedPassword;
            $user->save();
        }
    } elseif ($type == 'Admin') {
        // Update Admin password
        $user = Admin::find($otp->user_id);
        if ($user) {
            $user->password = $hashedPassword;
            $user->save();
        }
    }

    // Delete the OTP record
    otp::where('token', $token)->where('user_id', $status)->delete();

    // Redirect based on status
    if ($type == 'User') {
        return redirect('/login')->with('success', 'Password reset successfully!');
    } elseif ($type == 'Admin') {
        return redirect('/Adminlogin')->with('success', 'Password reset successfully!');
    }
}



    // for admin forget 
    public function AdminForget(){
        return view('User.AdminForget');
    }
    public function AdminForgetSubmit(Request $r){
        $validator = Validator::make($r->all(), [
            'email' =>'required|email|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }

        return redirect('AdminForgetOtpPage')->with('success', 'Product added successfully!');
    }
    public function AdminForgetOtpPage(){
        return view('User.AdminForgetOtp');
    }
public function AdminForgetOtp(Request $r){
    // Combine OTP input into a single string
    $otp = implode('', $r->input('otp'));

    // Validate the OTP
    $validator = Validator::make(['otp' => $otp], [
        'otp' => 'required|digits:4',
    ]);

    // If validation fails, redirect back with errors
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // If OTP is valid, redirect to the reset password page
    return redirect('AdminResetPassword')->with('success', 'OTP verified successfully!');
}

    public function AdminResetPassword(){
        return view('User.AdminResetPassword');
    }
    public function AdminResetPasswordSubmit(Request $r){
        $validator = Validator::make($r->all(), [
            'newpassword' =>'required|regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*]).{4,20}$/',
            'conformpassword' =>'required|same:newpassword',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }

        return redirect('Adminlogin')->with('success', 'Password reset successfully!');
    }



    // invoic download 
public function InvoiceDownload($type,$id) {
    $order=order::where('id',$id)->first();
    $user=Auth::guard('web')->user();
    $saller=Admin::where('id',$order->adminid)->first();
    $data=['order'=>$order,'user'=>$user,'saller'=>$saller];
    $date=Carbon::now()->format('d-m-y');
    // return view('RecipitGenerator/InvoiceGenerator',compact('order','user','saller'));
    $pdf = Pdf::loadView('RecipitGenerator/InvoiceGenerator', $data);
    return $pdf->download('invoice-'.$id.'-'.$date.'pdf');
}
}
