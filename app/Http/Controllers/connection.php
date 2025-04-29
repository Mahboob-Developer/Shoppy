<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordChanged;
use App\Models\products;
use App\Models\User;
use App\Models\create_category;
use App\Models\Admin;
use App\Models\order;
use App\Models\wishlist;
use App\Models\addtocart;

class connection extends Controller
{
    public function LogoutAdmin(Request $r) {
        Auth::guard('admin')->logout();
        return redirect('/Adminlogin');
    }
    public function AdminIndex() {
            $admin = Auth::guard('admin')->user();
            $orderCount=order::where('status','Processing')->count();
            $refundCount=order::where('status','Refund')->where('adminid',$admin->id)->count();
            return view('Admin.Dashboard',compact('admin','orderCount','refundCount'));

    }
    public function ProfileAdmin() {
                     $admin = Auth::guard('admin')->user();
          $orderCount=order::where('status','Processing')->count();
            $refundCount=order::where('status','Refund')->where('adminid',$admin->id)->count();
        return view('Admin.ProfileAdmin',compact('admin','orderCount','refundCount'));
    }
public function adminProfile(Request $r) {
        // Get the uploaded image
       $profileImage = $r->file('profile_image');

        if ($profileImage) {
            $extension = $profileImage->getClientOriginalExtension();
            $profileImageOriginalName = time() . '.' . $extension;
            // Move the new image to the Profile folder
            $profileImage->move(public_path('Profile'), $profileImageOriginalName);
        }

    
        // Find the user by ID
        $admin = Auth::guard('admin')->user();

    if ($admin) {
        // Delete the old image if it exists and is not the default image
        if (!empty($admin->image) && file_exists(public_path('Profile/' . $admin->image))) {
            unlink(public_path('Profile/' . $admin->image)); // Correct the path
        }
        $admin->image = $profileImageOriginalName;

        // Save the updated admin profile
        $admin->save();
    }

            return redirect()->back();
}
    
public function ProfileUpdate(){
        $admin = Auth::guard('admin')->user();

         $orderCount=order::where('status','Processing')->count();
            $refundCount=order::where('status','Refund')->where('adminid',$admin->id)->count();
        return view('Admin.ProfileUpdate',compact('admin','orderCount','refundCount'));
    }
public function ProfileAdminUpdate(Request $r) {
    $validator = Validator::make($r->all(), [
        'fullname' => 'required|min:2|regex:/^[a-zA-Z\s]+$/|max:20',    
        'gender' => 'required',
        'email' => 'required|email|max:50',
        'mobile' => 'required|regex:/^[0-9]{10}$/', // Corrected mobile validation
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


    return redirect('ProfileAdmin');
}

public function Products() {
        $admin = Auth::guard('admin')->user();

         $orderCount=order::where('status','Processing')->count();
            $refundCount=order::where('status','Refund')->where('adminid',$admin->id)->count();
        $products = products::where('adminid',$admin->id)->orderBy('id','desc')->get();
        return view('Admin/Product',compact('products','admin','refundCount','orderCount'));
    }

public function ProductAdd() {
        $admin = Auth::guard('admin')->user();
        $categories = create_category::all();
         $orderCount=order::where('status','Processing')->count();
            $refundCount=order::where('status','Refund')->where('adminid',$admin->id)->count();
        return view('Admin.ProductAdd', compact('categories','admin','refundCount','orderCount'));
    }
    
public function ProductAddform(Request $r) {
        $validator = Validator::make($r->all(), [
            'ProductName' => 'required|string',
            'category' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'productSize' => 'required|array',
            'quantity' => 'required|integer|min:1',
            'product_price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'first' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'second' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'third' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'fourth' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
    // Handle the first file
    $main = $r->file('first');
    $extension = $main->getClientOriginalExtension();
    $mainOriginal = time() . '1.' . $extension;
    $main->move(public_path('Product'), $mainOriginal);

    // Handle the second file
    $sideone = $r->file('second');
    $extension = $sideone->getClientOriginalExtension();
    $sideoneOriginal = time() . '2.' . $extension;
    $sideone->move(public_path('Product'), $sideoneOriginal);

    // Handle the third file
    $sidetwo = $r->file('third');
    $extension = $sidetwo->getClientOriginalExtension();
    $sidetwoOriginal = time() . '3.' . $extension;
    $sidetwo->move(public_path('Product'), $sidetwoOriginal);

    // Handle the fourth file
    $sidethree = $r->file('fourth');
    $extension = $sidethree->getClientOriginalExtension();
    $sidethreeOriginal = time() . '4.' . $extension;
    $sidethree->move(public_path('Product'), $sidethreeOriginal);
    
        // Assuming $r['productSize'] is an array of sizes
        $size = implode(',', $r['productSize']);
        // Store product details in the database
                    $admin = Auth::guard('admin')->user();
        products::create([
            'adminid' => $admin->id,
            'name' => $r['ProductName'],
            'category' => $r['category'],
            'brand' => $r['brand'],
            'size' => $size,
            'quantity' => $r['quantity'],
            'stock' => $r['quantity'],
            'price' => $r['product_price'],
            'description' => $r['description'],
            'mainimage' => $mainOriginal,
            'sideone' => $sideoneOriginal,
            'sidetwo' => $sidetwoOriginal,
            'sidethree' => $sidethreeOriginal,
        ]);
    
        return redirect('Products'); // Adjust this to your actual route
}
    

public function ProductUpdate($id) {
     $admin = Auth::guard('admin')->user();
     $orderCount=order::where('status','Processing')->count();
            $refundCount=order::where('status','Refund')->where('adminid',$admin->id)->count();

    $product = products::find($id);
    $categories = create_category::all(); // Retrieve all categories

    // Check if product exists
    if (!$product) {
        // Redirect to 'Products' if the product is not found
        return redirect('Products');
    }
    // Pass product, id, and categories to the view
    return view('Admin.ProductUpdate',compact('admin','orderCount','refundCount'), [
        'id' => $id,
        'product' => $product,
        'categories' => $categories
    ]);
}
public function ProductUpdateForm(Request $r, $id){
    // Validation
    $validator = Validator::make($r->all(), [
        'ProductName' => 'required|string',
        'category' => 'required|string|max:255',
        'brand' => 'required|string|max:255',
        'productSize' => 'required|array',
        'quantity' => 'required|numeric|min:2',
        'product_price' => 'required|numeric|min:2',
        'description' => 'required|string',
        'first' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'second' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'third' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'fourth' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    // Handle validation failure
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Retrieve the product to update
    $admin = Auth::guard('admin')->user();
    $product = products::find($id);

    if (!$product) {
        return redirect()->back()->with('error', 'Product not found.');
    }


    // Handle main image (first)
    if ($r->hasFile('first')) {
        $main = $r->file('first');
        $extension = $main->getClientOriginalExtension();
        $mainOriginal = time() . '1.' . $extension;
        $main->move(public_path('Product/'), $mainOriginal);
        if (file_exists(public_path('Product/'.$product->mainimage))) {
            unlink(public_path('Product/'.$product->mainimage));
        }
        $product->mainimage = $mainOriginal;
    }

    // Handle second image
    if ($r->hasFile('second')) {
        $sideone = $r->file('second');
        $extension = $sideone->getClientOriginalExtension();
        $sideoneOriginal = time() . '2.' . $extension;
        $sideone->move(public_path('Product/'), $sideoneOriginal);
        if (file_exists(public_path('Product/'.$product->sideone))) {
            unlink(public_path('Product/'.$product->sideone));
        }
        $product->sideone = $sideoneOriginal;
    }

    // Handle third image
    if ($r->hasFile('third')) {
        $sidetwo = $r->file('third');
        $extension = $sidetwo->getClientOriginalExtension();
        $sidetwoOriginal = time() . '3.' . $extension;
        $sidetwo->move(public_path('Product/'), $sidetwoOriginal);
        if (file_exists(public_path('Product/'.$product->sidetwo))) {
            unlink(public_path('Product/'.$product->sidetwo));
        }
        $product->sidetwo = $sidetwoOriginal;
    }

    // Handle fourth image
    if ($r->hasFile('fourth')) {
        $sidethree = $r->file('fourth');
        $extension = $sidethree->getClientOriginalExtension();
        $sidethreeOriginal = time() . '4.' . $extension;
        $sidethree->move(public_path('Product/'), $sidethreeOriginal);
        if (file_exists(public_path('Product/'.$product->sidethree))) {
            unlink(public_path('Product/'.$product->sidethree));
        }
        $product->sidethree = $sidethreeOriginal;
    }

    // Update other product fields
    $product->name = $r->input('ProductName');
    $product->category = $r->input('category');
    $product->brand = $r->input('brand');
    $product->size = implode(',', $r->input('productSize')); // Convert size array to string
    $product->quantity = $r->input('quantity');
    $product->price = $r->input('product_price');
    $product->description = $r->input('description');

    // Save updated product
    $product->save();

    return redirect('Products')->with('status', 'Product updated successfully.');
}


public function ProductDelete($id){
     $admin = Auth::guard('admin')->user();

      $orderCount=order::where('status','Processing')->count();
            $refundCount=order::where('status','Refund')->where('adminid',$admin->id)->count();
        $products = products::where('adminid',$admin->id)->orderBy('id','desc')->get();
        $id=$id;
        return view('Admin/Product',compact('products','admin','id','refundCount','orderCount'));
}
public function ProductDeleteForm(Request $r, $id){
    // Retrieve the product based on ID and admin ID
    $admin = Auth::guard('admin')->user();
    $product = products::where('id', $id)
                      ->where('adminid', $admin->id)
                      ->first();

    if (!$product) {
        return redirect()->back()->with('error', 'Product not found.');
    }

    // Array of image fields
    $imageFields = ['mainimage', 'sideone', 'sidetwo', 'sidethree'];

    foreach ($imageFields as $field) {
        $imageName = $product->$field;
        if (!empty($imageName)) {
            $imagePath = public_path('Product/' . $imageName);
            if (file_exists($imagePath)) {
                unlink($imagePath); 
            }
        }
    }
    $wishlistCount=wishlist::where('productid',$product->id)->count();
    if($wishlistCount>0){
        wishlist::where('productid',$product->id)->delete();
    }
    $addtocartCount=addtocart::where('productid',$product->id)->count();
    if($addtocartCount>0){
        addtocart::where('productid',$product->id)->delete();
    }
    $product->delete();

    return redirect('Products')->with('status', 'Product deleted successfully.');
}
public function Order() {
        $admin = Auth::guard('admin')->user();
         $orderCount=order::where('status','Processing')->count();
            $refundCount=order::where('status','Refund')->where('adminid',$admin->id)->count();
        $order = Order::where('adminid', $admin->id)->where(function ($query) {$query->where('status', 'Processing')->orWhere('status', 'Accepted')->orWhere('status', 'Completed')->orWhere('status', 'Cancelled');})->orderBy('id', 'desc')
    ->get();
        return view('Admin.Order',compact('admin', 'order', 'refundCount', 'orderCount'));
    }
public function OrderId($id) {
        $id=$id;
        $admin = Auth::guard('admin')->user();
         $orderCount=order::where('status','Processing')->count();
            $refundCount=order::where('status','Refund')->where('adminid',$admin->id)->count();
        $order = Order::where('adminid',$admin->id)->where(function ($query) {$query->where('status', 'Processing')->orWhere('status', 'Accepted')->orWhere('status', 'Completed')->orWhere('status', 'Cancelled');})->orderBy('id', 'desc')
    ->get();
        return view('Admin.Order',compact('admin', 'order','id','orderCount','refundCount'));
    }
public function OrderDeleted(Request $r,$id) {
        $order=order::find($id);
        if ($order) {
            $order->status='Cancelled';
            $order->save();
            return redirect('Order');
        } else {
            return redirect()->back()->with('error', 'Order not found.');
        }
    }
public function OrderUpdate($type,$id) {
        $order=order::where('id',$id)->first();
        if($type=='Accepted')
        {
            $order->status='Accepted';
        }
        if($type=='Completed'){
            $order->status='Completed';
        }
        if($type=='RefundAccepted'){
            $order->status='RefundAccepted';
        }
        if($type=='Refunded'){
            $order->status='Refunded';
        }
        $order->save();
        return redirect()->back();
    }
public function RefundRequest() {
         $admin = Auth::guard('admin')->user();
         $orderCount=order::where('status','Processing')->count();
            $refundCount=order::where('status','Refund')->where('adminid',$admin->id)->count();
        $order = Order::where('adminid', $admin->id)->where(function($query) {
        $query->where('status', 'Refund')->orWhere('status', 'Refunded')->orWhere('status', 'RefundCancelled')->orWhere('status', 'RefundAccepted');
        })
        ->orderBy('id', 'desc')
        ->get();

        return view('Admin.RefundRequest',compact('admin', 'order', 'refundCount', 'orderCount'));
    }
public function RefundRequestId($id) {
        $id=$id;
        $admin = Auth::guard('admin')->user();
         $orderCount=order::where('status','Processing')->count();
            $refundCount=order::where('status','Refund')->where('adminid',$admin->id)->count();
        $order = Order::where('adminid', $admin->id)->where(function($query) {
        $query->where('status', 'Refund')->orWhere('status', 'Refunded')->orWhere('status', 'RefundCancelled')->orWhere('status', 'RefundAccepted');
        })
        ->orderBy('id', 'desc')
        ->get();

        return view('Admin.RefundRequest',compact('admin', 'order', 'refundCount', 'orderCount','id'));
    }
public function RefundCancelForm(Request $r,$id) {
        $order=order::find($id);
        if ($order) {
            $order->status='RefundCancelled';
            $order->save();
            return redirect('RefundRequest');
        } else {
            return redirect()->back()->with('error', 'Order not found.');
        }
    }
public function AccountSetting()    {
        $admin = Auth::guard('admin')->user();
         $orderCount=order::where('status','Processing')->count();
            $refundCount=order::where('status','Refund')->where('adminid',$admin->id)->count();
        return view('Admin.AccountSetting',compact('admin','orderCount','refundCount'));
    }
public function AdminSetting(Request $r) {
    // Validate the input
    $validator = Validator::make($r->all(), [
    'currentPassword' => [
        'required',
        'regex:/^(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[!@#$%^&*]).{4,50}$/'
    ],
    'newPassword' => [
        'required',
        'confirmed',  // Ensures newPassword matches newPassword_confirmation
        'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$^*&!])(?=.*[a-z]).{5,30}$/'
    ],
    'newPassword_confirmation' => [
        'required',
        'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[@#$^*&!])(?=.*[a-z]).{5,30}$/'  // Apply same regex to the confirmation field
    ],
        ]);

        // If validation fails, return with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $admin = Auth::guard('admin')->user();
    if ($admin) {
        if (Hash::check($r->currentPassword,$admin->password)) {
            if (!empty($r->newPassword)) {
                $pwd = Hash::make($r->newPassword);
                $admin->password = $pwd;

                // Try saving the admin and check if it returns true
                if ($admin->save()) {
                    Mail::to($admin->email)->send(new PasswordChanged($admin->fullname));
                    return redirect()->back()->with(['type' => 'success', 'message' => 'Password has been changed successfully!']);
                } else {
                    return redirect()->back()->with(['type' => 'danger', 'message' => 'Some technical issues have occured please try again later.']);
                }
            } else {
                return redirect()->back()->with(['type' => 'warning', 'message' => 'New password cannot be empty!']);
            }
        } else {
            return redirect()->back()->with(['type' => 'warning', 'message' => 'Current password does not match!']);
        }
    }
}
}
