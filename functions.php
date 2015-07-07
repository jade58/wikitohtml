<?php

/* 
@Author - JadeWizard
@Blog - Jade-Wizard.ru
@Name - WikiToHTML
@Version - 0.2
@Git - https://github.com/jade58/wth
*/


  //Функция при помощи которорой мы получаем 
  //acces_token и ID пользователя 

 $user_id = '';
 $owner_id = '';
 $page_id = '';

  function get_token ($secret_code,$url) {

    global $user_id;

     if (!empty($secret_code)) {
         
        $api_url = 'https://oauth.vk.com/access_token?client_id=4950563&client_secret=Y0uQ1pLq8MBIlGPfb1W8&code='.$secret_code.'&redirect_uri='.$url.''; 
        $api_qurey = curl_init();

        curl_setopt($api_qurey, CURLOPT_URL, $api_url);
        curl_setopt($api_qurey, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($api_qurey, CURLOPT_HEADER, 0);

        $api_response = curl_exec($api_qurey);
        $api_array = json_decode($api_response,true);
        $user_id = $api_array['user_id'];

        return $api_array['access_token'];

     }

  }

  //Функция при помощи которой мы получаем
  //Имя пользователя

  function get_name ($user_id) {

        $api_url = 'https://api.vk.com/method/users.get?user_id='.$user_id.'';

        $api_qurey = curl_init();

        curl_setopt($api_qurey, CURLOPT_URL,$api_url);
        curl_setopt($api_qurey, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($api_qurey, CURLOPT_HEADER, 0);

        $api_response = curl_exec($api_qurey);
        $api_array = json_decode($api_response,true);

        $response_array = $api_array['response'];
        $zero_array = $response_array[0];
        $first_name = $zero_array['first_name'];

        return $first_name;

  }

  //Фунция при помощи котороый мы выходим с сайта
  //При помощи удаления cooikie.

  function logout () {
         
        setcookie ("token", "", time() - 3600);
        setcookie ("user_id", "", time() - 3600); 

        header("Location: http://localhost/wth/"); //Что бы кукисы обновились  

  }

  //Функция для разделения URL

  function str_exp($string) {

    global $owner_id,$page_id;

        $exp_url = explode('_', $string);

        $owner_id = $exp_url[0];
        $page_id = $exp_url[1];

  }

  function get_html($token) {

        global $owner_id,$page_id;

        $api_url = 'https://api.vk.com/method/pages.get?owner_id='.$owner_id.'&page_id='.$page_id.'&need_html=1&access_token='.$token.'';

        $api_qurey = curl_init();

        curl_setopt($api_qurey, CURLOPT_URL,$api_url);
        curl_setopt($api_qurey, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($api_qurey, CURLOPT_HEADER, 0);

        $api_response = curl_exec($api_qurey);
        $api_array = json_decode($api_response,true);

        $response_array = $api_array['response'];

        return $response_array['html'];
     

  }



?>