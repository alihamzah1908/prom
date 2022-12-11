<style>
    .display-none{
        display:none;
    }
    .form-group{
        width:100%;
    }
    .col-md-5x{
        width:100% !important;
        height:100% !important;
        padding-left: 15px;
        padding-right: 15px;
    }
</style>
<div class="card-body text-dark">
    <div class="row" hidden>
        <div class="col-md-12">
            <div class="form-group" style="margin-bottom: 0;">
                <label><h6><strong>Choose task time</strong></h6></label>
            </div>
            Send task with Schedule <input type="radio" name="pilih_waktu" value="dengan_jadwal" />&nbsp;&nbsp;&nbsp;&nbsp;
            Send task immediately(now) <input type="radio" name="pilih_waktu" value="sekarang" checked/><br><br>
            <span class="pilihan_jadwal">Daily <input type="radio" name="selectFrequency" value="dailyAt"/></span>&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="pilihan_jadwal">Weekly <input type="radio" name="selectFrequency" value="weeklyOn"/></span>&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="pilihan_jadwal">Monthly<input type="radio" name="selectFrequency" value="monthlyOn"/> </span><br>
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
                </select>&nbsp;&nbsp;
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
                </select>&nbsp;&nbsp;
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
                </select>&nbsp;&nbsp;
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
                </select>&nbsp;&nbsp;
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
                </select>&nbsp;&nbsp;
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
                $("input[name='pilih_waktu']").change(function(){

                    if($(this).val()=="dengan_jadwal"){
                        $(".pilihan_jadwal").show();
                    }else{
                            $(".pilihan_jadwal").hide(); 
                    }
                    
                });  
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
    </div><br>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group" style="margin-bottom: 0;">
                <label><h6><strong>Checklist</strong></h6></label>
            </div>
            <div class="row">
                <?php 
                $checklist_periode = old('checklist_periode');
                if(!$checklist_periode){
                    $checklist_periode = $task_detail->checklist_periode;
                }
                // if(!$checklist_periode){
                //     $task_detail->checklist_periode = 1;
                //     $checklist_periode = $task_detail->checklist_periode;
                // }
                
                $id_checklist_category = old('id_checklist_category');
                if(!$id_checklist_category){
                    $id_checklist_category = $task_detail->id_checklist_category;
                }
                if(!$id_checklist_category){
                    $task_detail->id_checklist_category = [];
                    $id_checklist_category = $task_detail->id_checklist_category;
                }
                
                if(!is_array($id_checklist_category)){
                    $id_checklist_category = json_decode($id_checklist_category);
                }
                if(!is_array($id_checklist_category)) $id_checklist_category = [$id_checklist_category]
                ?>
                @foreach(\App\Model\ChecklistPeriode::get() as $per)
                <!--<div class="col-sm-3">-->
                <!--    <div class="form-group">-->
                <!--        <div class="form-check">-->
                <!--            <input class="form-check-input" type="radio" required autofocus name="checklist_periode" value="{{$per->id_periode}}"-->
                <!--            @if(old('checklist_periode') == $per->id_periode || $task_detail->checklist_periode == $per->id_periode) checked @endif>-->
                <!--            <label class="form-check-label text_name">{{$per->periode_name}}</label>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                @endforeach
                
                <!--<div class="col-sm-12" id="checklist_category_parent">-->
                <!--    <select class="form-control select2-multiple" style="width: 99%;" name="id_checklist_category[]" id="id_checklist_category" multiple>-->
                <!--        @foreach(\App\Model\ChecklistCategory::get() as $cat)-->
                <!--            <option value="{{$cat->id_category}}" {{in_array($cat->id_category, $id_checklist_category) ? 'selected':''}}>{{$cat->category_name}}</option>-->
                <!--        @endforeach-->
                <!--    </select>-->
                <!--</div>-->
                
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
        </div>
    </div>
    <br> 
    <!--<hr>-->
    <p class="judul1">Basic Information</p>
    <div class="row">
        
        <table style="width:100%;">
            <tr>
                <td style="width:50%;">
                    <div class="col-md-5x">
                        <!--site id-->
                        <div class="form-group">
                        @if($task->id_site_a != '')
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label>Site ID</label>
                                </div>
                                
                                <div class="col-sm-10">
                                    <select class="form-control select2" style="width: 100%;" required autofocus name="id_site_a">
                                    <option selected="selected" disabled value="">-- Select Site --</option>
                                @foreach(\App\Model\Site::get() as $site)
                                    <option value="{{$site->site_id}}" 
                                    @if(old('id_site_a') == $site->site_id || $task->id_site_a == $site->site_id) selected @endif
                                    >
                                {{$site->name_site}}
                                    </option>
                                @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            
                        @endif
                        </div>
                        <!--task category-->
                        <div class="form-group">
                        @if($task->id_category != '')
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label>Task Category</label>
                                </div>
                                
                                <div class="col-sm-10">
                                    <select class="form-control select2 select_category" style="width: 100%;" onchange="setSubCategory({{$id_template}}, this.value)" required autofocus name="id_category">
                                    <option selected="selected" disabled value="">-- Select Category --</option>
                                @foreach(\App\Model\Category::where('id_task_type', $id_template)->get() as $cat)
                                    <option value="{{$cat->id_category}}">{{$cat->category_name}}</option>
                                @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        </div>
                        <!--task sub category where sub-->
                        <!--sub category where category-->
                        <div class="form-group">
                        @if($task->id_sub_category != '')
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label>Task Sub Category</label>
                                </div>
                                
                                <div class="col-sm-10">
                                    <select class="form-control searchSubCat select_sub_category" style="width: 100%;" name="id_sub_category" required autofocus></select>
                                </div>
                            </div>
                        @endif
                        </div>
                        <!--request start time where time-->
                        <div class="form-group">
                        @if($task_detail->request_start_time != '')
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="request_start_time">Request Start Time</label>
                                </div>
                                
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="request_start_time" id="request_start_time" required autofocus 
                                    @if(old('request_start_time')) value="{{old('request_start_time')}}"
                                    @elseif($task_detail->request_start_time) value="{{date('Y-m-d', strtotime($task_detail->request_start_time))}}" 
                                    @else value="{{date('Y-m-d')}}"@endif
                                    >
                                </div>
                            </div>
                        @endif
                        </div>
                        <!--request complete time where time-->
                        <div class="form-group">
                        @if($task_detail->request_complete_time != '')
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="request_complete_time">Request Completion</label>
                                </div>
                                
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="request_complete_time" required autofocus 
                                @if(old('request_complete_time')) value="{{old('request_complete_time')}}" @elseif($task_detail->request_complete_time) value="{{date('Y-m-d', strtotime($task_detail->request_complete_time))}}" @endif
                                >
                                </div>
                            </div>
                        @endif
                        </div>
                    </div>
                </td>
                <td style="width:50%;">
                    <div class="col-md-5x">
                        <!--title where title-->
                        <div class="form-group">
                        @if($task->subject != '')
                        
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label>Title</label>
                                </div>
                                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required autofocus 
                                    @if(old('subject')) value="{{old('subject')}}" @elseif($task->subject) value="{{$task->subject}}" @endif
                                    >
                                </div>
                            </div>
                        @endif
                        </div>
                        <!--desc where desc-->
                        <div class="form-group">
                        @if($task->description != '')
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="description">Description</label>
                                </div>
                                
                                <div class="col-sm-10">
                                    <textarea name="description" class="form-control @error('description') is-invalid invalid @enderror" id="description" rows="4" placeholder="Description" required autofocus>@if(old('description')){{old('description')}}@elseif($task->description){{$task->description}}@endif</textarea>
                                </div>
                            </div>
                        @endif
                        </div>
                        <!--tech-->
                        <div class="form-group">
                        @if($task->id_technician != '')
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label>Assign To</label>
                                </div>
                                
                                <div class="col-sm-10">
                                    <select class="form-control select2" style="width: 100%;" required autofocus name="id_technician">
                                    <option selected="selected" disabled value="">-- Select Assign To --</option>
                                @foreach(\App\Model\Technician::get() as $tech)
                                    <option value="{{$tech->id_technician}}" @if(old('id_technician') == $tech->id_technician || $task->id_technician == $tech->id_technician) selected @endif>{{$tech->name_technician}}</option>
                                @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        
        
        <div class="col-md-1"></div>
        
    </div>
    <br> 
    <hr>
    <p class="judul1">Site Information</p>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <!--<div class="form-group row">-->
            <!--    <div class="col-sm-2">-->
                            
            <!--    </div>-->
                        
            <!--    <div class="col-sm-10">-->
                            
            <!--    </div>       -->
            <!--</div>-->
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label for="site_name">Site Name</label>       
                    </div>
                            
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="site_name" id="site_name" placeholder="Site Name" readonly required autofocus
                        @if(old('site_name')) value="{{old('site_name')}}" @elseif($task->getSite) value="{{isset($task->getSite)?$task->getSite->name_site:'-'}}" @endif
                        >        
                    </div>       
                </div>
            </div>
            <div class="form-group">
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label for="site_address">Site Address</label>        
                    </div>
                            
                    <div class="col-sm-10">
                        <textarea name="site_address" class="form-control" id="site_address" readonly required autofocus rows="4" placeholder="Site Address">@if(old('site_address')){{old('site_address')}}@elseif($task->getSite){{isset($task->getSite)?$task->getSite->address:'-'}}@endif</textarea>       
                    </div>       
                </div>
            </div>
        </div>
        <!--<div class="col-md-1"></div>-->
        <div class="col-md-6">
            <div class="form-group">
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label for="region_manager">Region Manager</label>    
                    </div>
                        
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="region_manager" id="region_manager" placeholder="region_manager" readonly required autofocus
                        @if(old('region_manager')) value="{{old('region_manager')}}" @elseif($task->getSite) value="{{isset($task->getSite->manager)?$task->getSite->manager->name:'-'}}" @endif
                        >    
                    </div>
                </div>
                
                
            </div>
            <div class="form-group">
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label for="manager_phone_no">Manager Phone No</label>    
                    </div>
                        
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="manager_phone_no" id="manager_phone_no" placeholder="manager_phone_no" readonly required autofocus
                        @if(old('manager_phone_no')) value="{{old('manager_phone_no')}}" @elseif($task->getSite) value="{{isset($task->getSite->manager)?$task->getSite->manager->telpone:'-'}}" @endif
                        >    
                    </div>
                </div>
                
                
            </div>
            <div class="form-group">
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label>Region</label>   
                    </div>
                        
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="site_id_region" id="site_id_region" placeholder="site_id_region" readonly required autofocus
                        @if(old('site_id_region')) value="{{old('site_id_region')}}" @elseif($task->getSite) value="{{isset($task->getSite->region)?$task->getSite->region->region_name:'-'}}" @endif
                        >
                        <input hidden id="id_region" name="id_region"
                        @if(old('id_region')) value="{{old('id_region')}}" @elseif($task->id_region) value="{{$task->id_region}}" @endif
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        @if($task->id_category)
            $('.select_category').val({{$task->id_category}}).trigger('change');
        @endif 
        @if($task->id_sub_category)
        var $newOption = $("<option selected='selected'></option>").val({{$task->id_sub_category}}).text("{{$task->sub_category_name}}")
        $(".select_sub_category").append($newOption).trigger('change');
        @endif
        
        $(document).on('change', 'input[name=checklist_periode]', function(e){
            e.preventDefault();
            var ini = $(this),
                val = this.value,
                category = $('select[name=id_checklist_category]'),
                parent = $('#checklist_category_parent');
            
            switch(val){
                case '1':
                    req_category(parent, category)
                    break;
                case '2':
                    req_category(parent, category)
                    break;
                case '3':
                    unreq_category(parent, category)
                    console.log('3')
                    break;
                case '4':
                    unreq_category(parent, category)
                    console.log('4')
                    break;
                default:
                    unreq_category(parent, category)
            }
            console.log(val)
        })
        function req_category(parent, category){
            parent.removeClass('display-none');
            category.attr('required','required');
            category.attr('autofocus','autofocus');
        }
        function unreq_category(parent, category){
            parent.addClass('display-none');
            category.attr('required',false);
            category.attr('autofocus',false);
        }
    });
