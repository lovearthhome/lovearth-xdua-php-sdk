<?php
/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
include_once 'apigate/Util/Autoloader.php';

/**
*请求示例
*如一个完整的url为http://api.aaaa.com/createobject?key1=value&key2=value2
*$host为http://api.aaaa.com
*$path为/createobject
*query为key1=value&key2=value2
*/
class Agutil
{
	private static $appKey = "从xdua.com获取appkey";
    private static $appSecret = "从xdua.com获取appsecret";
	//协议(http或https)://域名:端口，注意必须有http://或https://
    #private static $host = "http://d5655fd0807547189939a22f6c99bee1-cn-beijing.alicloudapi.com";
    private static $host = "http://api.xdua.com";
	/**
	*method=POST且是表单提交，请求示例
	*/
	public function post($path,$headers,$form) {
		//域名后、query前的部分
		$request = new HttpRequest($this::$host, $path, HttpMethod::POST, $this::$appKey, $this::$appSecret);
        //设定Content-Type，根据服务器端接受的值来设置
		$request->setHeader(HttpHeader::HTTP_HEADER_CONTENT_TYPE, ContentType::CONTENT_TYPE_FORM);
		
        //设定Accept，根据服务器端接受的值来设置
		$request->setHeader(HttpHeader::HTTP_HEADER_ACCEPT, ContentType::CONTENT_TYPE_JSON);
        //如果是调用测试环境请设置
		$request->setHeader(SystemHeader::X_CA_STAGE, "RELEASE");
		$request->setHeader(SystemHeader::X_CA_NONCE, md5(uniqid(rand())));
		#在请求的 Header 里有个参数 X-Ca-Stage，取值 TEST/PRE/RELEASE，分别指向测试和线上环境，不传入该参数则默认是线上。

        //注意：业务header部分，如果没有则无此行(如果有中文，请做Utf8ToIso88591处理)
		//mb_convert_encoding("headervalue2中文", "ISO-8859-1", "UTF-8");
        foreach($headers as $k=>$v){
		    $request->setHeader($k, $v);
        }

        //注意：业务query部分，如果没有则无此行；请不要、不要、不要做UrlEncode处理
		//$request->setQuery("b-query2", "queryvalue2");
		//$request->setQuery("a-query1", "queryvalue1");

        //注意：业务body部分，如果没有则无此行；请不要、不要、不要做UrlEncode处理
        foreach($form as $k=>$v){
		    $request->setBody($k, $v);
        }
        //指定参与签名的header
		$request->setSignHeader(SystemHeader::X_CA_TIMESTAMP);
		$request->setSignHeader(SystemHeader::X_CA_NONCE);
        if(array_key_exists ("dua", $headers)){
            $request->setSignHeader("dua");
        }
		$response = HttpClient::execute($request);
        return $this->doResp($response);
    }

    /**
	*method=POST且是表单提交，请求示例
	*/
	public function put($path,$headers,$form) {
		//域名后、query前的部分
		$request = new HttpRequest($this::$host, $path, HttpMethod::PUT, $this::$appKey, $this::$appSecret);
        //设定Content-Type，根据服务器端接受的值来设置
		$request->setHeader(HttpHeader::HTTP_HEADER_CONTENT_TYPE, ContentType::CONTENT_TYPE_FORM);
		
        //设定Accept，根据服务器端接受的值来设置
		$request->setHeader(HttpHeader::HTTP_HEADER_ACCEPT, ContentType::CONTENT_TYPE_JSON);
        //如果是调用测试环境请设置
		#在请求的 Header 里有个参数 X-Ca-Stage，取值 TEST/PRE/RELEASE，分别指向测试和线上环境，不传入该参数则默认是线上。
		$request->setHeader(SystemHeader::X_CA_STAGE, "RELEASE");
		$request->setHeader(SystemHeader::X_CA_NONCE, md5(uniqid(rand())));
	
        //注意：业务header部分，如果没有则无此行(如果有中文，请做Utf8ToIso88591处理)
		//mb_convert_encoding("headervalue2中文", "ISO-8859-1", "UTF-8");
        foreach($headers as $k=>$v){
		    $request->setHeader($k, $v);
        }
        //注意：业务query部分，如果没有则无此行；请不要、不要、不要做UrlEncode处理
		//$request->setQuery("b-query2", "queryvalue2");
		//$request->setQuery("a-query1", "queryvalue1");

        //注意：业务body部分，如果没有则无此行；请不要、不要、不要做UrlEncode处理
        foreach($form as $k=>$v){
		    $request->setBody($k, $v);
        }
        //指定参与签名的header
		$request->setSignHeader(SystemHeader::X_CA_TIMESTAMP);
		$request->setSignHeader(SystemHeader::X_CA_NONCE);
        if(array_key_exists ("dua", $headers)){
            $request->setSignHeader("dua");
        }
		$response = HttpClient::execute($request);
        return $this->doResp($response);
    }
    /**
	*method=GET请求示例
	*/
    public function query($path,$headers,$query) {
		//域名后、query前的部分
		$request = new HttpRequest($this::$host, $path, HttpMethod::GET, $this::$appKey, $this::$appSecret);

        //设定Content-Type，根据服务器端接受的值来设置
		$request->setHeader(HttpHeader::HTTP_HEADER_CONTENT_TYPE, ContentType::CONTENT_TYPE_TEXT);
		
        //设定Accept，根据服务器端接受的值来设置
		$request->setHeader(HttpHeader::HTTP_HEADER_ACCEPT, ContentType::CONTENT_TYPE_JSON);
        //如果是调用测试环境请设置
        $request->setHeader(SystemHeader::X_CA_STAGE, "RELEASE");
		$request->setHeader(SystemHeader::X_CA_NONCE, md5(uniqid(rand())));
        foreach($headers as $k=>$v){
		    $request->setHeader($k, $v);
        }

        //注意：业务body部分，如果没有则无此行；请不要、不要、不要做UrlEncode处理
        foreach($query as $k=>$v){
		    $request->setQuery($k, $v);
        }
        //指定参与签名的header
		$request->setSignHeader(SystemHeader::X_CA_TIMESTAMP);
		$request->setSignHeader(SystemHeader::X_CA_NONCE);
        if(array_key_exists ("dua", $headers)){
            $request->setSignHeader("dua");
        }

		$response = HttpClient::execute($request);
        return $this->doResp($response);
	}


