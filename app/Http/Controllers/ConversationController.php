<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conversation;
use App\BusinessSetting;
use App\Message;
use Auth;
use App\Product;
use App\Seller;
use App\User;
use Mail;
use Cookie;
use App\Mail\ConversationMailManager;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (BusinessSetting::where('type', 'conversation_system')->first()->value == 1) {
            $conversations = Conversation::where('sender_id', Auth::user()->id)->orWhere('receiver_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(5);
            return view('frontend.user.conversations.index', compact('conversations'));
        }
        else {
            flash(translate('Conversation is disabled at this moment'))->warning();
            return back();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_index()
    {
        if (BusinessSetting::where('type', 'conversation_system')->first()->value == 1) {
            $conversations = Conversation::orderBy('created_at', 'desc')->get();
            return view('backend.support.conversations.index', compact('conversations'));
        }
        else {
            flash(translate('Conversation is disabled at this moment'))->warning();
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo $request->company; exit;
        $user_type = Product::findOrFail($request->product_id)->user->user_type;

        $conversation = new Conversation;
        $conversation->sender_id = Auth::user()->id;
        $conversation->receiver_id = Product::findOrFail($request->product_id)->user->id;
        $conversation->title = $request->title;
        $conversation->reference=$request->reference;
        $conversation->email=$request->email;

        if($conversation->save()) {
            $message = new Message;
            $message->conversation_id = $conversation->id;
            $message->user_id = Auth::user()->id;
            $message->message = $request->message;

            // if ($message->save()) {
            //     $this->send_message_to_seller($conversation, $message, $user_type);
            // }
        }
        // if($message->save())
        // {
        //     $seller = new Seller;
        //     $seller->user_id= Auth::user()->id;;
        //     $seller->company=$request->company;
        //     // echo $request->company; exit;
        //     $seller->phone=$request->phone;
        // }
        if($message->save())
        {
            $user = new User;
            $user->user_type="seller";
            $user->name=$request->name;
            $user->company=$request->company;
            $user->phone=$request->phone;
            if ($user->save()) {
                $this->send_message_to_seller($conversation, $message, $user_type ,$user);
            }
        }
        $user = Auth::user();
        $curr_uid = $user->id;

        $productLS=$request->productLS;

        $curr_name = $user->name;
        $array= array();
        $array['userIp'] = $request->ip();
        $array['user']=$curr_uid;
        $array['question']=$request->message;
        $array['comapny']=$request->company;
        $array['reference']=$request->reference;
        $array['contact_name']=$request->name;
        $array['email']=$request->email;
        $array['contact_number']=$request->phone;
        $array['productname']=$request->productname;
        $array['productstock']=$request->productstock;
        $array['productmodel']=$request->productmodel;
        $array['productLS']=$request->productLS;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        Mail::send('frontend.backendMailer.inquiry_mail', $array, function($message) use ($array) {
            $message->to(env("StockManager"));
            $message->subject($array['productLS'].' Inquiry Letter');
        });
        

        flash(translate('Message has been sent to Admin'))->success();
        return back();
    }

    public function diamond_model_store(Request $request){
         $request->validate([
        'company' => 'required',
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
        'zip' => 'required',
        'brand' => 'required',
        'model' => 'required',
        'serial' => 'required',
        'description' => 'required',
    ]);

         
        // $mails= array($request->getmail,$request->email);
        $captcha = $request['g-recaptcha-response'];
        // dd($mails);
      if($request->getmail != $request->email && !empty($captcha)){
       
          
        $conversation = new Conversation;
        $conversation->company = $request->company;
        $conversation->name = $request->name;
        $conversation->email=$request->email;
        $conversation->phone = $request->phone;
        $conversation->address = $request->address;
        $conversation->city = $request->city;
        $conversation->state = $request->state;
        $conversation->zip = $request->zip;
        $conversation->brand = $request->brand;
        $conversation->model = $request->model;
        $conversation->serial = $request->serial;
        $conversation->description = $request->description;

        Cookie::queue('cookiemail', $request->email, 2);
        //   $email = auth()->user()->email;
        //   dd($email);
        $array['userIp'] = $request->ip();
        $array['service_re_type']= $request->request_type;
        $array['company']= $request->company;
        $array['name'] = $request->name;
        $array['email']=$request->email;
        $array['phone']=$request->phone;
        $array['address']=$request->address;
        $array['city'] = $request->city;
        $array['state']=$request->state;
        $array['zip'] = $request->zip;
        $array['brand'] = $request->brand;
        $array['serial'] = $request->serial;
        $array['model'] = $request->model;
        $array['description'] = $request->description;
        $array['user_mail']=$request->email;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        Mail::send('frontend.allmails.service_req_mail', $array, function($message)use ($array) {
            $message->to(env("StockManager"));
            // $message->cc("samd@mitashdigital.com");
            $message->subject('Service Request Notification');
        });
         Mail::send('frontend.allmails.service_req_mail_to_user', $array, function($message)use ($array) {
            $message->to($array['user_mail']);
            // $message->cc("samd@mitashdigital.com");
            $message->subject('Service Request Received  !');
        });


        $conversation->save();
        flash(translate('Your Request Sended Sucessfully'))->success();
        return back();
      }
      else{
        flash(translate("Your message couldn't be delivered because you weren't recognized as a valid sender"))->error();
        return back();
      }

    }

    public function gold_collectibles_store(Request $request){
        // $conversation = new Conversation;
        // $conversation->company = $request->company;
        // $conversation->name = $request->name;
        // $conversation->email=$request->email;
        // $conversation->phone = $request->phone;
        // $conversation->address = $request->address;
        // $conversation->city = $request->city;
        // $conversation->state = $request->state;
        // $conversation->zip = $request->zip;
        // $conversation->brand = $request->brand;
        // $conversation->model = $request->model;
        // $conversation->serial = $request->serial;
        // $conversation->description = $request->description;
        //  $array['userIp'] = $request->ip();
        // $array['service_re_type']= "Jewelry Repair";
        // $array['company']= $request->company;
        // $array['name'] = $request->name;
        // $array['email']=$request->email;
        // $array['phone']=$request->phone;
        // $array['address']=$request->address;
        // $array['city'] = $request->city;
        // $array['state']=$request->state;
        // $array['zip'] = $request->zip;
        // $array['brand'] = $request->brand;
        // $array['serial'] = $request->serial;
        // $array['model'] = $request->model;
        // $array['description'] = $request->description;
        // $array['from'] = env('MAIL_FROM_ADDRESS');
        // Mail::send('frontend.allmails.service_req_mail', $array, function($message) {
        //     $message->to(env("StockManager"));
        //     $message->subject('Service Request Notification');
        // });
        // $conversation->save();
        // flash(translate('Jewelry Repair Request Sended Sucessfully'))->success();
        // return back();

    }

    public function memorabilia_store(Request $request){
        // $conversation = new Conversation;
        // $conversation->company = $request->company;
        // $conversation->name = $request->name;
        // $conversation->email=$request->email;
        // $conversation->phone = $request->phone;
        // $conversation->address = $request->address;
        // $conversation->city = $request->city;
        // $conversation->state = $request->state;
        // $conversation->zip = $request->zip;
        // $conversation->brand = $request->brand;
        // $conversation->model = $request->model;
        // $conversation->serial = $request->serial;
        // $conversation->description = $request->description;

        //  $array['userIp'] = $request->ip();
        // $array['service_re_type']= "Custom";
        // $array['company']= $request->company;
        // $array['name'] = $request->name;
        // $array['email']=$request->email;
        // $array['phone']=$request->phone;
        // $array['address']=$request->address;
        // $array['city'] = $request->city;
        // $array['state']=$request->state;
        // $array['zip'] = $request->zip;
        // $array['brand'] = $request->brand;
        // $array['serial'] = $request->serial;
        // $array['model'] = $request->model;
        // $array['description'] = $request->description;
        // $array['from'] = env('MAIL_FROM_ADDRESS');
        // Mail::send('frontend.allmails.service_req_mail', $array, function($message) {
        //     $message->to(env("StockManager"));
        //     $message->subject('Service Request Notification');
        // });
        // $conversation->save();
        // flash(translate('Custom Pieces Request Sended Sucessfully'))->success();
        // return back();

    }

    public function send_message_to_seller($conversation, $message, $user_type)
    {
        $array['view'] = 'emails.conversation';
        $array['subject'] = 'Sender:- '.Auth::user()->name;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['content'] = 'Hi! You recieved a message from '.Auth::user()->name.'.';
        $array['sender'] = Auth::user()->name;

        if($user_type == 'admin') {
            $array['link'] = route('conversations.admin_show', encrypt($conversation->id));
        } else {
            $array['link'] = route('conversations.show', encrypt($conversation->id));
        }

        $array['details'] = $message->message;

        try {
            Mail::to($conversation->receiver->email)->queue(new ConversationMailManager($array));
        } catch (\Exception $e) {
            //dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $conversation = Conversation::findOrFail(decrypt($id));
        if ($conversation->sender_id == Auth::user()->id) {
            $conversation->sender_viewed = 1;
        }
        elseif($conversation->receiver_id == Auth::user()->id) {
            $conversation->receiver_viewed = 1;
        }
        $conversation->save();
        return view('frontend.user.conversations.show', compact('conversation'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refresh(Request $request)
    {
        $conversation = Conversation::findOrFail(decrypt($request->id));
        if($conversation->sender_id == Auth::user()->id){
            $conversation->sender_viewed = 1;
            $conversation->save();
        }
        else{
            $conversation->receiver_viewed = 1;
            $conversation->save();
        }
        return view('frontend.partials.messages', compact('conversation'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_show($id)
    {
        $conversation = Conversation::findOrFail(decrypt($id));
        if ($conversation->sender_id == Auth::user()->id) {
            $conversation->sender_viewed = 1;
        }
        elseif($conversation->receiver_id == Auth::user()->id) {
            $conversation->receiver_viewed = 1;
        }
        $conversation->save();
        return view('backend.support.conversations.show', compact('conversation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conversation = Conversation::findOrFail(decrypt($id));
        foreach ($conversation->messages as $key => $message) {
            $message->delete();
        }
        if(Conversation::destroy(decrypt($id))){
            flash(translate('Conversation has been deleted successfully'))->success();
            return back();
        }
    }
}
