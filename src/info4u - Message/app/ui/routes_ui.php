<?php
$app->get('/info4u/', function ($request, $response) {
    $messages = [];
    $mes = 'ရေနွေးအရငင်တည်ရေနွေးများများလေးတည်ရေနွေးဆူရင်အသားပါးပါးလေးလှီးထားတာထည့်လိုက်အဖုံးအုပ်ပြီး15မိနစ်လောက်ပြုတ်အဲဒီထဲကြက်သွန်နီပါးပါးလှီးထည့်လိုကါ ကြက်သွန်ဖြူ4စိတ်5စိတ်လောကါအခွန်ခွာရေဆေးပြီးဒါးလေးနဲ့ပြားအောင်ရိုက်ပြီးထည့်လိုက်3မိနစ်လောက်တည်ထားပြီးခေါက်ဆွဲထည့်ခါကြက်ဥ မုန်ညှင်းထည့်ခေါက်ဆွဲထည့်ကြက်ဥတစ်လုံး';
    $mes = preg_replace("/\r|\n/", "", $mes);
    $message = [
        'message' => $mes,
        'height' => 23*ceil(mb_strlen($mes)/20),
        'pos' => 'message_left',
    ];
    $messages[] = $message;
    $mes = 'ထမင်းလည်းစားပေးအုန်း တစ်ခါစားရင်ပုဂံလုံးသေးသေးနဲ့တစ်လုံးလောက်စားပါအစာမကြေမှာစိုးလို့အများကြီးမစားနဲ့ ထမင်းကိုပူပူလေးဘဲစား ထမင်းဝင်မှမြန်မြန်ခွန်အားပြည့်မှာ။';
    $mes = preg_replace("/\r|\n/", "", $mes);
    $message = [
        'message' => $mes,
        'height' => 23*ceil(mb_strlen($mes)/20),
        'pos' => 'message_right',
    ];
    $messages[] = $message;
    return $this->viewInfo4u->render($response, 'index.twig', ['messages' => $messages]);
});
$app->get('/', function ($request, $response) {
    return redirect('/info4u/');
});
$app->get('/info4u', function ($request, $response) {
    return redirect('/info4u/');
});
$app->get('/info4u/{id}', function ($request, $response, $args) {
    if ($args['id'] == 'o2_division') renderO2Division(); 
    return $this->viewInfo4u->render($response, $args['id'] . '.twig', []);
});
/*
 * リダイレクトする
 * @param  String リダイレクトするURL
 * @return String リダイレクトスクリプト
 */
function redirect ($url) 
{
    return '<script>location.href= "'. $url . '"</script>';
}
/*
 * o2_division 画面の情報を返す
 * @return ResponseInterface o2_division 画面の情報
 */
function renderO2Division () 
{
    return '<script>location.href= "'. $url . '"</script>';
}

