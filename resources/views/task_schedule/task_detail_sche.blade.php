@if(2==2)
<div style="pointer-events: none;">
    <div class="card-body" style="border-bottom: 1px solid rgba(0, 0, 0, .125);">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Template Name</label>
                    <input class="form-control" readonly value="{{\App\Model\TaskType::where('id_type', $task->id_task_type)->first()->type_name}}">
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control select2" style="width: 100%;" name="id_status">
                        @foreach(\App\Model\Status::get() as $s)
                        <option value="{{$s->id_status}}" {{$task->id_status == $s->id_status ? 'selected':''}}>{{$s->status_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @if(1==2)
        <div class="row">
            <div class="col-md-12">
                    <!-- <select class="form-control select2" style="width: 100%;" name="frequency">
                        <option value="" selected disabled>-- Select Frequency --</option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select><br> -->
                    Daily <input type="radio" name="selectFrequency" value="dailyAt" {{  ($task->frequency == "dailyAt" ? ' checked' : '') }}/> &nbsp;&nbsp;&nbsp;&nbsp;
                    Weekly <input type="radio" name="selectFrequency" value="weeklyOn" {{  ($task->frequency == "weeklyOn" ? ' checked' : '') }}/> &nbsp;&nbsp;&nbsp;&nbsp;
                    Monthly<input type="radio" name="selectFrequency" value="monthlyOn" {{  ($task->frequency == "monthlyOn" ? ' checked' : '') }}/> 

                    <!-- <input style="display:none;" type="text" name="otherAnswer" id="otherAnswer"/> -->
                    <div class="row">
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
                    </div>
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
        </div>
        @endif
    </div>
    
    @if($add_ons)
        @if(count($add_ons))
            @foreach($add_ons as $add_on)
                <div class="card-body" style="border-bottom: 1px solid rgba(0, 0, 0, .125);">
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
                <div class="card-body" id="{{$add_on->section_id}}" style="border-bottom: 1px solid rgba(0, 0, 0, .125);">
                    <div class="row">
                    @foreach(\App\TaskAddOns::where('id_section', $add_on->id)->orderBy('id','ASC')->get() as $field)
                        <div class="form-group col-md-6" data-type="{{$field->type}}">
                            <?php $encode = ['id' => $field->field_id, 'name' => $field->name, 'type' => $field->type, 'value' => $field->value, 'parent' => isset($field->section)?$field->section->section_id:'',]; ?>
                            <input name="field_parent[]" value="{{$add_on->section_id}}" hidden>
                            <input name="arr_field[]" value="{{json_encode($encode)}}" hidden>
                            @if($field->type == "EMPTY_ROW")
                            <input id="{{$field->field_id}}" hidden name="{{$field->field_id}}" value="EMPTY_ROW">
                            <input name="fields[]" value="{{$field->field_id}}" hidden>
                            @else
                            <label>{{$field->name}}</label>
                            <input class='form-control' placeholder="{{$field->name}}" name="{{$field->name}}" type="{{$field->type}}" id="{{$field->field_id}}" value="{{$field->value}}">
                            <input name="fields[]" value="{{$field->name}}" hidden>
                            @endif
                        </div>
                    @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    @endif
</div>
<br>
<br>
<hr>
<br>
<?php 
$update_type = "IMAGE";
if($task->id_task_type == 2){
    if($task_detail->checklist_periode == 1){
        $update_type = "CHECKLIST";
    }elseif($task_detail->checklist_periode == 2){
        $update_type = "CHECKLIST";
    }
}
if($task->id_task_type == 3) $update_type = "NONE";
if($task->id_task_type == 4){
    $update_type = "IMAGE";
}

?>
@if($next_status == '5')
<div class="card collapsed-card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-11">
                <h3 class="card-title">SUBMIT {{$update_type}}</h3>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-tool float-right" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($update_type == "IMAGE")
        <form method="POST" action="/task/image_before_after/{{$task->id_task}}" enctype="multipart/form-data"> 
        @csrf
        <div class="row">
            <div class="col-md-6 image_before_wrapper">
                <div class="form-group">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-success btn-add-image-before"><i class="fa fa-plus"></i></button>
                        <button class="btn btn-sm btn-warning btn-min-image-before"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="form-group fc_image_before">
                    <label>Image Before</label>
                    <input class="form-control" type="file" name="image_before[]" accept="image/*">
                </div>
            </div>
            <div class="col-md-6 image_after_wrapper">
                <div class="form-group">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-success btn-add-image-after"><i class="fa fa-plus"></i></button>
                        <button class="btn btn-sm btn-warning btn-min-image-after"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="form-group fc_image_after">
                    <label>Image After</label>
                    <input class="form-control" type="file" name="image_after[]" accept="image/*">
                </div>
            </div>
        </div>
        
        <div class="card-footer bg-transparent">
            <button type="submit" class="btn btn-info float-right btn-md">Upload</button>
        </div>
        </form>
        @elseif($update_type == "CHECKLIST")
        <form method="POST" action="/task/submit_task_checklist/{{$task->id_task}}" enctype="multipart/form-data"> 
        @csrf
            <div style="height:80vh; overflow:auto">
                <table id="table_submit_checklit" class="table">
                    <thead>
                        <tr>
                            <th style="width: 52px">ID</th>
                            <th width="35%">Checklist</th>
                            <th>Is_Available</th>
                            <th>Answer</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $c = 0;
                        ?>
                        @forelse(\App\Model\Checklist::where('id_region', $task->id_region)->where('checklist_periode', $task_detail->checklist_periode)->whereIn('id_checklist_category', json_decode($task_detail->id_checklist_category))->get() as $ch)
                        <tr>
                            <td>{{++$c}}</td>
                            <td>{{$ch->checklist_name}}</td>
                            <td>
                                <input name="checklist[{{$c}}]" value="{{$ch->id_checklist}}" hidden>
                                <select class="form-control" name="is_available[{{$c}}]">
                                    <option>OK</option>
                                    <option>NOT OK</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control" name="answers[{{$c}}]" required autofocus>
                            </td>
                            <td>
                                <input class="form-control" name="image[{{$c}}]" type="file">
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-transparent">
                <button type="submit" class="btn btn-info float-right btn-md">Upload</button>
            </div>
        </form>
        @else
        @endif
    </div>
</div>
@endif
@if($update_type == "IMAGE")
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Images</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table" width="100%">
                    <thead>
                        <tr>
                            <th>Before</th>
                            @if($technician)
                            <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $image_before = getTaskImages($task->id_task, 'BEFORE');
                        ?>
                        @forelse($image_before as $b)
                        <tr>
                            <td>
                                <a href="/task_report/{{$b->image}}" target="new">
                                    <img src="/task_report/{{$b->image}}" width="150px">
                                </a>
                            </td>
                            @if($technician)
                            <td style="text-align: center; vertical-align: middle;">
                                @if($next_status == '5')
                                <a class="btn btn-sm btn-danger" href="/task/remove_image/{{$b->id}}"><i class="fa fa-trash"></i> REMOVE</a>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table" width="100%">
                    <thead>
                        <tr>
                            <th>After</th>
                            @if($technician)
                            <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $image_after = getTaskImages($task->id_task, 'AFTER');
                        ?>
                        @forelse($image_after as $a)
                        <tr>
                            <td>
                                <a href="/task_report/{{$a->image}}" target="new">
                                    <img src="/task_report/{{$a->image}}" width="150px">
                                </a>
                            </td>
                            @if($technician)
                            <td style="text-align: center; vertical-align: middle;">
                                @if($next_status == '5')
                                <a class="btn btn-sm btn-danger" href="/task/remove_image/{{$a->id}}"><i class="fa fa-trash"></i> REMOVE</a>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@elseif($update_type == "CHECKLIST")
    @if(1==2)
    <p class="judul1"></p>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Checklists</h3>
            <div class="card-tools">
                <form method="GET" action="/task/download2">
                    @csrf
                    <div name="download_type2"class="btn-group">
                        <a href="/task/checklist_answers/excel?id_task={{$task->id_task}}" value="EXCEL" class="btn btn-sm btn-success"> <i class="fa fa-file-excel"></i> EXCEL</a>
                        <a href="/task/checklist_answers/pdf?id_task={{$task->id_task}}" class="btn btn-sm btn-danger" target="new"><i class="fa fa-file-pdf"></i> PDF</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
        <table class="table" id="table_checklist" width="100%">
            <thead>
                <tr>
                    <th style="width: 52px">ID</th>
                    <th>Checklist</th>
                    <th>Is_Available</th>
                    <th>Answer</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $answers = isset($task->checklist_answers)?$task->checklist_answers->datas:'[]';
                $i = 0;
                ?>
                @forelse(json_decode($answers) as $a)
                <tr>
                    <td>{{++$i}}</td>
                    <td>{{$a->checklist_name}}</td>
                    <td>{{$a->is_avaiable}}</td>
                    <td>{{$a->answer}}</td>
                    <td>
                        <a href="/checklist_image/{{$a->image}}" target="new">
                            <img src="/checklist_image/{{$a->image}}" width="150px">
                        </a>
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
    @endif
@else
@endif

<script>
    var image_before = '<div class="form-group fc_image_before"><label>Image Before</label><input class="form-control" type="file" name="image_before[]" accept="image/*"></div>';
    var image_after  = '<div class="form-group fc_image_after"><label>Image After</label><input class="form-control" type="file" name="image_after[]" accept="image/*"></div>';
    
    var image_before_wrapper = $('.image_before_wrapper');
    var image_after_wrapper  = $('.image_after_wrapper');
    
    $(document).on('click', '.btn-add-image-before', function(e){
        e.preventDefault();
        image_before_wrapper.append(image_before);
    });
    $(document).on('click', '.btn-add-image-after', function(e){
        e.preventDefault();
        image_after_wrapper.append(image_after);
    });
    
    $(document).on('click', '.btn-min-image-before', function(e){
        e.preventDefault();
        $(".fc_image_before").last().remove();
    });
    $(document).on('click', '.btn-min-image-after', function(e){
        e.preventDefault();
        $(".fc_image_after").last().remove();
    });
    
    
    $(document).ready(function(){
        $('#table_checklist').DataTable();
    });
</script>















@endif