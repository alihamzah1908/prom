<?php

Route::get('/pdf_test', function () {
    $data = App\Model\Task::get();
    $pdf = \PDF::loadView('task.pdf');//->setPaper('LEGAL', 'landscape');
    return $pdf->stream();
});

Route::get('/excel_test', function () {
    $file = \Excel::download(new App\Excels\Task, "test.xlsx");
    return $file;
});
Route::get('/chart_demo', function () {
    return view('chart.demo');
});
Route::get('/meine', function () {
    $s = request()->a;
    
    $arr = [];
    foreach(alphabet() as $i => $k){
        if(!$i) $i = "0";
        $al = alphabet($i);
        $al = json_encode($al);
        $arr[] = [$al => $k];
    }
    return $arr;
    return toNum($s);
});
function alphabet($index = ''){
    $alphabet = array( 'a', 'b', 'c', 'd', 'e',
                       'f', 'g', 'h', 'i', 'j',
                       'k', 'l', 'm', 'n', 'o',
                       'p', 'q', 'r', 's', 't',
                       'u', 'v', 'w', 'x', 'y',
                       'z'
                       );
    if($index == "0") return $alphabet[0];
    if($index) return $alphabet[$index];
    return $alphabet;
}
function toNum($data) {
    $alphabet = alphabet();
    $alpha_flip = array_flip($alphabet);
    $return_value = -1;
    $length = strlen($data);
    for ($i = 0; $i < $length; $i++) {
        $return_value +=
            ($alpha_flip[$data[$i]] + 1) * pow(26, ($length - $i - 1));
    }
    return $return_value;
}