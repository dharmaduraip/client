<?php





 
Route::view('/', 'common/web/home');
/*Route::view('/home/{lang?}', 'common/web/home');*/
/*Route::view('/services/{lang?}', 'common/web/services');*/

Route::get('/pages/{type}', function ($type) {
    return view('common/web/cmspage', compact('type'));
});

Route::get('/access-denied', function () {
    abort('403');
});
Route::get('/nowpayment/success', function (\Illuminate\Http\Request $request) {

    try {
        $client = new \GuzzleHttp\Client();
        $params['form_params'] = ['order_id' => $request->random];

        $result = $client->post(env('BASE_URL') . '/api/v1/nowpayment/verify/payment', $params);
        $response = json_decode($result->getBody()) ;
      
        $data = $response->responseData ;
        if($data->admin_service == 'WALLET') {
            if($data->user_type == 'user') {
                return redirect('/wallet')->with('message', $response->message);
            } else {
                return redirect('/provider/wallet')->with('message', $response->message);
            }
        } else if($data->admin_service == 'TRANSPORT') {
            return redirect('/ride/'.$data->type_id.'/transport?id='.$data->transaction_id)->with('message', $response->message);
        } else if($data->admin_service == 'SERVICE') {
            return redirect()->to('/service/'.$data->type_id.'/service?id='.$data->transaction_id)->with('message', $response->message);
        } else if($data->admin_service == 'DELIVERY') {
            return redirect()->to('/delivery/'.$data->type_id.'/delivery?id='.$data->transaction_id)->with('message', $response->message);
        } else {
            return redirect()->to('/store/order/'.$data->id)->with('message', $response->message);
        }
    } catch (GuzzleHttp\Exception\ClientException $exception) {
        dd(json_decode($exception->getResponse()->getBody())->message);
    } catch (\Exception $exception) {
        dd($exception);
    }
    
});

Route::POST('/change/language', function (\Illuminate\Http\Request $request) {

    try {
       // return $request->all();
       // Session::set(['default_language', $request->language]);
       session()->put('default_language', $request->language);

       App::setLocale($request->language);
       \Log::info( session()->get('default_language'));
       return response()->json(['status' => true]);
    }catch (\Exception $exception) {
       return response()->json(['status' => false]);
    }    
});

Route::get('/nowpayment/failure', function (\Illuminate\Http\Request $request) {
    try {
        $client = new \GuzzleHttp\Client();
        $params['form_params'] = ['order_id' => $request->order_id];
        
        $result = $client->post(env('BASE_URL') . '/api/v1/nowpayment/failure/payment', $params);
        $response =  json_decode($result->getBody()) ;
        $data =  $response->responseData ;

        if($data->admin_service == 'WALLET') {
            if($data->user_type == 'user') {
                return redirect('/wallet')->with('error', $response->message);
            } else {
                return redirect('/provider/wallet')->with('error', $response->message);
            }
        } else if($data->admin_service == 'TRANSPORT') {
            return redirect('/ride/'.$data->type_id.'/transport?id='.$data->transaction_id)->with('error', $response->message);
        } else if($data->admin_service == 'ORDER') {
            return redirect()->to('/service/1/service?id='.$data->transaction_id)->with('message', $response->message);
        } else if($data->admin_service == 'SERVICE') {
            return redirect()->to('/service/'.$data->type_id.'/service?id='.$data->transaction_id)->with('message', $response->message);
        }
    } catch (GuzzleHttp\Exception\ClientException $exception) {
        dd(json_decode($exception->getResponse()->getBody())->message);
    } catch (\Exception $exception) {
        dd($exception);
    }
});

