@extends('template.default')
@section('submenu')
<style>
    .container-fluid {
    width: 100%;
    padding-right: 7.5px;
    padding-left: 7.5px;
    margin-right: auto;
    margin-left: auto;
    padding-top: 7px;
    }
    .card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 0rem 1rem 0rem 1rem;
    }
    label {
    display: inline-block;
    margin-bottom: 0.1rem;
    }
    p {
    margin-top: 0.1rem;
    margin-bottom: 0.2rem;
    }
    .form-group {
    margin-bottom: 0.3rem;
    }
</style>
<!--dihilangkan untuk judul-->
<!--<div class="row mb-2 pb-3">-->
<!--    <div class="col-sm-6">-->
<!--        <h3 class="m-0 text-dark"><strong>{{$template_name}}</strong></h3>-->
<!--        <small>Task > {{$template_name}}</small>-->
<!--    </div>-->
<!--</div>-->
@endsection
@section('content')

@if(Session::has('message'))
<div class="alert {{Session::get('alert-class')}} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    {{ Session::get('message') }}
</div>
@endif

<form method="POST" action="/task/new_task_schedule" enctype="multipart/form-data"> 
@csrf
<div class="card card-default">
    <!--<div class="card-header">-->
    <!--</div>-->
    <!--style="border-bottom: 1px solid rgba(0, 0, 0, .125);"-->
    <div class="card-body col-md-12" style="padding: 1rem 1rem 0rem 1rem !important;">
        <div class="form-group row">
            <div class="row">
                <h4 style="padding-left: 1rem;">Create Schedule</h4>
            </div>
            <div class="col-lg-12">
                <div class="row">          
                    <div class="col-lg-12">
                        <select class="form-control select2" style="width: 100%;" name="template_devault_value" onchange="document.location.href='/task/create_schedule?id_template={{$id_template}}&template_default_value='+this.value">
                            <option value="" selected disabled>-- Select Template --</option>
                            @foreach(\App\Templates::where('id_task_type', $id_template)->get() as $tmp)
                            <option value="{{$tmp->id}}" {{$template_default_value == $tmp->id ? 'selected':''}}>{{$tmp->template_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
                        <div class="col-sm-1 text-center" hidden>
                            <label>Task Type</label>
                        </div>
                        
                        <div class="col-sm-3" hidden>
                            <select class="form-control select2" style="width: 100%;" name="id_template" onchange="document.location.href='/task/create_schedule?id_template='+this.value">
                                @foreach(\App\Model\TaskType::get() as $type)
                                <option value="{{$type->id_type}}" {{$id_template == $type->id_type ? 'selected':''}}>{{$type->type_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row col-md-12">
                        <div class="col-md-6" hidden>
                                <div class="col-sm-3">
                                    <label>Frequency</label>
                                </div>
                                
                                <div class="col-sm-9">
                                    Monthly<input type="radio" name="selectFrequency" value="monthlyOn" checked {{  ($task->frequency == "monthlyOn" ? ' checked' : '') }}/> 

                                    <!-- <input style="display:none;" type="text" name="otherAnswer" id="otherAnswer"/> -->
                                    <!-- <div class="row">
                                        <select class="form-control otherAnswerDaily" style="width: 30%;" name="jam">
                                            <option value="" selected disabled>-- Select Hours --</option>
                                            <option value="1" {{  ($task->jam == "1" ? ' selected' : '') }}>01</option>
                                            <option value="2" {{  ($task->jam == "2" ? ' selected' : '') }}>02</option>
                                            <option value="3" {{  ($task->jam == "3" ? ' selected' : '') }}>03</option>
                                            <option value="4" {{  ($task->jam == "4" ? ' selected' : '') }}>04</option>
                                            <option value="5" {{  ($task->jam == "5" ? ' selected' : '') }}>05</option>
                                            <option value="6" {{  ($task->jam == "6" ? ' selected' : '') }}>06</option>
                                            <option value="7" {{  ($task->jam == "7" ? ' selected' : '') }}>07</option>
                                            <option value="8" {{  ($task->jam == "8" ? ' selected' : '') }}>08</option>
                                            <option value="9" {{  ($task->jam == "9" ? ' selected' : '') }}>09</option>
                                            <option value="10" {{  ($task->jam == "10" ? ' selected' : '') }}>10</option>
                                            <option value="11" {{  ($task->jam == "11" ? ' selected' : '') }}>11</option>
                                            <option value="12" {{  ($task->jam == "12" ? ' selected' : '') }}>12</option>
                                            <option value="13" {{  ($task->jam == "13" ? ' selected' : '') }}>13</option>
                                            <option value="14" {{  ($task->jam == "14" ? ' selected' : '') }}>14</option>
                                            <option value="15" {{  ($task->jam == "15" ? ' selected' : '') }}>15</option>
                                            <option value="16" {{  ($task->jam == "16" ? ' selected' : '') }}>16</option>
                                            <option value="17" {{  ($task->jam == "17" ? ' selected' : '') }}>17</option>
                                            <option value="18" {{  ($task->jam == "18" ? ' selected' : '') }}>18</option>
                                            <option value="19" {{  ($task->jam == "19" ? ' selected' : '') }}>19</option>
                                            <option value="20" {{  ($task->jam == "20" ? ' selected' : '') }}>20</option>
                                            <option value="21" {{  ($task->jam == "21" ? ' selected' : '') }}>21</option>
                                            <option value="22" {{  ($task->jam == "22" ? ' selected' : '') }}>22</option>
                                            <option value="23" {{  ($task->jam == "23" ? ' selected' : '') }}>23</option>
                                            <option value="0" {{  ($task->jam == "0" ? ' selected' : '') }}>00</option>
                                        </select>
                                        <select class="form-control otherAnswerDaily" style="width: 30%;" name="menit">
                                            <option value="" selected disabled>-- Select Minute --</option>
                                            <option value="1" {{  ($task->menit == "1" ? ' selected' : '') }}>01</option>
                                            <option value="2" {{  ($task->menit == "2" ? ' selected' : '') }}>02</option>
                                            <option value="3" {{  ($task->menit == "3" ? ' selected' : '') }}>03</option>
                                            <option value="4" {{  ($task->menit == "4" ? ' selected' : '') }}>04</option>
                                            <option value="5" {{  ($task->menit == "5" ? ' selected' : '') }}>05</option>
                                            <option value="6" {{  ($task->menit == "6" ? ' selected' : '') }}>06</option>
                                            <option value="7" {{  ($task->menit == "7" ? ' selected' : '') }}>07</option>
                                            <option value="8" {{  ($task->menit == "8" ? ' selected' : '') }}>08</option>
                                            <option value="9" {{  ($task->menit == "9" ? ' selected' : '') }}>09</option>
                                            <option value="10" {{  ($task->menit == "10" ? ' selected' : '') }}>10</option>
                                            <option value="11" {{  ($task->menit == "11" ? ' selected' : '') }}>11</option>
                                            <option value="12" {{  ($task->menit == "12" ? ' selected' : '') }}>12</option>
                                            <option value="13" {{  ($task->menit == "13" ? ' selected' : '') }}>13</option>
                                            <option value="14" {{  ($task->menit == "14" ? ' selected' : '') }}>14</option>
                                            <option value="15" {{  ($task->menit == "15" ? ' selected' : '') }}>15</option>
                                            <option value="16" {{  ($task->menit == "16" ? ' selected' : '') }}>16</option>
                                            <option value="17" {{  ($task->menit == "17" ? ' selected' : '') }}>17</option>
                                            <option value="18" {{  ($task->menit == "18" ? ' selected' : '') }}>18</option>
                                            <option value="19" {{  ($task->menit == "19" ? ' selected' : '') }}>19</option>
                                            <option value="20" {{  ($task->menit == "20" ? ' selected' : '') }}>20</option>
                                            <option value="21" {{  ($task->menit == "21" ? ' selected' : '') }}>21</option>
                                            <option value="22" {{  ($task->menit == "22" ? ' selected' : '') }}>22</option>
                                            <option value="23" {{  ($task->menit == "23" ? ' selected' : '') }}>23</option>
                                            <option value="24" {{  ($task->menit == "24" ? ' selected' : '') }}>24</option>
                                            <option value="25" {{  ($task->menit == "25" ? ' selected' : '') }}>25</option>
                                            <option value="26" {{  ($task->menit == "26" ? ' selected' : '') }}>26</option>
                                            <option value="27" {{  ($task->menit == "27" ? ' selected' : '') }}>27</option>
                                            <option value="28" {{  ($task->menit == "28" ? ' selected' : '') }}>28</option>
                                            <option value="29" {{  ($task->menit == "29" ? ' selected' : '') }}>29</option>
                                            <option value="30" {{  ($task->menit == "30" ? ' selected' : '') }}>30</option>
                                            <option value="31" {{  ($task->menit == "31" ? ' selected' : '') }}>31</option>
                                            <option value="32" {{  ($task->menit == "32" ? ' selected' : '') }}>32</option>
                                            <option value="33" {{  ($task->menit == "33" ? ' selected' : '') }}>33</option>
                                            <option value="34" {{  ($task->menit == "34" ? ' selected' : '') }}>34</option>
                                            <option value="35" {{  ($task->menit == "35" ? ' selected' : '') }}>35</option>
                                            <option value="36" {{  ($task->menit == "36" ? ' selected' : '') }}>36</option>
                                            <option value="37" {{  ($task->menit == "37" ? ' selected' : '') }}>37</option>
                                            <option value="38" {{  ($task->menit == "38" ? ' selected' : '') }}>38</option>
                                            <option value="39" {{  ($task->menit == "39" ? ' selected' : '') }}>39</option>
                                            <option value="40" {{  ($task->menit == "40" ? ' selected' : '') }}>40</option>
                                            <option value="41" {{  ($task->menit == "41" ? ' selected' : '') }}>41</option>
                                            <option value="42" {{  ($task->menit == "42" ? ' selected' : '') }}>42</option>
                                            <option value="43" {{  ($task->menit == "43" ? ' selected' : '') }}>43</option>
                                            <option value="44" {{  ($task->menit == "44" ? ' selected' : '') }}>44</option>
                                            <option value="45" {{  ($task->menit == "45" ? ' selected' : '') }}>45</option>
                                            <option value="46" {{  ($task->menit == "46" ? ' selected' : '') }}>46</option>
                                            <option value="47" {{  ($task->menit == "47" ? ' selected' : '') }}>47</option>
                                            <option value="48" {{  ($task->menit == "48" ? ' selected' : '') }}>48</option>
                                            <option value="49" {{  ($task->menit == "49" ? ' selected' : '') }}>49</option>
                                            <option value="50" {{  ($task->menit == "50" ? ' selected' : '') }}>50</option>
                                            <option value="51" {{  ($task->menit == "51" ? ' selected' : '') }}>51</option>
                                            <option value="52" {{  ($task->menit == "52" ? ' selected' : '') }}>52</option>
                                            <option value="53" {{  ($task->menit == "53" ? ' selected' : '') }}>53</option>
                                            <option value="54" {{  ($task->menit == "54" ? ' selected' : '') }}>54</option>
                                            <option value="55" {{  ($task->menit == "55" ? ' selected' : '') }}>55</option>
                                            <option value="56" {{  ($task->menit == "56" ? ' selected' : '') }}>56</option>
                                            <option value="57" {{  ($task->menit == "57" ? ' selected' : '') }}>57</option>
                                            <option value="58" {{  ($task->menit == "58" ? ' selected' : '') }}>58</option>
                                            <option value="59" {{  ($task->menit == "59" ? ' selected' : '') }}>59</option>
                                            <option value="0" {{  ($task->menit == "0" ? ' selected' : '') }}>00</option>
                                        </select><br>
                                        <select class="form-control otherAnswerWeekly" style="width: 30%; display:none;" name="hari">
                                            <option value="" selected disabled>-- Select Day --</option>
                                            <option value="1" {{  ($task->hari == "1" ? ' selected' : '') }}>Senin</option>
                                            <option value="2" {{  ($task->hari == "2" ? ' selected' : '') }}>Selasa</option>
                                            <option value="3" {{  ($task->hari == "3" ? ' selected' : '') }}>Rabu</option>
                                            <option value="4" {{  ($task->hari == "4" ? ' selected' : '') }}>Kamis</option>
                                            <option value="5" {{  ($task->hari == "5" ? ' selected' : '') }}>Jum'at</option>
                                            <option value="6" {{  ($task->hari == "6" ? ' selected' : '') }}>Sabtu</option>
                                            <option value="7" {{  ($task->hari == "7" ? ' selected' : '') }}>Ahad</option>
                                        </select>
                                        <select class="form-control otherAnswerWeekly" style="width: 30%; display:none;" name="jam">
                                            <option value="" selected disabled>-- Select Hours --</option>
                                            <option value="1" {{  ($task->jam == "1" ? ' selected' : '') }}>01</option>
                                            <option value="2" {{  ($task->jam == "2" ? ' selected' : '') }}>02</option>
                                            <option value="3" {{  ($task->jam == "3" ? ' selected' : '') }}>03</option>
                                            <option value="4" {{  ($task->jam == "4" ? ' selected' : '') }}>04</option>
                                            <option value="5" {{  ($task->jam == "5" ? ' selected' : '') }}>05</option>
                                            <option value="6" {{  ($task->jam == "6" ? ' selected' : '') }}>06</option>
                                            <option value="7" {{  ($task->jam == "7" ? ' selected' : '') }}>07</option>
                                            <option value="8" {{  ($task->jam == "8" ? ' selected' : '') }}>08</option>
                                            <option value="9" {{  ($task->jam == "9" ? ' selected' : '') }}>09</option>
                                            <option value="10" {{  ($task->jam == "10" ? ' selected' : '') }}>10</option>
                                            <option value="11" {{  ($task->jam == "11" ? ' selected' : '') }}>11</option>
                                            <option value="12" {{  ($task->jam == "12" ? ' selected' : '') }}>12</option>
                                            <option value="13" {{  ($task->jam == "13" ? ' selected' : '') }}>13</option>
                                            <option value="14" {{  ($task->jam == "14" ? ' selected' : '') }}>14</option>
                                            <option value="15" {{  ($task->jam == "15" ? ' selected' : '') }}>15</option>
                                            <option value="16" {{  ($task->jam == "16" ? ' selected' : '') }}>16</option>
                                            <option value="17" {{  ($task->jam == "17" ? ' selected' : '') }}>17</option>
                                            <option value="18" {{  ($task->jam == "18" ? ' selected' : '') }}>18</option>
                                            <option value="19" {{  ($task->jam == "19" ? ' selected' : '') }}>19</option>
                                            <option value="20" {{  ($task->jam == "20" ? ' selected' : '') }}>20</option>
                                            <option value="21" {{  ($task->jam == "21" ? ' selected' : '') }}>21</option>
                                            <option value="22" {{  ($task->jam == "22" ? ' selected' : '') }}>22</option>
                                            <option value="23" {{  ($task->jam == "23" ? ' selected' : '') }}>23</option>
                                            <option value="0" {{  ($task->jam == "0" ? ' selected' : '') }}>00</option>
                                        </select>
                                        <select class="form-control otherAnswerWeekly" style="width: 30%; display:none;" name="menit">
                                            <option value="" selected disabled>-- Select Minute --</option>
                                            <option value="1" {{  ($task->menit == "1" ? ' selected' : '') }}>01</option>
                                            <option value="2" {{  ($task->menit == "2" ? ' selected' : '') }}>02</option>
                                            <option value="3" {{  ($task->menit == "3" ? ' selected' : '') }}>03</option>
                                            <option value="4" {{  ($task->menit == "4" ? ' selected' : '') }}>04</option>
                                            <option value="5" {{  ($task->menit == "5" ? ' selected' : '') }}>05</option>
                                            <option value="6" {{  ($task->menit == "6" ? ' selected' : '') }}>06</option>
                                            <option value="7" {{  ($task->menit == "7" ? ' selected' : '') }}>07</option>
                                            <option value="8" {{  ($task->menit == "8" ? ' selected' : '') }}>08</option>
                                            <option value="9" {{  ($task->menit == "9" ? ' selected' : '') }}>09</option>
                                            <option value="10" {{  ($task->menit == "10" ? ' selected' : '') }}>10</option>
                                            <option value="11" {{  ($task->menit == "11" ? ' selected' : '') }}>11</option>
                                            <option value="12" {{  ($task->menit == "12" ? ' selected' : '') }}>12</option>
                                            <option value="13" {{  ($task->menit == "13" ? ' selected' : '') }}>13</option>
                                            <option value="14" {{  ($task->menit == "14" ? ' selected' : '') }}>14</option>
                                            <option value="15" {{  ($task->menit == "15" ? ' selected' : '') }}>15</option>
                                            <option value="16" {{  ($task->menit == "16" ? ' selected' : '') }}>16</option>
                                            <option value="17" {{  ($task->menit == "17" ? ' selected' : '') }}>17</option>
                                            <option value="18" {{  ($task->menit == "18" ? ' selected' : '') }}>18</option>
                                            <option value="19" {{  ($task->menit == "19" ? ' selected' : '') }}>19</option>
                                            <option value="20" {{  ($task->menit == "20" ? ' selected' : '') }}>20</option>
                                            <option value="21" {{  ($task->menit == "21" ? ' selected' : '') }}>21</option>
                                            <option value="22" {{  ($task->menit == "22" ? ' selected' : '') }}>22</option>
                                            <option value="23" {{  ($task->menit == "23" ? ' selected' : '') }}>23</option>
                                            <option value="24" {{  ($task->menit == "24" ? ' selected' : '') }}>24</option>
                                            <option value="25" {{  ($task->menit == "25" ? ' selected' : '') }}>25</option>
                                            <option value="26" {{  ($task->menit == "26" ? ' selected' : '') }}>26</option>
                                            <option value="27" {{  ($task->menit == "27" ? ' selected' : '') }}>27</option>
                                            <option value="28" {{  ($task->menit == "28" ? ' selected' : '') }}>28</option>
                                            <option value="29" {{  ($task->menit == "29" ? ' selected' : '') }}>29</option>
                                            <option value="30" {{  ($task->menit == "30" ? ' selected' : '') }}>30</option>
                                            <option value="31" {{  ($task->menit == "31" ? ' selected' : '') }}>31</option>
                                            <option value="32" {{  ($task->menit == "32" ? ' selected' : '') }}>32</option>
                                            <option value="33" {{  ($task->menit == "33" ? ' selected' : '') }}>33</option>
                                            <option value="34" {{  ($task->menit == "34" ? ' selected' : '') }}>34</option>
                                            <option value="35" {{  ($task->menit == "35" ? ' selected' : '') }}>35</option>
                                            <option value="36" {{  ($task->menit == "36" ? ' selected' : '') }}>36</option>
                                            <option value="37" {{  ($task->menit == "37" ? ' selected' : '') }}>37</option>
                                            <option value="38" {{  ($task->menit == "38" ? ' selected' : '') }}>38</option>
                                            <option value="39" {{  ($task->menit == "39" ? ' selected' : '') }}>39</option>
                                            <option value="40" {{  ($task->menit == "40" ? ' selected' : '') }}>40</option>
                                            <option value="41" {{  ($task->menit == "41" ? ' selected' : '') }}>41</option>
                                            <option value="42" {{  ($task->menit == "42" ? ' selected' : '') }}>42</option>
                                            <option value="43" {{  ($task->menit == "43" ? ' selected' : '') }}>43</option>
                                            <option value="44" {{  ($task->menit == "44" ? ' selected' : '') }}>44</option>
                                            <option value="45" {{  ($task->menit == "45" ? ' selected' : '') }}>45</option>
                                            <option value="46" {{  ($task->menit == "46" ? ' selected' : '') }}>46</option>
                                            <option value="47" {{  ($task->menit == "47" ? ' selected' : '') }}>47</option>
                                            <option value="48" {{  ($task->menit == "48" ? ' selected' : '') }}>48</option>
                                            <option value="49" {{  ($task->menit == "49" ? ' selected' : '') }}>49</option>
                                            <option value="50" {{  ($task->menit == "50" ? ' selected' : '') }}>50</option>
                                            <option value="51" {{  ($task->menit == "51" ? ' selected' : '') }}>51</option>
                                            <option value="52" {{  ($task->menit == "52" ? ' selected' : '') }}>52</option>
                                            <option value="53" {{  ($task->menit == "53" ? ' selected' : '') }}>53</option>
                                            <option value="54" {{  ($task->menit == "54" ? ' selected' : '') }}>54</option>
                                            <option value="55" {{  ($task->menit == "55" ? ' selected' : '') }}>55</option>
                                            <option value="56" {{  ($task->menit == "56" ? ' selected' : '') }}>56</option>
                                            <option value="57" {{  ($task->menit == "57" ? ' selected' : '') }}>57</option>
                                            <option value="58" {{  ($task->menit == "58" ? ' selected' : '') }}>58</option>
                                            <option value="59" {{  ($task->menit == "59" ? ' selected' : '') }}>59</option>
                                            <option value="0" {{  ($task->menit == "0" ? ' selected' : '') }}>00</option>
                                        </select><br>
                                        <select class="form-control otherAnswerMonthly" style="width: 30%; display:none;" name="tanggal">
                                            <option value="" selected disabled>-- Select Date --</option>
                                            <option value="1" {{  ($task->tanggal == "1" ? ' selected' : '') }}>01</option>
                                            <option value="2" {{  ($task->tanggal == "2" ? ' selected' : '') }}>02</option>
                                            <option value="3" {{  ($task->tanggal == "3" ? ' selected' : '') }}>03</option>
                                            <option value="4" {{  ($task->tanggal == "4" ? ' selected' : '') }}>04</option>
                                            <option value="5" {{  ($task->tanggal == "5" ? ' selected' : '') }}>05</option>
                                            <option value="6" {{  ($task->tanggal == "6" ? ' selected' : '') }}>06</option>
                                            <option value="7" {{  ($task->tanggal == "7" ? ' selected' : '') }}>07</option>
                                            <option value="8" {{  ($task->tanggal == "8" ? ' selected' : '') }}>08</option>
                                            <option value="9" {{  ($task->tanggal == "9" ? ' selected' : '') }}>09</option>
                                            <option value="10" {{  ($task->tanggal == "10" ? ' selected' : '') }}>10</option>
                                            <option value="11" {{  ($task->tanggal == "11" ? ' selected' : '') }}>11</option>
                                            <option value="12" {{  ($task->tanggal == "12" ? ' selected' : '') }}>12</option>
                                            <option value="13" {{  ($task->tanggal == "13" ? ' selected' : '') }}>13</option>
                                            <option value="14" {{  ($task->tanggal == "14" ? ' selected' : '') }}>14</option>
                                            <option value="15" {{  ($task->tanggal == "15" ? ' selected' : '') }}>15</option>
                                            <option value="16" {{  ($task->tanggal == "16" ? ' selected' : '') }}>16</option>
                                            <option value="17" {{  ($task->tanggal == "17" ? ' selected' : '') }}>17</option>
                                            <option value="18" {{  ($task->tanggal == "18" ? ' selected' : '') }}>18</option>
                                            <option value="19" {{  ($task->tanggal == "19" ? ' selected' : '') }}>19</option>
                                            <option value="20" {{  ($task->tanggal == "20" ? ' selected' : '') }}>20</option>
                                            <option value="21" {{  ($task->tanggal == "21" ? ' selected' : '') }}>21</option>
                                            <option value="22" {{  ($task->tanggal == "22" ? ' selected' : '') }}>22</option>
                                            <option value="23" {{  ($task->tanggal == "23" ? ' selected' : '') }}>23</option>
                                            <option value="24" {{  ($task->tanggal == "24" ? ' selected' : '') }}>24</option>
                                            <option value="25" {{  ($task->tanggal == "25" ? ' selected' : '') }}>25</option>
                                            <option value="26" {{  ($task->tanggal == "26" ? ' selected' : '') }}>26</option>
                                            <option value="27" {{  ($task->tanggal == "27" ? ' selected' : '') }}>27</option>
                                            <option value="28" {{  ($task->tanggal == "28" ? ' selected' : '') }}>28</option>
                                        </select>
                                        <select class="form-control otherAnswerMonthly" style="width: 30%; display:none;" name="jam">
                                        <option value="" selected disabled>-- Select Hours --</option>
                                            <option value="1" {{  ($task->jam == "1" ? ' selected' : '') }}>01</option>
                                            <option value="2" {{  ($task->jam == "2" ? ' selected' : '') }}>02</option>
                                            <option value="3" {{  ($task->jam == "3" ? ' selected' : '') }}>03</option>
                                            <option value="4" {{  ($task->jam == "4" ? ' selected' : '') }}>04</option>
                                            <option value="5" {{  ($task->jam == "5" ? ' selected' : '') }}>05</option>
                                            <option value="6" {{  ($task->jam == "6" ? ' selected' : '') }}>06</option>
                                            <option value="7" {{  ($task->jam == "7" ? ' selected' : '') }}>07</option>
                                            <option value="8" {{  ($task->jam == "8" ? ' selected' : '') }}>08</option>
                                            <option value="9" {{  ($task->jam == "9" ? ' selected' : '') }}>09</option>
                                            <option value="10" {{  ($task->jam == "10" ? ' selected' : '') }}>10</option>
                                            <option value="11" {{  ($task->jam == "11" ? ' selected' : '') }}>11</option>
                                            <option value="12" {{  ($task->jam == "12" ? ' selected' : '') }}>12</option>
                                            <option value="13" {{  ($task->jam == "13" ? ' selected' : '') }}>13</option>
                                            <option value="14" {{  ($task->jam == "14" ? ' selected' : '') }}>14</option>
                                            <option value="15" {{  ($task->jam == "15" ? ' selected' : '') }}>15</option>
                                            <option value="16" {{  ($task->jam == "16" ? ' selected' : '') }}>16</option>
                                            <option value="17" {{  ($task->jam == "17" ? ' selected' : '') }}>17</option>
                                            <option value="18" {{  ($task->jam == "18" ? ' selected' : '') }}>18</option>
                                            <option value="19" {{  ($task->jam == "19" ? ' selected' : '') }}>19</option>
                                            <option value="20" {{  ($task->jam == "20" ? ' selected' : '') }}>20</option>
                                            <option value="21" {{  ($task->jam == "21" ? ' selected' : '') }}>21</option>
                                            <option value="22" {{  ($task->jam == "22" ? ' selected' : '') }}>22</option>
                                            <option value="23" {{  ($task->jam == "23" ? ' selected' : '') }}>23</option>
                                            <option value="0" {{  ($task->jam == "0" ? ' selected' : '') }}>00</option>
                                        </select>
                                        <select class="form-control otherAnswerMonthly" style="width: 30%; display:none;" name="menit">
                                        <option value="" selected disabled>-- Select Minute --</option>
                                            <option value="1" {{  ($task->menit == "1" ? ' selected' : '') }}>01</option>
                                            <option value="2" {{  ($task->menit == "2" ? ' selected' : '') }}>02</option>
                                            <option value="3" {{  ($task->menit == "3" ? ' selected' : '') }}>03</option>
                                            <option value="4" {{  ($task->menit == "4" ? ' selected' : '') }}>04</option>
                                            <option value="5" {{  ($task->menit == "5" ? ' selected' : '') }}>05</option>
                                            <option value="6" {{  ($task->menit == "6" ? ' selected' : '') }}>06</option>
                                            <option value="7" {{  ($task->menit == "7" ? ' selected' : '') }}>07</option>
                                            <option value="8" {{  ($task->menit == "8" ? ' selected' : '') }}>08</option>
                                            <option value="9" {{  ($task->menit == "9" ? ' selected' : '') }}>09</option>
                                            <option value="10" {{  ($task->menit == "10" ? ' selected' : '') }}>10</option>
                                            <option value="11" {{  ($task->menit == "11" ? ' selected' : '') }}>11</option>
                                            <option value="12" {{  ($task->menit == "12" ? ' selected' : '') }}>12</option>
                                            <option value="13" {{  ($task->menit == "13" ? ' selected' : '') }}>13</option>
                                            <option value="14" {{  ($task->menit == "14" ? ' selected' : '') }}>14</option>
                                            <option value="15" {{  ($task->menit == "15" ? ' selected' : '') }}>15</option>
                                            <option value="16" {{  ($task->menit == "16" ? ' selected' : '') }}>16</option>
                                            <option value="17" {{  ($task->menit == "17" ? ' selected' : '') }}>17</option>
                                            <option value="18" {{  ($task->menit == "18" ? ' selected' : '') }}>18</option>
                                            <option value="19" {{  ($task->menit == "19" ? ' selected' : '') }}>19</option>
                                            <option value="20" {{  ($task->menit == "20" ? ' selected' : '') }}>20</option>
                                            <option value="21" {{  ($task->menit == "21" ? ' selected' : '') }}>21</option>
                                            <option value="22" {{  ($task->menit == "22" ? ' selected' : '') }}>22</option>
                                            <option value="23" {{  ($task->menit == "23" ? ' selected' : '') }}>23</option>
                                            <option value="24" {{  ($task->menit == "24" ? ' selected' : '') }}>24</option>
                                            <option value="25" {{  ($task->menit == "25" ? ' selected' : '') }}>25</option>
                                            <option value="26" {{  ($task->menit == "26" ? ' selected' : '') }}>26</option>
                                            <option value="27" {{  ($task->menit == "27" ? ' selected' : '') }}>27</option>
                                            <option value="28" {{  ($task->menit == "28" ? ' selected' : '') }}>28</option>
                                            <option value="29" {{  ($task->menit == "29" ? ' selected' : '') }}>29</option>
                                            <option value="30" {{  ($task->menit == "30" ? ' selected' : '') }}>30</option>
                                            <option value="31" {{  ($task->menit == "31" ? ' selected' : '') }}>31</option>
                                            <option value="32" {{  ($task->menit == "32" ? ' selected' : '') }}>32</option>
                                            <option value="33" {{  ($task->menit == "33" ? ' selected' : '') }}>33</option>
                                            <option value="34" {{  ($task->menit == "34" ? ' selected' : '') }}>34</option>
                                            <option value="35" {{  ($task->menit == "35" ? ' selected' : '') }}>35</option>
                                            <option value="36" {{  ($task->menit == "36" ? ' selected' : '') }}>36</option>
                                            <option value="37" {{  ($task->menit == "37" ? ' selected' : '') }}>37</option>
                                            <option value="38" {{  ($task->menit == "38" ? ' selected' : '') }}>38</option>
                                            <option value="39" {{  ($task->menit == "39" ? ' selected' : '') }}>39</option>
                                            <option value="40" {{  ($task->menit == "40" ? ' selected' : '') }}>40</option>
                                            <option value="41" {{  ($task->menit == "41" ? ' selected' : '') }}>41</option>
                                            <option value="42" {{  ($task->menit == "42" ? ' selected' : '') }}>42</option>
                                            <option value="43" {{  ($task->menit == "43" ? ' selected' : '') }}>43</option>
                                            <option value="44" {{  ($task->menit == "44" ? ' selected' : '') }}>44</option>
                                            <option value="45" {{  ($task->menit == "45" ? ' selected' : '') }}>45</option>
                                            <option value="46" {{  ($task->menit == "46" ? ' selected' : '') }}>46</option>
                                            <option value="47" {{  ($task->menit == "47" ? ' selected' : '') }}>47</option>
                                            <option value="48" {{  ($task->menit == "48" ? ' selected' : '') }}>48</option>
                                            <option value="49" {{  ($task->menit == "49" ? ' selected' : '') }}>49</option>
                                            <option value="50" {{  ($task->menit == "50" ? ' selected' : '') }}>50</option>
                                            <option value="51" {{  ($task->menit == "51" ? ' selected' : '') }}>51</option>
                                            <option value="52" {{  ($task->menit == "52" ? ' selected' : '') }}>52</option>
                                            <option value="53" {{  ($task->menit == "53" ? ' selected' : '') }}>53</option>
                                            <option value="54" {{  ($task->menit == "54" ? ' selected' : '') }}>54</option>
                                            <option value="55" {{  ($task->menit == "55" ? ' selected' : '') }}>55</option>
                                            <option value="56" {{  ($task->menit == "56" ? ' selected' : '') }}>56</option>
                                            <option value="57" {{  ($task->menit == "57" ? ' selected' : '') }}>57</option>
                                            <option value="58" {{  ($task->menit == "58" ? ' selected' : '') }}>58</option>
                                            <option value="59" {{  ($task->menit == "59" ? ' selected' : '') }}>59</option>
                                            <option value="0" {{  ($task->menit == "0" ? ' selected' : '') }}>00</option>
                                        </select><br>
                                    </div> -->
                                    <script>
                                            $("input[type='radio']").change(function(){

                                                if($(this).val()=="dailyAt")
                                                {
                                                    $(".otherAnswerDaily").show();
                                                }
                                                else
                                                {
                                                        $(".otherAnswerDaily").hide(); 
                                                }
                                                if($(this).val()=="weeklyOn")
                                                {
                                                    $(".otherAnswerWeekly").show();
                                                }
                                                else
                                                {
                                                        $(".otherAnswerWeekly").hide(); 
                                                }
                                                if($(this).val()=="monthlyOn")
                                                {
                                                    $(".otherAnswerMonthly").show();
                                                }
                                                else
                                                {
                                                        $(".otherAnswerMonthly").hide(); 
                                                }
                                                
                                            });  
                                    </script>
                                </div>
                                <!-- === -->
                            </div>
                        </div>
                        <div class="col-sm-1 text-right" hidden>
                            <label>Status</label>
                        </div>
                        
                        <div class="col-sm-3" hidden>
                            <input class="form-control" readonly value="OPEN">
                        </div>
        </div>
        
    </div>
    @include($task_type)
    @if($add_ons)
        @if(count($add_ons))
            @foreach($add_ons as $add_on)
                <div class="card-body" >
                    <div class="row">
                        <div class="col-md-5">
                            <p class="judul1">{{$add_on->name}}</p>
                            <input hidden name="section_name[]" value="{{$add_on->name}}">
                            <input hidden name="section_id[]" value="{{$add_on->section_id}}">
                        </div>
                        <div class="col-md-7">
                        </div>
                    </div>
                </div>
                <div class="card-body" id="{{$add_on->section_id}}" >
                    <div class="row">
                    @foreach(\App\TemplatesAddOns::where('id_section', $add_on->id)->orderBy('id','ASC')->get() as $field)
                        <div class="form-group col-md-6" data-type="{{$field->type}}">
                            <?php $encode = ['id' => $field->field_id, 'name' => $field->name, 'type' => $field->type, 'default_value' => $field->default_value, 'parent' => isset($field->section)?$field->section->section_id:'',]; ?>
                            <input name="field_parent[]" value="{{$add_on->section_id}}" hidden>
                            <input name="arr_field[]" value="{{json_encode($encode)}}" hidden>
                            @if($field->type == "EMPTY_ROW")
                            <input id="{{$field->field_id}}" hidden name="{{$field->field_id}}" value="EMPTY_ROW">
                            <input name="fields[]" value="{{$field->field_id}}" hidden>
                            @else
                            <label>{{$field->name}}</label>
                            <input class='form-control' placeholder="{{$field->name}}" name="{{$field->name}}" type="{{$field->type}}" id="{{$field->field_id}}" value="{{$field->default_value}}">
                            <input name="fields[]" value="{{$field->name}}" hidden>
                            @endif
                        </div>
                    @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    @endif
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
</div>
</form>
@endsection
@push('scripts')

@endpush