</script>
<script>
    $('.select2').select2();
    $('.select2-multiple').select2({
        placeholder:'-- Select Checklist Category --',
    });
    function setSubCategory(id_type, id_category){
        $(".searchSubCat").select2({
            placeholder: "Select Sub Category",
            ajax: {
                url: "/setup/Customization/"+id_type+"/getSubCategory",
                dataType: "json",
                data:{
                    id_category: id_category
                },
                delay: 250,
                processResults: function (data) {
                    data = data.data;
                    return {
                        results: $.map(data, function (item) {
                                return {
                                    text: item.sub_category_name,
                                    id: item.id_sub_category
                                };
                        })
                    };
                },
                cache: false
            }
        });
    }
    
    $(document).ready(function(){
        
        $(document).on('change', 'select[name=id_site_a]', function(e){
            e.preventDefault();
            var ini = $(this);
                id = ini.val();
            $.ajax({
                url: '/setup/servicedesk/site/getSite',
                type: "get",
                data: {
                        id: id
                      }
            })
            .done(function (result) {
                if(result.data[0]){
                    var data = result.data[0];
                        $('#site_name').val(data.name_site);
                        $('#site_address').val(data.address);
                        $('#region_manager').val(data.manager.name);
                        $('#manager_phone_no').val(data.manager.telpone);
                        $('#site_id_region').val(data.region.region_name);
                        $('#id_region').val(data.region.region_id);
                        
                }else{
                    var message = result.message || 'Not found!';
                    failedAlert(message);
                }
            })
            .fail(ajax_fail);
        }) 
        $('select[name=id_site_a]').trigger('change');
    });
</script>