Route::get('/payment/response', function (\Illuminate\Http\Request $request) {

    try {
        $client = new \GuzzleHttp\Client();
        $params['form_params'] = ['paymentId' => $request->paymentId, 'PayerID' => $request->PayerID, 'order' => $request->order, 'token' => $request->token];

        $result = $client->post(env('BASE_URL') . '/api/v1/verify/payment', $params);
        $response = json_decode($result->getBody()) ;
      
        $data = $response->responseData ;
        if($data->admin_service == 'WALLET') {
            if($data->user_type == 'user') {
                return redirect('/wallet')->with('message', $response->message);
            } else {
                return redirect('/provider/wallet')->with('message', $response->message);
            }
        } else if($data->admin_service == 'TRANSPORT') {
            return redirect('/ride/'.$data->type_id.'/transport?id='.$data->transaction_id)->with('message', $response->message);
        } else if($data->admin_service == 'SERVICE') {
            return redirect()->to('/service/'.$data->type_id.'/service?id='.$data->transaction_id)->with('message', $response->message);
        } else if($data->admin_service == 'DELIVERY') {
            return redirect()->to('/delivery/'.$data->type_id.'/delivery?id='.$data->transaction_id)->with('message', $response->message);
        } else {
            return redirect()->to('/store/order/'.$data->id)->with('message', $response->message);
        }
    } catch (GuzzleHttp\Exception\ClientException $exception) {
        dd(json_decode($exception->getResponse()->getBody())->message);
    } catch (\Exception $exception) {
        dd($exception);
    }
    
});

Route::get('/payment/failure', function (\Illuminate\Http\Request $request) {
    try {
        $client = new \GuzzleHttp\Client();
        $params['form_params'] = ['order' => $request->order];
        
        $result = $client->post(env('BASE_URL') . '/api/v1/failure/payment', $params);
        $response =  json_decode($result->getBody()) ;
        $data =  $response->responseData ;

        if($data->admin_service == 'WALLET') {
            if($data->user_type == 'user') {
                return redirect('/wallet')->with('error', $response->message);
            } else {
                return redirect('/provider/wallet')->with('error', $response->message);
            }
        } else if($data->admin_service == 'TRANSPORT') {
            return redirect('/ride/'.$data->type_id.'/transport?id='.$data->transaction_id)->with('error', $response->message);
        } else if($data->admin_service == 'ORDER') {
            return redirect()->to('/service/1/service?id='.$data->transaction_id)->with('message', $response->message);
        } else if($data->admin_service == 'SERVICE') {
            return redirect()->to('/service/'.$data->type_id.'/service?id='.$data->transaction_id)->with('message', $response->message);
        }
    } catch (GuzzleHttp\Exception\ClientException $exception) {
        dd(json_decode($exception->getResponse()->getBody())->message);
    } catch (\Exception $exception) {
        dd($exception);
    }
});



Route::get('/track/{id}', function ($id) {
    return view('common.admin.track', compact('id'));
});

Route::get('/limit', function () {
    return view('common.admin.limit.index');
});

Route::get('/revolut', function () {
    return view('common.user.account.revolut');
});
Route::get('/revolut/success', function (\Illuminate\Http\Request $request) {

    try {
        \Log::info($request->all());
        // $client = new \GuzzleHttp\Client();
        // $params['form_params'] = ['order_id' => $request->random];

        // $result = $client->post(env('BASE_URL') . '/api/v1/nowpayment/verify/payment', $params);
        // $response = json_decode($result->getBody()) ;
      
       // $data = $response->responseData ;
        if($request->admin_service == 'WALLET') {
            if($request->user_type == 'user') {
                // return redirect('/wallet')->with('message', $response->message);
                return redirect('/wallet');
            } else {
                return redirect('/provider/wallet');
            }
        } else if($request->admin_service == 'TRANSPORT') {
            return redirect('/ride/'.$request->type_id.'/transport?id='.$request->transaction_id);
        } else if($request->admin_service == 'SERVICE') {
            return redirect()->to('/service/'.$request->type_id.'/service?id='.$request->transaction_id);
        } else if($request->admin_service == 'DELIVERY') {
            return redirect()->to('/delivery/'.$request->type_id.'/delivery?id='.$request->transaction_id);
        } else {
            return redirect()->to('/store/order/'.$request->type_id);
        }
    } catch (GuzzleHttp\Exception\ClientException $exception) {
        dd(json_decode($exception->getResponse()->getBody())->message);
    } catch (\Exception $exception) {
        dd($exception);
    }
    
});