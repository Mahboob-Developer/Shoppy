<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReply;
use App\Mail\PasswordChanged;
use App\Models\User;
use App\Models\Admin;
use App\Models\products;
use App\Models\create_category;
use App\Models\create_offers;
use App\Models\addtocart;
use App\Models\order;
use App\Models\wishlist;
use App\Models\contacts;
use App\Models\ratingReview;
use Barryvdh\DomPDF\Facade\Pdf;




class Owner extends Controller
{
    public function Dashboard(){
        $admin=Auth::guard('admin')->user();
        $adminCount=Admin::where('status','Pending')->count();
        return view('Owner.Dashboard',compact('admin','adminCount'));
    }// YourController.php
public function ProductDetails() {
        $admin=Auth::guard('admin')->user();
        $adminCount=Admin::where('status','Pending')->count();
    $products = Products::orderBy('id', 'desc')->get();
    return view('Owner.ProductDetail',compact('products','adminCount','admin'));
}
public function ProductDetailsAction($id,$type) {
     $admin=Auth::guard('admin')->user();
        $adminCount=Admin::where('status','Pending')->count();
    $products = Products::orderBy('id', 'desc')->get();
    return view('Owner.ProductDetail',compact('products','adminCount','admin'));
}
    
public function ProductDetailsActionForm(Request $r, $id, $button){
    // Fetch the product by ID
    $product = products::where('id', $id)->first();

    // Check if the product exists
    if (!$product) {
        return redirect()->back()->with('error', 'Product not found.');
    }

    // Perform action based on the button clicked
    if ($button === 'Block') {
        $product->status = 'Block';
    } elseif ($button === 'Unblock') {
        $product->status = 'Active';
    } elseif ($button === 'Delete') {
        // Function to check and delete image if it is not used elsewhere
        $this->deleteImageFromFile($product->mainimage);
        $this->deleteImageFromFile($product->sideone);
        $this->deleteImageFromFile($product->sidetwo);
        $this->deleteImageFromFile($product->sidethree);

        // Delete the product
        $product->delete();

        return redirect('ProductDetails');
    }

    // Save changes if not deleted
    $product->save();

    return redirect('ProductDetails');
}

private function deleteImageFromFile($imageName){
    if ($imageName) {
        $imageCount = products::where('mainimage', $imageName)
            ->orWhere('sideone', $imageName)
            ->orWhere('sidetwo', $imageName)
            ->orWhere('sidethree', $imageName)
            ->count();

        if ($imageCount == 1) {
            $imagePath = public_path('Product/' . $imageName);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    }
}
public function UserDetails(){
    $admin = Auth::guard('admin')->user();
    $adminCount = Admin::where('status', 'Pending')->count();
    $userDetail = User::orderBy('id', 'desc')->get();
    $presentUser=['status'=>'Active'];
    // Return the view with the user details
    return view('Owner.User', compact('userDetail', 'adminCount', 'admin','presentUser'));
}
public function UserDetailsAction($id){
    $admin = Auth::guard('admin')->user();
    $adminCount = Admin::where('status', 'Pending')->count();
    $userDetail = User::orderBy('id', 'desc')->get();
    $presentUser = User::where('id',$id)->first(); 
    $CartCount=addtocart::where('userid',$id)->count();
    $BuyCount=order::where('user_id',$id)->count();
    // Return the view with the user details
    return view('Owner.User', compact('userDetail', 'adminCount', 'admin','id','presentUser','CartCount','BuyCount'));
}
public function UserAction($type, $id)
{
        $currentDate = Carbon::now()->toDateString();
    // Find the user by ID
    $user = User::find($id);

    // Check if the user exists
    if (!$user) {
        return redirect()->back()->with('danger', 'User not found.');
    }

    switch ($type) {
        case 'Block':
            $user->status = 'Block';
            $user->save();
            return redirect('/User');

        case 'Unblock':
            $user->status = 'Active'; 
            $user->save();
            return redirect('/User');

        case 'Cart':
            $admin=Auth::guard('admin')->user();
        $adminCount=Admin::where('status','Pending')->count();
        // for cart 
        $user = User::where('id',$id)->first();
        $cart = addtocart::where('userid', $user->id)->orderBy('id', 'desc')->get();
        $totalCart=addtocart::where('userid', $user->id)->count();
        $product=products::orderBy('id', 'desc')->get();
        $offer=create_offers::all();
        $adminDetails=Admin::all();
        return view('Owner.CartDetails',compact('admin','adminCount','user','cart','totalCart','product','offer','adminDetails','currentDate'));

        case 'Order':
            $admin=Auth::guard('admin')->user();
        $adminCount=Admin::where('status','Pending')->count();
        $order=order::where('user_id',$id)->orderBy('created_at', 'desc')->get();
        $orderCount=order::where('user_id',$id)->count();
        $saller=Admin::where('status','Admin')->get();
        $ratingReviewCount=ratingReview::where('userid',$user->id)->count();
        $user=User::where('id',$id)->first();
        $rating=[];
        if($ratingReviewCount>0){
            $rating=ratingReview::where('userid',$user->id)->get();
        }
        return view('Owner.OrderDetails',compact('user','saller','admin','adminCount','order','orderCount','rating'));

        case 'Delete':
            $wishlist=wishlist::where('userid', $user->id)->count();
            if($wishlist>0){
                wishlist::where('userid', $user->id)->delete();
            }
            $order=order::where('user_id', $user->id)->count();
            if($order>0){
                order::where('user_id', $user->id)->delete();
            }
            $addtocart=addtocart::where('userid', $user->id)->count();;
            if($addtocart>0){
                addtocart::where('user_id', $user->id)->delete();
            }

            if ($user->image == '') {
                $user->delete();
                return redirect('/User')->with('success', 'User deleted successfully.');
            } else {
                    $imagePath = public_path('Profile/' . $user->image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                $user->delete();
                return redirect('/User')->with('success', 'User and image deleted successfully.');
            }

        default:
            return redirect()->back()->with('danger', 'Invalid action type.');
    }
}
public function OwnerAction($type, $id) {
    if ($type == 'Delete') {
        addtocart::where('id', $id)->delete();
    }
    return redirect()->back();
}


public function UserBlock(Request $r, $id,$button) {
    return view('Owner.User',  ['id' => $id, 'button' => $button]);
}
public function UserBlockSuccess(Request $r) {
    return redirect('User');
}
public function UserUnBlock(Request $r, $id,$button) {
    return view('Owner.User', ['id' => $id, 'button' => $button]);
}
public function UserUnBlockSuccess(Request $r) {
    return redirect('User');
}
public function Saller(){
    $admin = Auth::guard('admin')->user();
    $adminCount = Admin::where('status', 'Pending')->count();
    $sallerDetail = Admin::orderBy('id', 'desc')->get();
        return view('Owner.Saller',compact('admin','adminCount', 'sallerDetail'));
}
public function SallerAction($type,$id){
     $admin = Auth::guard('admin')->user();
    $adminCount = Admin::where('status', 'Pending')->count();
    $sallerDetail = Admin::orderBy('id', 'desc')->get();
        return view('Owner.Saller',compact('admin','adminCount', 'sallerDetail','type','id'));
}
public function SallerActionForm(Request $r, $type,$id) {
    $saller = Admin::where('id',$id)->first();

    if ($type == 'Block') {
        $saller->status = 'Block';
    }

    if ($type == 'Unblock') {
        $saller->status = 'Admin';
    }

    if ($type == 'Delete') {
        // Get all products related to the seller
        $products = products::where('adminid', $saller->id)->get();

        foreach ($products as $productItem) {
            // Count the occurrences of each image in the products table
            $imageCounts = [
                'mainimage' => products::where('mainimage', $productItem->mainimage)
                    ->orWhere('sideone', $productItem->mainimage)
                    ->orWhere('sidetwo', $productItem->mainimage)
                    ->orWhere('sidethree', $productItem->mainimage)
                    ->count(),
                'sideone' => products::where('mainimage', $productItem->sideone)
                    ->orWhere('sideone', $productItem->sideone)
                    ->orWhere('sidetwo', $productItem->sideone)
                    ->orWhere('sidethree', $productItem->sideone)
                    ->count(),
                'sidetwo' => products::where('mainimage', $productItem->sidetwo)
                    ->orWhere('sideone', $productItem->sidetwo)
                    ->orWhere('sidetwo', $productItem->sidetwo)
                    ->orWhere('sidethree', $productItem->sidetwo)
                    ->count(),
                'sidethree' => products::where('mainimage', $productItem->sidethree)
                    ->orWhere('sideone', $productItem->sidethree)
                    ->orWhere('sidetwo', $productItem->sidethree)
                    ->orWhere('sidethree', $productItem->sidethree)
                    ->count(),
            ];

            // Delete images if they are only used once
            foreach ($imageCounts as $imageType => $count) {
                if ($count == 1) {
                    $imagePath = $productItem->{$imageType};  // Get image path
                    if (!empty($imagePath) && file_exists('Product/' . $imagePath)) {
                        unlink('Product/' . $imagePath);
                    }
                }
            }
        }

        // Delete all products related to this seller
        products::where('adminid', $saller->id)->delete();
    }
    if(!empty($saller->image)){
        $imageUser=User::where('image',$saller->image)->count();
        $imageAdmin=Admin::where('image',$saller->image)->count();
        if((($imageUser+$imageAdmin)==1) && (file_exists('Profile/' . $saller->image))){
            unlink('Profile/'.$saller->image);
        }
    }

    // Save changes to the seller
    $saller->save();

    return redirect('/Saller');
}

public function ContactUs(){
    $admin = Auth::guard('admin')->user();
    $adminCount = Admin::where('status', 'Pending')->count();
    $contactDetail = contacts::orderBy('id', 'desc')->get();
        return view('Owner.ContactUs',compact('contactDetail', 'adminCount','admin'));
}
public function ContactUsAction($type,$id){
        $admin = Auth::guard('admin')->user();
        $adminCount = Admin::where('status', 'Pending')->count();
        $contactDetail = contacts::orderBy('id', 'desc')->get();
        return view('Owner.ContactUs',compact('contactDetail', 'adminCount','admin','id','type'));
}
public function ContactReplyForm(Request $r, $id){
    // Validate the request
    $validator = Validator::make($r->all(), [
        'subject' => 'required|string|max:255',  // Adding max length validation as well
        'message' => 'required|string|min:10',   // Ensuring a minimum length for the message
    ]);

    // If validation fails, redirect back with errors and old input data
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();  // Keeps old input values in case of validation errors
    }

   $contact = contacts::where('id', $id)->first();
    $contact->status='Done';
    $contact->save();
    Mail::to($contact->email)->send(new ContactReply($r->subject,$r->message));
    return redirect('/ContactUs');

}
public function ContactDeleteFrom(Request $r,$id){
    contacts::where('id', $id)->delete();
    return redirect('/ContactUs');
}

public function Setting(){
    $admin = Auth::guard('admin')->user();
    $adminCount = Admin::where('status', 'Pending')->count();
    return view('Owner.Setting',compact('adminCount','admin'));
    }
 
public function SettingForm(Request $r){
    // Validation rules
    $validator = Validator::make($r->all(), [
        'currentPassword' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[!@#$%^&*]).{4,20}$/',
        'newPassword' => 'required|same:confirmPassword|regex:/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[!@#$%^&*]).{4,20}$/',
        'confirmPassword' => 'required|string|max:255',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Get the authenticated admin
    $admin = Auth::guard('admin')->user();

    // Check if the current password matches
    if (!Hash::check($r->currentPassword, $admin->password)) {
        return redirect()->back()->withErrors(['currentPassword' => 'Current password is incorrect.'])->withInput();
    }

    // Update the password
    $admin->password = Hash::make($r->newPassword); // Hash the new password before saving
    if($admin->save()){ 
    Mail::to($admin->email)->send(new PasswordChanged($admin->fullname));
    return redirect('Setting')->with('success', 'Password updated successfully!');
    }else{
        return redirect()->back()->with('danger', 'Some technical issues have occured please try again later.');
    }
}

public function adminProfile(Request $r) {
    $admin = Auth::guard('admin')->user();
    $image = $r->file('profile_image');
    if (empty($image)) {
        return redirect()->back();
    }
    $extension = $image->getClientOriginalExtension();
    $newImage = time() . '.' . $extension;

    // Move the new image to the 'Profile' directory
    $image->move(public_path('Profile'), $newImage);
    if (!empty($admin->image) && file_exists(public_path('Profile/' . $admin->image))) {
        unlink(public_path('Profile/' . $admin->image));
    }
    $admin->image = $newImage;
    $admin->save();

    return redirect('Account')->with('success', 'Profile updated successfully!');
}

public function Account(){
    $admin = Auth::guard('admin')->user();
    $adminCount = Admin::where('status', 'Pending')->count();
    return view('Owner.Account',compact('adminCount','admin'));
    }
public function ProfileUpdate(){
    $admin = Auth::guard('admin')->user();
    $adminCount = Admin::where('status', 'Pending')->count();
        return view('Owner.AccountUpdate',compact('adminCount','admin'));
    }
public function ProfileAdminUpdate(Request $r) {
    $validator = Validator::make($r->all(), [
        'fullname' => 'required|min:2|regex:/^[a-zA-Z\s]+$/|max:20',
        'gender' => 'required',
        'email' => 'required|email|max:50',
        'mobile' => 'required|regex:/^[0-9]{10}$/|digits:10',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
    $admin = Auth::guard('admin')->user();
    $admin->fullname = $r->fullname;
    $admin->gender = $r->gender;
    $admin->email = $r->email;
    $admin->mobile = $r->mobile;
    $admin->save();
    return redirect('Account')->with('success', 'Profile updated successfully!');
}

// for catagory 
public function Catagorydetails(){
        $admin=Auth::guard('admin')->user();
        $adminCount=Admin::where('status','Pending')->count();
        $catagory = create_category::orderBy('id', 'desc')->get();
        return view('Owner.Catagory',compact('catagory','adminCount','admin'));
    }
public function CatagoryAction($id){
       $admin=Auth::guard('admin')->user();
        $adminCount=Admin::where('status','Pending')->count();
        $catagory = create_category::orderBy('id', 'desc')->get();
        return view('Owner.Catagory',compact('catagory','adminCount','admin','id'));
}
public function CatagoryActionForm(Request $r, $id){
    // Find the category by ID
    $catagory = create_category::find($id);
    if (!$catagory) {
        return redirect('Catagorydetails')->with('error', 'Category not found.');
    }

    // If the image is only used by this category, delete the image file
    if (file_exists(public_path('Catagory/' . $catagory->image))) {
        unlink(public_path('Catagory/' . $catagory->image));
    }

    // Delete the category
    $catagory->delete();

    return redirect('Catagorydetails');
}

public function CatagoryAdd(){
     $admin=Auth::guard('admin')->user();
        $adminCount=Admin::where('status','Pending')->count();
        return view('Owner.CatagoryAdd',compact('admin','adminCount'));
}
public function CatagoryAddForm(Request $r){
    // Validation rules
    $validator = Validator::make($r->all(), [
    'Name' => 'required|string|max:55|min:3',
    'Size' => [
        'required',
        'regex:/^[\S]+$/',  // No spaces allowed
    ],
    'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);


    // Check if validation fails
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Handle the file upload
    $main = $r->file('image');
    $extension=$main->getClientOriginalExtension();
    $mainOriginal =time().'.'.$extension; // Prefix with timestamp to avoid conflicts
    $main->move(public_path('Catagory'), $mainOriginal);

    // Insert into database
    create_category::create([
        'name' => $r->Name,
        'size' => $r->Size,
        'image' => $mainOriginal,
    ]);

    // Redirect to the 'Catagory' route
    return redirect('Catagorydetails');
}
public function CatagoryUpdate(Request $r, $id) {
    // Fetch the category by ID
    $category = create_category::find($id);
    $admin=Auth::guard('admin')->user();
        $adminCount=Admin::where('status','Pending')->count();
    if (!$category) {
        return redirect('Catagorydetails');
    }
    return view('Owner.CatagoryUpdate', compact('id', 'category','admin','adminCount'));
}

public function CatagoryUpdateForm(Request $r, $id){
    // Validate the input data
    $validator = Validator::make($r->all(), [
        'Name' => 'required|string|max:55|min:3',
        'Size' => [
            'required',
            'regex:/^[\S]+$/', // Disallow spaces in size
        ],
        'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Find the category by ID
    $category = create_category::find($id);

    if (!$category) {
        return redirect()->route('Catagorydetails')->with('error', 'Category not found.');
    }

    // Update the category details
    $category->name = $r->Name;
    $category->size = $r->Size;

    // Handle the image file if provided
    if ($r->file('image')) {
        $imageUsageCount = create_category::where('image', $category->image)->count(); 
        
        // Delete the old image if it's only used once and exists
        if (file_exists(public_path('Catagory/' . $category->image))) {
            unlink(public_path('Catagory/' . $category->image));
        }

        // Upload the new image without modifying the original name
        $main = $r->file('image');
        $extension=$main->getClientOriginalExtension();
        $mainOriginal =time().'.'.$extension; // Prefix with timestamp to avoid conflicts
        $main->move(public_path('Catagory'), $mainOriginal);

        $category->image = $mainOriginal;
    }

    // Save the updated category
    $category->save();

    // Redirect to category details page with success message
    return redirect('Catagorydetails');
}

// for offer 
public function OfferDetails(){
    $admin=Auth::guard('admin')->user();
    $adminCount=Admin::where('status','Pending')->count();
    $offer = create_offers::orderBy('id', 'desc')->get();
        return view('Owner.Offer',compact('offer','adminCount','admin'));
    }
public function OfferAdd(){
        $category=create_category::get('name');
        $admin=Auth::guard('admin')->user();
    $adminCount=Admin::where('status','Pending')->count();

        return view('Owner.OfferAdd',compact('category','admin','adminCount'));
    }
public function OfferAddForm(Request $r){
    $validatedData = $r->validate([
        'Name' => 'required|string|max:255',
        'category' => 'required|string',
        'Discount' => 'required|numeric|digits_between:1,2',  
        'starting' => 'required|date',
        'ending' => 'required|date|after_or_equal:starting',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    if ($r['image']) {
        $image = $r->file('image');
        $extension = $image->getClientOriginalExtension();
        $imageOriginalName = time() . '.' . $extension;
        $image->move(public_path('Offer'), $imageOriginalName);
    }

    // Create a new offer
    $offer = create_offers::create([
        'name' => $r['Name'],
        'category' => $r['category'],
        'discount' => $r['Discount'],
        'price' => $r['Price'],
        'starting_date' => $r['starting'],
        'ending_date' => $r['ending'],
        'image' => $imageOriginalName,
    ]);

    // Redirect to the Offer page
    return redirect('OfferDetails');
}
public function OfferDetailsAction($id){
  $admin=Auth::guard('admin')->user();
    $adminCount=Admin::where('status','Pending')->count();
    $offer = create_offers::orderBy('id', 'desc')->get();
        return view('Owner.Offer',compact('offer','adminCount','admin','id'));
}
public function OfferDeleteForm(Request $r, $id){
    $offer = create_offers::find($id);
    if(file_exists(public_path('Offer') . '/' . $offer['image'])){
        unlink(public_path('Offer') . '/' . $offer['image']); 
    }
    $offer->delete();
    return redirect('OfferDetails');
}

public function OfferUpdate($id){
    $admin=Auth::guard('admin')->user();
    $adminCount=Admin::where('status','Pending')->count();
    $category=create_category::get('name');
    $offer=create_offers::find($id);
    if(!$offer)
    {
        return redirect('OfferDetails');
    }
    else{
        return view('Owner.OfferUpdate',compact('offer','category','id','admin','adminCount'));
    }
    }
public function OfferUpdateForm(Request $r, $id) {
    // Validate the request data
    $validatedData = $r->validate([
        'Name' => 'required|string|max:255',
        'category' => 'required|string',
        'Discount' => 'required|numeric|digits_between:1,2',  
        'starting' => 'required|date',
        'ending' => 'required|date|after_or_equal:starting',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    // Find the offer by ID
    $offer = create_offers::find($id);
    if (!$offer) {
        return redirect()->back()->withErrors(['Offer not found.']);
    }

    // Handle the image file if it is provided
    if ($r['image']) {
        $image = $r->file('image');
        $extension = $image->getClientOriginalExtension();
        $imageOriginalName = time() . '.' . $extension;
        $image->move(public_path('Offer'), $imageOriginalName);
        // Check if there is an old image to delete
        if (file_exists(public_path('Offer') . '/' . $offer->image)) {
            unlink(public_path('Offer') . '/' . $offer->image);
        }

        $offer->image = $imageOriginalName; // Update the image field with the new image name
    }

    // Update the offer details
    $offer->name = $r->Name;
    $offer->category = $r->category;
    $offer->discount = $r->Discount;
    $offer->starting_date = $r->starting;
    $offer->ending_date = $r->ending;

    $offer->save(); // Save the offer details

    // Redirect to the OfferDetails page
    return redirect('OfferDetails')->with('success', 'Offer updated successfully.');
}

// for user 
public function ViewUser(){
    return view ('Owner.ViewUser');
}
public function UserCart(){
    return view ('Owner.UserCart');
}

public function InvoiceDownload($type,$userid,$id) {
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