    /**
	*method=GET请求示例
	*/
    public function get($path,$headers) {
		//域名后、query前的部分
		$request = new HttpRequest($this::$host, $path, HttpMethod::GET, $this::$appKey, $this::$appSecret);

        //设定Content-Type，根据服务器端接受的值来设置
		$request->setHeader(HttpHeader::HTTP_HEADER_CONTENT_TYPE, ContentType::CONTENT_TYPE_TEXT);
		
        //设定Accept，根据服务器端接受的值来设置
		$request->setHeader(HttpHeader::HTTP_HEADER_ACCEPT, ContentType::CONTENT_TYPE_JSON);
        //如果是调用测试环境请设置
        $request->setHeader(SystemHeader::X_CA_STAGE, "RELEASE");
		$request->setHeader(SystemHeader::X_CA_NONCE, md5(uniqid(rand())));
        foreach($headers as $k=>$v){
		    $request->setHeader($k, $v);
        }
        //注意：业务body部分，如果没有则无此行；请不要、不要、不要做UrlEncode处理
        //指定参与签名的header
		$request->setSignHeader(SystemHeader::X_CA_TIMESTAMP);
		$request->setSignHeader(SystemHeader::X_CA_NONCE);
        if(array_key_exists ("dua", $headers)){
            $request->setSignHeader("dua");
        }

		$response = HttpClient::execute($request);
        return $this->doResp($response);
	}



	/**
	*method=DELETE请求示例
	*/
    public function delete($path,$headers) {
		//域名后、query前的部分
		$request = new HttpRequest($this::$host, $path, HttpMethod::DELETE, $this::$appKey, $this::$appSecret);

        //设定Content-Type，根据服务器端接受的值来设置
		$request->setHeader(HttpHeader::HTTP_HEADER_CONTENT_TYPE, ContentType::CONTENT_TYPE_TEXT);
		
        //设定Accept，根据服务器端接受的值来设置
		$request->setHeader(HttpHeader::HTTP_HEADER_ACCEPT, ContentType::CONTENT_TYPE_JSON);
        //如果是调用测试环境请设置
		$request->setHeader(SystemHeader::X_CA_STAGE, "RELEASE");
		$request->setHeader(SystemHeader::X_CA_NONCE, md5(uniqid(rand())));

        //注意：业务header部分，如果没有则无此行(如果有中文，请做Utf8ToIso88591处理)
		//mb_convert_encoding("headervalue2中文", "ISO-8859-1", "UTF-8");
        foreach($headers as $k=>$v){
		    $request->setHeader($k, $v);
        }
        //指定参与签名的header
        $request->setSignHeader(SystemHeader::X_CA_TIMESTAMP);
		$request->setSignHeader(SystemHeader::X_CA_NONCE);
        if(array_key_exists ("dua", $headers)){
            $request->setSignHeader("dua");
        }
        $response = HttpClient::execute($request);
        return $this->doResp($response);
    }






    public function doResp($response) {
        //这里解析出来的body是stdclass不是array
		$body = json_decode($response->getBody());
		//响应状态码，大于等于200小于300表示成功；大于等于400小于500为客户端错误；大于500为服务端错误。
		$status = 0;
		$reason = "success";
		$result = "";
        $httpStatus = $response->getHttpStatusCode();
        try{
            if($httpStatus>=200 && $httpStatus <300){
            	$status = $body->status;
            	$reason = $body->reason;
                $result = $body->result;
                $result = json_decode(json_encode($body->result),true);
                $debug  = json_decode(json_encode($body->debug),true);
            }else{
            	$status = $httpStatus;
            	$reason = "AliAGFail:".$response->getErrorMessage();
                $result = $response->getContent();
                $debug  = "n/a";
            }
        }catch (Exception $e){
            $status = 1;
            $reason = "AliAGException";
            $result = $httpStatus;
            $debug  = "n/a";
        }
		return ["status"=>$status,"reason"=>$reason,"result"=>$result,"debug"=>$debug];
    }
}
