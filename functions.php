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

  function get_token ($secret_code,$url) {

    global $user_id;

     if (!empty($secret_code)) {
         
        $api_url = 'https://oauth.vk.com/access_token?client_id=4950576&client_secret=h6iDx3eADczomfZ39209&code='.$secret_code.'&redirect_uri='.$url.''; 
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

        header("Location: http://localhost/sls/"); //Что бы кукисы обновились  

  }

  //Функция при помощи которой получаем список аудиозаписей (массив)

  function get_audio ($query,$access_token) {

        $api_url = 'https://api.vk.com/method/audio.search?q='.$query.'&access_token='.$access_token.'&lyrics=1&count=30';

        $api_qurey = curl_init();

        curl_setopt($api_qurey, CURLOPT_URL,$api_url);
        curl_setopt($api_qurey, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($api_qurey, CURLOPT_HEADER, 0);

        $api_response = curl_exec($api_qurey);
        $api_array = json_decode($api_response,true);

        $response_array = $api_array['response'];

        array_shift($response_array);

        foreach ($response_array as $result) {
           
        echo 
<<<HTML
<a href="http://localhost/sls/index.php?query=$query&lyrics=$result[lyrics_id]&send=1" class="list-group-item">
<h4 class="list-group-item-heading">$result[artist]</h4>
<p class="list-group-item-text">$result[title]</p>
</a>
HTML;

        }

  }


?>